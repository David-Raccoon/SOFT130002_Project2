<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = 'SELECT max(UID) FROM traveluser';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取新的用户ID
$uid = $row['max(UID)'] + 1;

// 检查工作在前端完成

$sql = 'INSERT INTO traveluser (UID,Email,UserName,Pass) 
VALUES (' . $uid . ',"' . $_POST['email'] . '","' . $_POST['username'] . '","' . $_POST['password'] . '")';

if (mysqli_query($connection, $sql)) {
    echo 'success';
} else {
    echo 'error: ' . mysqli_error(($connection));
}

mysqli_free_result($result);
mysqli_close($connection);
?>