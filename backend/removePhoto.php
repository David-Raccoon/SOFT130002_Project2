<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = 'select * from travelimage where PATH="' . $_GET['src'] . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$sql = 'DELETE FROM `travelimagefavor` WHERE ImageID=' . $row['ImageID'];
mysqli_query($connection, $sql);

$sql = 'DELETE FROM travelimage WHERE PATH="' . $_GET['src'] . '"';
if (mysqli_query($connection, $sql)) {
    $originFile = UPLOAD_PATH . "origin/" . $_GET['src'];
    $squareFile = UPLOAD_PATH . "square/" . $_GET['src'];
    if (!unlink($originFile)) {
        echo ("Error deleting $originFile");
    } else if (!unlink($squareFile)) {
        echo ("Error deleting $squareFile");
    } else
        echo 'success';
} else {
    echo 'error: ' . mysqli_error(($connection));
}

mysqli_free_result($result);
mysqli_close($connection);
?>