<?php
$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='time_zone'");
$row = mysqli_fetch_assoc($sql); 
if (!empty($row['option_value'])){
	$set_time_zone = $row['option_value'];
} else {
	$set_time_zone = '';
}
?>