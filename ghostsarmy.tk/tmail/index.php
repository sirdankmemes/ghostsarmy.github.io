<?php
require_once './config.php';
require_once './options.php';
error_reporting(E_ALL);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $config['title']; ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="core/signals.js"></script>
    <script src="core/hasher.min.js"></script> 
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <audio id="notifyUserSound" src="sound.mp3" preload="auto"></audio>
    <div class="container">
        <div id="generateID" align="center">
            <input class="setEmail" type="text" name="email" placeholder="Set Email ID"><span class="at">@</span>
            <select class="setDomain" name="domain">
                <?php
                foreach ($config['domains'] as $value) {
                    ?><option value="@<?php echo $value; ?>"><?php echo $value; ?></option><?php
                }
                ?>
            </select>
            <a style="color: #000;" data-placement="right" data-toggle="tooltip" title="Set Email ID" href="#" onclick="setNewID()">
                <span class="glyphicon glyphicon-send icon"></span>
            </a>
            <div style="font-size: 18px;">OR</div>
            <div class="breakicon">
                <a style="color: #000;" data-placement="bottom" data-toggle="tooltip" title="Generate a Random ID" href="#" onclick="generateRandomID()">
                    <span class="glyphicon glyphicon-random icon"></span>
                </a>
            </div>
        </div>
        <div id="createline" class="title">Hold tight! We are creating your MailBox :)</div>
        <div id="createdline" class="title">Your MailBox <strong><span onclick="copyToClipboard('#address')" id="address" data-toggle="tooltip" title="Click to copy email id"></span></strong> is set to receive mails</div>
        <div id="data">
        </div>
        <div class="message">
            Emails will appear here Automatically (Refreshing in <span id="timer"></span> Seconds)<br><br>
            <a style="color: #000; font-size: 24px;" data-placement="bottom" data-toggle="tooltip" title="Get New ID" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>">
              <span class="glyphicon glyphicon-random"></span>
            </a>
            <br><br>
            <?php echo $option['ads']; ?>
        </div>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html> 