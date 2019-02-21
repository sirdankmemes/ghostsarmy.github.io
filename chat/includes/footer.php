<?php

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='site_title'");

if($row = mysqli_fetch_assoc($sql)) {
$copyright = $row['option_value'];
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='ownfooter'");
$row = mysqli_fetch_assoc($sql); 
if ($row['option_value']=='1'){
?>
<footer class="footer">
      <div class="container">
        <p class="text-white">Copyright © <?php echo date("Y"); ?> <b><?php echo $copyright; ?></b></p>
      </div>
</footer>
<?php
} else {


?>
<footer class="footer">
      <div class="container">
        <p class="text-white">Copyright © <?php echo date("Y"); ?> <b>Leo Chat 1.5</b> by LeoCoding</p>
      </div>
</footer>
<?php
}
?>
