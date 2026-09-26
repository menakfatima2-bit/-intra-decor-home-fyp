<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    die("Access denied");
}

// FILTER: pending (is_approved = 0) or approved (is_approved = 1)
$status = (isset($_GET['status']) && $_GET['status'] === 'approved') ? 'approved' : 'pending';
$approved_value = ($status === 'approved') ? 1 : 0;

// SEARCH (name, email or city)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT u.id, u.name, u.email, u.city, u.phone AS user_phone, u.is_approved,
               p.phone AS profile_phone, p.whatsapp_number,
               (SELECT COUNT(*) FROM addservice a WHERE a.serviceprovider_id = u.id) AS total_services
        FROM users u
        LEFT JOIN providerprofile p ON p.provider_id = u.id
        WHERE u.role = 'service_provider' AND u.is_approved = ?";
$types  = "i";
$params = [$approved_value];

if($search !== ''){
    $sql   .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.city LIKE ?)";
    $like   = '%' . $search . '%';
    $types .= "sss";
    array_push($params, $like, $like, $like);
}
$sql .= " ORDER BY u.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Counts for the filter tabs
$pending_count  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM users WHERE role='service_provider' AND is_approved=0"))['c'];
$approved_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM users WHERE role='service_provider' AND is_approved=1"))['c'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Service Providers</title>
<link rel="stylesheet" href="adminproduct.css">
<style>
    .filters a.current { outline: 2px solid #4b2c2c; }
    .muted { color:#888; font-size:12px; }
    .empty-row td { text-align:center; color:#888; padding:30px; }
</style>
</head>
<body>

<?php include "notifications_bell.php"; ?>

<div class="dashboard">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admindashboard.php">Dashboard</a>
    <a href="adminseller.php">Manage Sellers</a>
    <a href="adminprovider.php" class="active">Manage Providers</a>
    <a href="adminproduct.php">Manage Products</a>
    <a href="notifications.php">Notifications</a>
    <a href="../logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main-content">

<h2>Manage Service Providers</h2>

<?php if(isset($_GET['msg'])){ ?>
<p class="success-msg">✔ Provider <?php echo $_GET['msg'] === 'blocked' ? 'blocked' : 'approved'; ?> successfully!</p>
<?php } ?>

<!-- SEARCH -->
<form method="GET" class="search-bar">
    <input type="hidden" name="status" value="<?php echo $status; ?>">
    <input type="text" name="search" placeholder="Search by name, email or city..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
</form>

<!-- FILTERS -->
<div class="filters">
    <a href="adminprovider.php?status=pending"  class="pending  <?php echo $status=='pending'?'current':''; ?>">Pending (<?php echo $pending_count; ?>)</a>
    <a href="adminprovider.php?status=approved" class="approved <?php echo $status=='approved'?'current':''; ?>">Approved (<?php echo $approved_count; ?>)</a>
</div>

<table>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>City</th>
    <th>Phone</th>
    <th>Services</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php if($result->num_rows == 0){ ?>
<tr class="empty-row"><td colspan="7">No <?php echo $status; ?> service providers found.</td></tr>
<?php } ?>

<?php while($row = $result->fetch_assoc()) {
    $phone = $row['profile_phone'] ?: $row['user_phone'];
?>
<tr>
    <td><?php echo htmlspecialchars($row['name']); ?></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
    <td><?php echo htmlspecialchars($row['city'] ?: '—'); ?></td>
    <td><?php echo $phone ? htmlspecialchars($phone) : '<span class="muted">—</span>'; ?></td>
    <td><?php echo intval($row['total_services']); ?></td>
    <td>
        <?php if($row['is_approved'] == 1){ ?>
            <span class="badge approved">Approved</span>
        <?php } else { ?>
            <span class="badge pending">Pending</span>
        <?php } ?>
    </td>
    <td class="actions">
        <?php if($row['is_approved'] == 1){ ?>
            <a class="reject-btn"
               href="adminapprove_provider.php?id=<?php echo $row['id']; ?>&action=block"
               onclick="return confirm('Block this service provider? They will not be able to log in.')">Block</a>
        <?php } else { ?>
            <a class="approve-btn"
               href="adminapprove_provider.php?id=<?php echo $row['id']; ?>&action=approve"
               onclick="return confirm('Approve this service provider?')">Approve</a>
        <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>

</body>
</html>
