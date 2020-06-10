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

$sql = "delete from travelimage where PATH=" . "\"" . $_GET['src'] . "\"";
if (mysqli_query($connection, $sql)) {
    $originFile = "C:\\xampp\\htdocs\\SOFT130002_Project2\\travel-images\\origin\\" . $_GET['src'];
    $squareFile = "C:\\xampp\\htdocs\\SOFT130002_Project2\\travel-images\\square\\" . $_GET['src'];
    if (!unlink($originFile)) {
        echo ("Error deleting $originFile");
    } else if (!unlink($squareFile)) {
        echo ("Error deleting $squareFile");
    } else
        echo 'success';
} else {
    echo 'error: ' . mysqli_error(($connection));
}

?>