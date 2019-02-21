<?php
// Include FB config file && User class
require_once 'includes/fbConfig.php';

if(isset($accessToken)){
	if(isset($_SESSION['facebook_access_token'])){
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}else{
		// Put short-lived access token in session
		$_SESSION['facebook_access_token'] = (string) $accessToken;
		
	  	// OAuth 2.0 client handler helps to manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();
		
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		
		// Set default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	
	// Redirect the user back to the same page if url has "code" parameter in query string
	if(isset($_GET['code'])){
		header('Location: ./');
	}
	
	// Getting user facebook profile info
	try {
		$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture.height(100)');
		$fbUserProfile = $profileRequest->getGraphNode()->asArray();
	} catch(FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// Redirect user back to app login page
		header("Location: ./");
		exit;
	} catch(FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	// Initialize User class
	
	
	// Insert or update user data to the database
	$fbUserData = array(
		'oauth_provider'=> 'facebook',
		'oauth_uid' 	=> $fbUserProfile['id'],
		'first_name' 	=> $fbUserProfile['first_name'],
		'last_name' 	=> $fbUserProfile['last_name'],
		'email' 		=> $fbUserProfile['email'],
		'gender' 		=> $fbUserProfile['gender'],
		'locale' 		=> $fbUserProfile['locale'],
		'picture' 		=> $fbUserProfile['picture']['url'],
		'link' 			=> $fbUserProfile['link']
	);

		if(!empty($fbUserData)){
$oauth_provider = $fbUserData['oauth_provider'];
$oauth_uid = mysqli_real_escape_string($conn, $fbUserData['oauth_uid']);
$first_name = mysqli_real_escape_string($conn, $fbUserData['first_name']);
$email = mysqli_real_escape_string($conn, $fbUserData['email']);
$gender = mysqli_real_escape_string($conn, $fbUserData['gender']);
$locale = mysqli_real_escape_string($conn, $fbUserData['locale']);
$picture = mysqli_real_escape_string($conn, $fbUserData['picture']);
$link = mysqli_real_escape_string($conn, $fbUserData['link']);
			
			// Check whether user data already exists in database
			$prevQuery = "SELECT * FROM users WHERE oauth_provider = '$oauth_provider' AND oauth_uid = '$oauth_uid'";
			$prevResult = $conn->query($prevQuery);
			if($prevResult->num_rows > 0){
				// Update user data if already exists
				$query = "UPDATE users SET userName = '$first_name', userEmail = '$email', gender = '$gender', locale = '$locale', avatar = '$picture', fb_link = '$link' WHERE oauth_provider = '$oauth_provider' AND oauth_uid = '$oauth_uid'";
				$update = $conn->query($query);

			} else {
				// Insert user data
				$query = "INSERT INTO users SET oauth_provider = '$oauth_provider', oauth_uid = '$oauth_uid', userName = '$first_name', userEmail = '$email', gender = '$gender', locale = '$locale', avatar = '$picture', fb_link = '$link'";
				$insert = $conn->query($query);

			}
			
			// Get user data from the database
			$result = $conn->query($prevQuery);
			$fbUserData = $result->fetch_assoc();
		}
	
	// Put user data into session
	$_SESSION['userData'] = $fbUserData;
	
	// Get logout url
	$logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');
	
	// Render facebook profile data
	if(!empty($fbUserData)){
		$_SESSION['user'] = $fbUserData['userId'];
		
		$res=$conn->query("SELECT userName FROM users WHERE userId='".$_SESSION['user']."'");
		$time = time();
		$row=mysqli_fetch_array($res);
		
		$conn->query("INSERT INTO chat SET Id='NULL', name='INFO', senderId='0', message='[i][b]".$row['userName']."[/b] ".$messages['loggedin']."[/i]', time='$time', ip='127.0.0.1'");
		/* $output  = '<h1>Facebook Profile Details </h1>';
		$output .= '<img src="'.$fbUserData['avatar'].'">';
        $output .= '<br/>Facebook ID : ' . $fbUserData['oauth_uid'];
        $output .= '<br/>Name : ' . $fbUserData['userName'].' '.$fbUserData['last_name'];
        $output .= '<br/>Email : ' . $fbUserData['userEmail'];
        $output .= '<br/>Gender : ' . $fbUserData['gender'];
        $output .= '<br/>Locale : ' . $fbUserData['locale'];
        $output .= '<br/>Logged in with : Facebook';
		$output .= '<br/><a href="'.$fbUserData['fb_link'].'" target="_blank">Click to Visit Facebook Page</a>';
        $output .= '<br/>Logout from <a href="'.$logoutURL.'">Facebook</a>';  */
		
	}else{
		$errMSG = "Some problem occurred, please try again.";
		$output = '';
	}
	
}  elseif ($helper->getError()) {
  // The user denied the request
		$error_code = xss($_GET['error_code']);
		$error_description = xss($_GET['error_description']);
		$error_reason = xss($_GET['error_reason']);
		
		$error = true;
		$errMSG = "Error Code: <b>$error_code</b><br />Description: <b>$error_description</b><br /> Reason: <b>$error_reason</b>";

} elseif (isset($_GET['error_message'])) {
	//something else is going on
// The user denied the request
		$error_code = xss($_GET['error_code']);
		$error_message = xss($_GET['error_message']);
		
		$error = true;
		$errMSG = "Error Code: <b>$error_code</b><br />Description: <b>$error_message</b>";
	
} else {
	// Get login url
	$loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
	
	// Render facebook login button
	$output = "<hr />\n<div class='centir'><a href='".htmlspecialchars($loginURL)."'><img src='assets/images/fb_login.png'></a></div><br />\n";
}
?>