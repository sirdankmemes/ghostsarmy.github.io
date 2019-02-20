<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }

 // select loggedin users detail
 $res=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysqli_fetch_array($res);
 
 //if not admin redirect to home
 if ($userRow["isadmin"] != 1 || $userRow["userId"] != 1) {
  header("Location: home.php");
  exit;	 
 }
	 
//On form submit
if(isset($_POST['submit'])){

	if(!empty($_POST['metadesc'])) { 
	$metadesc = mysqli_real_escape_string($conn, $_POST['metadesc']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='metadesc'");
	if($row = mysqli_fetch_assoc($sql)) {
	$sql = $conn->query("UPDATE settings SET option_value='$metadesc' WHERE option_name='metadesc'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='metadesc', option_value='$metadesc'");
	}
	
	} else { 
	$metadesc = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['metakey'])) {		
	$metakey = mysqli_real_escape_string($conn, $_POST['metakey']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='metakey'");
	if($row = mysqli_fetch_assoc($sql)) {
	$sql = $conn->query("UPDATE settings SET option_value='$metakey' WHERE option_name='metakey'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='metakey', option_value='$metakey'");	
	}
	
	} else { 
	$metakey = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['metaauthor'])) { 
	$metaauthor = mysqli_real_escape_string($conn, $_POST['metaauthor']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='metaauthor'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$metaauthor' WHERE option_name='metaauthor'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='metaauthor', option_value='$metaauthor'");
	}
	
	} else { 
	$metaauthor = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['site_title'])) { 
	$site_title = mysqli_real_escape_string($conn, $_POST['site_title']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='site_title'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$site_title' WHERE option_name='site_title'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='site_title', option_value='$site_title'");
	}
	
	} else { 
	$site_title = NULL; 
	}
	$count += $conn->affected_rows;
	
	if($_POST['ownfooter'] == '1' || $_POST['ownfooter'] == '0') { 
	$ownfooter = mysqli_real_escape_string($conn, $_POST['ownfooter']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='ownfooter'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$ownfooter' WHERE option_name='ownfooter'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='ownfooter', option_value='$ownfooter'");
	}
	
	} else { 
	$ownfooter = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if($_POST['rec_enabled'] == '1' || $_POST['rec_enabled'] == '0') { 
	$rec_enabled = mysqli_real_escape_string($conn, $_POST['rec_enabled']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='rec_enabled'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$rec_enabled' WHERE option_name='rec_enabled'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='rec_enabled', option_value='$rec_enabled'");
	}
	
	} else { 
	$rec_enabled = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['rec_site_key'])) { 
	$rec_site_key = mysqli_real_escape_string($conn, $_POST['rec_site_key']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='rec_site_key'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$rec_site_key' WHERE option_name='rec_site_key'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='rec_site_key', option_value='$rec_site_key'");
	}
	
	} else { 
	$rec_site_key = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['rec_secret_key'])) { 
	$rec_secret_key = mysqli_real_escape_string($conn, $_POST['rec_secret_key']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='rec_secret_key'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$rec_secret_key' WHERE option_name='rec_secret_key'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='rec_secret_key', option_value='$rec_secret_key'");
	}
	
	} else { 
	$rec_secret_key = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['time_zone'])) { 
	$time_zone = mysqli_real_escape_string($conn, $_POST['time_zone']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='time_zone'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$time_zone' WHERE option_name='time_zone'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='time_zone', option_value='$time_zone'");
	}
	
	} else { 
	$time_zone = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if($_POST['fb_login_enabled'] == '1' || $_POST['fb_login_enabled'] == '0') { 
	$fb_login_enabled = mysqli_real_escape_string($conn, $_POST['fb_login_enabled']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='fb_login_enabled'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$fb_login_enabled' WHERE option_name='fb_login_enabled'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='fb_login_enabled', option_value='$fb_login_enabled'");
	}
	
	} else { 
	$fb_login_enabled = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['fb_login_appid'])) { 
	$fb_login_appid = mysqli_real_escape_string($conn, $_POST['fb_login_appid']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='fb_login_appid'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$fb_login_appid' WHERE option_name='fb_login_appid'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='fb_login_appid', option_value='$fb_login_appid'");
	}
	
	} else { 
	$fb_login_appid = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['fb_login_appsecret'])) { 
	$fb_login_appsecret = mysqli_real_escape_string($conn, $_POST['fb_login_appsecret']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='fb_login_appsecret'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$fb_login_appsecret' WHERE option_name='fb_login_appsecret'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='fb_login_appsecret', option_value='$fb_login_appsecret'");
	}
	
	} else { 
	$fb_login_appsecret = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['fb_login_callback'])) { 
	$fb_login_callback = mysqli_real_escape_string($conn, $_POST['fb_login_callback']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='fb_login_callback'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$fb_login_callback' WHERE option_name='fb_login_callback'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='fb_login_callback', option_value='$fb_login_callback'");
	}
	
	} else { 
	$fb_login_callback = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if ($count>0) {
		$errTyp="success";
		$errMSG = $messages['adminsuccess'];
	}
	
	if($count==0) {
	$errTyp="danger";
	$errMSG = $messages['adminerror'];
	}

}

//If checkbox for copyright checked show that

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='ownfooter'");
$row = mysqli_fetch_assoc($sql); 
if ($row['option_value']=='1'){
	$checked = "checked='checked'";
}

//If checkbox for reCAPTCHA checked show that

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='rec_enabled'");
$row = mysqli_fetch_assoc($sql); 
if ($row['option_value']=='1'){
	$checked_rec = "checked='checked'";
}

//If checkbox for Facebook login checked show that

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='fb_login_enabled'");
$row = mysqli_fetch_assoc($sql); 
if ($row['option_value']=='1'){
	$checked_fb = "checked='checked'";
}

//Get protocol
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['adminpanel']; ?> - <?php echo $userRow['userEmail']; ?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
<link rel="stylesheet" href="assets/css/loader.css" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
</head>
<body>

<?php
require('nav.php');
?>

 <div id="wrapper">

 <div class="container"><br />
    
     <div class="page-header">
     <h3 class="inlineblock"><?php echo $messages['adminpanel']; ?></h3>
	 <span class="glyphicon glyphicon-cog admin"></span>
     </div>
        <div class="row">
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

<div class='well'>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	<label>
	<h4><?php echo "Time Zone"; ?></h4>
<?php
include('includes/timezone.php');
$zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

echo "<select name='time_zone'>\n";
foreach($zones as $zone) {
if($set_time_zone===$zone) {
$sel = " selected='selected'";
} else {
	$sel = '';
}
echo "<option value='".$zone."'".$sel.">".$zone."</option>\n";

}
echo "</select>\n";
?>
    </label>
	<hr>
	<label>
	<h4><?php echo $messages['site_title']; ?></h4>
    <textarea name="site_title" placeholder="" class="form-control" type="text" id="site_title"><?php optionvalue("site_title"); ?></textarea>
    </label><br />
	<input type="hidden" name="ownfooter" value="0" />
	<input type="checkbox" <?php if(isset($checked)) { echo $checked; } ?>name="ownfooter" value="1"> <?php echo $messages['remove_copyright']; ?><br>
	<hr>
	<label>
	<h4><?php echo $messages['meta_description']; ?></h4>
    <textarea name="metadesc" placeholder="" class="form-control" type="text" id="metadesc"><?php optionvalue("metadesc"); ?></textarea>
    </label><br />
	<label>
	<h4><?php echo $messages['meta_keywords']; ?></h4>
    <textarea name="metakey" placeholder="" class="form-control" type="text" id="metakey"><?php optionvalue("metakey"); ?></textarea>
    </label><br />
	<label>
	<h4><?php echo $messages['meta_author']; ?></h4>
    <textarea name="metaauthor" placeholder="" class="form-control" type="text" id="metaauthor"><?php optionvalue("metaauthor"); ?></textarea>
    </label><br />
	<hr>
	<img src="assets/images/fb_login.png" /><?php echo $messages['facebooklogin']; ?><br />
	<input type="hidden" name="fb_login_enabled" value="0" />
	<input type="checkbox" <?php if(isset($checked_fb)) { echo $checked_fb; } ?>name="fb_login_enabled" value="1"> <?php echo $messages['rec_enable']; ?><br>
	<label>
	<h4><?php echo $messages['appid']; ?></h4>
    <input type="text" name="fb_login_appid" value="<?php optionvalue("fb_login_appid"); ?>" placeholder="">
    </label><br />
	<label>
	<h4><?php echo $messages['appsecret']; ?></h4>
    <input type="text" name="fb_login_appsecret" value="<?php optionvalue("fb_login_appsecret"); ?>" placeholder="">
    </label><br />
	<label>
	<h4><?php echo $messages['callbackurl']; ?></h4>
    <input type="text" name="fb_login_callback" value="<?php optionvalue("fb_login_callback"); ?>" placeholder="">
    </label><br />
	<?php echo "<i>".$messages['probably'] .": ".$protocol.$_SERVER['HTTP_HOST']."/</i>"; ?>
	<hr>
	<img src="https://www.gstatic.com/recaptcha/admin/logo_recaptcha_color_24dp.png" />reCAPTCHA<br />
	<input type="hidden" name="rec_enabled" value="0" />
	<input type="checkbox" <?php if(isset($checked_rec)) { echo $checked_rec; } ?>name="rec_enabled" value="1"> <?php echo $messages['rec_enable']; ?><br>
	<label>
	<h4><?php echo $messages['sitekey']; ?></h4>
    <input type="text" name="rec_site_key" value="<?php optionvalue("rec_site_key"); ?>" placeholder="">
    </label><br />
	<label>
	<h4><?php echo $messages['secretkey']; ?></h4>
    <input type="text" name="rec_secret_key" value="<?php optionvalue("rec_secret_key"); ?>" placeholder="">
    </label><hr>
	<div class="alert alert-info" role="alert"><?php echo $messages['rec_how']; ?></div><hr>
	<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $messages['submit']; ?>" />
</form>
</div>
        </div>
		
		<a class="btn btn-default" href="smtp-config.php"><?php echo $messages['smtp_configuration']; ?></a>
    
    </div>
    
    </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="assets/js/chat.js"></script>
<br />
<?php require('includes/footer.php'); ?>     
</body>
</html>
<?php ob_end_flush(); ?>