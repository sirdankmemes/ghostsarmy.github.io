<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: home.php");
  exit;
 }
 
 $error = false;
 
  if ($_COOKIE['banned'] == '1') {

	  $errMSG = $messages['youarebanned'];
  }
  
  if ($_COOKIE['kick'] == '1') {

	  $errMSG = $messages['youarekicked'];
  }
 
 if( isset($_POST['btn-login']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs
  
  if(empty($email)){
   $error = true;
   $emailError = $messages['emailEmpty'];
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = $messages['emailInvalid'];
  }
  
  if(empty($pass)){
   $error = true;
   $passError = $messages['passEmpty'];
  }
  
  // if there's no error, continue to login
  if (!$error) {
   
   $password = hash('sha256', $pass); // password hashing using SHA256
  
   $res=$conn->query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
   
   if( $count == 1 && $row['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
	$time = time();
	$conn->query("INSERT INTO chat SET Id='NULL', name='INFO', senderId='0', message='[i][b]".$row['userName']."[/b] ".$messages['loggedin']."[/i]', time='$time', ip='127.0.0.1'");
    header("Location: home.php");
   } else {
    $errMSG = $messages['IncorrectCredentials'];
   }
    
  }
  
 }

//If Facebook login enabled, do magic
$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='fb_login_enabled'");
if($row = mysqli_fetch_assoc($sql)) {
$fb_login_is = $row['option_value'];
}
if($fb_login_is==1) {
require('includes/fb_login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('includes/meta.php'); ?>
<title>Chat system - <?php optionvalue("site_title"); ?></title>
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
             <h2 class=""><?php echo $messages['signin']; ?></h2>
         </div>
        
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
      if ( isset($banned) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $messages['youarebanned']; ?>
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
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="<?php echo $messages['yourpassword']; ?>" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-login" name="btn-login"><?php echo $messages['signin']; ?></button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group centir">
			 <?php echo $messages['notregistered']; ?>
             <a href="register.php" class="btn btn-default"><?php echo $messages['signup']; ?></a><br />
			 <a href="forgot-password.php"><?php echo $messages['forgotpassword']; ?></a>
            </div>
			<?php echo $output; ?>
        </div>
   
    </form>
    </div> 

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="assets/js/guest.js"></script>
<?php require('includes/footer.php'); ?>
</body>
</html>
<?php ob_end_flush(); ?>