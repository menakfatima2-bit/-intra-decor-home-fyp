<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user'){
    $current_url = 'serviceproviderdashboard/bookservice.php?id=' . intval($_GET['id']);
    header("Location: ../login.php?redirect=" . urlencode($current_url));
    exit();
}

$service_id = intval($_GET['id']);

$query = "SELECT a.*, p.phone, p.call_number, p.whatsapp_number
          FROM addservice a
          LEFT JOIN providerprofile p ON a.serviceprovider_id = p.provider_id
          WHERE a.service_id='$service_id'";
$result = mysqli_query($conn, $query);
$service = mysqli_fetch_assoc($result);

if(!$service){
    echo "<p style='text-align:center;margin-top:50px;'>Service not found.</p>";
    exit();
}

// NEW: same contact-number logic as providerprofileview.php (falls back to phone if not set)
$call_num = $service['call_number'] ?? $service['phone'] ?? '';
$wa_num   = $service['whatsapp_number'] ?? $service['phone'] ?? '';
$wa       = preg_replace('/[^0-9]/', '', $wa_num);
if(substr($wa,0,1)=='0') $wa = '92'.substr($wa,1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Leaflet Map CSS — free, no API key needed -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f0f0; font-family: Arial, sans-serif; }

        .wrapper { max-width: 600px; margin: 40px auto; padding: 0 20px 60px; }

        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            color: #4b2c2c; text-decoration: none; font-size: 14px;
            margin-bottom: 20px; font-weight: 600;
        }
        .back-link:hover { color: #c17f4a; }

        .service-summary {
            background: #4b2c2c; color: #fff;
            border-radius: 14px; padding: 20px 24px;
            margin-bottom: 24px; display: flex;
            justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 12px;
        }
        .service-summary h3 { font-size: 17px; margin-bottom: 4px; }
        .service-summary p  { font-size: 13px; color: #c0a0a0; }
        .service-summary .charge {
            background: #c17f4a; padding: 8px 18px;
            border-radius: 20px; font-size: 15px; font-weight: 700;
        }

        .form-card {
            background: #fff; border-radius: 16px; padding: 28px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        /* NEW: Quick contact box */
        .quick-contact {
            background: #fff8f2; border: 1px dashed #c17f4a;
            border-radius: 14px; padding: 14px 20px;
            margin-bottom: 24px; display: flex;
            align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }
        .quick-contact p {
            font-size: 13px; color: #6b4a3a; margin: 0;
        }
        .quick-contact .contact-btns { display: flex; gap: 10px; }
        .quick-contact a {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 16px; border-radius: 20px;
            font-size: 13px; font-weight: 600; text-decoration: none;
            color: #fff; transition: 0.2s;
        }
        .quick-contact .btn-call { background: #4b2c2c; }
        .quick-contact .btn-call:hover { background: #3a2222; }
        .quick-contact .btn-whatsapp { background: #25D366; }
        .quick-contact .btn-whatsapp:hover { background: #1ebc59; }
        .form-card h2 {
            color: #4b2c2c; font-size: 18px; margin-bottom: 22px;
            padding-bottom: 10px; border-bottom: 2px solid #f0e0e0;
        }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block; font-size: 13px; font-weight: 600;
            color: #4b2c2c; margin-bottom: 7px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%; padding: 11px 14px;
            border: 2px solid #e0c9c9; border-radius: 8px;
            font-size: 14px; color: #333; outline: none;
            transition: 0.2s; font-family: Arial, sans-serif;
        }
        .form-group input:focus,
        .form-group textarea:focus { border-color: #c17f4a; }
        .form-group textarea { height: 80px; resize: vertical; }

        /* Map */
        #map {
            width: 100%; height: 280px;
            border-radius: 10px;
            border: 2px solid #e0c9c9;
            margin-top: 8px;
            z-index: 1;
        }

        .map-hint {
            font-size: 12px; color: #888; margin-top: 6px;
            display: flex; align-items: center; gap: 5px;
        }
        .map-hint i { color: #c17f4a; }

        .location-detected {
            background: #d4edda; color: #155724;
            padding: 8px 14px; border-radius: 8px;
            font-size: 13px; margin-top: 8px;
            display: none; align-items: center; gap: 6px;
        }
        .location-detected i { color: #2ecc71; }

        .detect-btn {
            background: #4b2c2c; color: #fff;
            border: none; padding: 8px 16px;
            border-radius: 8px; cursor: pointer;
            font-size: 13px; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 8px; transition: 0.2s;
        }
        .detect-btn:hover { background: #c17f4a; }

        /* Payment */
        .payment-box {
            background: #f9f4ef;
            border: 2px solid #e8d8c8;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
            display: flex; align-items: center; gap: 12px;
        }
        .payment-box i { color: #c17f4a; font-size: 22px; }
        .payment-box div h4 { color: #4b2c2c; font-size: 14px; margin-bottom: 2px; }
        .payment-box div p  { color: #888; font-size: 12px; }

        .submit-btn {
            width: 100%; padding: 14px;
            background: #c17f4a; color: #fff;
            border: none; border-radius: 10px;
            font-size: 16px; font-weight: 600;
            cursor: pointer; transition: 0.2s; margin-top: 6px;
        }
        .submit-btn:hover { background: #4b2c2c; }
    </style>
</head>
<body>

<div class="wrapper">

    <a href="../providerview.php?id=<?php echo $service_id; ?>" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to Profile
    </a>

    <!-- Service Summary -->
    <div class="service-summary">
        <div>
            <h3><?php echo $service['service_name']; ?></h3>
            <p>
                <i class="fa-solid fa-user-gear"></i> <?php echo $service['serviceprovider_name']; ?> &nbsp;|&nbsp;
                <i class="fa-solid fa-location-dot"></i> <?php echo $service['city']; ?>
            </p>
        </div>
        <div class="charge">
            Rs <?php echo number_format($service['started_at'], 0); ?> / sq.ft
        </div>
    </div>

    <!-- NEW: Quick Contact (call/WhatsApp the provider directly before or during booking) -->
    <?php if(!empty($call_num) || !empty($wa)){ ?>
    <div class="quick-contact">
        <p><i class="fa-solid fa-circle-info"></i> Prefer to talk first? Contact the provider directly.
            <?php if(!empty($call_num)){ ?>
                <br><strong><i class="fa-solid fa-phone"></i> Call: <?php echo htmlspecialchars($call_num); ?></strong>
            <?php } ?>
            <?php if(!empty($wa_num) && $wa_num !== $call_num){ ?>
                <br><strong><i class="fa-brands fa-whatsapp"></i> WhatsApp: <?php echo htmlspecialchars($wa_num); ?></strong>
            <?php } ?>
        </p>
        <div class="contact-btns">
            <?php if(!empty($call_num)){ ?>
            <a href="tel:<?php echo $call_num; ?>" class="btn-call">
                <i class="fa-solid fa-phone"></i> Call Now
            </a>
            <?php } ?>
            <?php if(!empty($wa)){ ?>
            <a href="https://wa.me/<?php echo $wa; ?>?text=Hi! I'm interested in your <?php echo urlencode($service['service_name']); ?> service on Intra Decor Home."
               target="_blank" class="btn-whatsapp">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </a>
            <?php } ?>
        </div>
    </div>
    <?php } ?>

    <!-- Booking Form -->
    <div class="form-card">
        <h2><i class="fa-solid fa-calendar-check"></i> Book This Service</h2>

        <form method="POST" action="bookservice_action.php">
            <input type="hidden" name="service_id"   value="<?php echo $service['service_id']; ?>">
            <input type="hidden" name="provider_id"  value="<?php echo $service['serviceprovider_id']; ?>">
            <input type="hidden" name="service_name" value="<?php echo trim($service['service_name']); ?>">
            <input type="hidden" name="latitude"  id="lat_input"  value="">
            <input type="hidden" name="longitude" id="lng_input"  value="">
            <input type="hidden" name="map_link"  id="map_input"  value="">

            <!-- Date -->
            <div class="form-group">
                <label><i class="fa-solid fa-calendar"></i> Booking Date</label>
                <input type="date" name="booking_date"
                       min="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label><i class="fa-solid fa-location-dot"></i> Your Address</label>
                <textarea name="address" id="address_field"
                          placeholder="Enter your full address..." required></textarea>
            </div>

            <!-- Map -->
            <div class="form-group">
                <label><i class="fa-solid fa-map"></i> Pin Your Location on Map
                    <span style="font-weight:400;color:#aaa;">(Optional)</span>
                </label>

                <button type="button" class="detect-btn" onclick="detectLocation()">
                    <i class="fa-solid fa-crosshairs"></i> Detect My Location
                </button>

                <div id="map"></div>

                <div class="map-hint">
                    <i class="fa-solid fa-info-circle"></i>
                    Click on the map or use the "Detect My Location" button
                </div>

                <div class="location-detected" id="loc-detected">
                    <i class="fa-solid fa-circle-check"></i>
                    <span id="loc-text">Location pinned!</span>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="payment-box">
                <i class="fa-solid fa-money-bill-wave"></i>
                <div>
                    <h4>Payment: Cash on Delivery</h4>
                    <p>Provider will collect payment after service completion</p>
                </div>
            </div>

            <button type="submit" name="book_now" class="submit-btn">
                <i class="fa-solid fa-check"></i> Confirm Booking
            </button>
        </form>
    </div>

</div>

<!-- Leaflet Map JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Default Pakistan center
var map = L.map('map').setView([31.5204, 74.3587], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

var marker = null;

function setMarker(lat, lng){
    if(marker) map.removeLayer(marker);
    marker = L.marker([lat, lng], {draggable: true}).addTo(map);
    map.setView([lat, lng], 15);

    document.getElementById('lat_input').value  = lat;
    document.getElementById('lng_input').value  = lng;
    document.getElementById('map_input').value  = 'https://www.google.com/maps?q='+lat+','+lng;

    document.getElementById('loc-detected').style.display = 'flex';
    document.getElementById('loc-text').textContent = 'Location pinned! (' + lat.toFixed(4) + ', ' + lng.toFixed(4) + ')';

    // Marker drag
    marker.on('dragend', function(e){
        var pos = e.target.getLatLng();
        setMarker(pos.lat, pos.lng);
    });
}

// Map click
map.on('click', function(e){
    setMarker(e.latlng.lat, e.latlng.lng);
});

// Detect location
function detectLocation(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function(pos){
            setMarker(pos.coords.latitude, pos.coords.longitude);
        }, function(error){
            let msg = 'Could not detect your location. Please click on the map to pin it manually.';
            if (error.code === error.PERMISSION_DENIED) {
                msg = 'Location access was blocked. Please allow location access in your browser settings, or click on the map to pin your location manually.';
            } else if (error.code === error.POSITION_UNAVAILABLE) {
                msg = 'Your location is currently unavailable (GPS/location services may be turned off on your device). Please click on the map to pin it manually.';
            } else if (error.code === error.TIMEOUT) {
                msg = 'Location request timed out. Please try again, or click on the map to pin it manually.';
            } else if (window.location.protocol !== 'https:') {
                msg = 'Location detection requires a secure (HTTPS) connection. Please click on the map to pin your location manually.';
            }
            alert(msg);
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    } else {
        alert('Geolocation is not supported by your browser. Please click on the map to pin your location manually.');
    }
}
</script>

</body>
</html>