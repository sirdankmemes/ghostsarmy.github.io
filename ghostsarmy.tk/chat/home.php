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
 
 // variables
$name = $userRow['userName'];
$ip = $_SERVER['REMOTE_ADDR'];
$tm = time();
// database query
	if( !empty($_POST["message"]) )
	{
$message = mysqli_real_escape_string($conn, $_POST["message"]);
$senderId = $_SESSION['user'];

$sql = $conn->query("INSERT INTO chat SET Id='NULL', name='$name', senderId='$senderId', message='$message', time='$tm', ip='$ip'");
}
 
//active selector
$homeactive = "active";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['welcome']; ?> - <?php echo $userRow['userEmail']; ?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
<link rel="stylesheet" href="assets/css/loader.css" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />

<link rel="stylesheet" href="demo-files/demo.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require('nav.php');
?>

 <div id="wrapper">

 <div class="container"><br />
    
     <div class="page-header">
     <h3><?php echo $messages['chatroom']; ?></h3>
     </div>
        
        <div class="row">


<audio id='bgAudio'> <source src='boom.mp3' type='audio/mpeg'> </audio>
<?php
if ($userRow["isadmin"] == 1) {
echo "<div class='alert alert-success' role='alert'>".$userRow['userName'].", ".$messages['youareadmin']." <img alt=':)' border='0' src='smileys/smile.png' /></div>";

if(isset($_POST['chat'])) {
$brise = $conn->query("DELETE FROM `".$configs->database."`.`chat` WHERE `chat`.`Id` > 0");

$conn->query("INSERT INTO chat SET Id='NULL', name='INFO', senderId='0', message='".$messages['chatlogpruned']."', time='$tm', ip='127.0.0.1'");

}
    } 
?>
<div class="panel panel-primary">
<div class="panel-heading">Chat</div>
<div class="panel-body">
<img id="loader" class="loader" src="https://www.idansoft.com/oblivisionjs/images/loaders/loader.gif">
<div id="chatdiv" style="line-height: 26px;height: 262px;overflow:auto;"></div><br />
<?php  
require('chat.php'); 
?>
<span style="float: right"><?php echo $messages['sound']; ?><input class="btn" id="mutez" type="button" value="Mute" /></span>

</div>
</div>
<br />
<div class="panel panel-primary">
<div class="panel-heading"><?php echo $messages['lonline5']; ?></div>
<div class="panel-body">
<div id="lonline"></div>
</div>
</div>

<?php	
if ($userRow["isadmin"] == 1) {
echo "<div class='panel panel-danger'>";
echo "<div class='panel-heading'>".$messages['controls']."</div>";
echo "<div class='panel-body'>";
echo "<form method='post' id='form2' style='display: inline;' action='home.php'>";
echo "<input type='hidden' name='chat' value='chat'/>";
echo "<input type='submit' name='Submit' class='btn btn-danger' value='".$messages['delchatlog']."'>";
echo "</form>";
echo "<a href='user-list.php' class='btn btn-warning' style='float: right;'>".$messages['userlist']."</a>";
echo "</div>";
echo "</div>";
} 
?>       
        </div>
    
    </div>
    
    </div>
	
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
		<a href="" class="fullpreview" target="_blank">FULL IMAGE</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade youtubemodal" id="youtubemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<div class="iframe-yt">
		<iframe width="416" height="311" src="" frameborder="0" class="videopreview" style="width: 100%;" allowfullscreen></iframe>
		</div>
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