<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #faf6f5; }

        /* Scoped Font */
        .faq-hero, .page-wrapper {
            font-family: 'Outfit', sans-serif !important;
        }

        .faq-hero { position: relative; height: 300px; overflow: hidden; border-bottom: 4px solid #c17f4a; }
        .faq-hero img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.45); }
        .faq-hero-content {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: #fff; padding: 0 20px;
            background: linear-gradient(to bottom, rgba(75,44,44,0.3) 0%, rgba(42,16,16,0.6) 100%);
            animation: fadeIn 0.8s ease-out;
        }
        .faq-hero-content h1 { font-size: 2.6rem; font-weight: 800; text-shadow: 0 4px 10px rgba(0,0,0,0.4); letter-spacing: -0.5px; }
        .faq-hero-content p { max-width: 600px; line-height: 1.7; font-size: 16px; text-shadow: 0 2px 6px rgba(0,0,0,0.4); opacity: 0.95; margin-top: 8px; }

        .page-wrapper { max-width: 880px; margin: 0 auto; padding: 60px 24px 80px; }

        .faq-search {
            display: flex; align-items: center; gap: 12px;
            background: #fff; border-radius: 30px; padding: 14px 24px;
            box-shadow: 0 10px 30px rgba(75, 44, 44, 0.04); margin-bottom: 45px;
            border: 2px solid #e2d5d5; transition: all 0.3s ease;
        }
        .faq-search:focus-within {
            border-color: #c17f4a;
            box-shadow: 0 0 18px rgba(193, 127, 74, 0.15);
        }
        .faq-search i { color: #c17f4a; font-size: 16px; }
        .faq-search input {
            border: none; outline: none; flex: 1; font-size: 15px; font-family: inherit; color: #333;
            background: transparent;
        }

        .faq-category-tabs {
            display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 40px; justify-content: center;
        }
        .faq-tab {
            padding: 9px 22px; border-radius: 30px; border: 2px solid #e2d5d5;
            background: #fff; color: #4b2c2c; font-size: 13.5px; font-weight: 600;
            cursor: pointer; transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.15);
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .faq-tab.active, .faq-tab:hover { background: #4b2c2c; color: #fff; border-color: #4b2c2c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(75, 44, 44, 0.25); }

        .faq-group { margin-bottom: 30px; }
        .faq-group-title {
            color: #4b2c2c; font-size: 15px; font-weight: 700; margin-bottom: 14px;
            text-transform: uppercase; letter-spacing: 0.5px; display: none;
        }

        .faq-item {
            background: #fff; border-radius: 18px; margin-bottom: 15px;
            box-shadow: 0 6px 20px rgba(75,44,44,0.02); overflow: hidden;
            border: 1px solid rgba(75, 44, 44, 0.04);
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .faq-item:hover {
            border-color: rgba(193, 127, 74, 0.2);
            box-shadow: 0 10px 25px rgba(75, 44, 44, 0.05);
        }
        .faq-question {
            padding: 22px 26px; display: flex; align-items: center; justify-content: space-between;
            cursor: pointer; font-weight: 700; color: #4b2c2c; font-size: 15.5px;
            transition: color 0.3s;
        }
        .faq-question:hover { color: #c17f4a; }
        .faq-question i { color: #c17f4a; transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); flex-shrink: 0; margin-left: 12px; font-size: 14px; }
        .faq-item.open { border-color: #c17f4a; box-shadow: 0 10px 25px rgba(75, 44, 44, 0.06); }
        .faq-item.open .faq-question { color: #c17f4a; }
        .faq-item.open .faq-question i { transform: rotate(180deg); }
        .faq-answer {
            max-height: 0; overflow: hidden; transition: max-height 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), padding 0.4s;
            padding: 0 26px;
        }
        .faq-item.open .faq-answer { max-height: 350px; padding: 0 26px 24px; }
        .faq-answer p { color: #6b5555; font-size: 14.5px; line-height: 1.8; margin: 0; }

        .faq-empty { text-align: center; color: #999; padding: 40px; display: none; font-size: 15px; font-weight: 500; }

        .faq-cta {
            margin-top: 60px; text-align: center; background: linear-gradient(135deg, #4b2c2c 0%, #2a1010 100%);
            border-radius: 24px; padding: 45px 30px; color: #fff;
            box-shadow: 0 15px 40px rgba(75, 44, 44, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .faq-cta h3 { font-size: 22px; margin-bottom: 10px; font-weight: 800; letter-spacing: -0.5px; }
        .faq-cta p { font-size: 15px; opacity: 0.8; margin-bottom: 25px; }
        .faq-cta a {
            display: inline-flex; align-items: center; gap: 8px; background: #fff; color: #4b2c2c;
            padding: 13px 30px; border-radius: 30px; font-weight: 700; font-size: 14.5px; text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }
        .faq-cta a:hover { background: #c17f4a; color: #fff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(193, 127, 74, 0.3); }
    </style>
</head>
<body>

<div class="container">

    <!-- TOP HEADER -->
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
                <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i><span class="cart-text">Cart</span></a>
            </div>
        </div>
        <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
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

    <!-- HERO -->
    <div class="faq-hero">
        <img src="assets/images/hero.png" alt="FAQ">
        <div class="faq-hero-content">
            <h1>Frequently Asked Questions</h1>
            <p>Everything you need to know about ordering, payments, delivery, and our design tools.</p>
        </div>
    </div>

    <div class="page-wrapper">

        <div class="faq-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="faqSearchInput" placeholder="Search a question...">
        </div>

        <div class="faq-category-tabs">
            <div class="faq-tab active" data-cat="all">All</div>
            <div class="faq-tab" data-cat="orders">Orders &amp; Payments</div>
            <div class="faq-tab" data-cat="delivery">Delivery &amp; Returns</div>
            <div class="faq-tab" data-cat="tools">Design Tools</div>
            <div class="faq-tab" data-cat="services">Service Providers</div>
            <div class="faq-tab" data-cat="account">Account</div>
        </div>

        <div id="faqList">

            <!-- ORDERS & PAYMENTS -->
            <div class="faq-item" data-cat="orders">
                <div class="faq-question">How do I place an order?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Browse any category (Paints, Tiles, Wallpapers, Wall Panels), open a product page, and click "Add to Cart." Once you're ready, go to your cart and proceed to checkout to confirm your order and delivery details.</p></div>
            </div>
            <div class="faq-item" data-cat="orders">
                <div class="faq-question">What payment methods do you accept?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>We currently accept online payments through Safepay, using a debit/credit card or a supported wallet. At checkout you are taken to Safepay's secure payment page, and your order is confirmed automatically as soon as the payment goes through.</p></div>
            </div>
            <div class="faq-item" data-cat="orders">
                <div class="faq-question">Can I cancel or modify my order after placing it?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Orders can be cancelled or modified as long as they haven't been dispatched yet. Go to "My Orders" in your account dashboard, or contact our support team as soon as possible.</p></div>
            </div>
            <div class="faq-item" data-cat="orders">
                <div class="faq-question">Will I get a confirmation after ordering?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Yes, you'll see an order confirmation on-screen immediately, and you can track your order anytime from your account dashboard.</p></div>
            </div>

            <!-- DELIVERY & RETURNS -->
            <div class="faq-item" data-cat="delivery">
                <div class="faq-question">How long does delivery take?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Delivery usually takes 3–7 business days depending on your location and product availability.</p></div>
            </div>
            <div class="faq-item" data-cat="delivery">
                <div class="faq-question">What is your return policy?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Unused and unopened products can be returned within 7 days of delivery. Custom-cut wallpapers and made-to-order panels may not be eligible for return — check the specific product page for details.</p></div>
            </div>
            <div class="faq-item" data-cat="delivery">
                <div class="faq-question">How do I track my order?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Go to My Account → My Orders to see the live status of every order you've placed.</p></div>
            </div>
            <div class="faq-item" data-cat="delivery">
                <div class="faq-question">What if I receive a damaged or wrong product?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Contact our support team within 48 hours of delivery with photos of the item, and we'll arrange a replacement or refund.</p></div>
            </div>

            <!-- DESIGN TOOLS -->
            <div class="faq-item" data-cat="tools">
                <div class="faq-question">How does the Paint Visualizer work?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Upload a photo of your room, pick a paint color or shade, and the visualizer will show you a preview of how it would look on your walls before you buy.</p></div>
            </div>
            <div class="faq-item" data-cat="tools">
                <div class="faq-question">What is the AI Room Designer?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>It's an AI-assisted tool that helps you generate design ideas and previews for your room based on your preferences — a quick way to explore styles before committing to a purchase.</p></div>
            </div>
            <div class="faq-item" data-cat="tools">
                <div class="faq-question">Do the visualizer tools work on mobile?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Yes, all our design tools are optimized to work on both desktop and mobile browsers.</p></div>
            </div>

            <!-- SERVICE PROVIDERS -->
            <div class="faq-item" data-cat="services">
                <div class="faq-question">How do I hire a service provider or designer?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Go to the Services page, filter by your city and category, and browse verified providers. You can view their profile and contact details directly from there.</p></div>
            </div>
            <div class="faq-item" data-cat="services">
                <div class="faq-question">Are the service providers verified?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Yes, every provider listed on our platform goes through an approval process before they're allowed to appear in search results.</p></div>
            </div>
            <div class="faq-item" data-cat="services">
                <div class="faq-question">Can I apply to become a service provider?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Yes! Designers and contractors can apply through our "Apply as a Designer" form. Once approved, your profile will appear in the Services directory.</p></div>
            </div>

            <!-- ACCOUNT -->
            <div class="faq-item" data-cat="account">
                <div class="faq-question">Do I need an account to shop?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>You'll need to sign up or log in to add items to your cart, checkout, and track your orders. Signing up takes less than a minute.</p></div>
            </div>
            <div class="faq-item" data-cat="account">
                <div class="faq-question">I forgot my password. What do I do?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Click "Forgot Password" on the login page, enter your registered email, and follow the OTP verification steps to reset it.</p></div>
            </div>
            <div class="faq-item" data-cat="account">
                <div class="faq-question">How do I save products to my favorites?<i class="fa-solid fa-chevron-down"></i></div>
                <div class="faq-answer"><p>Click the heart/favorite icon on any product card or product page. Saved items appear under "Favorites" in your account dashboard.</p></div>
            </div>

        </div>

        <div class="faq-empty" id="faqEmpty">No questions match your search.</div>

        <div class="faq-cta">
            <h3>Still have questions?</h3>
            <p>Our support team is happy to help with anything not covered here.</p>
            <a href="Contact.php"><i class="fa-solid fa-envelope"></i> Contact Us</a>
        </div>

    </div><!-- end .page-wrapper -->

    <?php include 'Footer.php'; ?>

</div><!-- end .container -->

<script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.bottomheader');
    if (hamburger) hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });

    // Accordion toggle
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', () => {
            const item = q.closest('.faq-item');
            const wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });

    // Category filter
    const tabs = document.querySelectorAll('.faq-tab');
    const items = document.querySelectorAll('.faq-item');
    const searchInput = document.getElementById('faqSearchInput');
    const emptyMsg = document.getElementById('faqEmpty');

    function applyFilters(){
        const activeCat = document.querySelector('.faq-tab.active').dataset.cat;
        const searchTerm = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        items.forEach(item => {
            const matchesCat = activeCat === 'all' || item.dataset.cat === activeCat;
            const text = item.querySelector('.faq-question').textContent.toLowerCase();
            const matchesSearch = text.includes(searchTerm);
            const show = matchesCat && matchesSearch;
            item.style.display = show ? '' : 'none';
            if(show) visibleCount++;
        });

        emptyMsg.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            applyFilters();
        });
    });

    searchInput.addEventListener('input', applyFilters);
</script>
</body>
</html>