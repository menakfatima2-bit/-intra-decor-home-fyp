<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Use — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/footer.css">
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
        <img src="assets/images/hero.png" alt="Terms of Use">
        <div class="legal-hero-content">
            <h1>Terms of Use</h1>
            <p>The rules for using Intra Decor Home</p>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="legal-layout">

            <!-- TABLE OF CONTENTS -->
            <div class="legal-toc">
                <h4>On This Page</h4>
                <ul>
                    <li><a href="#acceptance">1. Acceptance of Terms</a></li>
                    <li><a href="#eligibility">2. Eligibility &amp; Account</a></li>
                    <li><a href="#orders">3. Orders, Pricing &amp; Payments</a></li>
                    <li><a href="#delivery">4. Delivery, Returns &amp; Refunds</a></li>
                    <li><a href="#design-tools">5. Design Tools &amp; User Content</a></li>
                    <li><a href="#providers">6. Service Providers &amp; Designers</a></li>
                    <li><a href="#conduct">7. Prohibited Conduct</a></li>
                    <li><a href="#ip">8. Intellectual Property</a></li>
                    <li><a href="#liability">9. Limitation of Liability</a></li>
                    <li><a href="#termination">10. Termination</a></li>
                    <li><a href="#governing-law">11. Governing Law</a></li>
                    <li><a href="#changes-terms">12. Changes to These Terms</a></li>
                    <li><a href="#contact-terms">13. Contact Us</a></li>
                </ul>
            </div>

            <!-- CONTENT -->
            <div class="legal-content">
                <span class="updated"><i class="fa-solid fa-clock"></i> Last updated: July 2026</span>

                <div class="legal-section">
                    <p>Welcome to Intra Decor Home. These Terms of Use ("Terms") govern your access to and use of our website, products, and services. Please read them carefully before using our platform.</p>
                </div>

                <div class="legal-section" id="acceptance">
                    <h2><i class="fa-solid fa-clipboard-check"></i> 1. Acceptance of Terms</h2>
                    <p>By accessing or using Intra Decor Home, you agree to be bound by these Terms and our <a href="Privacy-policy.php" style="color:#c17f4a; font-weight:600;">Privacy Policy</a>. If you do not agree with any part of these Terms, please do not use our website.</p>
                </div>

                <div class="legal-section" id="eligibility">
                    <h2><i class="fa-solid fa-id-card"></i> 2. Eligibility &amp; Account</h2>
                    <ul>
                        <li>You must be at least 18 years old to create an account and place orders on our platform.</li>
                        <li>You are responsible for maintaining the confidentiality of your account login details.</li>
                        <li>You agree to provide accurate and complete information when signing up or placing an order.</li>
                        <li>We reserve the right to suspend or terminate accounts that provide false information or violate these Terms.</li>
                    </ul>
                </div>

                <div class="legal-section" id="orders">
                    <h2><i class="fa-solid fa-bag-shopping"></i> 3. Orders, Pricing &amp; Payments</h2>
                    <ul>
                        <li>All product prices are listed in Pakistani Rupees (PKR) and are subject to change without prior notice.</li>
                        <li>Placing an order through our website constitutes an offer to purchase, which we may accept or decline.</li>
                        <li>Payments are accepted via <strong>Safepay</strong> (card or wallet). Transactions are processed securely through Safepay's payment gateway, and an order is only confirmed once the payment is successful.</li>
                        <li>Discounts and promotional offers are valid only for the period specified and cannot be combined unless stated otherwise.</li>
                    </ul>
                </div>

                <div class="legal-section" id="delivery">
                    <h2><i class="fa-solid fa-truck-fast"></i> 4. Delivery, Returns &amp; Refunds</h2>
                    <ul>
                        <li>Estimated delivery timelines are provided at checkout and may vary based on location and product availability.</li>
                        <li>Returns are accepted within 7 days of delivery for unused and unopened products, subject to our Returns Policy.</li>
                        <li>Custom-cut or made-to-order items (such as certain wallpapers or panels) may not be eligible for return.</li>
                        <li>Refunds, where applicable, will be processed back to the original payment method within a reasonable timeframe.</li>
                    </ul>
                </div>

                <div class="legal-section" id="design-tools">
                    <h2><i class="fa-solid fa-wand-magic-sparkles"></i> 5. Design Tools &amp; User Content</h2>
                    <p>Our Paint Visualizer and AI Room Designer allow you to upload photos of your space to preview products. By uploading a photo, you confirm that you have the right to use that image, and you grant us permission to process it solely for the purpose of generating your preview. We do not claim ownership of your uploaded photos.</p>
                </div>

                <div class="legal-section" id="providers">
                    <h2><i class="fa-solid fa-user-tie"></i> 6. Service Providers &amp; Designers</h2>
                    <p>Intra Decor Home connects customers with independent, verified service providers and designers. While we review provider applications before approval, providers are independent contractors and not employees of Intra Decor Home. Any agreement, work, or payment arrangement made directly with a service provider is between you and that provider; we are not a party to that agreement.</p>
                </div>

                <div class="legal-section" id="conduct">
                    <h2><i class="fa-solid fa-ban"></i> 7. Prohibited Conduct</h2>
                    <p>When using our platform, you agree not to:</p>
                    <ul>
                        <li>Use the website for any unlawful purpose or in violation of any applicable laws</li>
                        <li>Attempt to gain unauthorized access to our systems, other users' accounts, or non-public areas of the platform</li>
                        <li>Upload harmful, offensive, or infringing content through our design tools or contact forms</li>
                        <li>Interfere with or disrupt the operation of the website or its underlying infrastructure</li>
                    </ul>
                </div>

                <div class="legal-section" id="ip">
                    <h2><i class="fa-solid fa-copyright"></i> 8. Intellectual Property</h2>
                    <p>All content on this website — including the Intra Decor Home name, logo, product listings, images, and design tools — is the property of Intra Decor Home or its licensors and is protected by applicable intellectual property laws. You may not copy, reproduce, or distribute our content without prior written permission.</p>
                </div>

                <div class="legal-section" id="liability">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> 9. Limitation of Liability</h2>
                    <p>Intra Decor Home strives to provide accurate product information and reliable service, but we do not guarantee that colors, textures, or materials will appear identical in person as shown through our visualizer tools due to differences in lighting, screens, and surfaces. To the fullest extent permitted by law, we are not liable for indirect, incidental, or consequential damages arising from the use of our website or services.</p>
                </div>

                <div class="legal-section" id="termination">
                    <h2><i class="fa-solid fa-power-off"></i> 10. Termination</h2>
                    <p>We reserve the right to suspend or terminate your access to our platform at any time, without notice, if we believe you have violated these Terms or engaged in fraudulent or harmful activity.</p>
                </div>

                <div class="legal-section" id="governing-law">
                    <h2><i class="fa-solid fa-scale-balanced"></i> 11. Governing Law</h2>
                    <p>These Terms are governed by and construed in accordance with the laws of Pakistan. Any disputes arising from these Terms or your use of the platform will be subject to the exclusive jurisdiction of the courts of Lahore, Punjab.</p>
                </div>

                <div class="legal-section" id="changes-terms">
                    <h2><i class="fa-solid fa-rotate"></i> 12. Changes to These Terms</h2>
                    <p>We may revise these Terms from time to time. Continued use of the website after changes are posted constitutes your acceptance of the updated Terms. The "last updated" date at the top of this page reflects the most recent revision.</p>
                </div>

                <div class="legal-section" id="contact-terms">
                    <h2><i class="fa-solid fa-envelope-open-text"></i> 13. Contact Us</h2>
                    <p>If you have questions about these Terms of Use, please reach out:</p>
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