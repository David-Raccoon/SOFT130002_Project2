<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

const NUM = 9;
$res = array();

if ($_GET['random'] == 'false') {
    $image = array();
    $sql = "select * from travelimagefavor";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if (array_key_exists($row['ImageID'], $image)) {
            $image[$row['ImageID']]++;
        } else $image[$row['ImageID']] = 1;
    }
    arsort($image);
    foreach ($image as $imageID => $occurTimes) {
        $sql = "select * from travelimage where ImageID=" . $imageID;
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        array_push($res, $row['PATH'] . ":" . $row['Title'] . ":" . $row['Description']);
    }
    // 图片按热度选择不够时随机填充
    while (sizeof($res) < NUM) {
        $sql = 'select * from travelimage order by rand() limit 1';
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if (array_key_exists($row['ImageID'], $image))
            continue;
        else
            array_push($res, $row['PATH'] . ":" . $row['Title'] . ":" . $row['Description']);
    }
} else {
    $sql = 'select * from travelimage order by rand() limit ' . NUM;
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($res, $row['PATH'] . ":" . $row['Title'] . ":" . $row['Description']);
    }
}
mysqli_free_result($result);
mysqli_close($connection);
response($res);
?>