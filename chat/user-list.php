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
 if ($userRow["isadmin"] != 1) {
  header("Location: home.php");
  exit;	 
 }
	 
 // variables
$name = $userRow['userName'];

//get user list
$sql = $conn->query('SELECT * FROM users ORDER BY userId asc');
// show database results
while($row = mysqli_fetch_array($sql))
{
$rows[] = $row;
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $messages['userlist']; ?> - <?php echo $userRow['userEmail']; ?></title>
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
     <h3><?php echo $messages['userlist']; ?></h3>
     </div>
        
        <div class="row">
<table class="table">
<tr>
    <th><?php echo $messages['id']; ?></th>
    <th><?php echo $messages['username']; ?></th> 
    <th><?php echo $messages['email']; ?></th>
    <th><?php echo $messages['biog']; ?></th>
    <th><?php echo $messages['isadmin']; ?></th>
	<th><?php echo $messages['lactive']; ?></th>
  </tr>		
<?php
if (is_array($rows) || is_object($row)) {
foreach($rows as $row){ 
if ($row['isadmin']==1) {
	$isadmin = $messages['yes'];
} else {
	$isadmin = $messages['no'];
}
if ($row['banned']=="1") {
	$banned = " <span class='label label-danger'>".$messages['statusbanned']."</span>";
} else {
	$banned ="";
}
if (!empty($row['bio'])) {
	$bio = $row['bio'];
} else
	
	{
		$bio = "<i>".$messages['nobio']."</i>";
	}
if(!empty($row['lActive'])) {
	$lactive = date('Y-m-d H:i:s', $row['lActive']);
} else {
	$lactive = "<i>".$messages['nolactive']."</i>";
}
echo "<tr>";
echo "<td>".$row['userId']."</td>";
echo "<td><a href='profile.php?id=".$row['userId']."'>".$row['userName']."</a>".$banned."</td>";
echo "<td>".$row['userEmail']."</td>";
echo "<td>".$bio."</td>";
echo "<td>".$isadmin."</td>";
echo "<td>".$lactive."</td>";
echo "</tr>";
}
}
?>   
</table>
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