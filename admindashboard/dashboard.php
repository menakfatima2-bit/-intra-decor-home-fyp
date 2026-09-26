<?php
/*
include "../db.php"; // parent folder se db.php include

// Check if admin already exists
$check = "SELECT * FROM users WHERE email='admin@gmail.com'";
$result = mysqli_query($conn, $check);

if(mysqli_num_rows($result) == 0) {
    $hashed_password = password_hash("Admin123", PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role, city) 
            VALUES ('Admin', 'admin@gmail.com', '$hashed_password', 'admin', 'Karachi')";

    if(mysqli_query($conn, $sql)) {
        echo "Admin added successfully!";
    } else {
        echo "Error adding admin: " . mysqli_error($conn);
    }
} else {
    echo "Admin already exists!";
}
    */
?>