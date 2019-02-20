<?php
/*
 * Easy Mail is a free PHP mail script with basic text captcha to limit
 * SPAM. The subject can be auto-set by calling the script with a query
 * string, e.g. script.php?Test_Subject
 *
 * github.com/phhpro/easy-mail
 */


/*
 * document root
 * script folder
 * mail account
 * success flag
 */
$eml_root = $_SERVER['DOCUMENT_ROOT'];
$eml_fold = "/mail/";
$eml_acnt = "info";
$eml_flag = "OK";


/*
 ***********************************************************************
 *                                               NO NEED TO EDIT BELOW *
 ***********************************************************************
 */


//** link protocol
if (isset ($_SERVER['HTTPS']) && "on" === $_SERVER['HTTPS']) {
  $eml_prot = "s";
} else {
  $eml_prot = "";
}

$eml_prot = "http" . $eml_prot . "://";

/*
 * captcha min
 * captcha max
 * captcha value 1
 * captcha value 2
 */
$eml_cmin = 1;
$eml_cmax = 9;
$eml_cone = mt_rand($eml_cmin, $eml_cmax);
$eml_ctwo = mt_rand($eml_cmin, $eml_cmax);

/*
 * build form action
 * link auto subject
 * build mail account
 * init status
 * script version
 */
$eml_fact = htmlentities($eml_prot . $_SERVER['HTTP_HOST'] . $eml_fold, ENT_QUOTES, "UTF-8");
$eml_asub = htmlentities($_SERVER['QUERY_STRING'], ENT_QUOTES, "UTF-8");
$eml_acnt = $eml_acnt . "@" . $_SERVER['HTTP_HOST'];
$eml_stat = "";
$eml_make = 20171025;

//** check auto subject
if (isset ($eml_asub)) {

  //** print success status and reset subject
  if ($eml_asub === $eml_flag) {
    $eml_stat = "Your message has been sent.<br/>Forgot something? Just send another.";
    $eml_subj = "";
  } else {
    //** escape whitespace
    $eml_subj = str_replace("%20", " ", $eml_asub);
  }
}

//** form submit
if (isset ($_POST['eml_post'])) {
  $eml_name = htmlentities($_POST['eml_name'], ENT_QUOTES, "UTF-8");
  $eml_mail = htmlentities($_POST['eml_mail'], ENT_QUOTES, "UTF-8");
  $eml_subj = htmlentities($_POST['eml_subj'], ENT_QUOTES, "UTF-8");
  $eml_text = htmlentities($_POST['eml_text'], ENT_QUOTES, "UTF-8");
  $eml_csum = (int) $_POST['eml_csum'];
  $eml_cone = (int) $_POST['eml_cone'];
  $eml_ctwo = (int) $_POST['eml_ctwo'];
  $eml_cval = (int) ($eml_cone+$eml_ctwo);
  $eml_uman = htmlentities($_POST['eml_uman'], ENT_QUOTES, "UTF-8");

  //** check values
  if ($eml_name === "") {
    $eml_stat = "Missing name!";
  } elseif (preg_match("/^[a-zA-Z]+$/", $eml_name) !== 1) {
    $eml_stat = "Invalid name!";
  } elseif ($eml_mail === "") {
    $eml_stat = "Missing mail!";
  } elseif (!filter_var($eml_mail, FILTER_VALIDATE_EMAIL)) {
    $eml_stat = "Invalid mail!";
  } elseif ($eml_subj === "") {
    $eml_stat = "Missing subject!";
  } elseif ($eml_text === "") {
    $eml_stat = "Missing text!";
  } elseif ($eml_csum === "") {
    $eml_stat = "Missing code!";
  } elseif ($eml_cval !== $eml_csum) {
    $eml_stat = "Invalid code!";
  } elseif ($eml_uman === "") {
    $eml_stat = "Didn't you just forget something?";
  } else {
    //** build message
    $eml_mtxt = "$eml_name ($eml_mail) regarding: $eml_subj\n\n$eml_text";
    $eml_head = "From: Easy Mail <$eml_acnt>\r\nReply-To: $eml_mail";

    //** check mail success
    if (mail($eml_acnt, $eml_subj, $eml_mtxt, $eml_head)) {
      header("Location: " . $_SERVER['SCRIPT_NAME'] . "?$eml_flag");
      exit;
    } else {
      $eml_stat = "Your message could not be sent!";
    }
  }

  //** reset captcha
  $eml_cone = mt_rand($eml_cmin, $eml_cmax);
  $eml_ctwo = mt_rand($eml_cmin, $eml_cmax);
}
