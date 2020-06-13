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
if ($row == null)
    echo "true";
else
    echo "username already exists";

mysqli_free_result($result);
mysqli_close($connection);
?>