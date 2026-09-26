<?php
include "db.php";

$category = mysqli_real_escape_string($conn, $_GET['category']);
$type     = mysqli_real_escape_string($conn, $_GET['type']);

$query = "SELECT * FROM productadd 
          WHERE status='approved' 
          AND category='$category' 
          AND (product_type='$type' OR product_type LIKE '%$type%')
          ORDER BY id DESC";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $price    = $row['price'];
        $discount = $row['discount'];
        $final    = $price - ($price * $discount / 100);

        echo '
        <div style="
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            cursor: pointer;
            max-width: 260px;
            width: 100%;
        " onmouseover="this.style.transform=\'translateY(-6px)\'" 
           onmouseout="this.style.transform=\'translateY(0)\'">

            <img src="uploads/' . htmlspecialchars($row['product_image']) . '" 
                 alt="product"
                 style="
                    width: 100%;
                    height: 200px;
                    object-fit: cover;
                 ">

            <div style="padding: 15px;">
                <h3 style="
                    font-size: 16px;
                    color: #333;
                    margin-bottom: 6px;
                ">' . htmlspecialchars($row['name']) . '</h3>

                <p style="
                    font-size: 13px;
                    color: #888;
                    margin-bottom: 10px;
                ">' . htmlspecialchars($row['product_type']) . '</p>

                <div style="margin-bottom: 12px;">
                    <span style="
                        text-decoration: line-through;
                        color: #aaa;
                        font-size: 13px;
                        margin-right: 6px;
                    ">Rs. ' . $price . '</span>
                    <span style="
                        color: #4b2c2c;
                        font-size: 18px;
                        font-weight: bold;
                    ">Rs. ' . $final . '</span>

                    ' . ($discount > 0 ? '
                    <span style="
                        background: #e74c3c;
                        color: white;
                        padding: 2px 8px;
                        border-radius: 20px;
                        font-size: 12px;
                        margin-left: 5px;
                    ">' . $discount . '% OFF</span>' : '') . '
                </div>

                <button 
                    onclick="window.location.href=\'product_detail.php?id=' . $row['id'] . '\'"
                    style="
                        width: 100%;
                        background: #4b2c2c;
                        color: white;
                        border: none;
                        padding: 10px;
                        border-radius: 25px;
                        font-size: 14px;
                        cursor: pointer;
                        transition: background 0.3s;
                    "
                    onmouseover="this.style.background=\'#6b3d3d\'"
                    onmouseout="this.style.background=\'#4b2c2c\'"
                >View Details</button>
            </div>
        </div>';
    }
} else {
    echo '<p style="
        padding: 40px;
        color: #888;
        text-align: center;
        width: 100%;
    ">No approved products in this subcategory yet.</p>';
}
?>