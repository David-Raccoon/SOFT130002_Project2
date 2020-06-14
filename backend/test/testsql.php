<?php require_once('../config.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}
$sql = 'SELECT * FROM traveluser';
if ($result = mysqli_query($connection, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['UserName'] . "\n";
    }
} else
    print_r(mysqli_error($connection));

mysqli_free_result($result);
mysqli_close($connection);
?>