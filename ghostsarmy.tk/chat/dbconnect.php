<?php
if (!file_exists('config.php')) {
  header("Location: install/install.php");
  exit;
}

 // this will avoid deprecation errors in future.
error_reporting( ~E_DEPRECATED & ~E_NOTICE );
//error_reporting(E_ALL);

$configs = include('config.php');
 
$conn = new mysqli($configs->host, $configs->username, $configs->pass, $configs->database); 
 
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} 

//Set timezone
include('includes/timezone.php');

if(!empty($set_time_zone)) {
	date_default_timezone_set($set_time_zone);
} else {
date_default_timezone_set("Europe/Belgrade");
}

//function to prevent XSS
function xss($text) {
	$return = trim($text);
	$return = strip_tags($text);
	$return = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	return $return;
}

//Smileys
function smilies( $text ) {
    $smilies = array(
        ';)' => '<img src="smileys/wink.png" />',
        ':)' => '<img src="smileys/smile.png" />',
        ':-)' => '<img src="smileys/smile.png" />',
        ':))' => '<img src="smileys/smile-big.png" />',
        ':D' => '<img src="smileys/grin.png" />',        
        ':laugh:' => '<img src="smileys/laugh.png" />',
        ':-(' => '<img src="smileys/frown.png" />',
        ':(' => '<img src="smileys/frown.png" />',
        ':-((' => '<img src="smileys/frown-big.png" />',
        ':cry:' => '<img src="smileys/crying.png" />',
        ':-|' => '<img src="smileys/neutral.png" />',
        ':-*' => '<img src="smileys/kiss.png" />',
        ':-P' => '<img src="smileys/razz.png" />',
        ':chic:' => '<img src="smileys/chic.png" />',
        '8-)' => '<img src="smileys/cool.png" />',
        ':-X' => '<img src="smileys/angry.png" />',
        ':reallyangry:' => '<img src="smileys/really-angry.png" />',
        ':-?' => '<img src="smileys/confused.png" />',
        '?:-)' => '<img src="smileys/question.png" />',
        ':-/' => '<img src="smileys/thinking.png" />',
		':angel:' => '<img src="smileys/angel.png" />',
		':alien:' => '<img src="smileys/alien.png" />',
        ':pain:' => '<img src="smileys/pain.png" />',
        ':shock:' => '<img src="smileys/shock.png" />',
		':arrogant:' => '<img src="smileys/arrogant.png" />',
		':beatup:' => '<img src="smileys/beat-up.png" />',
        ':yes:' => '<img src="smileys/thumbs-up.png" />',
        ':no:' => '<img src="smileys/thumbs-down.png" />',
        ':heart:' => '<img src="smileys/heart.png" />',
        ':heartbroken:' => '<img src="smileys/heart-broken.png" />',
		':airplane:' => '<img src="smileys/airplane.png" />',
		':announce:' => '<img src="smileys/announce.png" />',

    );

    return str_replace( array_keys( $smilies ), array_values( $smilies ), $text );
}

//Links
    function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
    {
        // Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) {
            $attr = ' ' . $key . '="' . htmlentities($val) . '"';
        }
        
        $links = array();
        
        // Extract existing links and tags
        $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
        
        // Extract text links for each protocol
        foreach ((array)$protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" target=\"_blank\">$link</a>") . '>'; }, $value); break;
                case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
                case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
                default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
            }
        }
        
        // Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
    }
	
	
//Checks is URL an image

function isImage($l)
{
    return preg_match("/^[^\?]+\.(jpg|jpeg|gif|png)(?:\?|$)/", $l);
}

//Checks is URL Youtube video

function isYoutube($l)
{
    return preg_match("/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/", $l);
}

//Youtube links

function convertYoutube($string) {
	return preg_replace(
		"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
		"<a href='#' class='videopop'><img class='pop-inner' alt='$2' src='https://img.youtube.com/vi/$2/hqdefault.jpg'></img></a>",
		//"<iframe width=\"416\" height=\"311\" src=\"//www.youtube.com/embed/$2\" frameborder=\"0\" allowfullscreen></iframe>",
		$string
	);
}

//BBcode Function
function showBBcodes($text) {
	// BBcode array
	$find = array(
		'~\[b\](.*?)\[/b\]~s',
		'~\[i\](.*?)\[/i\]~s',
		'~\[u\](.*?)\[/u\]~s',
		'~\[quote\](.*?)\[/quote\]~s',
		'~\[size=(.*?)\](.*?)\[/size\]~s',
		'~\[color=(.*?)\](.*?)\[/color\]~s'
		//'~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
		//'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
	);
	// HTML tags to replace BBcode
	$replace = array(
		'<b>$1</b>',
		'<i>$1</i>',
		'<span style="text-decoration:underline;">$1</span>',
		'<pre>$1</'.'pre>',
		'<span style="font-size:$1px;">$2</span>',
		'<span style="color:$1;">$2</span>'
		//'<a href="$1">$1</a>',
		//'<img src="$1" alt="" />'
	);
	// Replacing the BBcodes with corresponding HTML tags
	return preg_replace($find,$replace,$text);
}

//Function for getting site options

function optionvalue($name) {
global $conn;	
$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='$name'");

if($row = mysqli_fetch_assoc($sql)) {
echo xss($row['option_value']);
}

}

if (isset($_COOKIE['lang'])) {
    if ($_COOKIE['lang'] == 'srb') {
        require('lang/srb.php');
    }
    elseif($_COOKIE['lang'] == 'eng') {
        require('lang/en.php');
    }
}
elseif(isset($_SESSION['user'])) {
    //check which one is selected, if selected
    $sql = $conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
    $get = mysqli_fetch_array($sql);
    if ($get['lang'] == "srb") {
        setcookie("lang", "srb", time() + (10 * 365 * 24 * 60 * 60));
        require('lang/srb.php');
    }
    elseif($get['lang'] == "eng") {
        setcookie("lang", "eng", time() + (10 * 365 * 24 * 60 * 60));
        require('lang/en.php');
    } else {
		require('lang/en.php');
	}
} else {
	require('lang/en.php');
}
 
 //if user banned
if( isset($_SESSION['user']) ) { 
	$sql=$conn->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$ban=mysqli_fetch_array($sql);	 
if( $ban['banned']=="1" ) {
	setcookie("banned", "1", time() + (10 * 365 * 24 * 60 * 60));
	header("Location: logout.php?logout");
	exit;
 } elseif( $ban['banned']=="0" ) {
	setcookie("banned", "0", time() + (10 * 365 * 24 * 60 * 60)); 
 }
 
 //if user kicked
if( $ban['kicked']=="1" ) {
	setcookie("kick", "1", time() + (10 * 365 * 24 * 60 * 60));
	$sql = "UPDATE users SET kicked='0' WHERE userId='".$_SESSION['user']."'";
	$conn->query($sql);	 
	header("Location: logout.php?logout");
	exit;
 } elseif( $ban['kicked']=="0" ) {
	setcookie("kick", "0", time() + (10 * 365 * 24 * 60 * 60));
 }
 }