<?php
 session_start();
 if (!isset($_SESSION['user'])) {
  header("Location: index.php");
 } else if(isset($_SESSION['user'])!="") {
  header("Location: home.php");
 }
 
 if (isset($_GET['logout'])) {
//Make a MYSQL connection_aborted

$configs = include('config.php'); 
$conn = new mysqli($configs->host, $configs->username, $configs->pass, $configs->database); 
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} 	 
	 
// Load language

if (isset($_COOKIE['lang'])) {
    if ($_COOKIE['lang'] == 'srb') {
        require('lang/srb.php');
    }
    elseif($_COOKIE['lang'] == 'eng') {
        require('lang/en.php');
    }
}
elseif(isset($_SESSION['user'])) {
    //check which one is selected, if selected
    $sql = $conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
    $get = mysqli_fetch_array($sql);
    if ($get['lang'] == "srb") {
        setcookie("lang", "srb", time() + (10 * 365 * 24 * 60 * 60));
        require('lang/srb.php');
    }
    elseif($get['lang'] == "eng") {
        setcookie("lang", "eng", time() + (10 * 365 * 24 * 60 * 60));
        require('lang/en.php');
    } else {
		require('lang/en.php');
	}
} else {
	require('lang/en.php');
}	 
	 
//Notify others user has logged out	 

  $res=$conn->query("SELECT userName FROM users WHERE userId='".$_SESSION['user']."'");
  $row=mysqli_fetch_array($res); 	 
  $time = time();
  $conn->query("INSERT INTO chat SET Id='NULL', name='INFO', senderId='0', message='[i][b]".$row['userName']."[/b] ".$messages['loggedout']."[/i]', time='$time', ip='127.0.0.1'");

// Remove access token from session
  unset($_SESSION['facebook_access_token']);

// Remove user data from session
  unset($_SESSION['userData']);  
  unset($_SESSION['user']);
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit;
 }