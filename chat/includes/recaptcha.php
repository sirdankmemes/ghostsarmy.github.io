<?php
$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='rec_enabled'");
$row = mysqli_fetch_assoc($sql); 
if ($row['option_value']=='1'){
	$rec_show = '1';
} elseif ($row['option_value']=='0') {
	$rec_show = '0';
} else {
	$rec_show = '0';
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='rec_site_key'");
$row = mysqli_fetch_assoc($sql); 
if (!empty($row['option_value'])){
	$rec_site_key = $row['option_value'];
} else {
	$rec_site_key = '';
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='rec_secret_key'");
$row = mysqli_fetch_assoc($sql); 
if (!empty($row['option_value'])){
	$rec_secret_key = $row['option_value'];
} else {
	$rec_secret_key = '';
}
?>