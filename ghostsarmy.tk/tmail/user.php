<?php
require_once './functions.php';
require_once './config.php';
session_start();
error_reporting(E_ALL);
if(isset($_GET['user'])) {
    $address = $_GET['user'];
    $address = strtolower($address);
    $emailParts = explode("@",$address);
    if(isset($emailParts[1])) {
        $domain = $emailParts[1];
    } else {
        $domain = null;
    }
    $address = preg_replace('/@.*$/', "", $address);  
    $address = preg_replace('/[^A-Za-z0-9_.+-]/', "", $address); 
    $domain = preg_replace('/[^A-Za-z0-9_.+-]/', "", $domain);
    if($address == null || $address == "") {   
        $address = generateRandomWord()."@".generateRandomDomain($config['domains']);
    } else {
        if($domain == null || $domain == "") {
            $address = $address."@".generateRandomDomain($config['domains']);
        } else {
            if(in_array($domain, $config['domains'])) {
                $address = $address."@".$domain;
            } else {
                $address = $address."@".generateRandomDomain($config['domains']);
            }
        }
    }
} else {
    $address = generateRandomWord()."@".generateRandomDomain($config['domains']);
}
$_SESSION['address'] = $address;
echo $address; 
?>