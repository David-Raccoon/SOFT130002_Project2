<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = 'SELECT * FROM traveluser WHERE UserName=' . '"' . $_GET['username'] . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取用户ID
$uid = $row['UID'];

$sql = 'SELECT * FROM travelimage WHERE PATH="' . $_GET['src'] . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取图片ID
$imageID = $row['ImageID'];

$sql = 'DELETE FROM travelimagefavor WHERE UID=' . $uid . ' AND ImageID=' . $imageID;
if (mysqli_query($connection, $sql)) {
    echo 'success';
} else {
    echo 'error: ' . mysqli_error(($connection));
}

mysqli_free_result($result);
mysqli_close($connection);
?>