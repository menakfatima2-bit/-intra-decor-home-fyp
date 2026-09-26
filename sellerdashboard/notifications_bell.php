<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php
$seller_id_notif = intval($_SESSION['user_id']);

$unread_count = 0;
$count_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM notifications WHERE seller_id=$seller_id_notif AND is_read=0");
if($count_res){
    $count_row = mysqli_fetch_assoc($count_res);
    $unread_count = $count_row['cnt'];
}

$recent_notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE seller_id=$seller_id_notif ORDER BY created_at DESC LIMIT 5");
?>

<div class="notif-bell-wrapper">
    <button class="notif-bell-btn" onclick="toggleNotifDropdown()">
        <i class="fa fa-bell"></i>
        <?php if($unread_count > 0){ ?>
            <span class="notif-badge"><?php echo $unread_count; ?></span>
        <?php } ?>
    </button>

    <div class="notif-dropdown" id="notifDropdown">
        <div class="notif-dropdown-header">Notifications</div>

        <?php if(mysqli_num_rows($recent_notifications) == 0){ ?>
            <div class="notif-empty">No notifications</div>
        <?php } else { ?>
            <?php while($n = mysqli_fetch_assoc($recent_notifications)){ ?>
                <a href="productlist.php"
                   class="notif-item <?php echo $n['is_read'] == 0 ? 'unread' : ''; ?>"
                   onclick="markNotifRead(<?php echo $n['id']; ?>)">
                    <div class="notif-msg"><?php echo htmlspecialchars($n['message']); ?></div>
                    <div class="notif-time"><?php echo date("d M, h:i A", strtotime($n['created_at'])); ?></div>
                </a>
            <?php } ?>
        <?php } ?>

        <a href="notifications.php" class="notif-view-all">View All</a>
    </div>
</div>

<style>
.notif-bell-wrapper{
    position: fixed;
    top: 18px;
    right: 28px;
    z-index: 9999;
}
.notif-bell-btn{
    background:#fff;
    border:1px solid #e5e5e5;
    width:42px;
    height:42px;
    border-radius:50%;
    font-size:18px;
    cursor:pointer;
    position:relative;
    color:#444;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
    display:flex;
    align-items:center;
    justify-content:center;
    transition: box-shadow 0.15s ease;
}
.notif-bell-btn:hover{
    box-shadow:0 4px 10px rgba(0,0,0,0.14);
}
.notif-badge{
    position:absolute;
    top:-4px;
    right:-4px;
    background:#e74c3c;
    color:#fff;
    font-size:11px;
    font-weight:600;
    min-width:18px;
    height:18px;
    line-height:18px;
    text-align:center;
    padding:0 4px;
    border-radius:50%;
    border:2px solid #fff;
}
.notif-dropdown{
    display:none;
    position:absolute;
    right:0;
    top:52px;
    width:320px;
    background:#fff;
    border:1px solid #eaeaea;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    overflow:hidden;
}
.notif-dropdown.show{ display:block; }
.notif-dropdown-header{
    padding:14px 16px;
    font-weight:600;
    font-size:15px;
    border-bottom:1px solid #f0f0f0;
    background:#fafafa;
}
.notif-empty{
    padding:24px 16px;
    text-align:center;
    color:#999;
    font-size:13px;
}
.notif-item{
    display:block;
    padding:12px 16px;
    border-bottom:1px solid #f5f5f5;
    text-decoration:none;
    color:#333;
    transition: background 0.15s ease;
}
.notif-item:last-of-type{ border-bottom:none; }
.notif-item:hover{ background:#f9f9f9; }
.notif-item.unread{ background:#eef6ff; }
.notif-item.unread:hover{ background:#e4f0ff; }
.notif-msg{ font-size:13.5px; line-height:1.4; color:#222; }
.notif-time{ font-size:11.5px; color:#999; margin-top:4px; }
.notif-view-all{
    display:block;
    text-align:center;
    padding:10px;
    font-size:13px;
    font-weight:500;
    color:#3b82f6;
    text-decoration:none;
    background:#fafafa;
    border-top:1px solid #f0f0f0;
}
.notif-view-all:hover{ background:#f0f0f0; }

@media (max-width: 480px){
    .notif-dropdown{ width: 260px; right: -10px; }
}
</style>

<script>
function toggleNotifDropdown(){
    document.getElementById('notifDropdown').classList.toggle('show');
}
document.addEventListener('click', function(e){
    var wrapper = document.querySelector('.notif-bell-wrapper');
    if(wrapper && !wrapper.contains(e.target)){
        document.getElementById('notifDropdown').classList.remove('show');
    }
});
function markNotifRead(id){
    fetch('mark_notification_read.php?id=' + id);
}
</script>

