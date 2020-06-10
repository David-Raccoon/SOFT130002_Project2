<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$res = array();
$sql = "select * from `travelimage` where Title like \"%" . $_GET['keyword'] . "%\"";
$result = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    array_push($res, $row['PATH'] . ":" . $row['Title'] . ":" . $row['Description']);
}
mysqli_free_result($result);
mysqli_close($connection);
response($res);
?>