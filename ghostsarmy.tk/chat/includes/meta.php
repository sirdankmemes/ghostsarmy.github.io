<?php
$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='metadesc'");
if($row = mysqli_fetch_assoc($sql)) {
echo "<meta name='description' content='".$row['option_value']."'>\n";
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='metakey'");
if($row = mysqli_fetch_assoc($sql)) {
echo "<meta name='keywords' content='".$row['option_value']."'>\n";
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='metaauthor'");
if($row = mysqli_fetch_assoc($sql)) {
echo "<meta name='author' content='".$row['option_value']."'>\n";
}
?>