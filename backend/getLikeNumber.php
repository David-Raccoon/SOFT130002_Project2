<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$count = 0;
$sql = 'SELECT * FROM travelimagefavor WHERE ImageID=' . $_GET['imageID'];
$result = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $count++;
}
echo $count;
mysqli_free_result($result);
mysqli_close($connection);
?>