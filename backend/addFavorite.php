<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
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

$sql = "select max(FavorID) from travelimagefavor";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取新的收藏ID
$favorID = $row['max(FavorID)'] + 1;


$sql = 'SELECT * FROM travelimagefavor WHERE UID=' . $uid . ' and ImageID=' . $_GET['imageID'];
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 查看收藏是否已经存在
if ($row != null) {
    echo "This photo has already been in your favorite!";
} else {
    $sql = 'INSERT INTO travelimagefavor (FavorID,UID,ImageID) VALUES (' . $favorID . ',' . $uid . ',' . $_GET['imageID'] . ')';
    if (mysqli_query($connection, $sql)) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error(($connection));
    }

}

mysqli_free_result($result);
mysqli_close($connection);
?>