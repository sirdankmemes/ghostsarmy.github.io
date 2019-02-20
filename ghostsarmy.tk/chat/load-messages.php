<?php
ob_start();
session_start();
//Preventing access to guests and non-ajax clients

if( !isset($_SESSION['user']) || !isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' ) ) {
	header("Location: index.php");
	exit;
 } 

require_once 'dbconnect.php';
	
// database queries
if (isset($_GET['newest'])) {
	$newest = (filter_var($_GET['newest'], FILTER_SANITIZE_NUMBER_FLOAT));
	$newest = str_replace(array('+','-'), '', $newest);
	
if ($newest==0) {
	$sql = $conn->query('(SELECT * FROM chat ORDER BY Id desc LIMIT 0,15) ORDER BY Id');
} else {
	$sql = $conn->query('(SELECT * FROM chat WHERE Id > '.$newest.' ORDER BY Id desc LIMIT 0,8) ORDER BY Id');
}
} elseif (isset($_GET['first'])) {
	$first = (filter_var($_GET['first'], FILTER_SANITIZE_NUMBER_FLOAT));
	$first = str_replace(array('+','-'), '', $first);
	
	$sql = $conn->query('(SELECT * FROM chat WHERE Id < '.$first.' ORDER BY Id desc LIMIT 0,8) ORDER BY Id');
} else {
	exit();
}

# show database results
while($row = mysqli_fetch_array($sql))
{
$rows[] = $row;
}

if( mysqli_num_rows($sql) >= 1 ) {
	
//
//Check if is admin, if yes CAN delete message
$rez=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
$check=mysqli_fetch_array($rez);
header('Content-Type: application/json');
if (is_array($rows) || is_object($row)) {
	$result = array();
foreach($rows as $row){ 
	$poruka = xss($row['message']);
	$poruka = smilies($poruka);
if(isImage($poruka)) {
	$poruka = "<a href='#' class='pop'><img class='pop-inner' src='".$poruka."'></img></a>";
} elseif(isYoutube($poruka)) {
	$poruka = convertYoutube($poruka);
} else {
	$poruka = linkify($poruka);
}
$poruka = showBBcodes($poruka);
$vreme = date('H:i:s', $row['time']);

if ($check["isadmin"] == 1) {
	$isadmin ="1";

} else {
	$isadmin ="0";	
}

$arr = array("msg_id"=>$row['Id'], "user_id"=>$row['senderId'], "time"=>$vreme, "name"=>$row['name'], "message"=>$poruka, "candel"=>$isadmin, "requestername"=>$check["userName"]);
array_push($result,$arr);
}
echo json_encode($result, JSON_PRETTY_PRINT);
} else {
echo "[]";
}

} elseif (isset($_GET['newest']) && $newest==0 && empty($row['name'])) {
	$time = time();
	$conn->query("INSERT INTO chat SET Id='NULL', name='INFO', senderId='0', message='No messages to show', time='$time', ip='127.0.0.1'");
}

ob_end_flush();
?>