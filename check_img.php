<?php
$conn = mysqli_connect("YOUR_DB_HOST","if0_42479335","YOUR_DB_PASSWORD","if0_42479335_intradecorhome");
$r = mysqli_query($conn, "SELECT provider_id, name, profile_image FROM providerprofile LIMIT 5");
while($row = mysqli_fetch_assoc($r)){
    echo $row['name'] . " → " . $row['profile_image'] . "<br>";
}
?>