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

//delete message
if (isset($_GET['rm'])) {
$query = $conn->query("DELETE from pm WHERE timestamp='".$_GET['rm']."' AND id2=".$_SESSION['user']);
}
//read incoming messages
$read=$conn->query("SELECT * FROM pm WHERE id2=".$_SESSION['user']." ORDER BY timestamp desc");
$conn->query("UPDATE pm set user2read = 'yes' WHERE id2=".$_SESSION['user']);
while($poruk = mysqli_fetch_array($read))
{
$poruke[] = $poruk;
} 
//read sent messages
$sql=$conn->query("SELECT * FROM pm WHERE id=".$_SESSION['user']." ORDER BY timestamp desc");
while($sent = mysqli_fetch_array($sql))
{
$posl[] = $sent;
} 
//active selector
$pmactive = "active";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['private']; ?> - <?php echo $userRow['userEmail']; ?></title>
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
     
     </div>
<div class="row">   

     <h3><?php echo $messages['readmessages']; ?></h3>
	 
        <?php
if (is_array($poruke) || is_object($row)) {
        foreach($poruke as $row){
$poruka = xss($row['message']);
$poruka = smilies($poruka);
$poruka = showBBcodes($poruka);

if(isImage($poruka)) {
	$poruka = "<a href='#' class='pop'><img class='pop-inner' src='".$poruka."'></img></a>";
} elseif(isYoutube($poruka)) {
	$poruka = convertYoutube($poruka);
} else {
	$poruka = linkify($poruka);
}

$naslov = xss($row['title']);
$naslov = smilies($naslov);
$naslov = linkify($naslov);
$naslov = showBBcodes($naslov);
			
$koje=$conn->query("SELECT * FROM users WHERE userId=".$row['id']);
$koje=mysqli_fetch_array($koje);
	echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'><h3 class='panel-title'>".$messages['title']." ".$naslov."<span style='float: right'>".$messages['from']." ".$koje['userName']."</span></h3></div>";
echo "<div class='panel-body'>".$messages['messagepm']." ".$poruka."</div>";
echo "<a href='private.php?id=".$koje['userId']."'>".$messages['reply']."</a> | ";
echo "<a href='read-private.php?rm=".$row['timestamp']."'>".$messages['delete']."</a>";
        echo "</div>";

}
} else {
echo "<div class='alert alert-info' role='alert'>".$messages['nomsg']."</div>";
}
        ?>
     <h3><?php echo $messages['sentmessages']; ?></h3>
        <?php
if (is_array($posl) || is_object($row)) {
foreach($posl as $row){ 
$poruka = xss($row['message']);
$poruka = smilies($poruka);
$poruka = showBBcodes($poruka);

if(isImage($poruka)) {
	$poruka = "<a href='#' class='pop'><img class='pop-inner' src='".$poruka."'></img></a>";
} elseif(isYoutube($poruka)) {
	$poruka = convertYoutube($poruka);
} else {
	$poruka = linkify($poruka);
}

$naslov = xss($row['title']);
$naslov = smilies($naslov);
$naslov = linkify($naslov);
$naslov = showBBcodes($naslov);

	echo "<div class='panel panel-info'>";
$koje=$conn->query("SELECT * FROM users WHERE userId=".$row['id2']);
$koje=mysqli_fetch_array($koje);
echo "<div class='panel-heading'><h3 class='panel-title'>".$messages['title']." ".$naslov."<span style='float: right'>".$messages['for']." ".$koje['userName']."</span></h3></div>";
echo "<div class='panel-body'>".$messages['messagepm']." ".$poruka."</div>";
if ($row['user2read']=="yes") {
echo $messages['seen']." <b>".$messages['yes']."</b>";
} elseif ($row['user2read']=="no")
{
echo $messages['seen']." <b>".$messages['no']."</b>";
} else
{
echo $messages['seen']." <b>".$messages['unknown']."</b>";
}
        echo "<br />";
        echo "</div>";
}
} else {
echo "<div class='alert alert-info' role='alert'>".$messages['nomsg']."</div>";
}
        ?>


    </div>
    
    </div>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="assets/js/chat.js"></script>
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
<br />
<?php require('includes/footer.php'); ?>     
</body>
</html>
<?php ob_end_flush(); ?>