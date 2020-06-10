<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
	die(mysqli_connect_error());
}
$sql = "select * from traveluser where UserName=" . "\"" . $_POST['username'] . "\"";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
if ($row == null)
	echo "user does not exist";
else if ($row['Pass'] == $_POST['password'])
	echo "success";
else
	echo "wrong password";
mysqli_free_result($result);
mysqli_close($connection);
?>