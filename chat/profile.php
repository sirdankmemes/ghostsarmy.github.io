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
//prevent sql injection
$user = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_FLOAT);
$user = str_replace(array('+','-'), '', $user);

 $rez=$conn->query("SELECT * FROM users WHERE userId='$user'");
 $rou=mysqli_fetch_array($rez);
 if ($rou) {
	 
 } else {
	 echo $messages['404error']; 
	 header("refresh:3;url=index.php");
	 exit();
	 }


if ($userRow["isadmin"] == 1) {
	//make admin
if(isset($_GET['admin']) && $_GET['admin']=="yes" && $rou['userId']!=1 && $rou['userId']!=$_SESSION['user']) {
$sql = "UPDATE users SET isadmin='1' WHERE userId='".$rou['userId']."'";
$conn->query($sql);
if($sql){
$success = "<div class='alert alert-success' role='alert'>".$messages['makedadmin']."</div>";
}
} elseif (isset($_GET['admin']) && $_GET['admin']=="no" && $rou['userId']!=1 && $rou['userId']!=$_SESSION['user']) {
$sql = "UPDATE users SET isadmin='0' WHERE userId='".$rou['userId']."'";
$conn->query($sql);
if($sql){
$success = "<div class='alert alert-success' role='alert'>".$messages['removedadmin']."</div>";
}
}

//Ban
if(isset($_GET['ban']) && $_GET['ban']=="yes" && $rou['userId']!=1 && $rou['userId']!=$_SESSION['user']) {
$sql = "UPDATE users SET banned='1' WHERE userId='".$rou['userId']."'";
$conn->query($sql);
if($sql){
$success = "<div class='alert alert-success' role='alert'>".$messages['banned']."</div>";
}
} elseif (isset($_GET['ban']) && $_GET['ban']=="no" && $rou['userId']!=1 && $rou['userId']!=$_SESSION['user']) {
$sql = "UPDATE users SET banned='0' WHERE userId='".$rou['userId']."'";
$conn->query($sql);
if($sql){
$success = "<div class='alert alert-success' role='alert'>".$messages['banremoved']."</div>";
}
}

//Kick
if(isset($_GET['kick']) && $_GET['kick']=="yes" && $rou['userId']!=1 && $rou['userId']!=$_SESSION['user']) {
$sql = "UPDATE users SET kicked='1' WHERE userId='".$rou['userId']."'";
$conn->query($sql);
if($sql){
$success = "<div class='alert alert-success' role='alert'>".$messages['kicked']."</div>";
}
}

//Displaying error message when admin attempts to do an action against first admin or himself
if(isset($_GET['admin']) && $rou['userId']==1 || isset($_GET['ban']) && $rou['userId']==1 || isset($_GET['kick']) && $rou['userId']==1) {
	$error = "<div class='alert alert-danger' role='alert'>".$messages['firstadmin']."</div>";
}

if(isset($_GET['admin']) && $rou['userId']==$_SESSION['user'] || isset($_GET['ban']) && $rou['userId']==$_SESSION['user'] || isset($_GET['kick']) && $rou['userId']==$_SESSION['user']) {
	$error = "<div class='alert alert-danger' role='alert'>".$messages['cantself']."</div>";
}

}

//getting new data about user if admin status has changed
if ($userRow["isadmin"] == 1) {
if( isset($_GET['admin']) || isset($_GET['ban'])) {
$rez=$conn->query("SELECT * FROM users WHERE userId='".$user."'");
$rou=mysqli_fetch_array($rez);	
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['userprofile']." ".$rou['userName']; ?> - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
</head>
<body>

 <?php
require('nav.php');
?>

 <div id="wrapper">

 <div class="container">
    
     <div class="page-header">
     <h3><?php echo $messages['userprofile']." ".$rou['userName']; ?></h3>
     </div>
        
        <div class="panel panel-default centere">
  <div class="panel-heading">
    <h3 class="panel-title inlineblock"><?php echo $rou['userName']; ?></h3>
	<?php
	if ($rou["isadmin"] == 1) {
	echo "<span class='label label-danger' style='float: right;'>ADMIN</span>";
	}
	?>
  </div>
        <div class="panel-body">
		
    <?php

	echo (isset($error)) ? $error : "";
	echo (isset($success)) ? $success : "";
if ($rou['avatar']) {
echo "<img height='100px' width='100px' src='".$rou['avatar']."' class='avatar img-responsive'></img><br />";
} else {
echo "<img height='100px' width='100px' src='assets/images/avatar-1.png' class='avatar img-responsive'></img><br />";	
}
       if ($userRow["isadmin"] == 1) {
           ?>
		   <!-- Single button -->
<div class="btn-group">
  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo $messages['usercontrols']; ?> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  <?php if ($rou["isadmin"] == 0) { ?>
    <li><a href="profile.php?id=<?php echo $rou['userId']; ?>&admin=yes"><?php echo $messages['makeadmin']; ?></a></li>
  <?php } else { ?>
      <li><a href="profile.php?id=<?php echo $rou['userId']; ?>&admin=no"><?php echo $messages['removeadmin']; ?></a></li>
  <?php } ?>
<?php if ($rou["banned"] == 0) { ?>
    <li><a href="profile.php?id=<?php echo $rou['userId']; ?>&ban=yes"><?php echo $messages['ban']; ?></a></li>
  <?php } else { ?>
      <li><a href="profile.php?id=<?php echo $rou['userId']; ?>&ban=no"><?php echo $messages['unban']; ?></a></li>
  <?php } ?>
    <li><a href="profile.php?id=<?php echo $rou['userId']; ?>&kick=yes"><?php echo $messages['kick']; ?></a></li>
  </ul>
</div><br />
<?php
	if( $rou['banned']=="1" ) {
	echo "<br />Status: "."<span class='label label-danger'>".$messages['statusbanned']."</span>";
}
?>
<table class="table">

    <?php echo "<tr>"."<td>".$messages['emailaddress']."</td>"."<td>".$rou['userEmail']."</td></tr>"; ?><br />


    <?php echo "<tr>"."<td>".$messages['userid']."</td>"."<td>".$rou['userId']."</td></tr>"; ?><br />
    <?php
    } else { 
	echo "<table class='table'>";
	}
    ?>
    <?php
    echo "<tr>"."<td>".$messages['lastactive']."</td>"."<td>".date('Y-m-d H:i:s', $rou['lActive'])."</td></tr>";
echo "</table>";
if ($rou['bio']) {

    echo "<h3>".$messages['bio']."</h3>"."<div class='well'>".xss($rou['bio'])."</div>";
}
echo "<h4><a href='private.php?id=".$rou['userId']."' class='btn btn-primary'>".$messages['sendmessage']."</a></h4>";
?>
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