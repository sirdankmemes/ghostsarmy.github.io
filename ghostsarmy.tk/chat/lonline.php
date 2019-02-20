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
#User last active
$t = time();
$query = "UPDATE users set lActive = '$t' WHERE userId=".$_SESSION['user'];
$res = $conn->query($query);

#Determining who is online
$t2=time()-300;
$sql2 = $conn->query("Select * FROM users WHERE lActive > '$t2'");
while($nesto = mysqli_fetch_array($sql2))
{

$online[] = $nesto;

} 

if (is_array($online) || is_object($nesto)) {
foreach($online as $nesto){ 
echo "<a href='profile.php?id=".$nesto['userId']."' class='label label-info'>".$nesto['userName']."</a> ";
} 
}
} else {
header("Location: home.php");
  exit;
}