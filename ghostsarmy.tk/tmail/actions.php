<?php
require_once './config.php';
require_once './core/PhpImap/__autoload.php';
require_once './options.php';
session_start();
error_reporting(E_ALL);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
if ( $action == "delete" ) {
    $mailbox = new PhpImap\Mailbox('{'.$config['host'].'/imap/ssl}INBOX', $config['user'], $config['pass'], __DIR__);
    $mailID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $mailID = preg_replace('/[^0-9.]+/', '', $mailID);
    $mail = $mailbox->getMail($mailID);
    $mailAddress = $mail->toString;
    if($mailAddress == $_SESSION['address']) {
        if($mailbox->deleteMail($mailID)) {
            echo "true";
        } else {
            echo "false";
        }
    } else {
        echo "UnAuthorized";
    }
} else if ( $action == "getUser" ) {
    echo $_SESSION['address'];
} else if ( $action == "download" ) {
    $mailbox = new PhpImap\Mailbox('{'.$config['host'].'/imap/ssl}INBOX', $config['user'], $config['pass'], __DIR__);
    $mailID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $mailID = preg_replace('/[^0-9.]+/', '', $mailID);
    $mail = $mailbox->getMail($mailID);
    $mailAddress = $mail->toString;
    if($mailAddress == $_SESSION['address']) {
        $filename = "downloads/".$_SESSION['address']."_".$mailID."_mail.eml";
        $mailbox->saveMail($mailID, $filename);
        echo "http://".$_SERVER['HTTP_HOST']."/".$filename;
    } else {
        echo "UnAuthorized";
    }
} else if ( $action == "refreshRate" ) {
    echo $option['refreshRate'];
}
