<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$content = '';
$countryCodeISO = '';
$cityCode = '';

if ($_GET['content'] != "") {
    $content = $_GET['content'];
}

if ($_GET['country'] != "") {
    $sql = "select * from `geocountries` where CountryName=\"" . $_GET['country'] . "\"";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $countryCodeISO = $row['ISO'];
}

if ($_GET['city'] != "") {
    $sql = "select * from `geocities` where AsciiName=\"" . $_GET['city'] . "\"" . " and CountryCodeISO=\"" . $countryCodeISO . "\"";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $cityCode = $row['GeoNameID'];
}

$sql = "select * from `travelimage` where ";
if ($content == '')
    $sql = $sql . "Content like \"%\" ";
else
    $sql = $sql . "Content=\"" . $content . "\" ";

if ($countryCodeISO == '')
    $sql = $sql . "and CountryCodeISO like \"%\" ";
else
    $sql = $sql . "and CountryCodeISO=\"" . $countryCodeISO . "\" ";

if ($cityCode == '')
// 有一些CityCode是NULL会被过滤掉
    $sql = $sql;
else
    $sql = $sql . "and CityCode=\"" . $cityCode . "\" ";

$result = mysqli_query($connection, $sql);
$res = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($res, $row['PATH']);
}
mysqli_free_result($result);
mysqli_close($connection);
response($res);
?>