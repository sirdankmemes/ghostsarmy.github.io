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

	if(!empty($_POST['smtp_host'])) { 
	$smtp_host = mysqli_real_escape_string($conn, $_POST['smtp_host']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='smtp_host'");
	if($row = mysqli_fetch_assoc($sql)) {
	$sql = $conn->query("UPDATE settings SET option_value='$smtp_host' WHERE option_name='smtp_host'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='smtp_host', option_value='$smtp_host'");
	}
	
	} else { 
	$smtp_host = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['smtp_port'])) {		
	$smtp_port = mysqli_real_escape_string($conn, $_POST['smtp_port']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='smtp_port'");
	if($row = mysqli_fetch_assoc($sql)) {
	$sql = $conn->query("UPDATE settings SET option_value='$smtp_port' WHERE option_name='smtp_port'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='smtp_port', option_value='$smtp_port'");	
	}
	
	} else { 
	$smtp_port = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['smtp_username'])) { 
	$smtp_username = mysqli_real_escape_string($conn, $_POST['smtp_username']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='smtp_username'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$smtp_username' WHERE option_name='smtp_username'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='smtp_username', option_value='$smtp_username'");
	}
	
	} else { 
	$smtp_username = NULL; 
	}
	
	$count += $conn->affected_rows;
	
	if(!empty($_POST['smtp_password'])) { 
	$smtp_password = mysqli_real_escape_string($conn, $_POST['smtp_password']); 
	
	$sql = $conn->query("SELECT * FROM settings WHERE option_name='smtp_password'");
	if($row = mysqli_fetch_assoc($sql)) { 
	$sql = $conn->query("UPDATE settings SET option_value='$smtp_password' WHERE option_name='smtp_password'");
	} else {
	$sql = $conn->query("INSERT INTO settings SET option_name='smtp_password', option_value='$smtp_password'");
	}
	
	} else { 
	$site_title = NULL; 
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


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['smtp_configuration']; ?> - <?php echo $userRow['userEmail']; ?></title>
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
     <h3 class="inlineblock"><?php echo $messages['smtp_configuration']; ?></h3>
	 <span class="glyphicon glyphicon-envelope admin"></span>
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
	<h4><?php echo $messages['smtp_host']; ?></h4>
    <input type="text" name="smtp_host" value="<?php optionvalue("smtp_host"); ?>" placeholder="">
    </label>
	<hr>
	<label>
	<h4><?php echo $messages['smtp_port']; ?></h4>
    <input type="text" name="smtp_port" value="<?php optionvalue("smtp_port"); ?>" placeholder="">
    </label>
	<hr>
	<label>
	<h4><?php echo $messages['smtp_username']; ?></h4>
    <input type="text" name="smtp_username" value="<?php optionvalue("smtp_username"); ?>" placeholder="">
    </label>
	<hr>
	<label>
	<h4><?php echo $messages['smtp_password']; ?></h4>
    <input type="password" name="smtp_password" value="<?php optionvalue("smtp_password"); ?>" placeholder="">
    </label>
	<hr>
	<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $messages['submit']; ?>" />
</form>
</div>
        </div>
		    
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