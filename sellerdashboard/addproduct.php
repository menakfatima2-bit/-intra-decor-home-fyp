<?php
session_start();
include "db.php";

// Make sure only seller can add product
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}
$seller_id = $_SESSION['user_id'];

$check = $conn->query("SELECT is_approved FROM users WHERE id = $seller_id");
$row = $check->fetch_assoc();

if($row['is_approved'] == 0){
    header("Location: dashboard.php?msg=notapproved");
    exit();
}

if (isset($_POST['productadd'])) {

    $seller_id   = $_SESSION['user_id'];
    $name        = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $type        = mysqli_real_escape_string($conn, $_POST['type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity    = mysqli_real_escape_string($conn, $_POST['quantity']);
    $discount    = mysqli_real_escape_string($conn, $_POST['discount']);
    $status      = "pending";

    // 2. Wallpaper extra fields
    $roll_width  = null;
    $roll_length = null;
    $material    = null;

    if ($category === 'wallpaper') {
        if (isset($_POST['roll_width_ft']) && isset($_POST['roll_width_in'])) {
            $w_ft = floatval($_POST['roll_width_ft']);
            $w_in = floatval($_POST['roll_width_in']);
            $roll_width = mysqli_real_escape_string($conn, round($w_ft + ($w_in / 12), 4));
        }
        if (isset($_POST['roll_length_ft']) && isset($_POST['roll_length_in'])) {
            $l_ft = floatval($_POST['roll_length_ft']);
            $l_in = floatval($_POST['roll_length_in']);
            $roll_length = mysqli_real_escape_string($conn, round($l_ft + ($l_in / 12), 4));
        }
        $material = isset($_POST['material']) ? mysqli_real_escape_string($conn, $_POST['material']) : null;
    }

    // 3. Tiles extra fields
    $tile_length = null;
    $tile_width  = null;
    $finish_type = null;

    if ($category === 'tiles') {
        if (isset($_POST['tile_length_ft']))
            $tile_length = mysqli_real_escape_string($conn, floatval($_POST['tile_length_ft']));
        if (isset($_POST['tile_width_ft']))
            $tile_width = mysqli_real_escape_string($conn, floatval($_POST['tile_width_ft']));
        $finish_type = isset($_POST['finish_type'])
            ? mysqli_real_escape_string($conn, $_POST['finish_type']) : null;
    }

    // 4. Wall Panels extra fields
    $panel_length = null;
    $panel_width  = null;

    if ($category === 'paneling') {
        if (isset($_POST['panel_length_ft']))
            $panel_length = mysqli_real_escape_string($conn, floatval($_POST['panel_length_ft']));
        if (isset($_POST['panel_width_ft']))
            $panel_width = mysqli_real_escape_string($conn, floatval($_POST['panel_width_ft']));
    }

    // 5. Paint extra fields (reuses the finish_type column for Shade, and material column for Finish)
    if ($category === 'paint') {
        $finish_type = isset($_POST['paint_shade'])
            ? mysqli_real_escape_string($conn, $_POST['paint_shade']) : null;
        $material = isset($_POST['paint_finish'])
            ? mysqli_real_escape_string($conn, $_POST['paint_finish']) : null;
    }

    // 5. Main image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext       = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image     = "product_" . time() . "." . $ext;
        $uploadDir = __DIR__ . "/../uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image))
            die("Main image upload failed");
    } else {
        die("No image uploaded");
    }

    // 6. Color images
    $color_image2 = null;
    if (isset($_FILES['color_image2']) && $_FILES['color_image2']['error'] === 0) {
        $ext2 = pathinfo($_FILES['color_image2']['name'], PATHINFO_EXTENSION);
        $color_image2 = "product_color2_" . time() . "." . $ext2;
        move_uploaded_file($_FILES['color_image2']['tmp_name'], $uploadDir . $color_image2);
    }

    $color_image3 = null;
    if (isset($_FILES['color_image3']) && $_FILES['color_image3']['error'] === 0) {
        $ext3 = pathinfo($_FILES['color_image3']['name'], PATHINFO_EXTENSION);
        $color_image3 = "product_color3_" . time() . "." . $ext3;
        move_uploaded_file($_FILES['color_image3']['tmp_name'], $uploadDir . $color_image3);
    }

    $color_image4 = null;
    if (isset($_FILES['color_image4']) && $_FILES['color_image4']['error'] === 0) {
        $ext4 = pathinfo($_FILES['color_image4']['name'], PATHINFO_EXTENSION);
        $color_image4 = "product_color4_" . time() . "." . $ext4;
        move_uploaded_file($_FILES['color_image4']['tmp_name'], $uploadDir . $color_image4);
    }

    $color_image5 = null;
    if (isset($_FILES['color_image5']) && $_FILES['color_image5']['error'] === 0) {
        $ext5 = pathinfo($_FILES['color_image5']['name'], PATHINFO_EXTENSION);
        $color_image5 = "product_color5_" . time() . "." . $ext5;
        move_uploaded_file($_FILES['color_image5']['tmp_name'], $uploadDir . $color_image5);
    }

    // 7. Insert into database
    $query = "INSERT INTO productadd 
(seller_id, name, price, category, product_type, description, product_image, quantity, discount, status,
roll_width, roll_length, material, color_image2, color_image3, color_image4, color_image5,
tile_length, tile_width, finish_type,
panel_length, panel_width)
VALUES 
('$seller_id', '$name', '$price', '$category', '$type', '$description', '$image', '$quantity', '$discount', '$status',
" . ($roll_width   !== null ? "'$roll_width'"   : "NULL") . ",
" . ($roll_length  !== null ? "'$roll_length'"  : "NULL") . ",
" . ($material     !== null ? "'$material'"     : "NULL") . ",
" . ($color_image2 !== null ? "'$color_image2'" : "NULL") . ",
" . ($color_image3 !== null ? "'$color_image3'" : "NULL") . ",
" . ($color_image4 !== null ? "'$color_image4'" : "NULL") . ",
" . ($color_image5 !== null ? "'$color_image5'" : "NULL") . ",
" . ($tile_length  !== null ? "'$tile_length'"  : "NULL") . ",
" . ($tile_width   !== null ? "'$tile_width'"   : "NULL") . ",
" . ($finish_type  !== null ? "'$finish_type'"  : "NULL") . ",
" . ($panel_length !== null ? "'$panel_length'" : "NULL") . ",
" . ($panel_width  !== null ? "'$panel_width'"  : "NULL") . ")";

    if (mysqli_query($conn, $query)) {

        // Notify all admins about the new product pending approval
        $notif_msg = mysqli_real_escape_string($conn, "New product \"$name\" submitted by seller (ID: $seller_id) - pending approval");
        $admins_res = mysqli_query($conn, "SELECT id FROM admins");
        if ($admins_res) {
            while ($admin_row = mysqli_fetch_assoc($admins_res)) {
                $aid = intval($admin_row['id']);
                mysqli_query($conn, "INSERT INTO notifications (admin_id, seller_id, message, is_read, created_at)
                                      VALUES ($aid, '$seller_id', '$notif_msg', 0, NOW())");
            }
        }

        header("Location: productlist.php");
        exit();
    } else {
        die("Database insert failed: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product | Seller Dashboard</title>
    <link rel="stylesheet" href="addproduct.css?v=7">
    <style>
        html, body { overflow: visible !important; }

        .tiles-heading {
            font-size: 14px; font-weight: 700; color: #4b2c2c;
            margin: 18px 0 6px; padding-bottom: 6px;
            border-bottom: 2px solid #e0e0e0;
        }
        .tiles-info {
            background: #f0f8ff; border-left: 4px solid #3498db;
            border-radius: 0 8px 8px 0; padding: 10px 14px;
            font-size: 12px; color: #1a5276; line-height: 1.6;
            margin-bottom: 14px;
        }
        #tile-preview {
            align-items: center; gap: 12px;
            background: #eaf6ff; border: 1.5px solid #aed6f1;
            border-radius: 10px; padding: 12px 16px;
            margin-top: 8px; font-size: 13px; color: #1a5276;
        }
        .tiles-note {
            background: #fef9e7; border: 1.5px solid #f9e79f;
            border-radius: 10px; padding: 12px 16px;
            font-size: 12px; color: #7d6608; line-height: 1.8;
            margin-top: 14px;
        }

        /* ── PANELS FIELDS STYLING ── */
        .panels-heading {
            font-size: 14px; font-weight: 700; color: #4b2c2c;
            margin: 18px 0 6px; padding-bottom: 6px;
            border-bottom: 2px solid #e0e0e0;
        }
        .panels-info {
            background: #f0fff4; border-left: 4px solid #27ae60;
            border-radius: 0 8px 8px 0; padding: 10px 14px;
            font-size: 12px; color: #1a5c35; line-height: 1.6;
            margin-bottom: 14px;
        }
        #panel-preview {
            align-items: center; gap: 12px;
            background: #eafff0; border: 1.5px solid #a8dfc0;
            border-radius: 10px; padding: 12px 16px;
            margin-top: 8px; font-size: 13px; color: #1a5c35;
        }
        .panels-note {
            background: #fef9e7; border: 1.5px solid #f9e79f;
            border-radius: 10px; padding: 12px 16px;
            font-size: 12px; color: #7d6608; line-height: 1.8;
            margin-top: 14px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Intra Decor</h2>
    <a href="Dashboard.php">Dashboard</a>
    <a href="addproduct.php" class="active">Add Product</a>
    <a href="productlist.php">Product List</a>
    <a href="sellerprofile.php">Seller Profile</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container">

        <h2>Add Product</h2>

        <form method="POST" enctype="multipart/form-data" action="addproduct.php">

            <div>
                <label>Product Name</label>
                <input type="text" name="product_name" placeholder="e.g. PVC White Panel" required>
            </div>

            <div>
                <label>Price (PKR) — Per Piece / Per Sheet</label>
                <input type="number" name="price" placeholder="e.g. 2500" required>
                <small>Enter price for one piece/sheet/roll</small>
            </div>

            <div>
                <label>Stock Quantity</label>
                <input type="number" name="quantity" placeholder="e.g. 50" required>
                <small>Total pieces/sheets available in stock</small>
            </div>

            <div>
                <label>Discount (%)</label>
                <input type="number" name="discount" min="0" max="100" placeholder="e.g. 10">
            </div>

            <div>
                <label>Category</label>
                <select id="category" name="category" onchange="loadTypes()" required>
                    <option value="">Select Category</option>
                    <option value="paint">Paint</option>
                    <option value="tiles">Tiles</option>
                    <option value="wallpaper">Wallpaper</option>
                    <option value="paneling">Wall Paneling</option>
                </select>
            </div>

            <div>
                <label>Product Type</label>
                <select id="type" name="type" required>
                    <option value="">Select Type</option>
                </select>
            </div>

            <!-- ===== WALLPAPER EXTRA FIELDS ===== -->
            <div id="wallpaper-fields" style="display:none;">

                <p class="wallpaper-heading">📏 Roll Dimensions (Feet & Inches)</p>
                <p class="color-info">
                    Standard wallpaper roll size in the real world:<br>
                    <strong>Width:</strong> 1 ft 6 in (18 inches) &nbsp;|&nbsp;
                    <strong>Length:</strong> 30 ft 0 in or 33 ft 0 in
                </p>

                <div class="ft-in-group">
                    <label>Roll Width</label>
                    <div class="ft-in-row">
                        <div class="ft-in-field">
                            <input type="number" name="roll_width_ft" id="roll_width_ft"
                                placeholder="1" min="0" max="10" oninput="updateRollPreview()">
                            <span class="unit-label">ft</span>
                        </div>
                        <div class="ft-in-field">
                            <input type="number" name="roll_width_in" id="roll_width_in"
                                placeholder="6" min="0" max="11" oninput="updateRollPreview()">
                            <span class="unit-label">in</span>
                        </div>
                    </div>
                    <small>Standard width: 1 ft 6 in (18 inches)</small>
                </div>

                <div class="ft-in-group">
                    <label>Roll Length</label>
                    <div class="ft-in-row">
                        <div class="ft-in-field">
                            <input type="number" name="roll_length_ft" id="roll_length_ft"
                                placeholder="30" min="0" max="200" oninput="updateRollPreview()">
                            <span class="unit-label">ft</span>
                        </div>
                        <div class="ft-in-field">
                            <input type="number" name="roll_length_in" id="roll_length_in"
                                placeholder="0" min="0" max="11" oninput="updateRollPreview()">
                            <span class="unit-label">in</span>
                        </div>
                    </div>
                    <small>Standard length: 30 ft 0 in or 33 ft 0 in</small>
                </div>

                <div class="roll-preview" id="roll-preview" style="display:none;">
                    <span class="preview-icon">📦</span>
                    <div class="preview-text">
                        <strong>1 Roll Coverage:</strong>
                        <span id="preview-sqft">—</span> sq ft
                        &nbsp;|&nbsp;
                        <strong>Size:</strong>
                        <span id="preview-size">—</span>
                    </div>
                </div>

                <div>
                    <label>Material</label>
                    <select name="material" id="material">
                        <option value="">Select Material</option>
                        <option value="Vinyl">Vinyl — Waterproof, Washable</option>
                        <option value="Non-woven">Non-woven — Easy to Remove</option>
                        <option value="Paper">Paper — Budget Friendly</option>
                        <option value="Fabric">Fabric — Luxury Look</option>
                    </select>
                    <small>Vinyl is the most popular choice in Pakistan</small>
                </div>

                <p class="wallpaper-heading" style="margin-top:20px;">🎨 Color Variants (Optional)</p>
                <p class="color-info">
                    Upload same wallpaper in different colors — customers can switch between them on product page.
                </p>

                <div class="wallpaper-grid">
                    <div>
                        <label>Color Variant 2</label>
                        <input type="file" name="color_image2" accept="image/*">
                        <small>e.g. Same design in Blue color</small>
                    </div>
                    <div>
                        <label>Color Variant 3</label>
                        <input type="file" name="color_image3" accept="image/*">
                        <small>e.g. Same design in Green color</small>
                    </div>
                    <div>
                        <label>Color Variant 4</label>
                        <input type="file" name="color_image4" accept="image/*">
                        <small>e.g. Same design in Brown color</small>
                    </div>
                    <div>
                        <label>Color Variant 5</label>
                        <input type="file" name="color_image5" accept="image/*">
                        <small>e.g. Same design in Purple color</small>
                    </div>
                </div>

                <div class="wallpaper-note">
                    ⚠️ Customers will see on the product page:<br>
                    <strong>• Roll size info (Width × Length in feet)</strong><br>
                    <strong>• 🧮 Wall Calculator — customer enters wall size in feet &amp; inches → rolls needed + total price calculated automatically</strong><br>
                    <strong>• 🎨 Color variant images to switch between colors</strong>
                </div>

            </div>
            <!-- ===== END WALLPAPER FIELDS ===== -->

            <!-- ===== TILES EXTRA FIELDS ===== -->
            <div id="tiles-fields" style="display:none;">

                <p class="tiles-heading">📐 Tile Size (Feet)</p>
                <div class="tiles-info">
                    Common tile sizes in Pakistan:<br>
                    <strong>1×1 ft</strong> (Bathroom) &nbsp;|&nbsp;
                    <strong>2×2 ft</strong> (Drawing Room) &nbsp;|&nbsp;
                    <strong>2×4 ft</strong> (Modern / Large Room)
                </div>

                <div class="ft-in-group">
                    <label>Tile Length</label>
                    <div class="ft-in-row">
                        <div class="ft-in-field">
                            <input type="number" name="tile_length_ft" id="tile_length_ft"
                                placeholder="2" min="0" max="10" oninput="updateTilePreview()">
                            <span class="unit-label">ft</span>
                        </div>
                    </div>
                    <small>e.g. 2 ft for a 2×2 tile</small>
                </div>

                <div class="ft-in-group">
                    <label>Tile Width</label>
                    <div class="ft-in-row">
                        <div class="ft-in-field">
                            <input type="number" name="tile_width_ft" id="tile_width_ft"
                                placeholder="2" min="0" max="10" oninput="updateTilePreview()">
                            <span class="unit-label">ft</span>
                        </div>
                    </div>
                    <small>e.g. 2 ft for a 2×2 tile</small>
                </div>

                <div id="tile-preview" style="display:none;">
                    🔲 &nbsp;
                    <strong>Tile Size:</strong> <span id="tile-preview-size">—</span>
                    &nbsp;|&nbsp;
                    <strong>1 Tile Area:</strong> <span id="tile-preview-sqft">—</span> sq ft
                </div>

                <div style="margin-top:14px;">
                    <label>Finish Type</label>
                    <select name="finish_type" id="finish_type">
                        <option value="">Select Finish</option>
                        <option value="Glossy">Glossy — Shiny, reflective</option>
                        <option value="Matte">Matte — Non-reflective, modern</option>
                        <option value="Polished">Polished — High-gloss, luxury</option>
                        <option value="Anti-slip">Anti-slip — Safe for wet areas</option>
                        <option value="Textured">Textured — Rough, outdoor use</option>
                    </select>
                    <small>Matte &amp; Anti-slip — best for bathrooms</small>
                </div>

                <div class="tiles-note">
                    ⚠️ Customers will see on the product page:<br>
                    <strong>• Tile size and finish type</strong><br>
                    <strong>• 🧮 Floor Calculator — room length × width → total sq ft + price</strong>
                </div>

            </div>
            <!-- ===== END TILES FIELDS ===== -->

            <!-- ===== WALL PANELS EXTRA FIELDS ===== -->
            <div id="panels-fields" style="display:none;">

                <p class="panels-heading">📐 Panel Size (Feet)</p>
                <div class="panels-info">
                    Common panel sizes in Pakistan:<br>
                    <strong>Sheet:</strong> 8×4 ft &nbsp;|&nbsp;
                    <strong>Strip:</strong> 8×0.5 ft or 8×1 ft &nbsp;|&nbsp;
                    <strong>3D Tile:</strong> 2×2 ft
                </div>

                <!-- PANEL LENGTH -->
                <div class="ft-in-group">
                    <label>Panel Length</label>
                    <div class="ft-in-row">
                        <div class="ft-in-field">
                            <input type="number" name="panel_length_ft" id="panel_length_ft"
                                placeholder="8" min="0" max="20" step="0.01"
                                oninput="updatePanelPreview()">
                            <span class="unit-label">ft</span>
                        </div>
                    </div>
                    <small>e.g. 8 ft for standard sheet, 2 ft for 3D tile</small>
                </div>

                <!-- PANEL WIDTH -->
                <div class="ft-in-group">
                    <label>Panel Width</label>
                    <div class="ft-in-row">
                        <div class="ft-in-field">
                            <input type="number" name="panel_width_ft" id="panel_width_ft"
                                placeholder="4" min="0" max="20" step="0.01"
                                oninput="updatePanelPreview()">
                            <span class="unit-label">ft</span>
                        </div>
                    </div>
                    <small>e.g. 4 ft for sheet, 0.5 ft for strip, 2 ft for 3D tile</small>
                </div>

                <!-- LIVE PANEL PREVIEW -->
                <div id="panel-preview" style="display:none;">
                    🪵 &nbsp;
                    <strong>Panel Size:</strong> <span id="panel-preview-size">—</span>
                    &nbsp;|&nbsp;
                    <strong>1 Panel Area:</strong> <span id="panel-preview-sqft">—</span> sq ft
                </div>

                <div class="panels-note">
                    ⚠️ Customers will see on the product page:<br>
                    <strong>• Panel size (Length × Width)</strong><br>
                    <strong>• 🧮 Wall Calculator — enter room wall size → panels needed + total price</strong>
                </div>

            </div>
            <!-- ===== END WALL PANELS FIELDS ===== -->

            <!-- ===== PAINT EXTRA FIELDS ===== -->
            <div id="paint-fields" style="display:none;">

                <p class="tiles-heading">🎨 Shade & Finish</p>
                <div class="tiles-info">
                    In real paint stores, a single color has multiple shades and finishes — each combination is a separate option for the customer.
                </div>

                <div>
                    <label>Shade</label>
                    <select name="paint_shade" id="paint_shade">
                        <option value="">Select Shade</option>
                        <option value="Extra Light">Extra Light</option>
                        <option value="Light">Light</option>
                        <option value="Medium">Medium</option>
                        <option value="Dark">Dark</option>
                        <option value="Extra Dark">Extra Dark</option>
                    </select>
                    <small>e.g. "Blue - Medium" is a different product from "Blue - Dark"</small>
                </div>

                <div style="margin-top:14px;">
                    <label>Finish</label>
                    <select name="paint_finish" id="paint_finish">
                        <option value="">Select Finish</option>
                        <option value="Matte">Matte — Non-reflective, modern</option>
                        <option value="Glossy">Glossy — Shiny, easy to clean</option>
                        <option value="Satin">Satin — Soft sheen, durable</option>
                        <option value="Eggshell">Eggshell — Low sheen, elegant</option>
                        <option value="Textured">Textured — Decorative, rough finish</option>
                    </select>
                </div>

                <div class="tiles-note" style="margin-top:14px;">
                    ⚠️ Customers will see on the product page:<br>
                    <strong>• Color, Shade &amp; Finish specifications</strong><br>
                    <strong>• 🧮 Paint Calculator — room size → litres needed + total price</strong>
                </div>

            </div>
            <!-- ===== END PAINT FIELDS ===== -->

            <div class="full-width">
                <label>Main Product Image</label>
                <input type="file" name="image" accept="image/*" required>
                <small>This will be the main display image</small>
            </div>

            <div class="full-width">
                <label>Description</label>
                <textarea name="description" placeholder="Describe your product — waterproof, self adhesive, best room for use, etc."></textarea>
            </div>

            <button name="productadd">Add Product</button>

        </form>

    </div>
</div>

<script>
const categoryTypes = {
    "paint": [
        "Red","Blue","Orange","Green","Purple",
        "Pink","Gray","Brown","Black","White"
    ],
    "tiles": [
        "Ceramic Tiles","Porcelain Tiles","Marble Tiles",
        "Granite Tiles","Mosaic Tiles","Terracotta Tiles",
        "Vitrified Tiles","Glass Tiles"
    ],
    "wallpaper": [
        "Floral Wallpaper","Abstract Wallpaper","Kids Wallpaper",
        "Geometric Wallpaper","Wood Wallpaper",
        "Brick / Stone Wallpaper","3D Wallpaper","Plain / Solid Color"
    ],
    "paneling": [
        "Brick Veneer","Metal Panels","Mirror Panels",
        "MDF Panels","PVC Panels","Wood Panels",
        "Wainscoting","Upholstered Panels"
    ]
};

function loadTypes() {
    const category        = document.getElementById("category").value;
    const typeSelect      = document.getElementById("type");
    const wallpaperFields = document.getElementById("wallpaper-fields");
    const tilesFields     = document.getElementById("tiles-fields");
    const panelsFields    = document.getElementById("panels-fields");
    const paintFields     = document.getElementById("paint-fields");

    typeSelect.innerHTML = "";
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.text  = "Select Type";
    typeSelect.appendChild(defaultOption);

    if (category && categoryTypes[category]) {
        categoryTypes[category].forEach(function(typeName) {
            const option = document.createElement("option");
            option.value = typeName;
            option.text  = typeName;
            typeSelect.appendChild(option);
        });
    }

    // Hide all extra fields
    wallpaperFields.style.display = "none";
    tilesFields.style.display     = "none";
    panelsFields.style.display    = "none";
    paintFields.style.display     = "none";

    // Clear wallpaper fields
    ["roll_width_ft","roll_width_in","roll_length_ft","roll_length_in"].forEach(id => {
        const el = document.getElementById(id);
        if(el){ el.removeAttribute("required"); el.value = ""; }
    });
    document.getElementById("material").removeAttribute("required");
    document.getElementById("material").value = "";
    document.getElementById("roll-preview").style.display = "none";

    // Clear tiles fields
    ["tile_length_ft","tile_width_ft"].forEach(id => {
        const el = document.getElementById(id);
        if(el){ el.removeAttribute("required"); el.value = ""; }
    });
    document.getElementById("finish_type").removeAttribute("required");
    document.getElementById("finish_type").value = "";
    document.getElementById("tile-preview").style.display = "none";

    // Clear panels fields
    ["panel_length_ft","panel_width_ft"].forEach(id => {
        const el = document.getElementById(id);
        if(el){ el.removeAttribute("required"); el.value = ""; }
    });
    document.getElementById("panel-preview").style.display = "none";

    // Clear paint fields
    document.getElementById("paint_shade").removeAttribute("required");
    document.getElementById("paint_shade").value = "";
    document.getElementById("paint_finish").removeAttribute("required");
    document.getElementById("paint_finish").value = "";

    // Show correct block
    if (category === "wallpaper") {
        wallpaperFields.style.display = "block";
        document.getElementById("roll_width_ft").setAttribute("required","required");
        document.getElementById("roll_length_ft").setAttribute("required","required");
        document.getElementById("material").setAttribute("required","required");

    } else if (category === "tiles") {
        tilesFields.style.display = "block";
        document.getElementById("tile_length_ft").setAttribute("required","required");
        document.getElementById("tile_width_ft").setAttribute("required","required");
        document.getElementById("finish_type").setAttribute("required","required");

    } else if (category === "paneling") {
        panelsFields.style.display = "block";
        document.getElementById("panel_length_ft").setAttribute("required","required");
        document.getElementById("panel_width_ft").setAttribute("required","required");

    } else if (category === "paint") {
        paintFields.style.display = "block";
        document.getElementById("paint_shade").setAttribute("required","required");
        document.getElementById("paint_finish").setAttribute("required","required");
    }
}

// Wallpaper roll live preview
function updateRollPreview() {
    const wFt = parseFloat(document.getElementById("roll_width_ft").value)  || 0;
    const wIn = parseFloat(document.getElementById("roll_width_in").value)   || 0;
    const lFt = parseFloat(document.getElementById("roll_length_ft").value)  || 0;
    const lIn = parseFloat(document.getElementById("roll_length_in").value)  || 0;
    const widthDecimal  = wFt + (wIn / 12);
    const lengthDecimal = lFt + (lIn / 12);
    const preview = document.getElementById("roll-preview");
    if (widthDecimal > 0 && lengthDecimal > 0) {
        document.getElementById("preview-sqft").textContent = (widthDecimal * lengthDecimal).toFixed(1);
        document.getElementById("preview-size").textContent = `${wFt} ft ${wIn} in  ×  ${lFt} ft ${lIn} in`;
        preview.style.display = "flex";
    } else {
        preview.style.display = "none";
    }
}

// Tile live preview
function updateTilePreview() {
    const l = parseFloat(document.getElementById("tile_length_ft").value) || 0;
    const w = parseFloat(document.getElementById("tile_width_ft").value)  || 0;
    const preview = document.getElementById("tile-preview");
    if (l > 0 && w > 0) {
        document.getElementById("tile-preview-size").textContent = `${l} ft × ${w} ft`;
        document.getElementById("tile-preview-sqft").textContent = (l * w).toFixed(2);
        preview.style.display = "flex";
    } else {
        preview.style.display = "none";
    }
}

// Panel live preview
function updatePanelPreview() {
    const l = parseFloat(document.getElementById("panel_length_ft").value) || 0;
    const w = parseFloat(document.getElementById("panel_width_ft").value)  || 0;
    const preview = document.getElementById("panel-preview");
    if (l > 0 && w > 0) {
        document.getElementById("panel-preview-size").textContent = `${l} ft × ${w} ft`;
        document.getElementById("panel-preview-sqft").textContent = (l * w).toFixed(2);
        preview.style.display = "flex";
    } else {
        preview.style.display = "none";
    }
}
</script>

</body>
</html>