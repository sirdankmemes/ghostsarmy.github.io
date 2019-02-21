<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: home.php");
  exit;
 }
 

include_once 'dbconnect.php';

$error = false;
 
$email = xss($_GET['key'].$_POST['email_address']);

$token=xss($_GET['reset'].$_POST['token']);

$t = time(); // current time
  
$sql=$conn->query("SELECT userEmail, token, tokenexp FROM users WHERE userEmail='$email'");
$check=mysqli_fetch_array($sql);

if (isset($_GET['key']) && isset($_GET['reset'])) {
	if ($email!=$check['userEmail'] || $token!=$check['token'] || $check['tokenexp'] < $t) {
  $error = true;
  $errTyp = "danger";
  $errMSG = $messages['tokenexpired']; 
  
  //disable input fields
  
  $disableinput = "disabled='disabled'";
	}
}

if (!isset($_GET['key']) && !isset($_GET['reset']) && !isset($_POST['token']) && !isset($_POST['email_address'])) {
  header("Location: home.php");
  exit;
}

 
 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
 
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = $messages['passEmpty'];
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = $messages['passLenght'];
  }
  
  // password encrypt using SHA256();
  $password = hash('sha256', $pass);
  
  // if there's no error, continue to reset
  if( !$error ) {
	// Changes password if token is not expired and matches the one in database
   $query = "UPDATE users SET userPass='$password' WHERE userEmail='".$_POST['email_address']."' and token='".$_POST['token']."' and tokenexp > '$t'";
   $res = $conn->query($query);
   $count = $conn->affected_rows;
   if ($count>0 && !empty($_POST['email_address']) && !empty($_POST['token'])) {
    $errTyp = "success";
    $errMSG = $messages['successreset'];
	$sql = $conn->query("UPDATE users set token = '' WHERE userEmail='$email' and token = '$token'");
    unset($token);
    unset($email);
    unset($pass);
	$disableinput = "disabled='disabled'";
   } else {
    $errTyp = "danger";
    $errMSG = $messages['danger']; 
	$disableinput = "disabled='disabled'";
   } 
    
  }
  
  
 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration - Leo Chat</title>
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
             <h2 class=""><?php echo $messages['newpassword']; ?></h2>
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
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="<?php echo $messages['enterpassword']; ?>" maxlength="15" <?php if(isset($disableinput)) { echo $disableinput; } ?>/>
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-login" name="btn-signup"><?php echo $messages['send']; ?></button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group centir">
             <a href="index.php" class="btn btn-default"><?php echo $messages['signinhere']; ?></a>
            </div>
        
        </div>
<input type="hidden" name="email_address" value="<?php echo $email; ?>" <?php if(isset($disableinput)) { echo $disableinput; } ?>>   
<input type="hidden" name="token" value="<?php echo $token; ?>" <?php if(isset($disableinput)) { echo $disableinput; } ?>>   
    </form>
    </div> 

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="assets/js/guest.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>