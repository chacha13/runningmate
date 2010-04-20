<?php
session_start();
$connection = mysql_connect ("localhost", "agilityp", "P@ssword1");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

require_once('recaptcha/recaptchalib.php');

/* Get the keys at http://recaptcha.net/api/getkey */
$publickey = '6LfmuQsAAAAAABvxwRAZcslKCG_9_4HFFwJX3Si7';
$privatekey = '6LfmuQsAAAAAAKyWuonzvtWRMAxXHSEkpze91N3H';

include_once("functions.php");
	   $result_check_email = mysql_query("SELECT * FROM users WHERE email = '$_POST[email]'", $connection);
	   $myrow_check_email = mysql_fetch_array($result_check_email);
	   $num_email = mysql_num_rows($result_check_email);
	   
	   $lastname = stripslashes($_POST['lastname']);
	   $firstname = stripslashes($_POST['firstname']);
	   $email = $_POST['email'];
	   $password = encode5t($_POST['password']);
	   $act_code = mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
	   $datevar = date("Y-m-d H:i:s");
	   
		   
	   /*if($_POST['submit']) {
	   	   $response = recaptcha_check_answer($privatekey,
		   $_SERVER["REMOTE_ADDR"],
		   $_POST["recaptcha_challenge_field"],
		   $_POST["recaptcha_response_field"]);
		   $error_count = 0;
	 
	   	   if($num_email == 1) {
		   		echo "<script language=\"JavaScript\">\n";
				echo "alert(dhhhhhhhdhdh);\n";
				echo "</script>"; 
		   }
		   if($lastname == ""){
				echo "<script language=\"JavaScript\">\n";
				echo "alert(dhhhhhhhdhdh);\n";
				echo "</script>";
		   }
		   if($firstname == "") {
				$error .= "Firstname can't be empty";
		   }
		   if($email == ""){
				$error .= "E-mail can't be blank";
		   }
		   if(strlen($_POST['password']) < 6 || strlen($_POST['password']) > 15)
		   {
				$error .= "Password could not be less than 6 and could not be greater than 15";
		   }
		   if($_POST['password'] <> $_POST['password2'])
		   {
				$error = "Passwords did not match";
		   }
		   if($error == ""){
		   		if($response->is_valid){
					$insert_sql = "INSERT INTO users(firstname, lastname, email, password, activation_code, created_at)VALUES('$firstname', '$lastname', '$email', '$password', '$act_code', '$datevar')";
					$insresult = mysql_query($insert_sql) or die("Invalid query:" . mysql_error());
					$insnumrows = mysql_affected_rows();
					
				  	require_once 'Swift/lib/swift_required.php';
					$transport = Swift_SmtpTransport::newInstance('mail.agilitypilipinas.com', 26)
					  ->setUsername('no-reply@agilitypilipinas.com')
					  ->setPassword('P@ssword1');
					$mailer = Swift_Mailer::newInstance($transport);
					$message = Swift_Message::newInstance('Runningmate Account Activation')
					  ->setFrom(array('no-reply@agilitypilipinas.com' => 'Runningmate'))
					  ->setTo(array($email, $email => $firstname))
					  ->setBody("Congratulations $firstname $lastname<br /><br /> This is a test email :) Good or bad? <br /><br />To complete your registration click this link http://test.agilitypilipinas.com/activate.php?aid=$act_code <br /><br /> Best regards,<br /> The Runningmate Team :D", "text/html");
					$result = $mailer->send($message);
				   }
				   else{
				   	echo "Type the image correctly.";
				   }
				
			}
	   }*/
?>
<?php

/* RECEIVE VALUE */
$validateValue=$_POST['validateValue'];
$validateId=$_POST['validateId'];
$validateError=$_POST['validateError'];







	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$arrayToJs[1] = $validateError;

if($validateValue =="karnius"){		// validate??
	$arrayToJs[2] = "true";			// RETURN TRUE
	echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';			// RETURN ARRAY WITH success
}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[2] = "false";
			echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';		// RETURN ARRAY WITH ERROR
		}
	}
	
}

?>