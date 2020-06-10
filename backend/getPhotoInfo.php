<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = "select * from travelimage where PATH=" . "\"" . $_GET['src'] . "\"";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$title = $row['Title'];
$description = $row['Description'];
$content = $row['Content'];
$countryCodeISO = $row['CountryCodeISO'];
$cityCode = $row['CityCode'];
$imageID = $row['ImageID'];

$sql = 'SELECT * FROM `geocountries` WHERE ISO="' . $countryCodeISO . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取国家名字
$country = $row['CountryName'];

$sql = 'SELECT * FROM `geocities` WHERE GeoNameID=' . $cityCode;
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取国家名字
$city = $row['AsciiName'];

echo $title . ":" . $description . ":" . $content . ":" . $country . ":" . $city . ":" . $imageID;
mysqli_free_result($result);
mysqli_close($connection);
?>