<?php
session_start();
include "../db.php";  // ✅ Fix 1: path

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'service_provider'){  // ✅ Fix 2: role
    header("Location: ../login.php");  // ✅ Fix 3: redirect path
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM booking WHERE user_id='$user_id' ORDER BY id DESC";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>
<link rel="stylesheet" href="booking.css">
</head>
<body>
<h2>My Bookings</h2>

<table>
<tr>
<th>ID</th>
<th>Service</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){
    $status_class = "status-" . strtolower($row['status']);
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['service_name']; ?></td>
<td><?php echo $row['booking_date']; ?></td>
<td class="<?php echo $status_class; ?>"><?php echo ucfirst($row['status']); ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>