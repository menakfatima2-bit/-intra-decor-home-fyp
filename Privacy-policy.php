<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        <img src="assets/images/hero.png" alt="Privacy Policy">
        <div class="legal-hero-content">
            <h1>Privacy Policy</h1>
            <p>How we collect, use, and protect your information</p>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="legal-layout">

            <!-- TABLE OF CONTENTS -->
            <div class="legal-toc">
                <h4>On This Page</h4>
                <ul>
                    <li><a href="#info-we-collect">1. Information We Collect</a></li>
                    <li><a href="#how-we-use">2. How We Use Your Information</a></li>
                    <li><a href="#payment">3. Payments &amp; Transactions</a></li>
                    <li><a href="#sharing">4. Sharing of Information</a></li>
                    <li><a href="#cookies">5. Cookies &amp; Tracking</a></li>
                    <li><a href="#visualizer">6. Design Tools &amp; Uploaded Photos</a></li>
                    <li><a href="#security">7. Data Security</a></li>
                    <li><a href="#rights">8. Your Rights &amp; Choices</a></li>
                    <li><a href="#children">9. Children's Privacy</a></li>
                    <li><a href="#changes">10. Changes to This Policy</a></li>
                    <li><a href="#contact-us">11. Contact Us</a></li>
                </ul>
            </div>

            <!-- CONTENT -->
            <div class="legal-content">
                <span class="updated"><i class="fa-solid fa-clock"></i> Last updated: July 2026</span>

                <div class="legal-section">
                    <p>Intra Decor Home ("we," "us," or "our") operates this website to help customers browse, visualize, and purchase interior décor products, and to connect with verified service providers. This Privacy Policy explains what information we collect, how we use it, and the choices you have.</p>
                    <p>By using our website, you agree to the collection and use of information as described in this policy.</p>
                </div>

                <div class="legal-section" id="info-we-collect">
                    <h2><i class="fa-solid fa-database"></i> 1. Information We Collect</h2>
                    <p>We collect the following types of information when you use our platform:</p>
                    <ul>
                        <li><strong>Account information:</strong> name, email address, phone number, and password when you sign up.</li>
                        <li><strong>Order information:</strong> shipping address, billing details, and order history.</li>
                        <li><strong>Contact form submissions:</strong> name, email, and message content when you reach out to us.</li>
                        <li><strong>Uploaded images:</strong> photos you upload to the Paint Visualizer or AI Room Designer to preview products in your space.</li>
                        <li><strong>Usage data:</strong> pages visited, products viewed, favorites saved, and general browsing activity on our site.</li>
                        <li><strong>Service provider information:</strong> if you apply as a designer or service provider, we collect your profile details, service categories, and city/area of operation.</li>
                    </ul>
                </div>

                <div class="legal-section" id="how-we-use">
                    <h2><i class="fa-solid fa-gears"></i> 2. How We Use Your Information</h2>
                    <ul>
                        <li>To process and deliver your orders</li>
                        <li>To create and manage your account, including login and password recovery via OTP</li>
                        <li>To respond to inquiries submitted through our Contact Us form</li>
                        <li>To show you relevant products, recommendations, and order updates</li>
                        <li>To connect you with verified service providers in your city</li>
                        <li>To improve our website, design tools, and overall user experience</li>
                        <li>To send occasional newsletters if you've subscribed (you can unsubscribe anytime)</li>
                    </ul>
                </div>

                <div class="legal-section" id="payment">
                    <h2><i class="fa-solid fa-credit-card"></i> 3. Payments &amp; Transactions</h2>
                    <p>We accept payments via Safepay. We never see or store your card or wallet details on our servers. Payment processing is handled entirely on Safepay's secure payment page.</p>
                </div>

                <div class="legal-section" id="sharing">
                    <h2><i class="fa-solid fa-share-nodes"></i> 4. Sharing of Information</h2>
                    <p>We do not sell your personal information. We may share limited information in the following cases:</p>
                    <ul>
                        <li>With delivery partners, to fulfil and ship your orders</li>
                        <li>With verified service providers, only when you choose to contact or hire them</li>
                        <li>With payment processors, to complete transactions</li>
                        <li>When required by law, regulation, or a valid legal request</li>
                    </ul>
                </div>

                <div class="legal-section" id="cookies">
                    <h2><i class="fa-solid fa-cookie-bite"></i> 5. Cookies &amp; Tracking</h2>
                    <p>We use session cookies to keep you logged in, remember your cart contents, and maintain a smooth browsing experience. We do not use cookies for third-party advertising. You can disable cookies through your browser settings, though some features (like the cart) may not work correctly without them.</p>
                </div>

                <div class="legal-section" id="visualizer">
                    <h2><i class="fa-solid fa-image"></i> 6. Design Tools &amp; Uploaded Photos</h2>
                    <p>When you use the Paint Visualizer or AI Room Designer and upload a photo of your room, that image is used only to generate your preview and improve the accuracy of our design tools. We do not use your uploaded room photos for advertising or share them with third parties.</p>
                </div>

                <div class="legal-section" id="security">
                    <h2><i class="fa-solid fa-lock"></i> 7. Data Security</h2>
                    <p>We take reasonable technical and organizational measures to protect your data, including encrypted password storage and OTP-based verification for sensitive actions like password resets. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p>
                </div>

                <div class="legal-section" id="rights">
                    <h2><i class="fa-solid fa-user-check"></i> 8. Your Rights &amp; Choices</h2>
                    <ul>
                        <li>You can update your profile information anytime from your Account Dashboard.</li>
                        <li>You can request deletion of your account and associated data by contacting our support team.</li>
                        <li>You can unsubscribe from newsletters using the link in any email, or by contacting us directly.</li>
                        <li>You can remove saved favorites or cart items at any time.</li>
                    </ul>
                </div>

                <div class="legal-section" id="children">
                    <h2><i class="fa-solid fa-child-reaching"></i> 9. Children's Privacy</h2>
                    <p>Our services are intended for users who are 18 years or older. We do not knowingly collect personal information from children. If you believe a child has provided us with personal information, please contact us and we will remove it.</p>
                </div>

                <div class="legal-section" id="changes">
                    <h2><i class="fa-solid fa-rotate"></i> 10. Changes to This Policy</h2>
                    <p>We may update this Privacy Policy from time to time to reflect changes in our practices or for legal reasons. Any updates will be posted on this page with a revised "last updated" date.</p>
                </div>

                <div class="legal-section" id="contact-us">
                    <h2><i class="fa-solid fa-envelope-open-text"></i> 11. Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy or how we handle your data, please reach out:</p>
                    <ul>
                        <li><strong>Email:</strong> ef91646@gmail.com</li>
                        <li><strong>Phone:</strong> +92-300-1234567</li>
                    </ul>
                    <p>You can also use our <a href="Contact.php" style="color:#c17f4a; font-weight:600;">Contact Us page</a> to send us a message directly.</p>
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