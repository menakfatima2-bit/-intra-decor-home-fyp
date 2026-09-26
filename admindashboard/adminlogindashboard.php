<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <!-- ✅ CSS LINK YAHA LAGTA HAI -->
    <link rel="stylesheet" href="adminlogindashboard.css">

</head>
<body>

<div class="navbar">
    Welcome, <?php echo $_SESSION['admin']; ?>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h1>Admin Dashboard</h1>
</div>

</body>
</html>