<?php
//Preventing access as guest
ob_start();
session_start();
if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 } 
require_once 'dbconnect.php';
$rez=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
$check=mysqli_fetch_array($rez);
if ($check["isadmin"] == 1) {
if(isset($_POST['del_id'])) {
$sql = $conn->query('SELECT * FROM chat');
mysqli_fetch_array($sql);
$del_id = (filter_var($_POST['del_id'], FILTER_SANITIZE_NUMBER_FLOAT,
FILTER_FLAG_ALLOW_FRACTION));
$whom = $conn->query("SELECT * from chat WHERE Id='".$del_id."'");
$whos=mysqli_fetch_array($whom);
if (mysqli_num_rows($whom)>0) {
$query = $conn->query("DELETE from chat WHERE Id='".$del_id."'");
}
if($query) {
echo "YES";
} elseif (empty($query)) {
echo "NO";
}
}
}