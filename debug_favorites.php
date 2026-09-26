<?php
session_start();
include "db.php";

echo "<h2>Debug Info</h2>";

if(!isset($_SESSION['user_id'])){
    echo "<p style='color:red'>❌ Aap login nahi hain. Pehle login karein, phir is page ko dobara open karein.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];
echo "<p>✅ Logged in as user_id: <b>$user_id</b></p>";

echo "<h3>Aapki favorites table entries:</h3>";
$query = "SELECT * FROM favorites WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

if(!$result){
    echo "<p style='color:red'>❌ Query Error: " . mysqli_error($conn) . "</p>";
    exit();
}

if(mysqli_num_rows($result) == 0){
    echo "<p style='color:red'>❌ Koi row nahi mili is user ke liye favorites table mein.</p>";
} else {
    echo "<table border='1' cellpadding='8' style='border-collapse:collapse'>";
    echo "<tr><th>id</th><th>user_id</th><th>item_id</th><th>type</th><th>created_at</th></tr>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['user_id']."</td>";
        echo "<td>".$row['item_id']."</td>";
        echo "<td>'".$row['type']."'</td>";
        echo "<td>".$row['created_at']."</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h3>productadd table mein item_id=98 hai ya nahi:</h3>";
$q2 = "SELECT id, name, status FROM productadd WHERE id='98'";
$r2 = mysqli_query($conn, $q2);
if($r2 && mysqli_num_rows($r2) > 0){
    $d = mysqli_fetch_assoc($r2);
    echo "<p>✅ Mila: id=".$d['id'].", name=".$d['name'].", status=".$d['status']."</p>";
} else {
    echo "<p style='color:red'>❌ productadd table mein id=98 wala product nahi mila.</p>";
}
?>