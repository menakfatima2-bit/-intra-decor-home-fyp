<?php
session_start();
include "db.php";

// Fetch real paint products from the database so users can actually buy them
$paint_products = [];
$pp_res = mysqli_query($conn, "SELECT id, product_type, price, discount, finish_type, material, product_image FROM productadd WHERE category='paint' AND status='approved' ORDER BY product_type ASC");
if ($pp_res) {
    while ($row = mysqli_fetch_assoc($pp_res)) {
        $paint_products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Paint Visualizer – Interior Hues</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/Footer.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
<style>
/* PAGE TITLE BANNER */
.page-header{background:linear-gradient(135deg,#3a1e1e 0%,#4b2c2c 100%);padding:28px;text-align:center;}
.page-header h1{font-size:34px;color:#fff;margin-bottom:6px;letter-spacing:0.5px;font-family:Georgia,serif;}
.page-header h1 span{color:#d4a56a;}
.page-header p{font-size:14px;color:#d1b1b1;max-width:480px;margin:0 auto;}
.how-to{display:flex;justify-content:center;gap:28px;padding:16px 28px;background:#fff;border-bottom:1px solid #eee;flex-wrap:wrap;}
.how-to .step{display:flex;align-items:center;gap:9px;font-size:12px;color:#888;}
.how-to .step .num{width:22px;height:22px;background:#4b2c2c;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;}
.main{display:grid;grid-template-columns:1fr 280px;height:calc(100vh - 296px);min-height:520px;}
.room-side{padding:16px;display:flex;flex-direction:column;gap:12px;overflow:hidden;}
.room-tabs{display:flex;gap:6px;}
.rtab{padding:6px 14px;border-radius:20px;border:1px solid var(--border);background:#fff;font-size:12px;cursor:pointer;font-family:var(--font);color:#888;transition:all 0.18s;}
.rtab.active{background:#4b2c2c;color:#fff;border-color:#4b2c2c;}
.canvas-box{position:relative;border-radius:14px;overflow:hidden;border:1px solid var(--border);flex:1;background:#e8e2d9;min-height:280px;}
#room-canvas{width:100%;height:100%;display:block;}
.wall-hint{position:absolute;bottom:12px;left:50%;transform:translateX(-50%);background:rgba(28,25,23,0.72);color:#fff;font-size:11px;padding:5px 14px;border-radius:20px;pointer-events:none;white-space:nowrap;}
.wall-row{display:flex;gap:7px;}
.wchip{display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:20px;border:1.5px solid var(--border);background:#fff;cursor:pointer;font-size:12px;font-family:var(--font);transition:all 0.15s;}
.wchip.active{border-color:#4b2c2c;background:#f5eded;}
.wdot{width:12px;height:12px;border-radius:50%;border:1px solid rgba(0,0,0,0.12);}
.suggest-box{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:12px 14px;}
.suggest-label{font-size:10px;letter-spacing:0.08em;text-transform:uppercase;color:#999;margin-bottom:10px;}
.suggest-row{display:flex;gap:8px;flex-wrap:wrap;}
.sug-item{display:flex;align-items:center;gap:7px;padding:6px 10px;border-radius:8px;border:1px solid var(--border);cursor:pointer;background:#faf8f5;transition:all 0.15s;font-size:12px;}
.sug-item:hover{border-color:#4b2c2c;background:#f5eded;}
.sug-dot{width:22px;height:22px;border-radius:5px;flex-shrink:0;border:1px solid rgba(0,0,0,0.08);}
.sug-info{display:flex;flex-direction:column;}
.sug-name{font-size:11px;font-weight:500;color:#333;}
.sug-wall{font-size:10px;color:#999;}
.panel{background:#fff;border-left:1px solid var(--border);display:flex;flex-direction:column;overflow-y:auto;overflow-x:hidden;}
.panel-head{padding:14px 16px;border-bottom:1px solid var(--border);}
.panel-title{font-size:13px;font-weight:500;color:#4b2c2c;margin-bottom:10px;}
.brand-row{display:flex;gap:4px;margin-bottom:12px;}
.btab{padding:4px 11px;border-radius:16px;border:1px solid var(--border);font-size:11px;cursor:pointer;background:transparent;font-family:var(--font);color:#888;transition:all 0.15s;}
.btab.active{background:#4b2c2c;color:#fff;border-color:#4b2c2c;}
.search-box{display:flex;align-items:center;gap:6px;border:1px solid var(--border);border-radius:8px;padding:6px 10px;background:#faf8f5;margin-bottom:10px;}
.search-box input{border:none;background:transparent;font-size:12px;font-family:var(--font);color:#333;outline:none;flex:1;}
.search-box input::placeholder{color:#bbb;}
.cat-row{display:flex;gap:4px;flex-wrap:wrap;margin-bottom:10px;}
.cat{padding:3px 9px;border-radius:12px;border:1px solid var(--border);font-size:11px;cursor:pointer;background:transparent;font-family:var(--font);color:#888;transition:all 0.12s;}
.cat.active{background:#4b2c2c;color:#fff;border-color:#4b2c2c;}
.color-scroll{padding:0 16px 8px;}
.color-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:5px;margin-bottom:10px;}
.csw{aspect-ratio:1;border-radius:7px;cursor:pointer;border:2px solid transparent;transition:all 0.15s;position:relative;}
.csw:hover{transform:scale(1.07);z-index:2;}
.csw.sel{border-color:#4b2c2c;transform:scale(1.1);z-index:3;}
.csw .tip{position:absolute;bottom:calc(100% + 4px);left:50%;transform:translateX(-50%);background:var(--dark);color:#fff;font-size:9px;padding:2px 6px;border-radius:5px;white-space:nowrap;pointer-events:none;opacity:0;transition:opacity 0.15s;z-index:10;}
.csw:hover .tip{opacity:1;}
.shade-section{padding:0 16px 10px;}
.shade-label{font-size:10px;letter-spacing:0.07em;text-transform:uppercase;color:#999;margin-bottom:7px;}
.shade-row{display:flex;gap:3px;}
.sh{flex:1;height:26px;border-radius:5px;cursor:pointer;border:2px solid transparent;transition:all 0.15s;}
.sh.sel{border-color:#4b2c2c;}
.sel-card{margin:0 16px 10px;display:flex;align-items:center;gap:10px;padding:10px;background:#faf8f5;border-radius:var(--radius);border:1px solid var(--border);}
.sel-swatch{width:40px;height:40px;border-radius:8px;flex-shrink:0;border:1px solid rgba(0,0,0,0.08);}
.sel-name{font-size:13px;font-weight:500;color:#4b2c2c;}
.sel-code{font-size:10px;color:#999;margin-top:2px;}
.sel-brand{font-size:10px;color:#4b2c2c;margin-top:2px;font-weight:500;}
.reset-btn{margin:0 16px 14px;padding:8px;border-radius:var(--radius);border:1px solid var(--border);background:transparent;font-family:var(--font);font-size:12px;color:#888;cursor:pointer;width:calc(100% - 32px);transition:background 0.15s;}
.reset-btn:hover{background:#faf8f5;}

/* NEW: Paint Calculator */
.paint-calc-box{margin:0 16px 14px;padding:14px;background:#fff8f2;border:1px dashed #c17f4a;border-radius:var(--radius);}
.paint-calc-title{font-size:13px;font-weight:600;color:#4b2c2c;margin-bottom:10px;display:flex;align-items:center;gap:6px;}
.paint-calc-inputs{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:10px;}
.paint-calc-inputs label{font-size:10px;color:#8a6a5a;display:block;margin-bottom:3px;}
.paint-calc-inputs input{width:100%;padding:6px 8px;border-radius:6px;border:1px solid var(--border);font-family:var(--font);font-size:12px;}
.paint-calc-btn{width:100%;padding:9px;border:none;border-radius:var(--radius);background:#4b2c2c;color:#fff;font-family:var(--font);font-size:12px;font-weight:600;cursor:pointer;transition:background 0.15s;}
.paint-calc-btn:hover{background:#3a2222;}
.paint-calc-result{margin-top:10px;padding:10px;background:#fff;border-radius:8px;font-size:12px;color:#4b2c2c;line-height:1.6;border:1px solid #eee;}
.paint-calc-result strong{color:#c17f4a;}

/* NEW: Download / Share buttons */
.paint-actions{margin:0 16px 10px;display:flex;gap:8px;}
.paint-action-btn{flex:1;padding:9px;border:none;border-radius:var(--radius);font-family:var(--font);font-size:12px;font-weight:600;cursor:pointer;color:#fff;display:flex;align-items:center;justify-content:center;gap:6px;transition:0.15s;}
.paint-action-btn.download{background:#c17f4a;}
.paint-action-btn.download:hover{background:#a8693a;}
.paint-action-btn.share{background:#25D366;}
.paint-action-btn.share:hover{background:#1ebc59;}
/* Footer styling now lives in assets/css/Footer.css (shared across all pages) */

@media(max-width:700px){
  .main{grid-template-columns:1fr;height:auto;}
  .panel{max-height:none;border-left:none;border-top:1px solid var(--border);}
  .how-to{gap:12px;}
  .room-side{height:60vh;}
}
</style>
</head>
<body>

<!-- TOP HEADER -->
<div class="topheader">
  <div class="headerleftside">
    <div class="logo-box">
      <img src="assets/images/logo.png" alt="Logo"/>
    </div>
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
      <a href="cart.php">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-text">Cart</span>
      </a>
    </div>
  </div>
  <div class="hamburger">
    <i class="fa-solid fa-bars"></i>
  </div>
</div>

<!-- NAVIGATION -->
<div class="bottomheader">
  <a href="index.php" class="nav-btn">Home</a>
  <a href="paint.php" class="nav-btn">Paint Visualizer</a>
  <a href="Tiles.php" class="nav-btn">Tiles</a>
  <a href="wallpaper.php" class="nav-btn">Wallpaper</a>
  <a href="wallpenals.php" class="nav-btn">Wall Panelling</a>
  <a href="services.php" class="nav-btn">Services</a>
  <a href="room-preview.php" class="nav-btn">AI Room Designer</a>
</div>

<!-- PAGE TITLE -->
<div class="page-header">
  <h1>Paint Color <span>Visualizer</span></h1>
  <p>Try wall colors for your home virtually — with real shades from Berger, Dulux, Nippon and Asian Paints</p>
</div>

<div class="how-to">
  <div class="step"><div class="num">1</div> Choose a room</div>
  <div class="step"><div class="num">2</div> Click on a wall</div>
  <div class="step"><div class="num">3</div> Select brand and color</div>
  <div class="step"><div class="num">4</div> View suggestions below</div>
</div>

<div class="main">
  <div class="room-side">
    <div class="room-tabs">
      <button class="rtab active" onclick="switchRoom('living')">Living Room</button>
      <button class="rtab" onclick="switchRoom('bedroom')">Bedroom</button>
    </div>
    <div class="canvas-box">
      <canvas id="room-canvas"></canvas>
      <div class="wall-hint">Click on a wall to select it</div>
    </div>
    <div class="wall-row" id="wall-row"></div>
    <div class="suggest-box">
      <div class="suggest-label" id="sug-label">Complementary Suggestions</div>
      <div class="suggest-row" id="sug-row"></div>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head">
      <div class="panel-title">Choose a Color</div>
      <div class="brand-row">
        <button class="btab active" onclick="switchBrand('berger')">Berger</button>
        <button class="btab" onclick="switchBrand('dulux')">Dulux</button>
        <button class="btab" onclick="switchBrand('nippon')">Nippon</button>
        <button class="btab" onclick="switchBrand('asian')">Asian</button>
      </div>
      <div class="search-box">
        <svg width="13" height="13" fill="none" stroke="#bbb" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" placeholder="Search colors..." oninput="filterColors(this.value)" id="search-inp"/>
      </div>
      <div class="cat-row" id="cat-row"></div>
    </div>
    <div class="color-scroll">
      <div class="color-grid" id="cgrid"></div>
    </div>
    <div class="shade-section">
      <div class="shade-label">Shade (Light → Dark)</div>
      <div class="shade-row" id="shade-row"></div>
    </div>
    <div class="sel-card">
      <div class="sel-swatch" id="sel-sw"></div>
      <div>
        <div class="sel-name" id="sel-nm">Select a color</div>
        <div class="sel-code" id="sel-cd">—</div>
        <div class="sel-brand" id="sel-br"></div>
      </div>
    </div>
    <a id="buy-color-btn" href="#" style="display:none;margin:10px 16px 0;padding:10px 14px;background:#4b2c2c;color:#fff;text-align:center;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
      <i class="fa-solid fa-cart-shopping"></i> Buy This Color
    </a>

    <!-- NEW: Paint Calculator -->
    <div class="paint-calc-box">
      <div class="paint-calc-title"><i class="fa-solid fa-calculator"></i> Paint Calculator</div>
      <div class="paint-calc-inputs">
        <div>
          <label>Wall Length (ft)</label>
          <input type="number" id="pc-length" min="1" placeholder="e.g. 12">
        </div>
        <div>
          <label>Wall Width (ft)</label>
          <input type="number" id="pc-width" min="1" placeholder="e.g. 10">
        </div>
        <div>
          <label>Wall Height (ft)</label>
          <input type="number" id="pc-height" min="1" value="10">
        </div>
      </div>
      <button class="paint-calc-btn" onclick="calculatePaint()">Calculate Paint Needed</button>
      <div id="pc-result" class="paint-calc-result" style="display:none;"></div>
    </div>

    <!-- NEW: Buy This Paint -->
    <div class="paint-calc-box" id="buy-paint-box">
      <div class="paint-calc-title"><i class="fa-solid fa-cart-shopping"></i> Buy This Paint</div>
      <?php if (count($paint_products) > 0): ?>
        <div style="margin-bottom:10px;">
          <label style="font-size:10px;color:#8a6a5a;display:block;margin-bottom:3px;">Select Product</label>
          <select id="buy-paint-select" style="width:100%;padding:7px 9px;border-radius:6px;border:1px solid var(--border);font-family:var(--font);font-size:12px;">
            <?php foreach ($paint_products as $pp):
                $ppFinal = $pp['price'] - ($pp['price'] * $pp['discount'] / 100);
            ?>
              <option value="<?php echo $pp['id']; ?>" data-price="<?php echo $ppFinal; ?>">
                <?php
                  $label = htmlspecialchars($pp['product_type']);
                  if (!empty($pp['finish_type'])) $label .= ' — ' . htmlspecialchars($pp['finish_type']);
                  if (!empty($pp['material']))    $label .= ' — ' . htmlspecialchars($pp['material']);
                  echo $label;
                ?> — Rs. <?php echo number_format($ppFinal, 0); ?>/L
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div style="margin-bottom:10px;">
          <label style="font-size:10px;color:#8a6a5a;display:block;margin-bottom:3px;">Quantity (Litres)</label>
          <input type="number" id="buy-paint-qty" min="1" value="1" style="width:100%;padding:7px 9px;border-radius:6px;border:1px solid var(--border);font-family:var(--font);font-size:12px;">
          <small style="font-size:10px;color:#aaa;">Tip: Calculate paint above first — quantity will auto-fill.</small>
        </div>
        <button class="paint-calc-btn" onclick="addPaintToCart()">
          <i class="fa-solid fa-cart-plus"></i> Add to Cart
        </button>
      <?php else: ?>
        <p style="font-size:12px;color:#999;">No paint products available for purchase right now.</p>
      <?php endif; ?>
    </div>

    <!-- NEW: Download / Share -->
    <div class="paint-actions">
      <button class="paint-action-btn download" onclick="downloadDesign()">
        <i class="fa-solid fa-download"></i> Download
      </button>
      <button class="paint-action-btn share" onclick="shareDesign()">
        <i class="fa-brands fa-whatsapp"></i> Share
      </button>
    </div>

    <button class="reset-btn" onclick="resetAll()">↺ Reset All</button>
  </div>
</div>

<!-- ===== FOOTER — same as index.php ===== -->
<?php include 'Footer.php'; ?>

<script>
const CATS=['All','Whites','Neutrals','Reds','Pinks','Oranges','Yellows','Greens','Blues','Purples','Browns'];
const BRANDS={
  berger:[
    {n:"Ivory Mist",c:"BRG-A01",cat:"Whites",s:["#fefcf8","#f8f2e6","#f0e6d0","#e2d0b0","#c8b485"]},
    {n:"Pearl White",c:"BRG-A02",cat:"Whites",s:["#fdf9f3","#f5edde","#ead8c0","#d4bfa0","#b89e78"]},
    {n:"Snow Breeze",c:"BRG-A03",cat:"Whites",s:["#fefefe","#f6f4f0","#ece8e0","#d8d3c8","#bdb8ac"]},
    {n:"Antique White",c:"BRG-A04",cat:"Whites",s:["#fdf8f0","#f4ead8","#e8d6b8","#d4b890","#b49060"]},
    {n:"Linen",c:"BRG-A05",cat:"Whites",s:["#faf6ee","#f0e8d4","#e0ceb0","#c8b080","#a88848"]},
    {n:"Warm Grey",c:"BRG-B01",cat:"Neutrals",s:["#f0eeec","#d8d4ce","#b8b2a8","#908880","#686058"]},
    {n:"Stone",c:"BRG-B02",cat:"Neutrals",s:["#eeeae4","#d4cfc8","#b8b2a8","#909090","#686868"]},
    {n:"Greige",c:"BRG-B03",cat:"Neutrals",s:["#f2ede6","#ddd5c8","#c4b8a8","#a89880","#887860"]},
    {n:"Taupe",c:"BRG-B04",cat:"Neutrals",s:["#f0ece4","#d8d0c0","#b8a890","#907860","#684838"]},
    {n:"Pebble",c:"BRG-B05",cat:"Neutrals",s:["#eeeae6","#d4d0cc","#b8b4b0","#989490","#706c68"]},
    {n:"Coral Bliss",c:"BRG-C01",cat:"Reds",s:["#fde8e0","#f9c4b0","#f09878","#d96840","#b04020"]},
    {n:"Crimson",c:"BRG-C02",cat:"Reds",s:["#fde0e0","#f8b8b8","#f08080","#d04040","#a01818"]},
    {n:"Brick Red",c:"BRG-C03",cat:"Reds",s:["#fce4dc","#f4bfb0","#e89080","#cc5840","#982818"]},
    {n:"Ruby",c:"BRG-C04",cat:"Reds",s:["#fce0e8","#f8b8c8","#f08098","#c84068","#982040"]},
    {n:"Tomato",c:"BRG-C05",cat:"Reds",s:["#fde4dc","#fac4b4","#f49880","#e06040","#b83020"]},
    {n:"Blush Pink",c:"BRG-D01",cat:"Pinks",s:["#fce8f0","#f8c8dc","#f0a0c0","#d86898","#a83868"]},
    {n:"Rose Petal",c:"BRG-D02",cat:"Pinks",s:["#fce8f0","#f4c0d4","#e890b0","#d05880","#a02858"]},
    {n:"Dusty Rose",c:"BRG-D03",cat:"Pinks",s:["#f8e8ec","#eeccd8","#e0a8c0","#c87898","#a04870"]},
    {n:"Baby Pink",c:"BRG-D04",cat:"Pinks",s:["#fef0f4","#fcd8e4","#f8b8d0","#f090b0","#d05880"]},
    {n:"Peach",c:"BRG-D05",cat:"Pinks",s:["#fef0e8","#fcd8c4","#f8b898","#f08860","#c85830"]},
    {n:"Tangerine",c:"BRG-E01",cat:"Oranges",s:["#feeee0","#fcd5b0","#f8b478","#f08040","#c05010"]},
    {n:"Apricot",c:"BRG-E02",cat:"Oranges",s:["#fef0e4","#fcd8b8","#f8b880","#f09040","#c86010"]},
    {n:"Terracotta",c:"BRG-E03",cat:"Oranges",s:["#f8e8e0","#f0c0a8","#e09070","#c05838","#903018"]},
    {n:"Amber",c:"BRG-E04",cat:"Oranges",s:["#fdf4e0","#fae0a0","#f4c040","#d89800","#a86800"]},
    {n:"Burnt Orange",c:"BRG-E05",cat:"Oranges",s:["#fce8dc","#f8c4a8","#f09870","#d86030","#a83000"]},
    {n:"Sunshine",c:"BRG-F01",cat:"Yellows",s:["#fefce0","#faf4a0","#f4e840","#d4c000","#a09000"]},
    {n:"Butter",c:"BRG-F02",cat:"Yellows",s:["#fefce8","#faf4c8","#f4e898","#e8d050","#c0a800"]},
    {n:"Lemon",c:"BRG-F03",cat:"Yellows",s:["#fefee8","#fafac8","#f4f490","#d4d430","#a0a000"]},
    {n:"Mustard",c:"BRG-F04",cat:"Yellows",s:["#fdf4e0","#f8e098","#e8c040","#c89808","#986800"]},
    {n:"Gold",c:"BRG-F05",cat:"Yellows",s:["#fdf0d8","#f8d898","#e8b850","#c88810","#987000"]},
    {n:"Sage Mist",c:"BRG-G01",cat:"Greens",s:["#e8f0e8","#c4d8c4","#98bc98","#6a9a6a","#3e723e"]},
    {n:"Mint Breeze",c:"BRG-G02",cat:"Greens",s:["#e0f8f0","#a8ecd8","#60d4b0","#20b080","#008060"]},
    {n:"Olive",c:"BRG-G03",cat:"Greens",s:["#eef0e0","#d4d8a8","#b0b870","#888840","#606010"]},
    {n:"Emerald",c:"BRG-G04",cat:"Greens",s:["#e0f0e8","#a8d8b8","#60b880","#188840","#006820"]},
    {n:"Forest",c:"BRG-G05",cat:"Greens",s:["#e0eee0","#a8cca8","#70a870","#388838","#085808"]},
    {n:"Pistachio",c:"BRG-G06",cat:"Greens",s:["#e8f4e0","#c8e4b0","#a0cc78","#78a840","#508010"]},
    {n:"Sky Dream",c:"BRG-H01",cat:"Blues",s:["#e4f0fa","#b8d8f4","#80b8ec","#4090d8","#1060b0"]},
    {n:"Ocean Blue",c:"BRG-H02",cat:"Blues",s:["#e0e8f8","#b0c4f0","#7098e4","#2858c8","#0828a0"]},
    {n:"Powder Blue",c:"BRG-H03",cat:"Blues",s:["#e8f0f8","#c0d4ee","#90b0e0","#5080c8","#1850a0"]},
    {n:"Teal",c:"BRG-H04",cat:"Blues",s:["#e0f4f4","#a8e0de","#60c0be","#209898","#006868"]},
    {n:"Navy",c:"BRG-H05",cat:"Blues",s:["#e0e4f0","#a8b4d8","#6070b0","#283888","#081060"]},
    {n:"Denim",c:"BRG-H06",cat:"Blues",s:["#e4eaf4","#b8c8e8","#8098d4","#4060b0","#183088"]},
    {n:"Lavender",c:"BRG-I01",cat:"Purples",s:["#ede8f8","#d0c4f0","#b098e4","#8860d0","#5830a0"]},
    {n:"Lilac",c:"BRG-I02",cat:"Purples",s:["#f0e8f8","#d8c0f0","#b890e0","#9060c8","#683098"]},
    {n:"Violet",c:"BRG-I03",cat:"Purples",s:["#ece0f8","#d0b0f0","#a870e4","#8030d0","#5000a8"]},
    {n:"Mauve",c:"BRG-I04",cat:"Purples",s:["#f0e4f4","#dcc0ea","#c090d8","#9858b8","#703090"]},
    {n:"Plum",c:"BRG-I05",cat:"Purples",s:["#eee0f4","#d4b0e8","#b070d0","#8830b0","#600088"]},
    {n:"Sandalwood",c:"BRG-J01",cat:"Browns",s:["#f5ede0","#e8d0b0","#d4ae80","#b88848","#8a6020"]},
    {n:"Cinnamon",c:"BRG-J02",cat:"Browns",s:["#f4e8e0","#e8c8a8","#d0986e","#b06030","#804018"]},
    {n:"Mocha",c:"BRG-J03",cat:"Browns",s:["#f0e8e0","#d8c4a8","#b89870","#907040","#685018"]},
    {n:"Chocolate",c:"BRG-J04",cat:"Browns",s:["#eee8e0","#d4c0a0","#b09070","#886040","#603818"]},
    {n:"Caramel",c:"BRG-J05",cat:"Browns",s:["#f4ece0","#e8d0a8","#d4a870","#b87838","#885010"]},
  ],
  dulux:[
    {n:"Timeless",c:"DLX-001",cat:"Whites",s:["#faf6ee","#f0e8d4","#e0d0b0","#c8b080","#a88848"]},
    {n:"Gardenia",c:"DLX-002",cat:"Whites",s:["#fdf9f2","#f5ecd8","#e8d8b4","#d4bc84","#b89450"]},
    {n:"White Mist",c:"DLX-003",cat:"Whites",s:["#fefefe","#f8f6f2","#eeebe4","#d8d4cc","#b8b4ac"]},
    {n:"Magnolia",c:"DLX-004",cat:"Whites",s:["#fefbf4","#f8f0e0","#ede0c8","#d8c8a8","#b8a880"]},
    {n:"Egyptian Cotton",c:"DLX-005",cat:"Neutrals",s:["#f9f0e4","#eedcbc","#e0c490","#c8a060","#a07830"]},
    {n:"Goose Down",c:"DLX-006",cat:"Neutrals",s:["#f5f0e8","#e4d8c0","#ccbc90","#b09860","#8a7030"]},
    {n:"Warm Cocoa",c:"DLX-007",cat:"Browns",s:["#f0e8e0","#d8c4b0","#c09878","#a07040","#784818"]},
    {n:"Chic Shadow",c:"DLX-008",cat:"Purples",s:["#e8e4f0","#ccc4e4","#a898d0","#8068b8","#5838a0"]},
    {n:"Forest Fern",c:"DLX-009",cat:"Greens",s:["#e4f0e4","#b8d8b8","#80b880","#489448","#186818"]},
    {n:"Mineral Mist",c:"DLX-010",cat:"Blues",s:["#e4eef4","#b8d2e4","#80aed0","#4880b4","#185894"]},
    {n:"Sunset Haze",c:"DLX-011",cat:"Oranges",s:["#fdf0e4","#f8d4b0","#f0b070","#e08030","#c05800"]},
    {n:"Frosted Mint",c:"DLX-012",cat:"Greens",s:["#e8f8f4","#b8ecdc","#78d8bc","#30b890","#009068"]},
    {n:"Dusky Rose",c:"DLX-013",cat:"Pinks",s:["#f8e8ec","#f0c4d4","#e090b0","#c05880","#903050"]},
    {n:"Cobalt Blue",c:"DLX-014",cat:"Blues",s:["#e0e8f8","#a8c0f0","#6080e0","#2840c0","#081098"]},
    {n:"Terracotta Spice",c:"DLX-015",cat:"Reds",s:["#f4e4dc","#e8c0a8","#d08870","#b05030","#882808"]},
    {n:"Olive Leaf",c:"DLX-016",cat:"Greens",s:["#eef0de","#d4d8a8","#b0b868","#889030","#606000"]},
    {n:"Plum Wine",c:"DLX-017",cat:"Purples",s:["#f0e0f0","#d8a8d8","#b860b8","#900090","#680068"]},
    {n:"Steel Blue",c:"DLX-018",cat:"Blues",s:["#e4ecf4","#b8cce4","#80a8d0","#407898","#105870"]},
  ],
  nippon:[
    {n:"Pearl Lust",c:"NIP-101",cat:"Whites",s:["#faf8f4","#f0ecdf","#e0d8c0","#c8bc98","#a89870"]},
    {n:"Arctic White",c:"NIP-102",cat:"Whites",s:["#f8f8f8","#eeeee8","#e0dfd8","#ccccbf","#b8b8a8"]},
    {n:"Sakura Pink",c:"NIP-103",cat:"Pinks",s:["#fce8ec","#f8c0cc","#f090a4","#e05878","#b82850"]},
    {n:"Zen Grey",c:"NIP-104",cat:"Neutrals",s:["#f0eeec","#d8d4ce","#b8b2a8","#908880","#686058"]},
    {n:"Bamboo Green",c:"NIP-105",cat:"Greens",s:["#e8f2e4","#c0ddb8","#90c080","#58a048","#287818"]},
    {n:"Ocean Calm",c:"NIP-106",cat:"Blues",s:["#e0eef8","#b0ccec","#70a4d8","#2878c0","#0050a0"]},
    {n:"Saffron",c:"NIP-107",cat:"Yellows",s:["#fdf4e0","#fae0a0","#f4c040","#d89800","#a86800"]},
    {n:"Plum Dusk",c:"NIP-108",cat:"Purples",s:["#f0e4f0","#d8b8d8","#b880b8","#904890","#681868"]},
    {n:"Copper Sand",c:"NIP-109",cat:"Browns",s:["#f4ece4","#e4cebc","#d0a888","#b87848","#905018"]},
    {n:"Indigo Night",c:"NIP-110",cat:"Blues",s:["#e4e8f8","#b8c4f0","#8090e0","#4858c8","#1828b0"]},
    {n:"Sakura White",c:"NIP-111",cat:"Whites",s:["#fef8f8","#f8ece8","#f0d8d0","#e0b8b0","#c09090"]},
    {n:"Matcha",c:"NIP-112",cat:"Greens",s:["#e8f0e0","#c4d8a8","#98b870","#688838","#404808"]},
    {n:"Sky Haze",c:"NIP-113",cat:"Blues",s:["#e8f2fc","#c0d8f4","#88b8e8","#4888d0","#1058a8"]},
    {n:"Coral Sand",c:"NIP-114",cat:"Oranges",s:["#fce8dc","#f8c8a8","#f0a070","#d86840","#a83810"]},
    {n:"Lavender Mist",c:"NIP-115",cat:"Purples",s:["#f0ecf8","#d8cef0","#b8a4e0","#8870c8","#584098"]},
  ],
  asian:[
    {n:"Ivory Dream",c:"ASN-001",cat:"Whites",s:["#fefcf4","#f8f0dc","#f0e0b8","#dcc888","#c0a050"]},
    {n:"Vanilla",c:"ASN-002",cat:"Whites",s:["#fefae8","#f8f0c0","#f0e080","#d8c030","#a89000"]},
    {n:"Porcelain",c:"ASN-003",cat:"Whites",s:["#fefefe","#f4f2ee","#e8e4dc","#d0ccc0","#b0ac9e"]},
    {n:"Cashmere",c:"ASN-004",cat:"Neutrals",s:["#f4eeea","#e0d4cc","#c8b8b0","#a89088","#887068"]},
    {n:"Silver Sage",c:"ASN-005",cat:"Greens",s:["#e8ece8","#c8d4c8","#a0b8a0","#789878","#507850"]},
    {n:"Mystic Blue",c:"ASN-006",cat:"Blues",s:["#e4ecf8","#b8ccf0","#7898e0","#3860c0","#103098"]},
    {n:"Papaya",c:"ASN-007",cat:"Oranges",s:["#fdf0e4","#f8d8b0","#f0b070","#d88030","#a85000"]},
    {n:"Jade Green",c:"ASN-008",cat:"Greens",s:["#e0f0e8","#a8d8c0","#60b890","#188860","#006038"]},
    {n:"Berry",c:"ASN-009",cat:"Purples",s:["#f0e0f4","#d8a8e8","#b860d0","#9020a8","#680080"]},
    {n:"Sand Dune",c:"ASN-010",cat:"Browns",s:["#f4ece0","#e8d0a8","#d0a870","#b07838","#885010"]},
    {n:"Flamingo",c:"ASN-011",cat:"Pinks",s:["#fce8f0","#f8c4d8","#f090b8","#d84888","#a01858"]},
    {n:"Sunshine Yellow",c:"ASN-012",cat:"Yellows",s:["#fefce0","#faf498","#f4e840","#d4c000","#a09000"]},
    {n:"Aqua",c:"ASN-013",cat:"Blues",s:["#e0f8f8","#a0e8e8","#48d0d0","#10a8a8","#007878"]},
    {n:"Brick",c:"ASN-014",cat:"Reds",s:["#f4e0dc","#e8b8b0","#d08070","#b04838","#802818"]},
    {n:"Earthy Brown",c:"ASN-015",cat:"Browns",s:["#f0e8e0","#d8c4a8","#b89878","#907048","#685028"]},
  ]
};

const ROOM_DEFS={
  living:{defaultColors:{back:'#e8e2d8',left:'#d8d2c8',right:'#d0cac0'}},
  bedroom:{defaultColors:{back:'#ece6de',left:'#ddd7cf',right:'#d4cec6'}},
  kitchen:{defaultColors:{back:'#f0ece4',left:'#e4e0d8',right:'#dcd8d0'}}
};

function dk(hex,a){
  let r=parseInt(hex.slice(1,3),16),g=parseInt(hex.slice(3,5),16),b=parseInt(hex.slice(5,7),16);
  return'#'+[r,g,b].map(v=>Math.round(v*(1-a)).toString(16).padStart(2,'0')).join('');
}

const canvas=document.getElementById('room-canvas');
const ctx=canvas.getContext('2d');

function poly(pts,fill,stroke,sw){
  ctx.beginPath();ctx.moveTo(pts[0][0],pts[0][1]);
  pts.slice(1).forEach(p=>ctx.lineTo(p[0],p[1]));ctx.closePath();
  if(fill){ctx.fillStyle=fill;ctx.fill();}
  if(stroke){ctx.strokeStyle=stroke;ctx.lineWidth=sw||1;ctx.stroke();}
}
function rct(x,y,w,h,r,fill,stroke,sw){
  ctx.beginPath();
  if(r)ctx.roundRect(x,y,w,h,[r]);else ctx.rect(x,y,w,h);
  if(fill){ctx.fillStyle=fill;ctx.fill();}
  if(stroke){ctx.strokeStyle=stroke;ctx.lineWidth=sw||1;ctx.stroke();}
}

function drawRoom(){
  const W=canvas.width,H=canvas.height;
  const sx=W/580,sy=H/390;
  ctx.clearRect(0,0,W,H);
  ctx.save();ctx.scale(sx,sy);
  if(curRoom==='living')drawLiving();
  else if(curRoom==='bedroom')drawBedroom();
  else drawKitchen();
  const wallPts={
    back:[[80,50],[460,50],[460,295],[80,295]],
    left:[[0,0],[80,50],[80,295],[0,390]],
    right:[[460,50],[580,0],[580,390],[460,295]]
  };
  ctx.save();ctx.strokeStyle='rgba(75,44,44,0.85)';ctx.lineWidth=3;ctx.setLineDash([]);
  ctx.beginPath();
  wallPts[selWall].forEach((p,i)=>i===0?ctx.moveTo(p[0],p[1]):ctx.lineTo(p[0],p[1]));
  ctx.closePath();ctx.stroke();ctx.restore();
  ctx.restore();
}

function drawLiving(){
  const B=wc.back,L=dk(wc.left,0.12),R=dk(wc.right,0.12);
  poly([[80,50],[460,50],[460,295],[80,295]],B,'#00000010',0.5);
  poly([[0,0],[80,50],[80,295],[0,390]],L,'#00000015',0.5);
  poly([[460,50],[580,0],[580,390],[460,295]],R,'#00000015',0.5);
  poly([[0,0],[80,50],[460,50],[580,0]],'#f5f1ec');
  const fg=ctx.createLinearGradient(0,290,0,390);fg.addColorStop(0,'#b0a080');fg.addColorStop(1,'#887850');
  poly([[0,390],[80,295],[460,295],[580,390]],fg);
  poly([[80,285],[460,285],[460,295],[80,295]],'rgba(255,255,255,0.22)');
  poly([[0,380],[80,285],[80,295],[0,390]],'rgba(255,255,255,0.18)');
  poly([[460,285],[580,380],[580,390],[460,295]],'rgba(255,255,255,0.18)');
  const wg=ctx.createLinearGradient(185,65,185,205);wg.addColorStop(0,'rgba(175,218,255,0.62)');wg.addColorStop(1,'rgba(140,200,255,0.35)');
  rct(185,65,210,142,4,wg,'#c8c0b0',1.5);
  rct(183,63,214,146,5,null,'#b8b0a0',2);
  ctx.strokeStyle='#c0b8a8';ctx.lineWidth=1.5;
  ctx.beginPath();ctx.moveTo(290,63);ctx.lineTo(290,209);ctx.stroke();
  ctx.beginPath();ctx.moveTo(183,134);ctx.lineTo(397,134);ctx.stroke();
  rct(175,208,240,10,2,'#c4b8a8','#b8ac9c',0.5);
  ctx.save();ctx.globalAlpha=0.04;poly([[183,63],[397,63],[460,290],[120,290]],'#fffbe0');ctx.restore();
  rct(300,80,80,60,3,'rgba(255,255,255,0.6)','#c0b8a8',1);
  rct(305,85,70,50,2,'rgba(175,155,135,0.3)');
  rct(145,242,295,50,6,'#7a6245');rct(138,225,308,22,5,'#8e7458');
  rct(138,222,18,68,4,'#6a5235');rct(428,222,18,68,4,'#6a5235');
  rct(165,228,90,14,5,'#a8906a','#9a8060',0.5);
  rct(262,228,60,14,5,'#b09870','#a08860',0.5);
  rct(330,228,90,14,5,'#a8906a','#9a8060',0.5);
  rct(145,260,295,8,0,'rgba(0,0,0,0.1)');
  rct(210,278,165,16,3,'#9a7850','#887040',0.5);
  rct(215,294,5,8,1,'#785830');rct(368,294,5,8,1,'#785830');
  rct(282,264,16,15,4,'#8b9e7a');rct(285,250,10,16,3,'#6a8060');
  ctx.strokeStyle='#989088';ctx.lineWidth=3;
  ctx.beginPath();ctx.moveTo(113,200);ctx.lineTo(113,292);ctx.stroke();
  ctx.beginPath();ctx.ellipse(113,197,22,9,0,0,Math.PI*2);
  ctx.fillStyle='rgba(240,232,215,0.9)';ctx.fill();ctx.strokeStyle='#c8c0b0';ctx.lineWidth=1;ctx.stroke();
  rct(395,255,55,30,3,'#a08060','#907050',0.5);
  rct(398,285,5,8,0,'#806040');rct(442,285,5,8,0,'#806040');
}

function drawBedroom(){
  const B=wc.back,L=dk(wc.left,0.12),R=dk(wc.right,0.12);
  poly([[80,50],[460,50],[460,295],[80,295]],B,'#00000010',0.5);
  poly([[0,0],[80,50],[80,295],[0,390]],L,'#00000015',0.5);
  poly([[460,50],[580,0],[580,390],[460,295]],R,'#00000015',0.5);
  poly([[0,0],[80,50],[460,50],[580,0]],'#f5f1ec');
  const fg=ctx.createLinearGradient(0,290,0,390);fg.addColorStop(0,'#c8b898');fg.addColorStop(1,'#a89878');
  poly([[0,390],[80,295],[460,295],[580,390]],fg);
  poly([[80,285],[460,285],[460,295],[80,295]],'rgba(255,255,255,0.2)');
  rct(225,68,135,98,3,null,'#b8b0a0',2);
  const wg=ctx.createLinearGradient(225,68,225,166);wg.addColorStop(0,'rgba(175,218,255,0.52)');wg.addColorStop(1,'rgba(140,200,255,0.3)');
  rct(227,70,131,94,2,wg);
  ctx.strokeStyle='#c0b8a8';ctx.lineWidth=1.5;ctx.beginPath();ctx.moveTo(293,68);ctx.lineTo(293,166);ctx.stroke();
  const cl=ctx.createLinearGradient(195,60,225,60);cl.addColorStop(0,'rgba(180,140,110,0.72)');cl.addColorStop(1,'rgba(180,140,110,0.18)');
  rct(195,58,32,140,0,cl);
  const cr=ctx.createLinearGradient(358,60,390,60);cr.addColorStop(0,'rgba(180,140,110,0.18)');cr.addColorStop(1,'rgba(180,140,110,0.72)');
  rct(358,58,32,140,0,cr);
  rct(190,56,200,5,2,'#b0a090');
  rct(148,168,290,95,8,'#6a5438');rct(155,174,276,84,6,'#7a6248');
  rct(138,258,310,30,4,'#5a4428');rct(148,232,290,30,3,'#e0d8d0','#ccbcac',1);
  rct(148,238,290,22,2,'#b09880','#a08870',0.5);
  rct(158,218,110,20,8,'#f0e8e0','#d8ccc0',1);
  rct(318,218,110,20,8,'#f0e8e0','#d8ccc0',1);
  rct(163,221,100,14,5,null,'#d0c4b8',0.5);rct(323,221,100,14,5,null,'#d0c4b8',0.5);
  rct(88,242,58,48,4,'#8a7050','#786040',0.5);rct(394,242,58,48,4,'#8a7050','#786040',0.5);
  ctx.strokeStyle='rgba(0,0,0,0.1)';ctx.lineWidth=1;
  ctx.beginPath();ctx.moveTo(90,262);ctx.lineTo(144,262);ctx.stroke();
  ctx.beginPath();ctx.moveTo(396,262);ctx.lineTo(450,262);ctx.stroke();
  ctx.beginPath();ctx.arc(117,272,3,0,Math.PI*2);ctx.fillStyle='#a09070';ctx.fill();
  ctx.beginPath();ctx.arc(423,272,3,0,Math.PI*2);ctx.fillStyle='#a09070';ctx.fill();
  ctx.strokeStyle='#b0a080';ctx.lineWidth=2.5;
  ctx.beginPath();ctx.moveTo(117,220);ctx.lineTo(117,244);ctx.stroke();
  ctx.beginPath();ctx.ellipse(117,218,18,8,0,0,Math.PI*2);ctx.fillStyle='rgba(245,238,220,0.92)';ctx.fill();ctx.strokeStyle='#c8c0b0';ctx.lineWidth=1;ctx.stroke();
  ctx.strokeStyle='#b0a080';ctx.lineWidth=2.5;
  ctx.beginPath();ctx.moveTo(423,220);ctx.lineTo(423,244);ctx.stroke();
  ctx.beginPath();ctx.ellipse(423,218,18,8,0,0,Math.PI*2);ctx.fillStyle='rgba(245,238,220,0.92)';ctx.fill();ctx.strokeStyle='#c8c0b0';ctx.lineWidth=1;ctx.stroke();
}

function drawKitchen(){
  const B=wc.back,L=dk(wc.left,0.12),R=dk(wc.right,0.12);
  poly([[80,50],[460,50],[460,295],[80,295]],B,'#00000010',0.5);
  poly([[0,0],[80,50],[80,295],[0,390]],L,'#00000015',0.5);
  poly([[460,50],[580,0],[580,390],[460,295]],R,'#00000015',0.5);
  poly([[0,0],[80,50],[460,50],[580,0]],'#f8f4f0');
  const fg=ctx.createLinearGradient(0,290,0,390);fg.addColorStop(0,'#d0c8b8');fg.addColorStop(1,'#b4ac9c');
  poly([[0,390],[80,295],[460,295],[580,390]],fg);
  rct(82,158,378,60,0,'rgba(240,236,228,0.45)');
  ctx.strokeStyle='rgba(200,192,180,0.4)';ctx.lineWidth=0.5;
  for(let x=82;x<460;x+=30){ctx.beginPath();ctx.moveTo(x,158);ctx.lineTo(x,218);ctx.stroke();}
  for(let y=158;y<220;y+=20){ctx.beginPath();ctx.moveTo(82,y);ctx.lineTo(460,y);ctx.stroke();}
  rct(88,62,190,90,3,'#d8ccb8','#c4b8a4',1);
  rct(93,67,90,80,2,'#ccc0ac');rct(188,67,86,80,2,'#ccc0ac');
  ctx.beginPath();ctx.arc(138,107,4,0,Math.PI*2);ctx.fillStyle='#a89880';ctx.fill();
  ctx.beginPath();ctx.arc(231,107,4,0,Math.PI*2);ctx.fillStyle='#a89880';ctx.fill();
  rct(285,62,130,90,3,null,'#b8b0a0',2);
  const wg=ctx.createLinearGradient(285,62,285,152);wg.addColorStop(0,'rgba(175,218,255,0.52)');wg.addColorStop(1,'rgba(140,200,255,0.3)');
  rct(287,64,126,86,2,wg);
  ctx.strokeStyle='#c0b8a8';ctx.lineWidth=1.5;
  ctx.beginPath();ctx.moveTo(350,62);ctx.lineTo(350,152);ctx.stroke();
  ctx.beginPath();ctx.moveTo(285,107);ctx.lineTo(415,107);ctx.stroke();
  rct(80,218,380,16,2,'#c8bdb0','#b8b0a0',1);
  rct(80,232,380,5,0,'rgba(0,0,0,0.07)');
  [85,182,274,366].forEach(x=>{
    rct(x,234,90,50,0,'#ccc0ac','#b8aca0',1);
    ctx.beginPath();ctx.arc(x+45,261,3.5,0,Math.PI*2);ctx.fillStyle='#a89880';ctx.fill();
  });
  rct(290,208,115,12,2,'#b8b0a8','#a0a098',1);rct(298,211,99,7,2,'#a0989c');
  rct(344,188,7,22,3,'#b8b8b8');rct(330,186,36,6,3,'#c0c0c0');
  rct(110,208,130,12,2,'#d8d0c8');
  [[140,200],[195,200]].forEach(([cx,cy])=>{
    ctx.beginPath();ctx.arc(cx,cy,13,0,Math.PI*2);ctx.fillStyle='#c4bcb4';ctx.strokeStyle='#a8a0a0';ctx.lineWidth=1;ctx.fill();ctx.stroke();
    ctx.beginPath();ctx.arc(cx,cy,7,0,Math.PI*2);ctx.fillStyle='#b8b0a8';ctx.fill();
  });
  rct(108,140,136,20,3,'#d0c8be','#b8b0a8',1);
}

const WALL_PTS={
  back:[[80,50],[460,50],[460,295],[80,295]],
  left:[[0,0],[80,50],[80,295],[0,390]],
  right:[[460,50],[580,0],[580,390],[460,295]]
};
function ptInPoly(x,y,pts){
  let inside=false;
  for(let i=0,j=pts.length-1;i<pts.length;j=i++){
    const[xi,yi]=pts[i],[xj,yj]=pts[j];
    if((yi>y)!==(yj>y)&&x<(xj-xi)*(y-yi)/(yj-yi)+xi)inside=!inside;
  }
  return inside;
}
canvas.addEventListener('click',e=>{
  const r=canvas.getBoundingClientRect();
  const mx=(e.clientX-r.left)*(580/canvas.width);
  const my=(e.clientY-r.top)*(390/canvas.height);
  for(const[w,pts]of Object.entries(WALL_PTS)){
    if(ptInPoly(mx,my,pts)){selectWall(w);break;}
  }
});

function hexToHsl(hex){
  let r=parseInt(hex.slice(1,3),16)/255,g=parseInt(hex.slice(3,5),16)/255,b=parseInt(hex.slice(5,7),16)/255;
  const max=Math.max(r,g,b),min=Math.min(r,g,b);let h,s,l=(max+min)/2;
  if(max===min){h=s=0;}else{const d=max-min;s=l>0.5?d/(2-max-min):d/(max+min);
    switch(max){case r:h=(g-b)/d+(g<b?6:0);break;case g:h=(b-r)/d+2;break;case b:h=(r-g)/d+4;break;}h/=6;}
  return[Math.round(h*360),Math.round(s*100),Math.round(l*100)];
}
function hslToHex(h,s,l){
  s/=100;l/=100;const a=s*Math.min(l,1-l);
  const f=n=>{const k=(n+h/30)%12;const c=l-a*Math.max(Math.min(k-3,9-k,1),-1);return Math.round(255*c).toString(16).padStart(2,'0');};
  return`#${f(0)}${f(8)}${f(4)}`;
}
function getComplements(hex){
  const[h,s,l]=hexToHsl(hex);
  const l2=l>50?Math.max(l-20,25):Math.min(l+20,82);
  return[
    {hex:hslToHex((h+30)%360,Math.max(s-10,20),l2),label:"Analogous"},
    {hex:hslToHex((h+180)%360,Math.max(s-15,20),l2),label:"Complementary"},
    {hex:hslToHex((h+120)%360,Math.max(s-10,20),l2),label:"Triadic"},
  ];
}
function findClosest(hex){
  const all=BRANDS[curBrand];let best=null,bestD=Infinity;
  const[r1,g1,b1]=[parseInt(hex.slice(1,3),16),parseInt(hex.slice(3,5),16),parseInt(hex.slice(5,7),16)];
  all.forEach(c=>c.s.forEach((s,si)=>{
    const[r2,g2,b2]=[parseInt(s.slice(1,3),16),parseInt(s.slice(3,5),16),parseInt(s.slice(5,7),16)];
    const d=(r1-r2)**2+(g1-g2)**2+(b1-b2)**2;
    if(d<bestD){bestD=d;best={c,si};}
  }));
  return best;
}
function updateSuggestions(){
  const curHex=wc[selWall];
  const comps=getComplements(curHex);
  const others=Object.keys(wc).filter(w=>w!==selWall);
  const wallLabel={back:'Back',left:'Left',right:'Right'};
  document.getElementById('sug-label').textContent=`Suggested colors for ${others.map(w=>wallLabel[w]).join(' & ')} walls`;
  document.getElementById('sug-row').innerHTML=comps.map((comp,i)=>{
    const cl=findClosest(comp.hex);
    const nm=cl?cl.c.n:'—';const hx=cl?cl.c.s[cl.si]:comp.hex;
    const tw=others[i%others.length];
    return`<div class="sug-item" onclick="applySug('${hx}','${tw}')">
      <div class="sug-dot" style="background:${hx}"></div>
      <div class="sug-info"><span class="sug-name">${nm}</span><span class="sug-wall">${comp.label} → ${wallLabel[tw]} wall</span></div>
    </div>`;
  }).join('');
}
function applySug(hex,wall){wc[wall]=hex;drawRoom();renderWallRow();}

let curRoom='living',selWall='back',curBrand='berger',selCI=null,selSI=2,curCat='All',searchQ='';
let wc={back:'#e8e2d8',left:'#d8d2c8',right:'#d0cac0'};
let origWc={back:'#e8e2d8',left:'#d8d2c8',right:'#d0cac0'};

function initRoom(name){
  curRoom=name;
  wc={...ROOM_DEFS[name].defaultColors};
  origWc={...ROOM_DEFS[name].defaultColors};
  drawRoom();renderWallRow();updateSuggestions();
}
function renderWallRow(){
  const names={back:'Back Wall',left:'Left Wall',right:'Right Wall'};
  document.getElementById('wall-row').innerHTML=Object.entries(names).map(([id,lbl])=>`
    <button class="wchip ${id===selWall?'active':''}" onclick="selectWall('${id}')">
      <div class="wdot" style="background:${wc[id]}"></div>${lbl}
    </button>`).join('');
}
function selectWall(wall){selWall=wall;renderWallRow();drawRoom();updateSuggestions();}
function switchRoom(name){
  document.querySelectorAll('.rtab').forEach((t,i)=>t.classList.toggle('active',['living','bedroom','kitchen'][i]===name));
  initRoom(name);
}
function buildCats(){
  document.getElementById('cat-row').innerHTML=CATS.map(c=>`
    <button class="cat ${c===curCat?'active':''}" onclick="pickCat('${c}')">${c}</button>`).join('');
}
function pickCat(c){curCat=c;document.querySelectorAll('.cat').forEach((el,i)=>el.classList.toggle('active',CATS[i]===c));buildGrid();}
function filterColors(q){searchQ=q;buildGrid();}
function buildGrid(){
  let colors=BRANDS[curBrand];
  if(curCat!=='All')colors=colors.filter(c=>c.cat===curCat);
  if(searchQ)colors=colors.filter(c=>c.n.toLowerCase().includes(searchQ.toLowerCase())||c.c.toLowerCase().includes(searchQ.toLowerCase()));
  document.getElementById('cgrid').innerHTML=colors.map(c=>{
    const oi=BRANDS[curBrand].indexOf(c);
    return`<div class="csw ${oi===selCI?'sel':''}" style="background:${c.s[2]}" onclick="pickColor(${oi})"><div class="tip">${c.n}</div></div>`;
  }).join('');
}
function buildShades(){
  if(selCI===null){document.getElementById('shade-row').innerHTML='';return;}
  document.getElementById('shade-row').innerHTML=BRANDS[curBrand][selCI].s.map((s,i)=>`
    <div class="sh ${i===selSI?'sel':''}" style="background:${s}" onclick="pickShade(${i})"></div>`).join('');
}
// ── Buy This Color: map any brand hex shade to our closest purchasable
// paint color category (matches PaintShop.php / seller "Add Product" list)
// Uses HSL (hue/saturation/lightness) instead of raw RGB distance, since
// hue-based classification matches human color perception much better.
// Note: our 10 purchasable categories have no dedicated "Yellow" option,
// so yellow hues are deliberately grouped under Orange (the nearest
// available bucket) — that part is intentional, not a bug.
function nearestGenericColor(hex){
  const [h,s,l]=hexToHsl(hex);

  // Very light, low/medium-saturation colors read as White (covers pale
  // creams and off-whites too, not just pure grayscale near-white)
  if(l>=82&&s<60)return'White';

  // Very dark colors of any hue read as Black
  if(l<=18)return'Black';

  // Pure grayscale (no real hue at all): White/Gray/Black by lightness
  if(s<15){
    if(l>=70)return'White';
    return'Gray';
  }

  // Brown: muted/desaturated warm hues (red-orange family) — the real
  // difference between "Orange" and "Brown" at a similar hue angle is
  // mainly saturation: Oranges are vivid (much higher saturation),
  // Browns are muted, regardless of exactly how light or dark they are.
  if(h<50&&s<65)return'Brown';

  // Chromatic colors: classify by hue position on the color wheel
  if(h<12||h>=345)return'Red';
  if(h<70)return'Orange';   // includes yellows — no separate Yellow bucket
  if(h<170)return'Green';
  if(h<200)return'Green';   // teal/cyan leans into Green
  if(h<255)return'Blue';
  if(h<310)return'Purple';
  return'Pink';             // 310–345: magenta/rose/coral-pink range
}
function updateBuyButton(hex){
  const name=nearestGenericColor(hex);
  const btn=document.getElementById('buy-color-btn');
  btn.href='category_products.php?category=paint&type='+encodeURIComponent(name);
  btn.innerHTML='<i class="fa-solid fa-cart-shopping"></i> Buy '+name+' Paint';
  btn.style.display='block';
}
function pickColor(idx){selCI=idx;selSI=2;buildGrid();buildShades();applyColor();}
function pickShade(idx){selSI=idx;buildShades();applyColor();}
function applyColor(){
  if(selCI===null)return;
  const c=BRANDS[curBrand][selCI],hex=c.s[selSI];
  wc[selWall]=hex;drawRoom();renderWallRow();updateSuggestions();
  document.getElementById('sel-sw').style.background=hex;
  document.getElementById('sel-nm').textContent=c.n;
  document.getElementById('sel-cd').textContent=c.c+' · '+hex.toUpperCase();
  document.getElementById('sel-br').textContent=curBrand.charAt(0).toUpperCase()+curBrand.slice(1)+' Paints';
  updateBuyButton(hex);
}
function switchBrand(b){
  curBrand=b;selCI=null;selSI=2;curCat='All';searchQ='';
  document.getElementById('search-inp').value='';
  document.querySelectorAll('.btab').forEach((t,i)=>t.classList.toggle('active',['berger','dulux','nippon','asian'][i]===b));
  buildCats();buildGrid();buildShades();
  document.getElementById('sel-nm').textContent='Select a color';
  document.getElementById('sel-cd').textContent='—';
  document.getElementById('sel-br').textContent='';
  document.getElementById('sel-sw').style.background='';
}
function resetAll(){
  wc={...origWc};selCI=null;selSI=2;
  buildGrid();buildShades();drawRoom();renderWallRow();updateSuggestions();
  document.getElementById('sel-nm').textContent='Select a color';
  document.getElementById('sel-cd').textContent='—';
  document.getElementById('sel-br').textContent='';
  document.getElementById('sel-sw').style.background='';
  document.getElementById('pc-result').style.display='none';
}

// NEW: Paint Calculator (assumes ~120 sq.ft coverage per litre per coat, 2 coats recommended)
const PAINT_PRICE_PER_LITRE = 850; // approx. mid-range price in PKR, adjust as needed
const COVERAGE_SQFT_PER_LITRE_PER_COAT = 120;

function calculatePaint(){
  const length = parseFloat(document.getElementById('pc-length').value);
  const width  = parseFloat(document.getElementById('pc-width').value);
  const height = parseFloat(document.getElementById('pc-height').value) || 10;

  const resultBox = document.getElementById('pc-result');

  if(!length || !width || length <= 0 || width <= 0){
    resultBox.style.display = 'block';
    resultBox.innerHTML = 'Please enter a valid wall length and width.';
    return;
  }

  const wallArea = 2 * (length + width) * height; // perimeter x height
  const totalCoverageNeeded = wallArea * 2; // 2 coats
  const litresNeeded = Math.ceil(totalCoverageNeeded / COVERAGE_SQFT_PER_LITRE_PER_COAT);
  const totalCost = litresNeeded * PAINT_PRICE_PER_LITRE;

  resultBox.style.display = 'block';
  resultBox.innerHTML = `You need <strong>${litresNeeded} litres</strong> for a ${length}ft × ${width}ft room (${height}ft height, 2 coats).
    Estimated cost: <strong>Rs. ${totalCost.toLocaleString()}</strong> at Rs. ${PAINT_PRICE_PER_LITRE}/litre.`;

  // Auto-fill the "Buy This Paint" quantity field with the calculated litres
  const qtyInput = document.getElementById('buy-paint-qty');
  if (qtyInput) qtyInput.value = litresNeeded;
}

// NEW: Add the selected real paint product to cart
function addPaintToCart(){
  const select = document.getElementById('buy-paint-select');
  const qtyInput = document.getElementById('buy-paint-qty');
  if (!select) return;

  const productId = select.value;
  const quantity = parseInt(qtyInput.value) || 1;

  fetch('add_to_cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `product_id=${encodeURIComponent(productId)}&quantity=${encodeURIComponent(quantity)}`
  })
  .then(res => res.text())
  .then(response => {
    if (response.trim() === 'login') {
      alert('Please login first!');
      window.location.href = 'login.php';
      return;
    }
    try {
      const data = JSON.parse(response);
      if (data.status === 'success') {
        let badge = document.getElementById('cart-badge');
        if (!badge) {
          const cartLink = document.querySelector('.cart-box a');
          badge = document.createElement('span');
          badge.id = 'cart-badge';
          badge.style.cssText = 'position:absolute;top:-8px;right:-10px;background:#c0392b;color:white;font-size:11px;font-weight:bold;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;';
          cartLink.style.position = 'relative';
          cartLink.appendChild(badge);
        }
        badge.textContent = data.cart_count;
        alert('Paint added to cart successfully!');
      } else if (data.message) {
        alert(data.message);
      } else {
        alert('Something went wrong, please try again.');
      }
    } catch(e) { alert('Something went wrong, please try again.'); }
  })
  .catch(() => alert('Connection error!'));
}

// NEW: Download the current room preview as an image
function downloadDesign(){
  const link = document.createElement('a');
  link.download = 'my-paint-design.jpg';
  link.href = canvas.toDataURL('image/jpeg', 0.92);
  link.click();
}

// NEW: Share via WhatsApp (opens with a text message; the canvas image itself can be downloaded and attached manually)
function shareDesign(){
  const text = encodeURIComponent('Check out this paint color combination I created on Intra Decor Home! \uD83C\uDFA8');
  window.open('https://wa.me/?text=' + text, '_blank');
}

function resizeCanvas(){
  const box=canvas.parentElement.getBoundingClientRect();
  canvas.width=box.width;canvas.height=box.height;drawRoom();
}
window.addEventListener('resize',resizeCanvas);
window.addEventListener('load',()=>{
  initRoom('living');
  resizeCanvas();
  buildCats();buildGrid();buildShades();
  renderWallRow();
});
document.querySelector('.hamburger').addEventListener('click', () => {
    document.querySelector('.bottomheader').classList.toggle('active');
});
</script>
</body>
</html>