<?php
session_start();
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us — Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #faf6f5; }

        /* Scoped Font */
        .contact-hero, .page-wrapper {
            font-family: 'Outfit', sans-serif !important;
        }

        .contact-hero {
            position: relative; height: 300px; overflow: hidden;
            border-bottom: 4px solid #c17f4a;
        }
        .contact-hero img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.45); }
        .contact-hero-content {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; color: #fff; padding: 0 20px;
            background: linear-gradient(to bottom, rgba(75,44,44,0.3) 0%, rgba(42,16,16,0.6) 100%);
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .contact-hero-content h1 { font-size: 2.6rem; font-weight: 800; text-shadow: 0 4px 10px rgba(0,0,0,0.4); letter-spacing: -0.5px; }
        .contact-hero-content p { max-width: 600px; line-height: 1.7; font-size: 16px; text-shadow: 0 2px 6px rgba(0,0,0,0.4); opacity: 0.95; margin-top: 8px; }

        .page-wrapper { max-width: 1140px; margin: 0 auto; padding: 60px 24px 80px; }

        .contact-grid {
            display: grid; grid-template-columns: 1fr 1.4fr; gap: 40px;
            align-items: stretch;
        }
        @media (max-width: 850px){ .contact-grid { grid-template-columns: 1fr; gap: 30px; } }

        /* Left info panel */
        .contact-info-panel {
            background: linear-gradient(135deg, #4b2c2c 0%, #2a1010 100%);
            border-radius: 24px; padding: 45px 35px; color: #fff;
            box-shadow: 0 15px 40px rgba(75, 44, 44, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .contact-info-panel h3 { font-size: 24px; margin-bottom: 12px; font-weight: 800; letter-spacing: -0.5px; }
        .contact-info-panel > p { font-size: 14.5px; opacity: 0.8; margin-bottom: 35px; line-height: 1.7; }
        .info-row { display: flex; gap: 18px; margin-bottom: 28px; align-items: flex-start; }
        .info-row i {
            width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1);
            color: #c17f4a; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        .info-row:hover i { background: #c17f4a; color: #fff; transform: scale(1.08); }
        .info-row h4 { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; opacity: 0.65; font-weight: 700; }
        .info-row p, .info-row a { font-size: 15px; color: #eee; text-decoration: none; font-weight: 400; transition: color 0.2s; }
        .info-row a:hover { color: #c17f4a; }
        
        .contact-social { display: flex; gap: 12px; margin-top: 20px; }
        .contact-social a {
            width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.08);
            color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .contact-social a:hover { background: #c17f4a; color: #fff; transform: scale(1.15) translateY(-3px); box-shadow: 0 6px 15px rgba(193,127,74,0.4); }

        /* Right form panel */
        .contact-form-panel {
            background: #fff; border-radius: 24px; padding: 45px 35px;
            box-shadow: 0 10px 35px rgba(75, 44, 44, 0.04);
            border: 1px solid rgba(75, 44, 44, 0.04);
        }
        .contact-form-panel h3 { color: #4b2c2c; font-size: 24px; margin-bottom: 25px; font-weight: 800; letter-spacing: -0.5px; }
        .form-row { display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap; }
        .form-group { flex: 1 1 200px; display: flex; flex-direction: column; }
        .form-group label { font-size: 14px; color: #4b2c2c; font-weight: 600; margin-bottom: 8px; }
        .form-group input, .form-group textarea {
            padding: 13px 16px; border-radius: 12px; border: 2px solid #e2d5d5;
            font-size: 14.5px; font-family: inherit; outline: none; color: #333;
            transition: all 0.3s ease;
            background: #fdfcfc;
        }
        .form-group input:focus, .form-group textarea:focus {
            border-color: #c17f4a;
            background: #fff;
            box-shadow: 0 0 15px rgba(193, 127, 74, 0.15);
        }
        .form-group textarea { resize: vertical; min-height: 140px; }
        .contact-submit-btn {
            background: #4b2c2c; color: #fff; border: none; padding: 14px 34px;
            border-radius: 30px; font-size: 15px; font-weight: 600; cursor: pointer;
            transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 6px 20px rgba(75, 44, 44, 0.15);
        }
        .contact-submit-btn:hover { background: #6b3d3d; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(75, 44, 44, 0.25); }
        .contact-submit-btn:active { transform: translateY(0); }
        
        #contact-status { margin-top: 18px; font-size: 14px; display: none; padding: 12px 16px; border-radius: 10px; font-weight: 500; }
        #contact-status.success { background: #e6f7ec; color: #1e7e42; display: block; border-left: 4px solid #2ecc71; }
        #contact-status.error { background: #fdecea; color: #c0392b; display: block; border-left: 4px solid #e74c3c; }

        /* Map */
        .contact-map { margin-top: 50px; border-radius: 24px; overflow: hidden; box-shadow: 0 15px 40px rgba(75, 44, 44, 0.08); border: 1px solid rgba(75, 44, 44, 0.05); }
        .contact-map iframe { width: 100%; height: 350px; border: 0; display: block; }
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
    <div class="contact-hero">
        <img src="assets/images/hero.png" alt="Contact Intra Decor Home">
        <div class="contact-hero-content">
            <h1>Get in Touch</h1>
            <p>Questions about an order, a product, or want to talk to a designer? We're here to help.</p>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="contact-grid">

            <!-- LEFT: INFO -->
            <div class="contact-info-panel">
                <h3>Contact Information</h3>
                <p>Reach out to us directly, or fill in the form and our team will get back to you within 24 hours.</p>

                <div class="info-row">
                    <i class="fa-solid fa-envelope"></i>
                    <div><h4>Email</h4><a href="mailto:ef91646@gmail.com">ef91646@gmail.com</a></div>
                </div>
                <div class="info-row">
                    <i class="fa-solid fa-phone"></i>
                    <div><h4>Phone</h4><a href="tel:+923001234567">+92-300-1234567</a></div>
                </div>
                <div class="info-row">
                    <i class="fa-solid fa-clock"></i>
                    <div><h4>Working Hours</h4><p>Mon – Sat: 9am – 7pm</p></div>
                </div>

                <div class="contact-social">
                    <a href="#" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/923001234567" target="_blank" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <!-- RIGHT: FORM -->
            <div class="contact-form-panel">
                <h3>Send Us a Message</h3>
                <form id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="c-name">Full Name</label>
                            <input type="text" id="c-name" name="name" placeholder="Your name" required>
                        </div>
                        <div class="form-group">
                            <label for="c-email">Email Address</label>
                            <input type="email" id="c-email" name="email" placeholder="you@example.com" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="c-subject">Subject</label>
                            <input type="text" id="c-subject" name="subject" placeholder="What is this about?" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="c-message">Message</label>
                            <textarea id="c-message" name="message" placeholder="Write your message here..." required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="contact-submit-btn">
                        Send Message <i class="fa-solid fa-paper-plane"></i>
                    </button>
                    <div id="contact-status"></div>
                </form>
            </div>

        </div>

    </div><!-- end .page-wrapper -->

    <?php include 'Footer.php'; ?>

</div><!-- end .container -->

<script>
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.bottomheader');
    if (hamburger) hamburger.addEventListener('click', ()=>{ nav.classList.toggle('active'); });

    const contactForm = document.getElementById('contactForm');
    const statusBox = document.getElementById('contact-status');

    contactForm.addEventListener('submit', function(e){
        e.preventDefault();
        const formData = new FormData(contactForm);
        const submitBtn = contactForm.querySelector('.contact-submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending... <i class="fa-solid fa-spinner fa-spin"></i>';

        fetch('Contact_submit.php', { method: 'POST', body: formData })
            .then(res => res.text())
            .then(text => {
                let data;
                try { data = JSON.parse(text); } catch(err){ data = {status:'error', message:'Something went wrong. Please try again.'}; }

                statusBox.className = data.status === 'success' ? 'success' : 'error';
                statusBox.textContent = data.message;

                if(data.status === 'success'){ contactForm.reset(); }
            })
            .catch(() => {
                statusBox.className = 'error';
                statusBox.textContent = 'Something went wrong. Please try again.';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Message <i class="fa-solid fa-paper-plane"></i>';
            });
    });
</script>
</body>
</html>