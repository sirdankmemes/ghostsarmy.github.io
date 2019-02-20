 <?php
 // select loggedin users detail
 $sql=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysqli_fetch_array($sql);
 ?>
 
 <nav class="navbar navbar-blue navbar-fixed-top">
 <a href="home.php"><img src="assets/images/logo2.png" class="logo-center"></a>
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand <?php echo (isset($homeactive)) ? $homeactive : ""; ?>" href="home.php">Chat</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav <?php echo (isset($pmactive)) ? $pmactive : ""; ?>">
            <li><a href="read-private.php"><?php echo $messages['inbox'];?> <luka id="inboxhunter"></luka></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
<?php

 if ($userRow["isadmin"] == 1 && $userRow["userId"] == 1) {
 echo "<li class='dropdown'>\n<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>ADMIN</a>\n";
 echo "<ul class='dropdown-menu'>\n";
 echo "<li><a href='admin-panel.php'><span class='glyphicon glyphicon-cog'></span>&nbsp;".$messages['adminpanel']."</a></li>\n";
 echo "<li><a href='smtp-config.php'><span class='glyphicon glyphicon-envelope'></span>&nbsp;".$messages['smtp_configuration']."</a></li>\n";
 echo "</ul></li>\n";
 } 

?>       
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
     <span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $messages['hi']." ".$userRow['userName']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="edit-profile.php"><span class="glyphicon glyphicon-edit"></span>&nbsp;<?php echo $messages['editprofile']; ?></a></li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;<?php echo $messages['signout']; ?></a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 