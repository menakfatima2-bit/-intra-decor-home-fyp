<?php
session_start();
include "db.php";

$error = "";

/* ✅ Agar already login hai to redirect */
if(isset($_SESSION['user_id'])){
    $chk_uid = $_SESSION['user_id'];
    $chk_res = mysqli_query($conn, "SELECT id FROM users WHERE id='$chk_uid'");
    if(!$chk_res || mysqli_num_rows($chk_res) == 0){
        // Stale session (user deleted from DB), destroy session to allow fresh login
        session_destroy();
        session_start();
    } else {
        if($_SESSION['user_role'] == 'admin'){
            header("Location: admindashboard/admindashboard.php");
        }
        elseif($_SESSION['user_role'] == 'seller'){
            header("Location: sellerdashboard/Dashboard.php");
        }
        elseif($_SESSION['user_role'] == 'service_provider'){
            header("Location: serviceproviderdashboard/serviceprovider.php");
        }
        else{
            // Agar redirect URL hai to wahan jao
            if(isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])){
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header("Location: $redirect");
            } else {
                header("Location: userdashboard/userdashboard.php");
            }
        }
        exit();
    }
}

// Redirect URL save karo — jahan se aaya tha
if(isset($_GET['redirect'])){
    $_SESSION['redirect_after_login'] = $_GET['redirect'];
}

// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$error = "";

/* LOGIN LOGIC */
if(isset($_POST['login'])){

    $email    = $_POST['login_email'];
    $password = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){

            $_SESSION['wrong_attempt'] = 0;
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role']  = $user['role'];
            $_SESSION['city']       = $user['city'];
            $_SESSION['phone']      = $user['phone'];

            if($user['role'] == 'admin'){
                header("Location: admindashboard/admindashboard.php");
            }
            elseif($user['role'] == 'seller'){
                header("Location: sellerdashboard/Dashboard.php");
            }
            elseif($user['role'] == 'service_provider'){
                if($user['is_approved'] == 1){
                    header("Location: serviceproviderdashboard/serviceprovider.php");
                } else {
                    $error = "Your account is pending admin approval. Please wait!";
                }
            }
            else{
                // User — redirect URL check karo
                if(isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])){
                    $redirect = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    header("Location: $redirect");
                } else {
                    header("Location: userdashboard/userdashboard.php");
                }
            }

            if(empty($error)) exit();

        } else {
            if(!isset($_SESSION['wrong_attempt'])){
                $_SESSION['wrong_attempt'] = 0;
            }
            $_SESSION['wrong_attempt']++;
            $error = "Incorrect password!";
        }

    } else {
        $error = "Email not found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login — Intra Decor Home</title>
    <link rel="stylesheet" href="login.css?v=3">
    <style>
        .success-msg {
            background: #d5f5e3; color: #1e8449;
            border: 1px solid #a9dfbf; border-radius: 8px;
            padding: 10px 14px; font-size: 13px;
            text-align: center; margin-bottom: 16px;
        }
        .guest-links {
            margin-top: 18px; padding-top: 14px;
            border-top: 1px solid #eee;
            text-align: center; font-size: 13px;
        }
        .guest-links a { color: #4b2c2c; font-weight: 600; text-decoration: none; }
        .guest-links a:hover { text-decoration: underline; }
        .guest-links .sep { color: #ccc; margin: 0 8px; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box">

        <h2 style="text-align:center; margin-bottom: 20px;">Login</h2>

        <?php if (isset($_GET['registered'])): ?>
        <div class="success-msg">
            ✅ Registration successful! Please login to continue.
        </div>
        <?php endif; ?>

        <form method="POST" action="login.php" id="loginForm">
            <input type="email" name="login_email" placeholder="Email" required>

            <div class="password-wrapper">
                <input type="password" id="password" name="login_password" placeholder="Password" required>
                <span id="togglePassword">👁</span>
            </div>

            <?php if(!empty($error)){ ?>
            <div style="color:red; margin-top:5px;">
                <?php echo $error; ?>
            </div>
            <?php } ?>

            <button type="submit" name="login">Login</button>
        </form>

        <p style="text-align:center; margin-top:10px;">
            Don't have an account? <a href="signup.php">Signup here</a>
        </p>

        <?php if(isset($_SESSION['wrong_attempt']) && $_SESSION['wrong_attempt'] >= 1){ ?>
        <p style="text-align:center; margin-top:5px;">
            <a href="forgotpassword.php">Forgot Password?</a>
        </p>
        <?php } ?>

        <!-- Guests can still use the website without logging in -->
        <div class="guest-links">
            <a href="index.php">&larr; Back to Home</a>
            <span class="sep">|</span>
            <a href="Track-order.php">Track My Order</a>
        </div>

    </div>
</div>

<script>
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");
togglePassword.addEventListener("click", function(){
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
});
</script>

</body>
</html>