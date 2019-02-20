<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 include 'includes/recaptcha.php';
 
 // it will never let you open this page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }
 
 $error = false;
 
 if( isset($_POST['btn-login']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  // prevent sql injections / clear user invalid inputs
  
  if(empty($email)){
   $error = true;
   $emailError = $messages['emailEmpty'];
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = $messages['emailInvalid'];
  }
  
  //reCAPTCHA validation
  if($rec_show == '1' && !empty($rec_secret_key)) {
	  
	  if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
	  
	  $rec_secret_key = $rec_secret_key;
	  $ip = $_SERVER['REMOTE_ADDR'];
	  
	  $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$rec_secret_key."&response=".$captcha."&remoteip=".$ip);
      $responseKeys = json_decode($response,true);
      if(intval($responseKeys["success"]) !== 1) {
		$error = true;
        $errTyp = "danger";
		$errMSG = $messages['rec_invalid']; 
      } else {
        //echo '<h2>Thanks for posting comment.</h2>';
      }
	  
  }
  
  // if there's no error, continue
  if (!$error) {
	
   $res=$conn->query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
   $row=mysqli_fetch_array($res);
   //variables

   $count = mysqli_num_rows($res); // if email correct it returns must be 1 row
   
   if( $count == 1 ) {
	   
	$t = time()+900; // current time + 5 minutes
	$sql = $conn->query("UPDATE users set tokenexp = '$t' WHERE userEmail='$email'");
	$token = bin2hex(openssl_random_pseudo_bytes(16)); //generate unique token
	$sql = $conn->query("UPDATE users set token = '$token' WHERE userEmail='$email'");
	   
	$msg = "<a href='http://".$_SERVER['SERVER_NAME']."/reset.php?key=".$email."&reset=".$token."'>LINK</a>"; 
	
	define('FORGET_PASS_MAILER_PROTECTION', true);
	require('includes/forgot_password_mail.php');
	
	$errTyp = "success";
    $errMSG = $row['userName'].", ".$messages['resetsent'];
   } else {
	$errTyp = "danger";
    $errMSG = $messages['notfoundindb'];
   }
    
  }
  
 }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chat system - Leo Chat</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12 home-form-box">
        
         <div class="form-group">
		   <div class="imgcontainer">
		   <img id="image" alt="Avatar" class="login-avatar" />
		   </div>
             <h2 class=""><?php echo $messages['forgotpassword']; ?></h2>
         </div>
        
         <div class="form-group">
             <hr />
            </div>
            
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
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="<?php echo $messages['youremail']; ?>" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
<?php 
if($rec_show == '1' && !empty($rec_site_key)) {
			echo "<div class='g-recaptcha' data-sitekey='".$rec_site_key."'></div>\n<hr />";
}
?>              
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-login" name="btn-login"><?php echo $messages['send']; ?></button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group centir">
             <a href="index.php" class="btn btn-default"><?php echo $messages['signin']; ?></a>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>
<?php 
if($rec_show == '1') {
echo "<script src='https://www.google.com/recaptcha/api.js'></script>\n";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="assets/js/guest.js"></script>
<?php require('includes/footer.php'); ?>
</body>
</html>
<?php ob_end_flush(); ?>