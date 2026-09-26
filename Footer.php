<!-- ============================================= -->
    <!-- SHARED PROFESSIONAL FOOTER — included on every page -->
    <!-- ============================================= -->
    <footer class="footer">

        <!-- Newsletter -->
        <div class="footer-newsletter">
            <div class="newsletter-text">
                <h3><i class="fa-solid fa-envelope-open-text"></i> Get Decor Inspiration</h3>
                <p>Weekly ideas, offers &amp; room makeover tips — straight to your inbox.</p>
            </div>
            <form class="newsletter-form" action="newsletter.php" method="POST">
                <input type="email" name="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe &nbsp;<i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>

        <!-- 4 Columns -->
        <div class="footer-top">

            <!-- Col 1: About -->
            <div class="footer-block">
                <h3>Intra Decor Home</h3>
                <p>Premium interior décor solutions for modern homes in Pakistan. Quality products, expert guidance.</p>
                <ul class="footer-contact-list">
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:ef91646@gmail.com">ef91646@gmail.com</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-clock"></i>
                        <span>Mon–Sat: 9am – 7pm</span>
                    </li>
                </ul>
                <div class="social-icons">
                    <a href="#" class="social-btn facebook" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-btn instagram" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/923001234567" class="social-btn whatsapp" title="WhatsApp" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="footer-block">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php"><i class="fa-solid fa-chevron-right"></i> Home</a></li>
                    <li><a href="About.php"><i class="fa-solid fa-chevron-right"></i> About Us</a></li>
                    <li><a href="products.php"><i class="fa-solid fa-chevron-right"></i> Products</a></li>
                    <li><a href="services.php"><i class="fa-solid fa-chevron-right"></i> Services</a></li>
                    <li><a href="room-preview.php"><i class="fa-solid fa-chevron-right"></i> AI Decor Ideas</a></li>
                    <li><a href="Contact.php"><i class="fa-solid fa-chevron-right"></i> Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 3: Categories -->
            <div class="footer-block">
                <h3>Categories</h3>
                <ul>
                    <li><a href="paint.php"><i class="fa-solid fa-chevron-right"></i> Wall Paints</a></li>
                    <li><a href="Tiles.php"><i class="fa-solid fa-chevron-right"></i> Tiles</a></li>
                    <li><a href="wallpaper.php"><i class="fa-solid fa-chevron-right"></i> Wallpapers</a></li>
                    <li><a href="wallpenals.php"><i class="fa-solid fa-chevron-right"></i> Wall Panels</a></li>
                </ul>
            </div>

            <!-- Col 4: Customer Care -->
            <div class="footer-block">
                <h3>Customer Care</h3>
                <ul>
                    <li><a href="userdashboard/userdashboard.php"><i class="fa-solid fa-chevron-right"></i> My Account</a></li>
                    <li><a href="Track-order.php"><i class="fa-solid fa-chevron-right"></i> Track Order</a></li>
                    <li><a href="Returns-policy.php"><i class="fa-solid fa-chevron-right"></i> Returns Policy</a></li>
                    <li><a href="faq.php"><i class="fa-solid fa-chevron-right"></i> FAQ</a></li>
                    <li><a href="Privacy-policy.php"><i class="fa-solid fa-chevron-right"></i> Privacy Policy</a></li>
                    <li><a href="Terms.php"><i class="fa-solid fa-chevron-right"></i> Terms of Use</a></li>
                </ul>
            </div>

        </div>

        <!-- Trust Badges -->
        <div class="footer-trust">
            <div class="trust-badges">
                <div class="trust-badge" id="secureCheckoutBadge" style="cursor:pointer;">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Secure Checkout</span>
                </div>
                <div class="trust-badge" id="easyReturnsBadge" style="cursor:pointer;">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Easy Returns</span>
                </div>
                <div class="trust-badge">
                    <i class="fa-solid fa-headset"></i>
                    <span>24/7 Support</span>
                </div>
            </div>
            <div class="payment-methods">
                <span>We accept:</span>
                <span class="pay-tag">Safepay</span>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Intra Decor Home. All Rights Reserved. Made with <i class="fa-solid fa-heart" style="color:#e74c3c;"></i> in Pakistan.</p>
            <div class="footer-bottom-links">
                <a href="Privacy-policy.php">Privacy Policy</a>
                <a href="Terms.php">Terms</a>
                <a href="Sitemap.php">Sitemap</a>
            </div>
        </div>

    </footer>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" title="Back to Top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Secure Checkout Info Modal -->
    <div class="secure-modal-overlay" id="secureModalOverlay">
        <div class="secure-modal">
            <button class="secure-modal-close" id="secureModalClose"><i class="fa-solid fa-xmark"></i></button>
            <div class="secure-modal-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <h3>Secure Checkout</h3>
            <p class="secure-modal-sub">Your payment and personal information are protected at every step.</p>
            <div class="secure-modal-points">
                <div class="secure-point">
                    <i class="fa-solid fa-lock"></i>
                    <div>
                        <h4>Encrypted Connection</h4>
                        <p>All data sent between your browser and our site is protected over a secure connection.</p>
                    </div>
                </div>
                <div class="secure-point">
                    <i class="fa-solid fa-credit-card"></i>
                    <div>
                        <h4>Secure Payment Gateway</h4>
                        <p>Payments are processed through Safepay's secure payment gateway — we never store your card or wallet details on our servers.</p>
                    </div>
                </div>
                <div class="secure-point">
                    <i class="fa-solid fa-user-shield"></i>
                    <div>
                        <h4>Privacy Protected</h4>
                        <p>Your personal details are handled according to our <a href="Privacy-policy.php">Privacy Policy</a> and never sold to third parties.</p>
                    </div>
                </div>
                <div class="secure-point">
                    <i class="fa-solid fa-headset"></i>
                    <div>
                        <h4>Support if Something Goes Wrong</h4>
                        <p>Our team is available 24/7 to help resolve any issue with your order or payment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Easy Returns Info Modal -->
    <div class="secure-modal-overlay" id="returnsModalOverlay">
        <div class="secure-modal">
            <button class="secure-modal-close" id="returnsModalClose"><i class="fa-solid fa-xmark"></i></button>
            <div class="secure-modal-icon"><i class="fa-solid fa-rotate-left"></i></div>
            <h3>Easy Returns</h3>
            <p class="secure-modal-sub">A quick look at how returns work at Intra Decor Home.</p>
            <div class="secure-modal-points">
                <div class="secure-point">
                    <i class="fa-solid fa-calendar-check"></i>
                    <div>
                        <h4>7-Day Return Window</h4>
                        <p>Unused, unopened items in original packaging can be returned within 7 days of delivery.</p>
                    </div>
                </div>
                <div class="secure-point">
                    <i class="fa-solid fa-ban"></i>
                    <div>
                        <h4>Some Exceptions Apply</h4>
                        <p>Custom-cut wallpapers, made-to-order panels, and opened paint tins are not eligible for return.</p>
                    </div>
                </div>
                <div class="secure-point">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                    <div>
                        <h4>Simple Refunds</h4>
                        <p>Once your return is approved, refunds go back to your original payment method within 5–10 business days.</p>
                    </div>
                </div>
                <div class="secure-point">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <h4>Damaged or Wrong Item?</h4>
                        <p>Contact us within 48 hours and we'll arrange a free replacement or refund.</p>
                    </div>
                </div>
            </div>
            <a href="Returns-policy.php" style="display:inline-block; margin-top:22px; background:#4b2c2c; color:#fff; padding:11px 26px; border-radius:30px; font-size:13px; font-weight:600; text-decoration:none;">
                Read Full Returns Policy <i class="fa-solid fa-arrow-right" style="margin-left:6px;"></i>
            </a>
        </div>
    </div>

    <style>
        .secure-modal-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55);
            z-index: 9999; align-items: center; justify-content: center; padding: 20px;
        }
        .secure-modal-overlay.show { display: flex; }
        .secure-modal {
            background: #fff; border-radius: 20px; max-width: 460px; width: 100%;
            padding: 34px 30px; position: relative; text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: secureModalPop 0.25s ease;
        }
        @keyframes secureModalPop {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .secure-modal-close {
            position: absolute; top: 14px; right: 14px; background: #f5f0f0; border: none;
            width: 32px; height: 32px; border-radius: 50%; color: #4b2c2c; cursor: pointer;
            font-size: 14px; display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
        }
        .secure-modal-close:hover { background: #4b2c2c; color: #fff; }
        .secure-modal-icon {
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, #4b2c2c 0%, #7a4040 100%);
            color: #fff; font-size: 24px; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .secure-modal h3 { color: #4b2c2c; font-size: 19px; font-weight: 700; margin-bottom: 6px; }
        .secure-modal-sub { color: #999; font-size: 13px; margin-bottom: 24px; line-height: 1.6; }
        .secure-modal-points { text-align: left; display: flex; flex-direction: column; gap: 18px; }
        .secure-point { display: flex; gap: 14px; align-items: flex-start; }
        .secure-point i { color: #c17f4a; font-size: 18px; margin-top: 2px; flex-shrink: 0; width: 20px; }
        .secure-point h4 { color: #4b2c2c; font-size: 13.5px; font-weight: 700; margin-bottom: 4px; }
        .secure-point p { color: #888; font-size: 12.5px; line-height: 1.6; }
        .secure-point p a { color: #c17f4a; font-weight: 600; text-decoration: none; }
        .secure-point p a:hover { text-decoration: underline; }
    </style>

    <script>
        (function(){
            var badge   = document.getElementById('secureCheckoutBadge');
            var overlay = document.getElementById('secureModalOverlay');
            var closeBtn = document.getElementById('secureModalClose');

            if (badge && overlay) {
                badge.addEventListener('click', function(){ overlay.classList.add('show'); });
                closeBtn.addEventListener('click', function(){ overlay.classList.remove('show'); });
                overlay.addEventListener('click', function(e){
                    if (e.target === overlay) overlay.classList.remove('show');
                });
                document.addEventListener('keydown', function(e){
                    if (e.key === 'Escape') overlay.classList.remove('show');
                });
            }

            var returnsBadge   = document.getElementById('easyReturnsBadge');
            var returnsOverlay = document.getElementById('returnsModalOverlay');
            var returnsClose   = document.getElementById('returnsModalClose');

            if (returnsBadge && returnsOverlay) {
                returnsBadge.addEventListener('click', function(){ returnsOverlay.classList.add('show'); });
                returnsClose.addEventListener('click', function(){ returnsOverlay.classList.remove('show'); });
                returnsOverlay.addEventListener('click', function(e){
                    if (e.target === returnsOverlay) returnsOverlay.classList.remove('show');
                });
                document.addEventListener('keydown', function(e){
                    if (e.key === 'Escape') returnsOverlay.classList.remove('show');
                });
            }
        })();
    </script>

    <script>
        (function(){
            var backBtn = document.getElementById('backToTop');
            if(backBtn){
                window.addEventListener('scroll', function(){
                    backBtn.classList.toggle('show', window.scrollY > 300);
                });
                backBtn.addEventListener('click', function(){
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Newsletter subscribe (plain JS - no jQuery dependency needed)
            var newsletterForm = document.querySelector('.newsletter-form');
            if(newsletterForm){
                newsletterForm.addEventListener('submit', function(e){
                    e.preventDefault();
                    var emailInput = newsletterForm.querySelector('input[name="email"]');
                    var formData = new FormData();
                    formData.append('email', emailInput.value);

                    fetch('newsletter.php', { method: 'POST', body: formData })
                        .then(function(res){ return res.text(); })
                        .then(function(text){ alert(text); newsletterForm.reset(); })
                        .catch(function(){ alert('Something went wrong. Please try again.'); });
                });
            }
        })();
    </script>