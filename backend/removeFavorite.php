<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = "select * from traveluser where UserName=" . "\"" . $_GET['username'] . "\"";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取用户ID
$uid = $row['UID'];

$sql = "select * from travelimage where PATH=" . "\"" . $_GET['src'] . "\"";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取用户ID
$imageID = $row['ImageID'];

$sql = "delete from travelimagefavor where UID=" . $uid . " and ImageID=" . $imageID;
if (mysqli_query($connection, $sql)) {
    echo 'success';
} else {
    echo 'error: ' . mysqli_error(($connection));
}
?>