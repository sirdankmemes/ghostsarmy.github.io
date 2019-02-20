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

$user = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_FLOAT);
$user = str_replace(array('+','-'), '', $user);

$rez=$conn->query("SELECT * FROM users WHERE userId='".$user."'");
$rou=mysqli_fetch_array($rez);
$userid = $rou['userId'];
if ($rou) {} else {echo "I DIED BECAUSE OF YOU"; exit();}
if (isset($_POST['message']) && !empty($_POST["message"])) {
$message = mysqli_real_escape_string($conn, $_POST['message']);
$title = mysqli_real_escape_string($conn, $_POST['title']);
$conn->query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$_SESSION['user'].'", "'.$userid.'", "'.$title.'", "'.$_SESSION['user'].'", "'.$userid.'", "'.$message.'", "'.time().'", "yes", "no")');
if ($conn) {
$resultat = $messages['msgsuccess']." <b>".$rou['userName']."</b>";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['sndmsgto']; ?> - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>
<body>
<?php
require('nav.php');
?>

 <div id="wrapper">

 <div class="container">
    
     <div class="page-header">
     <h3><?php echo $messages['sndmsgto'].$rou['userName']; ?></h3>
     </div>
        
        <div class="row msgshadow">
		
<?php
if ($_SESSION['user'] == $userid)
{
echo "<div class='alert alert-danger' role='alert' style='margin: 0 auto;'>".$messages['pmself']."</div>";
} else {
if (isset($resultat)) { 
echo "<div class='alert alert-success' role='alert' style='margin: 0 auto;'>".$resultat."</div>";
} else {
?>
    <form action="private.php?id=<? echo $user; ?>" method="post" class="navbar-form navbar-left">
                <?php echo $messages['plsfillmsg']; ?><br />
        <label for="title"><?php echo $messages['title']; ?></label><br /><input class="form-control" type="text" value="" id="title" name="title" /><br />
        <label for="message"><?php echo $messages['messagepm']; ?></label><br /><textarea class="form-control" cols="40" rows="5" id="message" name="message"></textarea><br /><br />
        <input type="submit" value="<?php echo $messages['submit']; ?>" class="btn btn-primary" />
    </form>
<?php } } ?>
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