<?php header('Access-Control-Allow-Origin:*'); ?>
<?php require_once('config.php'); ?>
<?php require_once('response.php'); ?>
<?php
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}

$imageID = $_POST['imageID'];
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];

$sql = 'SELECT * FROM geocountries WHERE CountryName=' . '"' . $_POST['country'] . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取国家ISO码
$countryCodeISO = $row['ISO'];

$sql = 'SELECT * FROM geocities WHERE CountryCodeISO="' . $countryCodeISO . '" AND AsciiName="' . $_POST['city'] . '"';
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
// 获取城市ID
$cityCode = $row['GeoNameID'];

if (!array_key_exists('img', $_FILES)) {
    $sql = 'UPDATE travelimage SET 
        Title="' . $title .
        '",Description="' . $description .
        '",Content="' . $content .
        '",CountryCodeISO="' . $countryCodeISO .
        '",CityCode="' . $cityCode .
        '" WHERE ImageID = ' . $imageID;
    if (mysqli_query($connection, $sql)) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error(($connection));
    }
} else {
    // 生成图片名
    $imgName = date('Y_m_d_h_i_s_', time()) . $_POST['username'] . ".jpg";
    // 保存图片和裁剪后的图片
    $originPath = UPLOAD_PATH . "origin/" . $imgName;
    $squarePath = UPLOAD_PATH . "square/" . $imgName;
    move_uploaded_file($_FILES["img"]["tmp_name"], $originPath);
    img_cut_square($originPath, $squarePath, 150);

    // 删除原图
    $originName = $_POST['originName'];
    $originFile = UPLOAD_PATH . "origin/" . $originName;
    $squareFile = UPLOAD_PATH . "square/" . $originName;
    if (!unlink($originFile)) {
        echo ("Error deleting $originFile");
    } else if (!unlink($squareFile)) {
        echo ("Error deleting $squareFile");
    }

    $sql = 'UPDATE travelimage SET 
        Title="' . $title .
        '",Description="' . $description .
        '",Content="' . $content .
        '",CountryCodeISO="' . $countryCodeISO .
        '",CityCode="' . $cityCode .
        '",PATH="' . $imgName .
        '" WHERE ImageID = ' . $imageID;
    if (mysqli_query($connection, $sql)) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error(($connection));
    }
}

mysqli_free_result($result);
mysqli_close($connection);

// 将图片裁剪为正方形
function img_cut_square($src_path, $des_path, $des_w = 150)
{
    $img_info = getimagesize($src_path);
    $img_width = $img_info[0];
    $img_height = $img_info[1];
    $img_type = $img_info[2];
    if ($img_type != 2 && $img_type != 3) return;
    if ($img_height > $img_width) {
        $scale_width = $des_w;
        $scale_height = round($des_w / $img_width * $img_height);
        $src_y = round(($scale_height - $des_w) / 2);
        $src_x = 0;
    } else {
        $scale_height = $des_w;
        $scale_width = round($des_w / $img_height * $img_width);
        $src_y = 0;
        $src_x = round(($scale_width - $des_w) / 2);
    }
    $dst_ims = imagecreatetruecolor($scale_width, $scale_height);
    $white = imagecolorallocate($dst_ims, 255, 255, 255);
    imagefill($dst_ims, 0, 0, $white);
    if ($img_type == 2) {
        $src_im = @imagecreatefromjpeg($src_path);
    } else if ($img_type == 3) {
        $src_im = @imagecreatefrompng($src_path);
    }
    imagecopyresized($dst_ims, $src_im, 0, 0, 0, 0, $scale_width, $scale_height, $img_width, $img_height);
    $dst_im = imagecreatetruecolor($des_w, $des_w);
    imagecopy($dst_im, $dst_ims, 0, 0, $src_x, $src_y, $des_w, $des_w);
    if ($img_type == 2) {
        imagejpeg($dst_im, $des_path);
    } else if ($img_type == 3) {
        imagepng($dst_im, $des_path);
    }
    imagedestroy($dst_im);
    imagedestroy($dst_ims);
    imagedestroy($src_im);
}
?>