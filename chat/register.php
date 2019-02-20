<?php
 ob_start();
 session_start();
 if( isset($_SESSION['user'])!="" ){
  header("Location: home.php");
 }
 include_once 'dbconnect.php';
 include 'includes/recaptcha.php';

 $error = false;
 
//Prevent registration of banned user 
  if ($_COOKIE['banned'] == '1') {
	  $errTyp = "danger";
	  $error = true;
	  $errMSG = $messages['youarebanned'];
  }

  //show current lang
  if ($_COOKIE['lang']=="srb")
  {	
  $selectedsrb = "selected";
  } elseif ($_COOKIE['lang']=="eng") {
  $selectedeng = "selected";
  }
  
 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  $lang = xss($_POST['language']);
  
  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = $messages['nameError'];
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = $messages['nameErrorlenght'];
  } else if (!preg_match("/^[a-zA-Z]+$/",$name)) {
   $error = true;
   $nameError = $messages['namealphonly'];
  } else {
	  // check if name exist or not
   $query = "SELECT userName FROM users WHERE userName='$name'";
   $result = $conn->query($query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $nameError = $messages['nameinuse'];
   }
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = $messages['emailInvalid'];
  } else {
   // check email exist or not
   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = $conn->query($query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = $messages['emailInUse'];
   }
  }
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
  
  // if there's no error, continue to signup
  if( !$error ) {
   
   $query = "INSERT INTO users(userName,userEmail,userPass,lang) VALUES('$name','$email','$password','$lang')";
   $res = $conn->query($query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = $messages['successreg'];
    unset($name);
    unset($email);
    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = $messages['danger']; 
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
             <h2 class=""><?php echo $messages['signupreg']; ?></h2>
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
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="name" class="form-control" placeholder="<?php echo $messages['entername']; ?>" maxlength="50" value="<?php echo $name ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="<?php echo $messages['enteremail']; ?>" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="<?php echo $messages['enterpassword']; ?>" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
			<hr />
            <div class="form-group">
			<div class="dropdown">
<select name="language" class="btn btn-default dropdown-toggle">
  <option value="eng" <?php echo (isset($selectedeng)) ? $selectedeng : ""; ?>><?php echo $messages['english']; ?></option>
  <option value="srb" <?php echo (isset($selectedsrb)) ? $selectedsrb : ""; ?>><?php echo $messages['serbian']; ?></option>
</select>	
			</div>

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
             <button type="submit" class="btn btn-block btn-login" name="btn-signup"><?php echo $messages['signupreg']; ?></button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group centir">
			 <?php echo $messages['alreadyregistered']; ?>
             <a href="index.php" class="btn btn-default"><?php echo $messages['signinhere']; ?></a>
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
</body>
</html>
<?php ob_end_flush(); ?>