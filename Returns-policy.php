<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returns Policy — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <style>
        html { scroll-behavior: smooth; }
        body { background: #faf6f5; }

        /* Scoped Font */
        .legal-hero, .page-wrapper {
            font-family: 'Outfit', sans-serif !important;
        }

        .legal-hero { position: relative; height: 240px; overflow: hidden; border-bottom: 4px solid #c17f4a; }
        .legal-hero img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.45); }
        .legal-hero-content {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: #fff; padding: 0 20px;
            background: linear-gradient(to bottom, rgba(75,44,44,0.3) 0%, rgba(42,16,16,0.6) 100%);
            animation: fadeIn 0.8s ease-out;
        }
        .legal-hero-content h1 { font-size: 2.4rem; font-weight: 800; text-shadow: 0 4px 10px rgba(0,0,0,0.4); letter-spacing: -0.5px; }
        .legal-hero-content p { font-size: 15px; opacity: 0.95; margin-top: 8px; text-shadow: 0 2px 6px rgba(0,0,0,0.4); }

        .page-wrapper { max-width: 1140px; margin: 0 auto; padding: 60px 24px 80px; }
        .legal-layout { display: grid; grid-template-columns: 280px 1fr; gap: 40px; align-items: start; }
        @media (max-width: 850px){ .legal-layout { grid-template-columns: 1fr; gap: 30px; } .legal-toc { position: static !important; } }

        .legal-toc {
            background: #fff; border-radius: 20px; padding: 28px 24px;
            box-shadow: 0 10px 30px rgba(75, 44, 44, 0.04); position: sticky; top: 25px;
            border: 1px solid rgba(75, 44, 44, 0.04);
        }
        .legal-toc h4 { color: #4b2c2c; font-size: 13.5px; margin-bottom: 18px; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; }
        .legal-toc ul { list-style: none; padding: 0; margin: 0; }
        .legal-toc li { margin-bottom: 12px; }
        .legal-toc li:last-child { margin-bottom: 0; }
        .legal-toc a {
            text-decoration: none; font-size: 14.5px; color: #7a6262;
            display: block; padding: 6px 0; border-left: 3px solid transparent; padding-left: 14px;
            transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
            font-weight: 500;
        }
        .legal-toc a:hover { color: #4b2c2c; border-left-color: #c17f4a; transform: translateX(4px); }

        .legal-content {
            background: #fff; border-radius: 24px; padding: 45px 40px;
            box-shadow: 0 10px 35px rgba(75, 44, 44, 0.04);
            border: 1px solid rgba(75, 44, 44, 0.04);
        }
        @media(max-width: 600px){ .legal-content { padding: 30px 20px; } }
        .legal-content .updated {
            font-size: 13.5px; color: #c17f4a; margin-bottom: 35px; display: inline-flex; align-items: center; gap: 6px;
            background: rgba(193, 127, 74, 0.08); padding: 6px 16px; border-radius: 30px; font-weight: 600;
        }
        .legal-section { margin-bottom: 40px; scroll-margin-top: 25px; }
        .legal-section:last-child { margin-bottom: 0; }
        .legal-section h2 {
            color: #4b2c2c; font-size: 20px; margin-bottom: 16px; font-weight: 800;
            display: flex; align-items: center; gap: 12px; letter-spacing: -0.5px;
        }
        .legal-section h2 i { color: #c17f4a; font-size: 18px; }
        .legal-section p, .legal-section li { color: #6b5555; font-size: 15px; line-height: 1.85; }
        .legal-section p { margin-bottom: 14px; }
        .legal-section p:last-child { margin-bottom: 0; }
        .legal-section ul { padding-left: 24px; margin: 12px 0; }
        .legal-section li { margin-bottom: 8px; }
        .legal-section strong { color: #4b2c2c; font-weight: 600; }

        /* Timeline steps for "how to return" */
        .return-steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-top: 24px; }
        .return-step {
            background: #faf6f5; border-radius: 18px; padding: 24px 20px; text-align: center;
            border: 1px solid rgba(75, 44, 44, 0.04);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .return-step:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(75, 44, 44, 0.04);
            border-color: rgba(193, 127, 74, 0.2);
        }
        .return-step .num {
            width: 36px; height: 36px; border-radius: 50%; background: #4b2c2c; color: #fff;
            display: flex; align-items: center; justify-content: center; font-weight: 700; margin: 0 auto 14px; font-size: 14px;
            box-shadow: 0 4px 10px rgba(75, 44, 44, 0.2);
        }
        .return-step:hover .num {
            background: #c17f4a;
            box-shadow: 0 4px 10px rgba(193, 127, 74, 0.35);
        }
        .return-step p { font-size: 13.5px; color: #6b5555; line-height: 1.6; }
        .return-step p strong { color: #4b2c2c; }

        .highlight-box {
            background: #fff9e6; color: #8a6d1c; padding: 18px 22px; border-radius: 16px;
            font-size: 14.5px; margin-top: 20px; border-left: 4px solid #c17f4a;
            display: flex; align-items: center; gap: 12px; border-top: 1px solid #f9ebcc; border-bottom: 1px solid #f9ebcc; border-right: 1px solid #f9ebcc;
        }
        .highlight-box i { font-size: 18px; color: #c17f4a; flex-shrink: 0; }
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
    <div class="legal-hero">
        <img src="assets/images/hero.png" alt="Returns Policy">
        <div class="legal-hero-content">
            <h1>Returns Policy</h1>
            <p>Simple, fair returns for peace of mind</p>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="legal-layout">

            <!-- TABLE OF CONTENTS -->
            <div class="legal-toc">
                <h4>On This Page</h4>
                <ul>
                    <li><a href="#eligibility-return">1. Return Eligibility</a></li>
                    <li><a href="#non-returnable">2. Non-Returnable Items</a></li>
                    <li><a href="#how-to-return">3. How to Request a Return</a></li>
                    <li><a href="#condition">4. Condition of Returned Items</a></li>
                    <li><a href="#refunds">5. Refunds</a></li>
                    <li><a href="#exchanges">6. Exchanges</a></li>
                    <li><a href="#damaged">7. Damaged, Defective, or Wrong Items</a></li>
                    <li><a href="#return-contact">8. Contact Us</a></li>
                </ul>
            </div>

            <!-- CONTENT -->
            <div class="legal-content">
                <span class="updated"><i class="fa-solid fa-clock"></i> Last updated: July 2026</span>

                <div class="legal-section">
                    <p>We want you to feel confident shopping with Intra Decor Home. If something isn't right with your order, this policy explains how returns, exchanges, and refunds work.</p>
                </div>

                <div class="legal-section" id="eligibility-return">
                    <h2><i class="fa-solid fa-calendar-check"></i> 1. Return Eligibility</h2>
                    <ul>
                        <li>Returns are accepted within <strong>7 days</strong> of the delivery date.</li>
                        <li>Items must be unused, unopened, and in their original packaging with all tags/labels intact.</li>
                        <li>Proof of purchase (Order ID) is required for all return requests.</li>
                    </ul>
                </div>

                <div class="legal-section" id="non-returnable">
                    <h2><i class="fa-solid fa-ban"></i> 2. Non-Returnable Items</h2>
                    <p>The following items cannot be returned unless they arrive damaged or defective:</p>
                    <ul>
                        <li>Custom-cut wallpapers made to your specific wall measurements</li>
                        <li>Made-to-order wall panels</li>
                        <li>Opened or used paint tins/cans</li>
                        <li>Products marked as "Final Sale" on the product page</li>
                    </ul>
                    <div class="highlight-box">
                        <i class="fa-solid fa-circle-info"></i> Always check the individual product page — some items may have specific return conditions noted there.
                    </div>
                </div>

                <div class="legal-section" id="how-to-return">
                    <h2><i class="fa-solid fa-rotate-left"></i> 3. How to Request a Return</h2>
                    <div class="return-steps">
                        <div class="return-step"><div class="num">1</div><p>Go to <strong>My Account → My Orders</strong> and locate your order</p></div>
                        <div class="return-step"><div class="num">2</div><p>Or use our <strong>Track Order</strong> page with your Order ID and phone number</p></div>
                        <div class="return-step"><div class="num">3</div><p>Contact our support team via the <strong>Contact Us</strong> page with your Order ID and reason for return</p></div>
                        <div class="return-step"><div class="num">4</div><p>Our team will confirm pickup or drop-off instructions within 24–48 hours</p></div>
                    </div>
                </div>

                <div class="legal-section" id="condition">
                    <h2><i class="fa-solid fa-magnifying-glass"></i> 4. Condition of Returned Items</h2>
                    <p>Returned items are inspected upon receipt. Items that show signs of use, damage caused after delivery, or missing parts/packaging may be rejected, or a partial refund may be issued at our discretion.</p>
                </div>

                <div class="legal-section" id="refunds">
                    <h2><i class="fa-solid fa-money-bill-transfer"></i> 5. Refunds</h2>
                    <ul>
                        <li>Once your return is received and inspected, we will notify you of the approval status.</li>
                        <li>Approved refunds for orders paid via <strong>Safepay</strong> are issued back to the same card or wallet used for payment.</li>
                        <li>Refunds are typically processed within 5–10 business days after approval.</li>
                        <li>Original delivery charges (if any) are non-refundable, unless the return is due to our error (wrong or defective item).</li>
                    </ul>
                </div>

                <div class="legal-section" id="exchanges">
                    <h2><i class="fa-solid fa-right-left"></i> 6. Exchanges</h2>
                    <p>If you'd like a different color, size, or product instead of a refund, mention this when requesting your return. Exchanges are subject to stock availability of the requested item.</p>
                </div>

                <div class="legal-section" id="damaged">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> 7. Damaged, Defective, or Wrong Items</h2>
                    <p>If you receive a damaged, defective, or incorrect item:</p>
                    <ul>
                        <li>Contact us within <strong>48 hours</strong> of delivery.</li>
                        <li>Include your Order ID and clear photos of the item and packaging.</li>
                        <li>We will arrange a free replacement or a full refund — no return shipping cost to you in these cases.</li>
                    </ul>
                </div>

                <div class="legal-section" id="return-contact">
                    <h2><i class="fa-solid fa-envelope-open-text"></i> 8. Contact Us</h2>
                    <p>For any return or refund request, reach out to us:</p>
                    <ul>
                        <li><strong>Email:</strong> ef91646@gmail.com</li>
                        <li><strong>Phone:</strong> +92-300-1234567</li>
                    </ul>
                    <p>Or use our <a href="Contact.php" style="color:#c17f4a; font-weight:600;">Contact Us page</a> / <a href="Track-order.php" style="color:#c17f4a; font-weight:600;">Track Order page</a> directly.</p>
                </div>

            </div>
        </div>
    </div><!-- end .page-wrapper -->

    <?php include 'Footer.php'; ?>

</div><!-- end .container -->

<script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.bottomheader');
    if (hamburger) hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });
</script>
</body>
</html>