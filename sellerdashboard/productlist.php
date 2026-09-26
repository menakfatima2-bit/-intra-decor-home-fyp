<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

$query = "SELECT * FROM productadd WHERE seller_id='$seller_id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Products | Seller Dashboard</title>
    <link rel="stylesheet" href="productlist.css?v=4">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Poppins',sans-serif; display:flex; min-height:100vh; background:#f1f2f6; }

        .sidebar { width:240px; background:#4b2c2c; padding:30px 20px; height:100vh; position:fixed; left:0; top:0; }
        .sidebar h2 { color:#fff; text-align:center; margin-bottom:40px; font-size:16px; }
        .sidebar a { display:block; color:#dcdde1; text-decoration:none; padding:12px 14px; margin-bottom:8px; border-radius:8px; transition:0.3s; font-size:14px; }
        .sidebar a:hover, .sidebar a.active { background:#ffa502; color:#fff; }

        .main-content { margin-left:240px; padding:30px; width:100%; }

        .container { background:#fff; padding:25px; border-radius:15px; box-shadow:0 5px 20px rgba(0,0,0,0.08); border-top:5px solid #ffa502; }

        h2 { text-align:center; margin-bottom:25px; color:#4b2c2c; font-size:22px; }

        table { width:100%; border-collapse:collapse; }

        table th {
            background:#4b2c2c;
            color:#fff;
            padding:12px 10px;
            text-align:left;
            font-size:13px;
            white-space:nowrap;
        }

        table td {
            padding:10px;
            border-bottom:1px solid #eee;
            font-size:13px;
            color:#333;
            vertical-align:middle;
        }

        table tr:hover td { background:#fafafa; }

        table td img {
            width:55px;
            height:55px;
            object-fit:cover;
            border-radius:8px;
            display:block;
        }

        .price-box { display:flex; flex-direction:column; gap:2px; }
        .old-price { text-decoration:line-through; color:#aaa; font-size:11px; }
        .final-price { color:#27ae60; font-weight:700; font-size:14px; }

        .discount-badge {
            display:inline-block;
            background:#ffeaea;
            color:#e74c3c;
            padding:2px 8px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .status-approved { color:#27ae60; font-weight:600; font-size:12px; }
       .status-pending  { color:#f39c12; font-weight:600; font-size:12px; }
        .status-rejected { color:#e74c3c; font-weight:600; font-size:12px; }
        .reject-reason-text { font-size:11px; color:#888; margin-top:3px; max-width:180px; }

        .actions { display:flex; gap:6px; align-items:center; }

        .actions a {
            padding:6px 12px;
            border-radius:6px;
            font-size:12px;
            font-weight:600;
            color:#fff;
            text-decoration:none;
            transition:0.2s;
            white-space:nowrap;
        }

        .edit-btn   { background:#4CAF50; }
        .edit-btn:hover { background:#388e3c; }
        .delete-btn { background:#f44336; }
        .delete-btn:hover { background:#c62828; }
        .view-btn   { background:#1e90ff; }
        .view-btn:hover { background:#1565c0; }

        .no-products { text-align:center; color:#888; padding:40px; font-size:15px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Seller Dashboard</h2>
    <a href="Dashboard.php">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="productlist.php" class="active">My Products</a>
    <a href="seller_orders.php">Orders</a>
    <a href="sellerprofile.php">Seller Profile</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="container">
        <h2>My Products</h2>

        <?php if(mysqli_num_rows($result) > 0){ ?>
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Discount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){
                $price      = $row['price'];
                $discount   = $row['discount'];
                $final      = $price - ($price * $discount / 100);
            ?>
            <tr>
                <td>
                    <img src="../uploads/<?php echo htmlspecialchars($row['product_image']); ?>">
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td>
                    <div class="price-box">
                        <?php if($discount > 0){ ?>
                        <span class="old-price">Rs. <?php echo number_format($price, 0); ?></span>
                        <?php } ?>
                        <span class="final-price">Rs. <?php echo number_format($final, 0); ?></span>
                    </div>
                </td>
                <td><?php echo $row['quantity']; ?></td>
                <td>
                    <?php if($discount > 0){ ?>
                    <span class="discount-badge"><?php echo $discount; ?>% OFF</span>
                    <?php } else { echo '-'; } ?>
                </td>
                <td>
    <?php if($row['status'] == 'approved'){ ?>
        <span class="status-approved">✔ Approved</span>
    <?php } elseif($row['status'] == 'rejected'){ ?>
        <span class="status-rejected" title="<?php echo htmlspecialchars($row['reject_reason']); ?>">✘ Rejected</span>
        <?php if(!empty($row['reject_reason'])){ ?>
            <div class="reject-reason-text"><?php echo htmlspecialchars($row['reject_reason']); ?></div>
        <?php } ?>
    <?php } else { ?>
        <span class="status-pending">⏳ Pending</span>
    <?php } ?>
</td>
                <td>
                    <div class="actions">
                        <a href="editproduct.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                        <a href="deleteproduct.php?id=<?php echo $row['id']; ?>" class="delete-btn"
                           onclick="return confirm('Delete this product?')">Delete</a>
                        <a href="viewdetail.php?id=<?php echo $row['id']; ?>" class="view-btn">View</a>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </table>

        <?php } else { ?>
            <p class="no-products">No products found. Add some products!</p>
        <?php } ?>
    </div>
</div>

</body>
</html>