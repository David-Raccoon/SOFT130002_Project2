<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = 'SELECT * FROM travelimage WHERE PATH=' . '"' . $_GET['src'] . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$title = $row['Title'];
$description = $row['Description'];
$content = $row['Content'];
$countryCodeISO = $row['CountryCodeISO'];
$cityCode = $row['CityCode'];
$imageID = $row['ImageID'];
$uid = $row['UID'];

$sql = 'SELECT * FROM geocountries WHERE ISO="' . $countryCodeISO . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取国家名字
$country = $row['CountryName'];

$sql = 'SELECT * FROM geocities WHERE GeoNameID=' . $cityCode;
$result = mysqli_query($connection, $sql);
// 获取城市名字
if ($result != null) {
    $row = mysqli_fetch_assoc($result);
    $city = $row['AsciiName'];
} else
    $city = '';

$sql = 'SELECT * FROM traveluser WHERE UID=' . $uid;
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取作者名字
$userName = $row['UserName'];

echo $title . ":" . $description . ":" . $content . ":" . $country . ":" . $city . ":" . $imageID . ":" . $userName;
mysqli_free_result($result);
mysqli_close($connection);
?>