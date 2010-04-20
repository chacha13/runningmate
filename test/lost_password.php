<?php
session_start();
$connection = mysql_connect ("localhost", "", "");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

if($_POST['submit']) {
	$result_login = mysql_query("SELECT * FROM users WHERE email = '$_POST[email]'", $connection);
	$myrow_login = mysql_fetch_array($result_login);
	$num = mysql_num_rows($result_login);
}

require_once('recaptcha/recaptchalib.php');

$publickey = '6LeUagsAAAAAAFhlDKSm3Ccktj97L3gI4aNyQlmZ';
$privatekey = '6LeUagsAAAAAAEbfbQ05Ue2KdkkIt0AuiCp_zEDf';

include_once("functions.php");
?>
<html>
<head>
<title>Runningmate / Lost Password</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
<script src="javascripts/button.js" type="text/javascript"></script>
</head>

<body>
</div>
<div id="bg">
    <div id="wrapper">

      
    <div class="top"> <a href="login.php">Login</a> <a href="register.php">Signup</a> 
      <div class="clear"></div>

</div>


      <div>  

        <div class="left" style="width: 450px; padding-right: 20px;">
      
<h1>Lost Password</h1>

<form name="form1" action="" method="post">

<?

if($mail == 1){
	echo "We have sent your password to your email address :)";
}

$password = decode5t($myrow_login[4]);

if($_POST['submit']){

$response = recaptcha_check_answer($privatekey,
		   $_SERVER["REMOTE_ADDR"],
		   $_POST["recaptcha_challenge_field"],
		   $_POST["recaptcha_response_field"]);
$email = $_POST['email'];

if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
  if($num == 1){
  				require "Mail.php";

				   // Identify the sender, recipient, mail subject, and body
				   $sender    = "Runningmate <webmaster@runningmate.ph>";
				   $recipient = $_POST['email'];
				   $subject   = "Lost Password";
				   $body      = "We are informed that you want your password to be retrieved. . .\n\n";
				   $body     .= "------------------------------\n";
				   $body     .= "Your password: $password\n\n";
				   $body     .= "Congratulations! ! ! XD";
				
				   // Identify the mail server, username, password, and port
				   $server   = "ssl://mail.runningmate.ph";
				   $username = "webmaster@runningmate.ph";
				   $password = "P@ssword1";
				   $port     = "465";
				
				   // Set up the mail headers
				   $headers = array(
				      "From"    => $sender,
				      "To"      => $recipient,
				      "Subject" => $subject
				   );
				
				   // Configure the mailer mechanism
				   $smtp = Mail::factory("smtp",
				      array(
				        "host"     => $server,
				        "username" => $username,
				        "password" => $password,
				        "auth"     => true,
				        "port"     => 465
				      )
				   );
				
				   // Send the message
				   $mail = $smtp->send($recipient, $headers, $body);
				
				   if (PEAR::isError($mail)) {
				      echo ($mail->getMessage());
				   }
				
  }
  else {
  				echo "That email address is not yet registered to our site :|";
  }
}
else 
{
  echo "Invalid email address.";
}

}


?>
<div>
 <div>
	  	<?php  echo recaptcha_get_html($publickey, $error); ?>
	  </div>
<label for="email">E-mail Address</label>
<input type="text" name="email" size="25" />

</div>

<div>
<input name="submit" type="submit" value="Send" class="button">
</div>
 </form>
      </div>

        

          <div class="clear"></div>
        </div>

        <div id="footer">
  <p>
This app was built with <strong>27</strong> man hours by <a href="http://2amiserv.ph" target="_blank">2AM Interactive</a>
</p>
  <p>
<a href="http://tangkilikan.com.ph" target="_blank">Tangkilikan.com.ph</a> | <a href="http://runningmate.ph" target="_blank">Runningmate.ph</a>

</p>
</div>

      </div>
    </div>
</body>
</html>