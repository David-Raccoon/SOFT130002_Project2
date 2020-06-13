<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$res = array();
$sql = 'SELECT * FROM geocountries WHERE CountryName="' . $_GET['country'] . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

$sql = 'SELECT * FROM travelimage WHERE CountryCodeISO="' . $row['ISO'] . '"';

$result = mysqli_query($connection, $sql);
$cityCodeCount = array();
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['CityCode'] == null)
        continue;
    if (array_key_exists($row['CityCode'], $cityCodeCount))
        $cityCodeCount[$row['CityCode']]++;
    else
        $cityCodeCount[$row['CityCode']] = 1;
}
arsort($cityCodeCount);
$res = array();
foreach ($cityCodeCount as $cityCode => $count) {
    $sql = 'SELECT * FROM geocities WHERE GeoNameID="' . $cityCode . '"';
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    array_push($res, $row['AsciiName']);
}
mysqli_free_result($result);
mysqli_close($connection);
response($res);
?>