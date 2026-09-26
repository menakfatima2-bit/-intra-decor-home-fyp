<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller'){
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Fetch orders for this seller's products only
$query = "SELECT orders.*, 
          productadd.name as product_name, 
          productadd.product_image,
          productadd.price,
          productadd.category,
          productadd.product_type,
          COALESCE(users.name, orders.name) as buyer_name,
          COALESCE(users.email, 'N/A') as buyer_email
          FROM orders
          JOIN productadd ON orders.product_id = productadd.id
          LEFT JOIN users ON orders.user_id = users.id
          WHERE productadd.seller_id = '$seller_id'
          ORDER BY orders.id DESC";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Orders | Seller Dashboard</title>
    <link rel="stylesheet" href="sellerdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .orders-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .orders-table th { background: #4b2c2c; color: white; padding: 12px 15px; text-align: left; font-size: 13px; }
        .orders-table td { padding: 12px 15px; border-bottom: 1px solid #f0e8e8; font-size: 13px; color: #333; vertical-align: middle; }
        .orders-table tr:last-child td { border-bottom: none; }
        .orders-table tr:hover td { background: #fdf8f8; }
        .orders-table img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }

        .status-pending  { background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .status-confirmed{ background: #d1e7dd; color: #0a3622; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .status-delivered{ background: #cfe2ff; color: #084298; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .status-cancelled{ background: #f8d7da; color: #842029; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }

        .payment-cod  { background: #e2e3e5; color: #383d41; padding: 3px 8px; border-radius: 10px; font-size: 11px; }
        .payment-jazz { background: #fff3cd; color: #856404; padding: 3px 8px; border-radius: 10px; font-size: 11px; }
        .payment-easy { background: #d1e7dd; color: #0a3622; padding: 3px 8px; border-radius: 10px; font-size: 11px; }

        .buyer-info .buyer-name { font-weight: bold; color: #333; }
        .buyer-info .buyer-email { font-size: 11px; color: #888; margin-top: 2px; }
        .buyer-info .buyer-addr { font-size: 11px; color: #666; margin-top: 2px; }

        .update-btn {
            background: #4b2c2c;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            transition: 0.2s;
        }
        .update-btn:hover { background: #6b3d3d; }

        .no-orders {
            text-align: center;
            padding: 60px 20px;
            color: #888;
            background: white;
            border-radius: 12px;
        }
        .no-orders i { font-size: 3rem; color: #ddd; display: block; margin-bottom: 15px; }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .s-card {
            background: white;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            text-align: center;
        }
        .s-card .s-num { font-size: 1.8rem; font-weight: bold; color: #4b2c2c; }
        .s-card .s-lbl { font-size: 12px; color: #888; margin-top: 4px; }

        .container {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border-top: 5px solid #ffa502;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="dashboard">

    <div class="sidebar">
        <h2>Seller Dashboard</h2>
        <a href="Dashboard.php">Dashboard</a>
        <a href="addproduct.php">Add Product</a>
        <a href="productlist.php">My Products</a>
        <a href="seller_orders.php" class="active">Orders</a>
        <a href="sellerprofile.php">Seller Profile</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <button class="menu-btn" onclick="toggleSidebar()">
                <i class="fa fa-bars"></i>
            </button>
            <div>
                <h1>My Orders</h1>
                <p>Manage customer orders here</p>
            </div>
            <?php include "notifications_bell.php"; ?>
        </div>

        <div class="container">
        <h2><i class="fa fa-box"></i> My Orders</h2>

        <?php
        // Summary count karo
        $total_orders = mysqli_num_rows($result);
        $pending = $confirmed = $delivered = 0;
        $all_orders = [];

        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $all_orders[] = $row;
                if($row['status'] == 'pending') $pending++;
                elseif($row['status'] == 'confirmed') $confirmed++;
                elseif($row['status'] == 'delivered') $delivered++;
            }
        }
        ?>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="s-card">
                <div class="s-num"><?php echo $total_orders; ?></div>
                <div class="s-lbl">Total Orders</div>
            </div>
            <div class="s-card">
                <div class="s-num" style="color:#856404"><?php echo $pending; ?></div>
                <div class="s-lbl">Pending</div>
            </div>
            <div class="s-card">
                <div class="s-num" style="color:#0a3622"><?php echo $confirmed; ?></div>
                <div class="s-lbl">Confirmed</div>
            </div>
            <div class="s-card">
                <div class="s-num" style="color:#084298"><?php echo $delivered; ?></div>
                <div class="s-lbl">Delivered</div>
            </div>
        </div>

        <?php if(count($all_orders) > 0){ ?>
        <table class="orders-table">
            <tr>
                <th>Product</th>
                <th>Buyer Info</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Update</th>
            </tr>

            <?php foreach($all_orders as $order){ ?>
            <tr>
                <!-- Product -->
                <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <img src="../uploads/<?php echo htmlspecialchars($order['product_image']); ?>">
                        <div>
                            <div style="font-weight:bold;"><?php echo htmlspecialchars($order['product_name']); ?></div>
                            <div style="font-size:11px; color:#888;"><?php echo htmlspecialchars($order['category']); ?></div>
                        </div>
                    </div>
                </td>

                <!-- Buyer Info -->
                <td>
                    <div class="buyer-info">
                        <div class="buyer-name">
                            <i class="fa fa-user" style="color:#4b2c2c; font-size:11px;"></i>
                            <?php echo htmlspecialchars($order['buyer_name']); ?>
                        </div>
                        <div class="buyer-email">
                            <i class="fa fa-envelope" style="font-size:10px;"></i>
                            <?php echo htmlspecialchars($order['buyer_email']); ?>
                        </div>
                        <div class="buyer-addr">
                            <i class="fa fa-location-dot" style="font-size:10px;"></i>
                            <?php echo htmlspecialchars($order['address'] ?? ''); ?>, 
                            <?php echo htmlspecialchars($order['city'] ?? ''); ?>
                        </div>
                        <div class="buyer-addr">
                            <i class="fa fa-phone" style="font-size:10px;"></i>
                            <?php echo htmlspecialchars($order['phone'] ?? ''); ?>
                        </div>
                    </div>
                </td>

                <!-- Quantity -->
                <td>
                    <strong><?php echo $order['quantity']; ?></strong>
                </td>

                <!-- Amount -->
                <td>
                    <strong style="color:#4b2c2c;">Rs. <?php echo number_format($order['amount'], 0); ?></strong>
                </td>

                <!-- Payment Method -->
                <td>
                    <?php
                    $pm = $order['payment_method'] ?? 'cod';
                    if($pm == 'cod'){
                        echo '<span class="payment-cod">💵 Cash on Delivery</span>';
                    } elseif($pm == 'jazzcash'){
                        echo '<span class="payment-jazz">📱 JazzCash</span>';
                    } else {
                        echo '<span class="payment-easy">💚 Easypaisa</span>';
                    }
                    ?>
                </td>

                <!-- Date -->
                <td style="font-size:12px; color:#666;">
                    <?php echo date('d M Y', strtotime($order['created_at'])); ?><br>
                    <span style="color:#aaa;"><?php echo date('h:i A', strtotime($order['created_at'])); ?></span>
                </td>

                <!-- Status -->
                <td>
                    <?php
                    $st = $order['status'];
                    if($st == 'pending')   echo '<span class="status-pending">Pending</span>';
                    elseif($st == 'confirmed') echo '<span class="status-confirmed">Confirmed</span>';
                    elseif($st == 'delivered') echo '<span class="status-delivered">Delivered</span>';
                    elseif($st == 'cancelled') echo '<span class="status-cancelled">Cancelled</span>';
                    else echo '<span>'.$st.'</span>';
                    ?>
                </td>

                <!-- Update Status -->
                <td>
                    <form action="update_order_status.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="status" style="padding:4px 8px; border-radius:6px; border:1px solid #ddd; font-size:12px; margin-bottom:5px;">
                            <option value="pending"   <?php if($order['status']=='pending')   echo 'selected'; ?>>Pending</option>
                            <option value="confirmed" <?php if($order['status']=='confirmed') echo 'selected'; ?>>Confirmed</option>
                            <option value="delivered" <?php if($order['status']=='delivered') echo 'selected'; ?>>Delivered</option>
                            <option value="cancelled" <?php if($order['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select><br>
                        <button type="submit" class="update-btn">Update</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <?php } else { ?>
        <div class="no-orders">
            <i class="fa fa-box-open"></i>
            <h3>No orders yet!</h3>
            <p>When customers place orders for your products, they will appear here.</p>
        </div>
        <?php } ?>

    </div>
</div>
</div>

</body>
</html>