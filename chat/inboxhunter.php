<?php
//Preventing reading messages as guest
ob_start();
session_start();
if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 } 
//Samo AJAX moze da poziva fajl
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
{
require_once 'dbconnect.php';
//global query for unread messages 
$countme=$conn->query("SELECT * FROM pm WHERE id2=".$_SESSION['user']." AND user2read = 'no'");
$inbox = mysqli_num_rows($countme);
if($inbox >=1){
echo "<span class='badge' style='background-color:#F44336!important;color:#fff;'>".$inbox."</span>";
}
else {
echo "<span class='badge' style='background-color:#fff!important;color:#000;'>".$inbox."</span>";
}

} else {
header("Location: home.php");
  exit;
}
