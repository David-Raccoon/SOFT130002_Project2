<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$sql = 'SELECT * FROM travelimage';
$result = mysqli_query($connection, $sql);
$countryCodeCount = array();
while ($row = mysqli_fetch_assoc($result)) {
    if (array_key_exists($row['CountryCodeISO'], $countryCodeCount))
        $countryCodeCount[$row['CountryCodeISO']]++;
    else
        $countryCodeCount[$row['CountryCodeISO']] = 1;
}
arsort($countryCodeCount);
$res = array();
foreach ($countryCodeCount as $countryCode => $count) {
    $sql = 'SELECT * FROM geocountries WHERE ISO="' . $countryCode . '"';
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    array_push($res, $row['CountryName']);
}
mysqli_free_result($result);
mysqli_close($connection);
response($res);
?>