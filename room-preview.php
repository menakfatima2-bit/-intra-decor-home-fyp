<?php
session_start();
include "db.php";

$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $c = mysqli_query($conn,
        "SELECT SUM(quantity) as total 
         FROM cart WHERE user_id='{$_SESSION['user_id']}'"
    );
    if ($c) {
        $cr = mysqli_fetch_assoc($c);
        $cart_count = $cr['total'] ?? 0;
    }
}

// Last saved design (used to restore the "Recently Applied Combo" on page load)
$last_design = isset($_SESSION['last_design']) ? $_SESSION['last_design'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Room Designer - Intra Decor Home</title>
    <link rel="stylesheet" href="assets/css/style.css?v=10">
    <link rel="stylesheet" href="assets/css/room-preview.css?v=4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Footer.css">
</head>
<body>

    <div class="container">
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
                    <a href="cart.php" style="position:relative; display:inline-block;">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-text">Cart</span>
                        <?php if ($cart_count > 0) { ?>
                            <span id="cart-badge" style="
                                position: absolute;
                                top: -8px;
                                right: -10px;
                                background: #e74c3c;
                                color: white;
                                font-size: 11px;
                                font-weight: bold;
                                width: 18px;
                                height: 18px;
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "><?php echo $cart_count; ?></span>
                        <?php } ?>
                    </a>
                </div>
            </div>
            <!-- Hamburger for Mobile -->
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
            <a href="room-preview.php" class="nav-btn active">AI Room Designer</a>
        </div>

        <!-- MAIN INTERACTIVE SECTION -->
        <div class="designer-title-section">
            <h1>AI Room Designer</h1>
            <p>Customize your space instantly. Select a category, pick a product, and see the texture apply realistically to the room walls or floor.</p>
        </div>

        <div class="designer-wrapper">
            <!-- Left Side: Interactive Preview -->
            <div class="preview-panel">
                <div class="room-img-container" id="roomImgContainer">
                    <img id="roomPreviewImg" src="assets/images/room.jpeg" alt="Room Preview">

                    <!-- Loader Overlay -->
                    <div id="designerLoader" class="designer-loader">
                        <div class="spinner"></div>
                        <p>AI Processing Room Mask...</p>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div id="designerStatus" class="status-badge" style="display:none;">
                    <i class="fa-solid fa-circle"></i>
                    <span>Mode: Original Image</span>
                </div>

                <!-- Cost Estimate -->
                <div id="costEstimate" class="cost-estimate" style="display:none;"></div>

                <!-- Add to Cart / Download / Share -->
                <div class="preview-actions" id="previewActions" style="display:none;">
                    <button id="addToCartBtn" class="action-btn cart-btn" type="button">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                    </button>
                    <a id="downloadBtn" class="action-btn download-btn" href="#" download="my-room-design.jpg">
                        <i class="fa-solid fa-download"></i> Download
                    </a>
                    <button id="shareBtn" class="action-btn share-btn" type="button">
                        <i class="fa-brands fa-whatsapp"></i> Share
                    </button>
                </div>

                <button id="resetBtn" class="reset-btn" style="display:none;">
                    <i class="fa-solid fa-rotate-left"></i> Reset Room
                </button>
            </div>

            <!-- Right Side: Step-by-Step Control Panel -->
            <div class="controls-panel">
                <!-- Step 1: Select Category -->
                <div>
                    <h3 class="step-title"><span>1</span> Choose Category</h3>
                    <div id="categoryTabs" class="category-tabs">
                        <div class="empty-state">Loading categories...</div>
                    </div>
                </div>

                <!-- Step 2: Select Subcategory (Product Type) -->
                <div>
                    <h3 class="step-title"><span>2</span> Select Subcategory</h3>
                    <div id="subcategoryContainer" class="subcategory-container">
                        <div style="color: #999; font-size: 0.85rem; padding: 5px 0;">Please choose a category first.</div>
                    </div>
                </div>

                <!-- Step 3: Choose Product -->
                <div>
                    <h3 class="step-title"><span>3</span> Pick Product</h3>
                    <div id="productsGrid" class="products-grid">
                        <div class="empty-state">Choose a subcategory to view products.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW: Trending Combos -->
        <div class="trending-section">
            <h2 class="trending-title"><i class="fa-solid fa-fire"></i> Trending Combos</h2>
            <p class="trending-subtitle">Popular design pairings — tap one to preview it instantly.</p>
            <div id="trendingCombos" class="trending-combos">
                <div class="empty-state">Loading trending combos...</div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include 'Footer.php'; ?>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.hamburger').click(function() {
                $('.bottomheader').toggleClass('active');
            });

            // State variables
            let selectedCategory = '';
            let selectedSubcategory = '';
            let activeWallTexture = '';
            let activeFloorTexture = '';
            let activeWallProductId = '';
            let activeFloorProductId = '';
            let activeWallPrice = 0;
            let activeFloorPrice = 0;
            let loaderMessageTimer = null;
            let selectedRoomKey = 'default';

            // All products loaded so far, grouped by category (used for Trending Combos matching)
            let allProductsByCategory = {};

            const roomPreviewMap = {
                'default':    'assets/images/room.jpeg',
                'bedroom':    'assets/images/rooms/bedroom.jpg',
                'livingroom': 'assets/images/rooms/livingroom.jpg',
                'kitchen':    'assets/images/rooms/kitchen.jpg',
                'washroom':   'assets/images/rooms/washroom.jpg'
            };

            let lastDesign = <?php echo json_encode($last_design); ?>;

            const categoryMeta = {
                'wallpaper': { icon: 'fa-brush', name: 'Wallpapers' },
                'tiles': { icon: 'fa-cubes', name: 'Floor Tiles' },
                'paneling': { icon: 'fa-square', name: 'Wall Panels' }
            };

            // 1. Fetch Categories
            function loadCategories() {
                $.ajax({
                    url: 'get-designer-categories.php',
                    method: 'GET',
                    success: function(response) {
                        if(response.success) {
                            let html = '';
                            response.categories.forEach((cat, index) => {
                                const meta = categoryMeta[cat] || { icon: 'fa-folder-open', name: cat };
                                html += `
                                    <div class="category-card" data-category="${cat}">
                                        <i class="fa-solid ${meta.icon}"></i>
                                        <span>${meta.name}</span>
                                    </div>
                                `;
                            });
                            $('#categoryTabs').html(html);

                            if(response.categories.length > 0) {
                                $('.category-card').first().click();
                            }

                            // Preload products for all categories in the background (for Trending Combos)
                            preloadAllProductsForCombos(response.categories);
                        } else {
                            $('#categoryTabs').html('<div class="empty-state">Error loading categories.</div>');
                        }
                    },
                    error: function() {
                        $('#categoryTabs').html('<div class="empty-state">Error loading categories.</div>');
                    }
                });
            }

            $(document).on('click', '.category-card', function() {
                $('.category-card').removeClass('active');
                $(this).addClass('active');
                
                selectedCategory = $(this).data('category');
                selectedSubcategory = '';
                
                $('#subcategoryContainer').html('<div style="color: #999; font-size: 0.85rem; padding: 5px 0;">Loading subcategories...</div>');
                $('#productsGrid').html('<div class="empty-state">Please select a subcategory first.</div>');
                
                loadSubcategories(selectedCategory);
            });

            // 2. Fetch Subcategories
            function loadSubcategories(category) {
                $.ajax({
                    url: 'get-designer-subcategories.php',
                    method: 'GET',
                    data: { category: category },
                    success: function(response) {
                        if(response.success) {
                            if(response.subcategories.length > 0) {
                                let html = '';
                                response.subcategories.forEach((sub, index) => {
                                    html += `<button class="pill-btn" data-subcategory="${sub}">${sub}</button>`;
                                });
                                $('#subcategoryContainer').html(html);
                                $('.pill-btn').first().click();
                            } else {
                                $('#subcategoryContainer').html('<div style="color: #999; font-size: 0.85rem; padding: 5px 0;">No subcategories found.</div>');
                            }
                        } else {
                            $('#subcategoryContainer').html('<div style="color: #c0392b; font-size: 0.85rem; padding: 5px 0;">Error.</div>');
                        }
                    },
                    error: function() {
                        $('#subcategoryContainer').html('<div style="color: #c0392b; font-size: 0.85rem; padding: 5px 0;">Error.</div>');
                    }
                });
            }

            $(document).on('click', '.pill-btn', function() {
                $('.pill-btn').removeClass('active');
                $(this).addClass('active');
                
                selectedSubcategory = $(this).data('subcategory');
                $('#productsGrid').html('<div class="empty-state">Loading products...</div>');
                
                loadProducts(selectedCategory, selectedSubcategory);
            });

            // 3. Fetch Products
            function loadProducts(category, subcategory) {
                $.ajax({
                    url: 'get-designer-products.php',
                    method: 'GET',
                    data: { category: category, subcategory: subcategory },
                    success: function(response) {
                        if(response.success) {
                            if(response.products.length > 0) {
                                let html = '';
                                response.products.forEach(prod => {
                                    html += `
                                        <div class="product-item-card" data-image="${prod.product_image}" data-id="${prod.id}" data-price="${prod.price}">
                                            <div class="prod-img-box">
                                                <img src="${prod.product_image}" alt="${prod.name}">
                                            </div>
                                            <div class="prod-details">
                                                <h4 class="prod-name" title="${prod.name}">${prod.name}</h4>
                                                <div class="prod-price">
                                                    <span>Rs. ${Number(prod.price).toLocaleString()}</span>
                                                    <button class="prod-view-btn" onclick="event.stopPropagation(); window.location.href='product_detail.php?id=${prod.id}'">View</button>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                });
                                $('#productsGrid').html(html);
                            } else {
                                $('#productsGrid').html('<div class="empty-state">No products found in this subcategory.</div>');
                            }
                        } else {
                            $('#productsGrid').html('<div class="empty-state">Error loading products.</div>');
                        }
                    },
                    error: function() {
                        $('#productsGrid').html('<div class="empty-state">Error loading products.</div>');
                    }
                });
            }

            // NEW: Silently preload a few products per category (for Trending Combos), without touching the visible UI
            function preloadAllProductsForCombos(categories) {
                let remaining = categories.length;
                if (remaining === 0) { renderTrendingCombos(); return; }

                allProductsByCategory = {};

                categories.forEach(function(cat) {
                    // Step 1: get this category's subcategories
                    $.ajax({
                        url: 'get-designer-subcategories.php',
                        method: 'GET',
                        data: { category: cat },
                        success: function(subResponse) {
                            if (!subResponse.success || subResponse.subcategories.length === 0) {
                                remaining--;
                                if (remaining === 0) renderTrendingCombos();
                                return;
                            }

                            allProductsByCategory[cat] = [];
                            let subsLeft = subResponse.subcategories.length;

                            // Step 2: pull products for every subcategory in this category
                            subResponse.subcategories.forEach(function(sub) {
                                $.ajax({
                                    url: 'get-designer-products.php',
                                    method: 'GET',
                                    data: { category: cat, subcategory: sub },
                                    success: function(prodResponse) {
                                        if (prodResponse.success) {
                                            allProductsByCategory[cat] = allProductsByCategory[cat].concat(prodResponse.products);
                                        }
                                    },
                                    complete: function() {
                                        subsLeft--;
                                        if (subsLeft === 0) {
                                            remaining--;
                                            if (remaining === 0) renderTrendingCombos();
                                        }
                                    }
                                });
                            });
                        },
                        error: function() {
                            remaining--;
                            if (remaining === 0) renderTrendingCombos();
                        }
                    });
                });
            }

            // NEW: Build 3 "trending" combo cards by simply pairing a wallpaper/panel product with a tile product
            function renderTrendingCombos() {
                const wallPool  = (allProductsByCategory['wallpaper'] || []).concat(allProductsByCategory['paneling'] || []);
                const floorPool = allProductsByCategory['tiles'] || [];

                if (wallPool.length === 0 || floorPool.length === 0) {
                    $('#trendingCombos').html('<div class="empty-state">Not enough products yet to suggest combos.</div>');
                    return;
                }

                const comboNames = ['Modern Grey Look', 'Warm Earth Tones', 'Bright Floral Charm', 'Classic Neutral'];
                const comboCount = Math.min(4, wallPool.length, floorPool.length);

                let html = '';
                for (let i = 0; i < comboCount; i++) {
                    const wallProd  = wallPool[i % wallPool.length];
                    const floorProd = floorPool[(i + 1) % floorPool.length];
                    const comboTotal = (parseFloat(wallProd.price) || 0) + (parseFloat(floorProd.price) || 0);

                    html += `
                        <div class="combo-card"
                             data-wall-image="${wallProd.product_image}"
                             data-wall-id="${wallProd.id}"
                             data-wall-price="${wallProd.price}"
                             data-floor-image="${floorProd.product_image}"
                             data-floor-id="${floorProd.id}"
                             data-floor-price="${floorProd.price}">
                            <div class="combo-thumbs">
                                <img src="${wallProd.product_image}" alt="Wall">
                                <img src="${floorProd.product_image}" alt="Floor">
                            </div>
                            <h4>${comboNames[i % comboNames.length]}</h4>
                            <p>Rs. ${comboTotal.toLocaleString()} <span>total</span></p>
                            <button class="combo-try-btn">Try This Combo</button>
                        </div>
                    `;
                }
                $('#trendingCombos').html(html);
            }

            // NEW: Clicking a trending combo applies both its wall + floor products in one go
            $(document).on('click', '.combo-card', function() {
                const card = $(this);

                activeWallTexture    = card.data('wall-image');
                activeWallProductId  = card.data('wall-id');
                activeWallPrice      = parseFloat(card.data('wall-price')) || 0;

                activeFloorTexture   = card.data('floor-image');
                activeFloorProductId = card.data('floor-id');
                activeFloorPrice     = parseFloat(card.data('floor-price')) || 0;

                // Scroll the preview into view so the user sees the result apply
                $('html, body').animate({ scrollTop: $('.preview-panel').offset().top - 20 }, 400);

                applyDesign();
            });

            // 4. Product click handler (Apply Texture)
            $(document).on('click', '.product-item-card', function() {
                const productImage = $(this).data('image');
                const productId = $(this).data('id');
                const productPrice = parseFloat($(this).data('price')) || 0;
                
                if (selectedCategory === 'tiles') {
                    activeFloorTexture = productImage;
                    activeFloorProductId = productId;
                    activeFloorPrice = productPrice;
                } else {
                    activeWallTexture = productImage;
                    activeWallProductId = productId;
                    activeWallPrice = productPrice;
                }

                applyDesign();
            });

            // Cycles through friendly progress messages while the AI request is in flight
            function startLoaderMessages() {
                const messages = [
                    'Detecting walls & floor...',
                    'Applying texture...',
                    'Adjusting lighting & shadows...',
                    'Finishing up...'
                ];
                let i = 0;
                $('#designerLoader p').text(messages[0]);
                loaderMessageTimer = setInterval(function() {
                    i = (i + 1) % messages.length;
                    $('#designerLoader p').text(messages[i]);
                }, 1800);
            }

            function stopLoaderMessages() {
                if (loaderMessageTimer) {
                    clearInterval(loaderMessageTimer);
                    loaderMessageTimer = null;
                }
            }

            function updateCostEstimate() {
                const total = activeWallPrice + activeFloorPrice;

                if (total <= 0) {
                    $('#costEstimate').hide();
                    return;
                }

                let breakdown = '';
                if (activeWallPrice > 0) {
                    breakdown += `Wall/Panel: Rs. ${activeWallPrice.toLocaleString()}`;
                }
                if (activeFloorPrice > 0) {
                    breakdown += (breakdown ? ' + ' : '') + `Floor: Rs. ${activeFloorPrice.toLocaleString()}`;
                }

                $('#costEstimate').show().html(`
                    <i class="fa-solid fa-calculator"></i>
                    <span><strong>Estimated Cost: Rs. ${total.toLocaleString()}</strong> <small>(${breakdown}, based on listed product price)</small></span>
                `);
            }

            // Runs the AI designer AJAX call and updates the UI on success
            function applyDesign() {
                $('#designerLoader').css('display', 'flex');
                startLoaderMessages();
                
                $.ajax({
                    url: 'apply-designer.php',
                    method: 'GET',
                    data: {
                        wall_texture: activeWallTexture,
                        floor_texture: activeFloorTexture,
                        room: selectedRoomKey,
                        wall_product_id: activeWallProductId,
                        floor_product_id: activeFloorProductId,
                        wall_price: activeWallPrice,
                        floor_price: activeFloorPrice
                    },
                    success: function(response) {
                        $('#designerLoader').hide();
                        stopLoaderMessages();
                        
                        if(response.success) {
                             const finalSrc = response.result_path + '?t=' + new Date().getTime();
                             $('#roomPreviewImg').attr('src', finalSrc);
                             
                             let displayLabel = '';
                             if (activeWallTexture && activeFloorTexture) {
                                 displayLabel = 'Wallpaper & Floor Tiles';
                             } else if (activeWallTexture) {
                                 displayLabel = selectedCategory === 'paneling' ? 'Wall Panels' : 'Wallpaper Design';
                             } else if (activeFloorTexture) {
                                 displayLabel = 'Floor Tiles';
                             } else {
                                 displayLabel = 'Design Applied';
                             }
                             $('#designerStatus').show().html(`
                                 <i class="fa-solid fa-circle" style="color: #27ae60;"></i>
                                 <span>Applied: ${displayLabel}</span>
                             `);

                             updateCostEstimate();
                             
                             $('#resetBtn').show();
                             $('#previewActions').show();
                             $('#downloadBtn').attr('href', response.result_path);
                        } else {
                            alert('AI Room Designer Error: ' + response.error);
                        }
                    },
                    error: function() {
                        $('#designerLoader').hide();
                        stopLoaderMessages();
                        alert('Failed to connect to the AI Room Designer server.');
                    }
                });
            }

            // 5. Reset button handler
            $('#resetBtn').click(function() {
                activeWallTexture = '';
                activeFloorTexture = '';
                activeWallProductId = '';
                activeFloorProductId = '';
                activeWallPrice = 0;
                activeFloorPrice = 0;

                const src = roomPreviewMap[selectedRoomKey] || roomPreviewMap['default'];
                $('#roomPreviewImg').attr('src', src);
                $('#designerStatus').hide();
                $('#costEstimate').hide();
                $('#previewActions').hide();
                $(this).hide();
            });

            // Room-Suggestions dropdown -> switch base room photo
            $(document).on('click', '.room-option', function(e) {
                e.preventDefault();
                $('.room-option').removeClass('active');
                $(this).addClass('active');

                selectedRoomKey = $(this).data('room');

                activeWallTexture = '';
                activeFloorTexture = '';
                activeWallProductId = '';
                activeFloorProductId = '';
                activeWallPrice = 0;
                activeFloorPrice = 0;

                const newSrc = roomPreviewMap[selectedRoomKey] || roomPreviewMap['default'];

                $('#roomPreviewImg').off('error').attr('src', newSrc).on('error', function() {
                    $(this).off('error').attr('src', roomPreviewMap['default']);
                    alert('This room photo has not been added to the server yet, showing the default room instead.');
                });

                $('#designerStatus').hide();
                $('#costEstimate').hide();
                $('#previewActions').hide();
                $('#resetBtn').hide();
            });

            // Add to Cart directly from the designer
            $('#addToCartBtn').click(function() {
                const ids = [];
                if (activeWallProductId) ids.push(activeWallProductId);
                if (activeFloorProductId) ids.push(activeFloorProductId);

                if (ids.length === 0) {
                    alert('Please select a product first.');
                    return;
                }

                let completed = 0;
                let loggedOut = false;
                let latestCartCount = null;

                ids.forEach(function(id) {
                    $.ajax({
                        url: 'add_to_cart.php',
                        method: 'POST',
                        dataType: 'text',
                        data: { product_id: id, quantity: 1 },
                        success: function(raw) {
                            if (raw.trim() === 'login') {
                                loggedOut = true;
                            } else {
                                try {
                                    const parsed = JSON.parse(raw);
                                    if (parsed && parsed.cart_count !== undefined) {
                                        latestCartCount = parsed.cart_count;
                                    }
                                    if (parsed && parsed.status !== 'success' && parsed.message) {
                                        alert(parsed.message);
                                    }
                                } catch (e) { /* ignore parse errors */ }
                            }
                        },
                        complete: function() {
                            completed++;
                            if (completed === ids.length) {
                                finishAddToCart(loggedOut, latestCartCount);
                            }
                        }
                    });
                });
            });

            function finishAddToCart(loggedOut, cartCount) {
                if (loggedOut) {
                    if (confirm('Please login to add items to your cart. Go to the login page now?')) {
                        window.location.href = 'signup.php';
                    }
                    return;
                }
                if (cartCount !== null) {
                    updateCartBadge(cartCount);
                }
                alert('Product(s) added to your cart!');
            }

            function updateCartBadge(count) {
                let badge = $('#cart-badge');
                if (count > 0) {
                    if (badge.length === 0) {
                        $('.cart-box a').append('<span id="cart-badge" style="position:absolute;top:-8px;right:-10px;background:#e74c3c;color:white;font-size:11px;font-weight:bold;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;">' + count + '</span>');
                    } else {
                        badge.text(count);
                    }
                }
            }

            // Share button (opens WhatsApp with a message)
            $('#shareBtn').click(function() {
                const text = encodeURIComponent('Check out this room design I created on Intra Decor Home! \uD83C\uDFE0\u2728');
                window.open('https://wa.me/?text=' + text, '_blank');
            });

            // Restore the last applied design when the page loads (Recently Applied Combo)
            function restoreLastDesign() {
                if (!lastDesign || !lastDesign.result_path) return;

                activeWallTexture = lastDesign.wall_texture || '';
                activeFloorTexture = lastDesign.floor_texture || '';
                activeWallProductId = lastDesign.wall_product_id || '';
                activeFloorProductId = lastDesign.floor_product_id || '';
                activeWallPrice = parseFloat(lastDesign.wall_price) || 0;
                activeFloorPrice = parseFloat(lastDesign.floor_price) || 0;
                selectedRoomKey = lastDesign.room_key || 'default';

                $('.room-option').removeClass('active');
                $('.room-option[data-room="' + selectedRoomKey + '"]').addClass('active');

                const testImg = new Image();
                testImg.onload = function() {
                    $('#roomPreviewImg').attr('src', lastDesign.result_path + '?t=' + new Date().getTime());
                    $('#designerStatus').show().html(`
                        <i class="fa-solid fa-circle" style="color: #27ae60;"></i>
                        <span>Restored: Your last design</span>
                    `);
                    $('#resetBtn').show();
                    $('#previewActions').show();
                    $('#downloadBtn').attr('href', lastDesign.result_path);
                    updateCostEstimate();
                };
                testImg.onerror = function() {
                    // Preview image no longer exists on the server (auto-cleaned) - silently ignore
                };
                testImg.src = lastDesign.result_path;
            }

            // Start Flow
            loadCategories();
            restoreLastDesign();
        });
    </script>
</body>
</html>