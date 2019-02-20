<?php
if($_FILES['photo']['name'])
{
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if($check !== false) {
        $response .= $messages['verimgok'] . $check["mime"] . ".<br />";
        $uploadOk = 1;
    } else {
        $response .= $messages['verimgerr'] ."<br />";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $response .= $messages['filexist']." ";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["photo"]["size"] > 500000) {
    $response .= $messages['filbig']." ";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $response .= $messages['filexterr']." ";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $response .= $messages['filuplerr'];
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $response .= $messages['filuplok']. basename( $_FILES["photo"]["name"]). $messages['filuplok2'];
    } else {
        $response .= $messages['filuplerr2'];
    }
}
}
?>