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

$sql = "select * from travelimagefavor where UID=" . "\"" . $uid . "\"";
$result = mysqli_query($connection, $sql);
$res = array();
while ($row = mysqli_fetch_assoc($result)) {
    $imageID = $row['ImageID'];
    $sql = "select * from travelimage where ImageID=" . "\"" . $imageID . "\"";
    $result_image = mysqli_query($connection, $sql);
    $row_image = mysqli_fetch_assoc($result_image);
    array_push($res, $row_image['PATH'] . ":" . $row_image['Title'] . ":" . $row_image['Description']);
}

mysqli_free_result($result);
mysqli_close($connection);
response($res);
?>