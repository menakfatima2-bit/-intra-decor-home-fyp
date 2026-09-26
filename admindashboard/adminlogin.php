<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="adminlogin.css?v=2">
<title>Admin Login</title>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>

   <form action="loginprocess.php" method="post">
        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>