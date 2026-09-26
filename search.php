<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
include "db.php";

/* ================= SEARCH INPUT ================= */
$q      = isset($_GET['q'])    ? trim($_GET['q'])    : '';
$filter = isset($_GET['in'])   ? $_GET['in']         : 'all';
$sort   = isset($_GET['sort']) ? $_GET['sort']       : 'relevance';

$allowed_filters = ['all', 'wallpaper', 'tiles', 'paneling', 'paint', 'services'];
if (!in_array($filter, $allowed_filters)) $filter = 'all';
$q = substr($q, 0, 100);

/* Common spelling variations -> the words actually used in the database */
$synonyms = [
    'penal' => 'panel', 'penals' => 'panel', 'panels' => 'panel', 'panelling' => 'paneling',
    'wallpapers' => 'wallpaper', 'wall paper' => 'wallpaper', 'tiles' => 'tile',
    'paints' => 'paint', 'colour' => 'color', 'colours' => 'color', 'colors' => 'color',
    'merbal' => 'marble', 'marbel' => 'marble', 'woden' => 'wood', 'wooden' => 'wood',
];

/* Words that should also match related words (e.g. "tile" should find "Floor Tiling") */
$alternatives = [
    'tile'    => ['tile', 'tiling'],
    'paint'   => ['paint'],               // also covers painting / painter
    'painter' => ['paint'],
    'painting'=> ['paint'],
    'fitting' => ['fit', 'install'],
    'fitter'  => ['fit', 'install'],
    'install' => ['install', 'fit'],
    'installation' => ['install', 'fit'],
    'panel'   => ['panel'],
];

function build_terms($q, $synonyms, $alternatives) {
    $q = strtolower($q);
    foreach ($synonyms as $from => $to) {
        if (strpos($from, ' ') !== false) $q = str_replace($from, $to, $q);
    }
    $words = preg_split('/\s+/', preg_replace('/[^a-z0-9\s\-]/', ' ', $q), -1, PREG_SPLIT_NO_EMPTY);
    $terms = [];
    foreach ($words as $w) {
        if (isset($synonyms[$w])) $w = $synonyms[$w];
        // "Marbles" -> "marble" (simple plural handling; "tile" still matches "tiles")
        if (strlen($w) > 4 && substr($w, -1) === 's') $w = substr($w, 0, -1);
        if (strlen($w) < 2) continue;
        // each term = list of alternatives; ANY alternative may match
        $terms[$w] = isset($alternatives[$w]) ? $alternatives[$w] : [$w];
    }
    // Generic "service" words (fitting, installation, mistri...) are only used when
    // they are the ONLY words, otherwise "tile fitting" would miss "Floor Tiling"
    $soft = ['fit', 'fitting', 'fitter', 'install', 'installation', 'installer',
             'service', 'work', 'worker', 'mistri', 'karigar', 'expert', 'best', 'cheap'];
    $strong = array_diff_key($terms, array_flip($soft));
    if (!empty($strong)) $terms = $strong;
    return array_slice(array_values($terms), 0, 6);
}

/* Builds "(colA LIKE ? OR colB LIKE ? ...)" for every alternative of one term */
function term_condition($columns, $alts, &$params) {
    $parts = [];
    foreach ($alts as $a) {
        foreach ($columns as $col) {
            $parts[]  = "$col LIKE ?";
            $params[] = '%' . $a . '%';
        }
    }
    return '(' . implode(' OR ', $parts) . ')';
}

/* Runs a prepared statement with a dynamic list of string params */
function run_search($conn, $sql, $params) {
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];
    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    $stmt->execute();
    $res  = $stmt->get_result();
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $stmt->close();
    return $rows;
}

$terms    = build_terms($q, $synonyms, $alternatives);
$products = [];
$services = [];

if (!empty($terms)) {
    /* ---------- PRODUCTS ---------- */
    // Every word must appear somewhere (name, category, type, description, material, finish)
    $where  = ["status = 'approved'"];
    $params = [];
    $pcols  = ['name', 'category', 'product_type', 'description', 'material', 'finish_type'];
    foreach ($terms as $alts) {
        $where[] = term_condition($pcols, $alts, $params);
    }
    // Relevance: name matches rank highest, then type/category
    $score  = [];
    $sparams = [];
    foreach ($terms as $alts) {
        $score[] = "(CASE WHEN name LIKE ? THEN 3 ELSE 0 END + CASE WHEN product_type LIKE ? OR category LIKE ? THEN 2 ELSE 0 END)";
        $like = '%' . $alts[0] . '%';
        array_push($sparams, $like, $like, $like);
    }
    $orderBy = "relevance DESC, id DESC";
    if ($sort === 'low')  $orderBy = "(price - price * discount / 100) ASC";
    if ($sort === 'high') $orderBy = "(price - price * discount / 100) DESC";
    if ($sort === 'new')  $orderBy = "id DESC";

    $sql = "SELECT *, (" . implode(' + ', $score) . ") AS relevance
            FROM productadd
            WHERE " . implode(' AND ', $where) . "
            ORDER BY $orderBy
            LIMIT 200";
    $products = run_search($conn, $sql, array_merge($sparams, $params));

    /* ---------- SERVICES ---------- */
    $swhere  = ["u.is_approved = 1", "a.status = 'Active'"];
    $sparams2 = [];
    $scols = ['a.service_name', 'a.category', 'a.serviceprovider_name', 'a.city', 'a.service_description'];
    foreach ($terms as $alts) {
        $swhere[] = term_condition($scols, $alts, $sparams2);
    }
    $ssql = "SELECT a.*, p.profile_image
             FROM addservice a
             LEFT JOIN providerprofile p ON a.serviceprovider_id = p.provider_id
             LEFT JOIN users u ON a.serviceprovider_id = u.id
             WHERE " . implode(' AND ', $swhere) . "
             ORDER BY a.service_id DESC
             LIMIT 60";
    $services = run_search($conn, $ssql, $sparams2);
}

/* Counts for filter chips */
$counts = ['wallpaper' => 0, 'tiles' => 0, 'paneling' => 0, 'paint' => 0];
foreach ($products as $p) {
    $c = strtolower($p['category']);
    if (isset($counts[$c])) $counts[$c]++;
}
$svc_total = count($services);
$total_all = count($products) + $svc_total;

/* Apply the chosen filter */
if ($filter === 'services') {
    $products = [];
} elseif ($filter !== 'all') {
    $products = array_values(array_filter($products, function ($p) use ($filter) {
        return strtolower($p['category']) === $filter;
    }));
    $services = [];
}
$shown = count($products) + count($services);

function chip_url($q, $in, $sort) {
    return 'search.php?q=' . urlencode($q) . '&in=' . $in . ($sort !== 'relevance' ? '&sort=' . $sort : '');
}

$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $uid = intval($_SESSION['user_id']);
    $c   = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id='$uid'");
    $cr  = mysqli_fetch_assoc($c);
    $cart_count = $cr['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $q !== '' ? htmlspecialchars($q) . ' - Search' : 'Search'; ?> | Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif; background:#f7f4f0; color:#2a2a2a; }

        /* ── HERO ── */
        .cat-hero {
            background: linear-gradient(135deg,#4b2c2c 0%,#7a4040 60%,#2c1a1a 100%);
            padding: 55px 40px 40px;
            position: relative;
            overflow: hidden;
        }
        .cat-hero::before {
            content:'';
            position:absolute; inset:0;
            background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .breadcrumb {
            position:relative;
            font-size:12px;
            color:rgba(255,255,255,0.55);
            margin-bottom:14px;
        }
        .breadcrumb a { color:rgba(255,255,255,0.55); text-decoration:none; }
        .breadcrumb a:hover { color:#d4a96a; }
        .breadcrumb span { color:rgba(255,255,255,0.9); }
        .cat-hero h1 {
            font-family:'Playfair Display',serif;
            font-size:2.5rem;
            color:#fff;
            position:relative;
        }
        .cat-hero-sub {
            color:rgba(255,255,255,0.65);
            font-size:0.9rem;
            margin-top:8px;
            position:relative;
        }
        .hero-line {
            width:50px; height:3px;
            background:#d4a96a;
            margin-top:16px;
            border-radius:2px;
            position:relative;
        }

        /* ── TOOLBAR ── */
        .toolbar {
            max-width:1300px;
            margin:30px auto 0;
            padding:0 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:12px;
        }
        .toolbar-left {
            display:flex;
            align-items:center;
            gap:14px;
        }
        .back-btn {
            display:inline-flex;
            align-items:center;
            gap:7px;
            color:#4b2c2c;
            text-decoration:none;
            font-size:13px;
            font-weight:500;
            border:1.5px solid #4b2c2c;
            padding:7px 18px;
            border-radius:25px;
            transition:all 0.3s;
        }
        .back-btn:hover { background:#4b2c2c; color:#fff; }
        .results-count { font-size:13px; color:#888; }

        .sort-select {
            padding:8px 18px;
            border-radius:25px;
            border:1.5px solid #ddd;
            background:#fff;
            font-size:13px;
            font-family:'DM Sans',sans-serif;
            color:#2a2a2a;
            outline:none;
            cursor:pointer;
            transition:border 0.3s;
        }
        .sort-select:focus { border-color:#4b2c2c; }

        /* ── PRODUCTS GRID ── */
        .products-section {
            max-width:1300px;
            margin:24px auto 60px;
            padding:0 30px;
        }
        .products-grid {
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
            gap:26px;
        }

        /* ── PRODUCT CARD ── */
        .prod-card {
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            box-shadow:0 4px 18px rgba(75,44,44,0.08);
            transition:transform 0.3s,box-shadow 0.3s;
            cursor:pointer;
        }
        .prod-card:hover {
            transform:translateY(-7px);
            box-shadow:0 18px 40px rgba(75,44,44,0.16);
        }
        .prod-img-wrap {
            position:relative;
            height:210px;
            overflow:hidden;
        }
        .prod-img-wrap img {
            width:100%; height:100%;
            object-fit:cover;
            transition:transform 0.4s;
        }
        .prod-card:hover .prod-img-wrap img { transform:scale(1.07); }

        .prod-badge {
            position:absolute;
            top:12px; left:12px;
            background:#e74c3c;
            color:#fff;
            font-size:11px;
            font-weight:700;
            padding:4px 10px;
            border-radius:20px;
        }

        .prod-body { padding:16px 18px 18px; }
        .prod-type {
            font-size:10px;
            color:#b08060;
            text-transform:uppercase;
            letter-spacing:1.2px;
            margin-bottom:5px;
            font-weight:500;
        }
        .prod-name {
            font-family:'Playfair Display',serif;
            font-size:1rem;
            color:#2a2a2a;
            margin-bottom:12px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .prod-price {
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:14px;
        }
        .prod-old { text-decoration:line-through; color:#bbb; font-size:12px; }
        .prod-final { font-size:1.2rem; font-weight:700; color:#4b2c2c; }

        .prod-btn {
            width:100%;
            background:#4b2c2c;
            color:#fff;
            border:none;
            padding:10px;
            border-radius:25px;
            font-size:13px;
            font-family:'DM Sans',sans-serif;
            font-weight:500;
            cursor:pointer;
            transition:background 0.3s;
        }
        .prod-btn:hover { background:#7a4040; }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align:center;
            padding:80px 20px;
            grid-column:1/-1;
            background:#fff;
            border-radius:16px;
            box-shadow:0 4px 18px rgba(75,44,44,0.06);
        }
        .empty-state i { font-size:4rem; color:#ddd; margin-bottom:20px; display:block; }
        .empty-state h3 {
            font-family:'Playfair Display',serif;
            font-size:1.4rem;
            color:#999;
            margin-bottom:8px;
        }
        .empty-state p { color:#bbb; font-size:13px; margin-bottom:20px; }
        .empty-state a {
            display:inline-flex; align-items:center; gap:6px;
            background:#4b2c2c; color:#fff;
            padding:10px 24px; border-radius:25px;
            text-decoration:none; font-size:13px;
            transition:background 0.3s;
        }
        .empty-state a:hover { background:#7a4040; }

        /* ── FOOTER ── */
        .footer { background:#2c1a1a; color:rgba(255,255,255,0.75); padding:50px 40px 20px; }
        .footer-top { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:30px; margin-bottom:35px; }
        .footer-block h3 { color:#fff; font-family:'Playfair Display',serif; font-size:1.1rem; margin-bottom:14px; padding-bottom:8px; border-bottom:2px solid #d4a96a; display:inline-block; }
        .footer-block p,.footer-block ul li { font-size:13px; line-height:2; list-style:none; }
        .footer-block ul li a { color:rgba(255,255,255,0.65); text-decoration:none; transition:color 0.2s; }
        .footer-block ul li a:hover { color:#d4a96a; }
        .footer-bottom { border-top:1px solid rgba(255,255,255,0.1); padding-top:18px; text-align:center; font-size:12px; color:rgba(255,255,255,0.4); }

        @media(max-width:600px){
            .cat-hero h1 { font-size:1.7rem; }
            .cat-hero { padding:40px 20px 30px; }
            .products-section { padding:0 16px; }
            .toolbar { padding:0 16px; }
            .products-grid { grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:14px; }
        }

        /* ── SEARCH PAGE EXTRAS ── */
        .search-big { max-width:620px; margin-top:22px; display:flex; background:#fff; border-radius:40px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,0.18); position:relative; z-index:1; }
        .search-big input { flex:1; border:none; outline:none; padding:14px 22px; font-size:15px; font-family:'DM Sans',sans-serif; }
        .search-big button { border:none; background:#d4a96a; color:#2c1a1a; padding:0 26px; font-weight:600; cursor:pointer; font-size:14px; }
        .search-big button:hover { background:#c49655; }
        .filter-chips { display:flex; gap:8px; flex-wrap:wrap; }
        .chip { padding:7px 16px; border-radius:20px; border:1px solid #d8cfc5; background:#fff; color:#4b2c2c; font-size:13px; text-decoration:none; transition:all 0.2s; }
        .chip:hover { border-color:#4b2c2c; }
        .chip.active { background:#4b2c2c; color:#fff; border-color:#4b2c2c; }
        .chip span { opacity:0.7; font-size:11px; margin-left:3px; }
        .section-title { font-family:'Playfair Display',serif; color:#4b2c2c; font-size:1.4rem; margin:10px 0 18px; }
        .svc-avatar { width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#4b2c2c,#7a4040); color:#fff; font-size:3rem; font-weight:700; font-family:'Playfair Display',serif; }
        .svc-meta { font-size:12px; color:#888; margin:4px 0 8px; }
        .svc-meta i { color:#d4a96a; margin-right:4px; }
        .suggest-links { margin-top:14px; font-size:13px; color:#888; }
        .suggest-links a { color:#4b2c2c; font-weight:600; margin:0 6px; text-decoration:none; }
        .suggest-links a:hover { text-decoration:underline; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="topheader">
    <div class="headerleftside">
        <div class="logo-box"><img src="assets/images/logo.png" alt="Logo"/></div>
        <div class="search-box">
            <form action="search.php" method="GET" style="display:contents;">
                <input type="text" name="q" placeholder="Search products & services..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass" style="cursor:pointer;" onclick="this.closest('form').submit()"></i>
            </form>
        </div>
    </div>
    <div class="headerrightside">
        <div class="user-menu">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <a class="login" href="logout.php">Logout</a>
            <?php } else { ?>
                <a class="login" href="signup.php">Login/Signup</a>
            <?php } ?>
            <a class="my-account" href="userdashboard/userdashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
        </div>
        <div class="cart-box">
            <a href="cart.php" style="position:relative;display:inline-block;">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-text">Cart</span>
                <?php if($cart_count > 0){ ?>
                <span id="cart-badge" style="position:absolute;top:-8px;right:-10px;background:#e74c3c;color:white;font-size:11px;font-weight:bold;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;"><?php echo $cart_count; ?></span>
                <?php } ?>
            </a>
        </div>
    </div>
    <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
</div>
<div class="bottomheader">
    <a href="index.php" class="nav-btn">Home</a>
    <a href="paint.php" class="nav-btn">Paint Visualizer</a>
    <a href="Tiles.php" class="nav-btn">Tiles</a>
    <a href="wallpaper.php" class="nav-btn">Wallpaper</a>
    <a href="wallpenals.php" class="nav-btn">Wall Panelling</a>
    <a href="services.php" class="nav-btn">Services</a>
    <a href="room-preview.php" class="nav-btn">AI Room Designer</a>
</div>

<!-- HERO -->
<div class="cat-hero">
    <div class="breadcrumb">
        <a href="index.php">Home</a> &rsaquo;
        <span>Search</span>
    </div>
    <h1><?php echo $q !== '' ? 'Results for &ldquo;' . htmlspecialchars($q) . '&rdquo;' : 'Search'; ?></h1>
    <p class="cat-hero-sub">
        <?php if ($q !== '') { echo $total_all . ' result' . ($total_all != 1 ? 's' : '') . ' found'; }
              else { echo 'Find wallpapers, tiles, wall panels, paints and services'; } ?>
    </p>
    <form class="search-big" action="search.php" method="GET">
        <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Try &quot;marble tiles&quot;, &quot;wood panel&quot;, &quot;floral wallpaper&quot;..." autofocus>
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    </form>
    <div class="hero-line"></div>
</div>

<?php if ($q !== ''): ?>
<!-- TOOLBAR -->
<div class="toolbar">
    <div class="filter-chips">
        <a class="chip <?php echo $filter=='all'?'active':''; ?>" href="<?php echo chip_url($q,'all',$sort); ?>">All<span>(<?php echo $total_all; ?>)</span></a>
        <a class="chip <?php echo $filter=='wallpaper'?'active':''; ?>" href="<?php echo chip_url($q,'wallpaper',$sort); ?>">Wallpaper<span>(<?php echo $counts['wallpaper']; ?>)</span></a>
        <a class="chip <?php echo $filter=='tiles'?'active':''; ?>" href="<?php echo chip_url($q,'tiles',$sort); ?>">Tiles<span>(<?php echo $counts['tiles']; ?>)</span></a>
        <a class="chip <?php echo $filter=='paneling'?'active':''; ?>" href="<?php echo chip_url($q,'paneling',$sort); ?>">Wall Panels<span>(<?php echo $counts['paneling']; ?>)</span></a>
        <a class="chip <?php echo $filter=='paint'?'active':''; ?>" href="<?php echo chip_url($q,'paint',$sort); ?>">Paint<span>(<?php echo $counts['paint']; ?>)</span></a>
        <a class="chip <?php echo $filter=='services'?'active':''; ?>" href="<?php echo chip_url($q,'services',$sort); ?>">Services<span>(<?php echo $svc_total; ?>)</span></a>
    </div>
    <?php if ($filter !== 'services'): ?>
    <select class="sort-select" onchange="sortResults(this.value)">
        <option value="relevance" <?php echo $sort=='relevance'?'selected':''; ?>>Most Relevant</option>
        <option value="new"  <?php echo $sort=='new' ?'selected':''; ?>>Newest First</option>
        <option value="low"  <?php echo $sort=='low' ?'selected':''; ?>>Price: Low to High</option>
        <option value="high" <?php echo $sort=='high'?'selected':''; ?>>Price: High to Low</option>
    </select>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="products-section">

    <?php if ($q === ''): ?>
        <div class="products-grid">
            <div class="empty-state">
                <i class="fa-solid fa-magnifying-glass"></i>
                <h3>What are you looking for?</h3>
                <p>Type a product name, material or service in the search box above.</p>
                <div class="suggest-links">
                    Popular:
                    <a href="search.php?q=marble">Marble</a>
                    <a href="search.php?q=wood">Wood</a>
                    <a href="search.php?q=floral">Floral</a>
                    <a href="search.php?q=pvc">PVC</a>
                    <a href="search.php?q=tile+fitting">Tile Fitting</a>
                </div>
            </div>
        </div>

    <?php elseif ($shown == 0): ?>
        <div class="products-grid">
            <div class="empty-state">
                <i class="fa-regular fa-face-frown"></i>
                <h3>No results for &ldquo;<?php echo htmlspecialchars($q); ?>&rdquo;</h3>
                <p>Check the spelling or try a more general word.</p>
                <div class="suggest-links">
                    Browse:
                    <a href="wallpaper.php">Wallpaper</a>
                    <a href="Tiles.php">Tiles</a>
                    <a href="wallpenals.php">Wall Panels</a>
                    <a href="PaintShop.php">Paint</a>
                    <a href="services.php">Services</a>
                </div>
            </div>
        </div>

    <?php else: ?>

        <?php if (!empty($products)): ?>
        <?php if (!empty($services)): ?><h2 class="section-title">Products (<?php echo count($products); ?>)</h2><?php endif; ?>
        <div class="products-grid">
            <?php foreach ($products as $row):
                $price    = $row['price'];
                $discount = $row['discount'];
                $final    = $price - ($price * $discount / 100);
                $id       = intval($row['id']);
                $img      = "uploads/" . htmlspecialchars($row['product_image']);
                $name     = htmlspecialchars($row['name']);
                $ptype    = htmlspecialchars($row['product_type']);
            ?>
            <div class="prod-card" onclick="window.location.href='product_detail.php?id=<?php echo $id; ?>'">
                <div class="prod-img-wrap">
                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>" loading="lazy">
                    <?php if ($discount > 0): ?>
                    <span class="prod-badge"><?php echo intval($discount); ?>% OFF</span>
                    <?php endif; ?>
                </div>
                <div class="prod-body">
                    <p class="prod-type"><?php echo $ptype; ?></p>
                    <h3 class="prod-name"><?php echo $name; ?></h3>
                    <div class="prod-price">
                        <?php if ($discount > 0): ?>
                        <span class="prod-old">Rs. <?php echo number_format($price, 0); ?></span>
                        <?php endif; ?>
                        <span class="prod-final">Rs. <?php echo number_format($final, 0); ?></span>
                    </div>
                    <button class="prod-btn" onclick="event.stopPropagation();window.location.href='product_detail.php?id=<?php echo $id; ?>'">
                        View Details
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($services)): ?>
        <h2 class="section-title" style="margin-top:<?php echo empty($products) ? '10px' : '40px'; ?>;">Services (<?php echo count($services); ?>)</h2>
        <div class="products-grid">
            <?php foreach ($services as $s):
                $sid   = intval($s['service_id']);
                $sname = htmlspecialchars(trim($s['service_name']));
                $pname = htmlspecialchars($s['serviceprovider_name']);
                $pic   = $s['profile_image'];
                $src   = '';
                if (!empty($pic)) $src = (strpos($pic, 'http') === 0) ? $pic : 'uploads/' . $pic;
            ?>
            <div class="prod-card" onclick="window.location.href='providerview.php?id=<?php echo $sid; ?>'">
                <div class="prod-img-wrap">
                    <?php if ($src): ?>
                        <img src="<?php echo htmlspecialchars($src); ?>" alt="<?php echo $pname; ?>" loading="lazy">
                    <?php else: ?>
                        <div class="svc-avatar"><?php echo strtoupper(substr($pname, 0, 1)); ?></div>
                    <?php endif; ?>
                </div>
                <div class="prod-body">
                    <p class="prod-type"><?php echo htmlspecialchars($s['category'] ?: 'Service'); ?></p>
                    <h3 class="prod-name"><?php echo $sname; ?></h3>
                    <p class="svc-meta">
                        <i class="fa-solid fa-user"></i><?php echo $pname; ?> &nbsp;
                        <?php if (!empty($s['city'])): ?><i class="fa-solid fa-location-dot"></i><?php echo htmlspecialchars($s['city']); ?><?php endif; ?>
                    </p>
                    <div class="prod-price">
                        <span class="prod-final">Rs. <?php echo number_format($s['started_at'], 0); ?></span>
                        <span class="prod-old" style="text-decoration:none;">/ sq.ft</span>
                    </div>
                    <button class="prod-btn" onclick="event.stopPropagation();window.location.href='providerview.php?id=<?php echo $sid; ?>'">
                        View Provider
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>

<!-- FOOTER -->
<?php include 'Footer.php'; ?>

<script>
function sortResults(sortBy){
    const params = new URLSearchParams(window.location.search);
    params.set('sort', sortBy);
    window.location.href = 'search.php?' + params.toString();
}
const hamburger = document.querySelector('.hamburger');
const nav       = document.querySelector('.bottomheader');
if (hamburger) hamburger.addEventListener('click',()=>{ nav.classList.toggle('active'); });
</script>
</body>
</html>
