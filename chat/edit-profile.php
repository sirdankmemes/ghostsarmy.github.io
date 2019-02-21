<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }

//insert bio
$who = $_SESSION['user'];
if(isset($_POST['bio']) && !empty($_POST['bio'])) {
//prevent sql injection
$bio = mysqli_real_escape_string($conn, $_POST['bio']);
	
$biography = "UPDATE users SET bio='$bio' WHERE userId='$who'";
$bioupdate = $conn->query($biography);
if($bioupdate) {
		$biores = "<div class='alert alert-success' role='alert'>".$messages['bioupdated']."</div>";
} else {
	$biores = "<div class='alert alert-danger' role='alert'>".$messages['bionotupdated']."</div>";
}
}
//update language on submit
if(isset($_POST['language'])){
$selectedlang = mysqli_real_escape_string($conn, $_POST['language']);
$conn->query("UPDATE users SET lang='$selectedlang' WHERE userId='$who'");
setcookie("lang", $selectedlang, time()+3600);
header("Refresh:0");
}

//check which one is selected, if selected
$sql=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
$get=mysqli_fetch_array($sql);

if ($get['lang']=="srb")
{	
	$selectedsrb = "selected";
} elseif ($get['lang']=="eng") {
		$selectedeng = "selected";
}

if($_FILES['photo']['name'])
{
require('avatar-upload.php');
$avatar = "uploads/".basename( $_FILES["photo"]["name"]);
if (!$uploadOk == 0) {
$avqu = "UPDATE users SET avatar='$avatar' WHERE userId='$who'";
$avupdate = $conn->query($avqu);

	$avataresponse = "<div class='alert alert-success' role='alert'>".$response."</div>";

} elseif ($uploadOk == 0) {
	$avataresponse = "<div class='alert alert-danger' role='alert'>".$response."</div>";
}
}
// select loggedin users detail
$res=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['editprofile']; ?> - <?php echo $userRow['userEmail']; ?></title>
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
     <h3><?php echo $messages['userprofile']." ".$userRow['userName']; ?></h3>
     </div>
        
<div class="panel panel-default centere">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $userRow['userName']; ?></h3>
  </div>
        <div class="panel-body">       
<?php
echo (isset($biores)) ? $biores : "";
echo (isset($avataresponse)) ? $avataresponse : "";

if ($userRow['avatar']) {
echo "<img height='100px' width='100px' src='".$userRow['avatar']."' class='avatar img-responsive'></img><br />";
} else {
echo "<img height='100px' width='100px' src='assets/images/avatar-1.png' class='avatar img-responsive'></img><br />";		
}
?>
    <?php 
	echo "<table class='table'>";
	echo "<tr>"."<td>".$messages['emailaddress']."</td>"."<td>".$userRow['userEmail']."</td></tr>"; ?><br />
    <?php echo "<tr>"."<td>".$messages['userid']."</td>"."<td>".$userRow['userId']."</td></tr>"; ?><br />
    <?php
    echo "<tr>"."<td>".$messages['lastactive']."</td>"."<td>".date('Y-m-d H:i:s', $userRow['lActive'])."</td></tr>";
	echo "</table>";
if ($userRow['bio']) {
    ?><br />
    <?php
    echo "<h3>".$messages['bio']."</h3>"."<div class='well'>".xss($userRow['bio'])."</div>";
}
?>
</div></div>
     <div class="page-header">
     <h3><? echo $messages['edityourprofile']; ?></h3>
     </div>
<div class='well'>
<h4><? echo $messages['bioedit']; ?></h4>
<form method="post" action="edit-profile.php">
    <label>
    <textarea name="bio" class="form-control" type="text" id="bio"></textarea>
    </label><br />

    <input type="submit" name="Submit" class="btn btn-primary" value="<?php echo $messages['submit']; ?>">

</form>
</div>
<div class='well'>
<h4>Avatar:</h4>
<form action="edit-profile.php" method="post" enctype="multipart/form-data">
	<?php echo $messages['youravatar']; ?><input type="file" id="photo" name="photo" size="25" /><br />
	<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $messages['submit']; ?>" />
</form>
</div>
     <div class="page-header">
     <h3><?php echo $messages['changelang']; ?></h3>
     </div>
<div class='well'>
<form action="edit-profile.php" method="post">
<select name="language" class="btn btn-default dropdown-toggle">
  <option value="eng" <?php echo (isset($selectedeng)) ? $selectedeng : ""; ?>><?php echo $messages['english']; ?></option>
  <option value="srb" <?php echo (isset($selectedsrb)) ? $selectedsrb : ""; ?>><?php echo $messages['serbian']; ?></option>
</select>	
<input type="submit" name="submit" class="btn btn-primary" value="<?php echo $messages['submit']; ?>" />
</form>
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