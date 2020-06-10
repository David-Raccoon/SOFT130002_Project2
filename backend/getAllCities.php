<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = "select * from `geocountries` where CountryName=\"" . $_GET['country'] . "\"";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$sql = "select distinct AsciiName from `geocities` where CountryCodeISO=\"" . $row['ISO'] . "\" order by AsciiName";
$result = mysqli_query($connection, $sql);
$res = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($res, $row['AsciiName']);
}
mysqli_free_result($result);
mysqli_close($connection);
response($res);
?>