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
	   
		   
	   if($_POST['submit']) {
	   	   $response = recaptcha_check_answer($privatekey,
		   $_SERVER["REMOTE_ADDR"],
		   $_POST["recaptcha_challenge_field"],
		   $_POST["recaptcha_response_field"]);
		   $error_count = 0;
	 
	   	   if($num_email == 1) {
		   		$error = "This e-mail address is already registered to our site";
		   }
		   if($lastname == ""){
				$error .= "Lastname can't be empty";
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
	   }
?>
<html>
<head>
<title>Runningmate / Register</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
<script src="http://code.jquery.com/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.js" type="text/javascript"></script>
<script>
var RecaptchaOptions = {
   theme : 'white',
   tabindex : 2
};
</script>

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
      
<h1>Register to Runningmate</h1>

 <form name="form1" action="register.php" method="post">
         
          
       <? 

	   
	   if($insnumrows > 0){
	   			echo "We have sent an activation to your email address";
	   }

		  ?>
		  
           <div class="form_row"> 
            <label for="username"> Lastname</label>
            <input name="lastname" type="text" class="textfield" id="lastname" size="25" value="<? echo $_POST['lastname']; ?>"/>
          </div>
          <div class="form_row"> 
            <label for="username">Firstname</label>
            <input name="firstname" type="text" class="textfield" id="firstname" size="25" value="<? echo $_POST['firstname']; ?>"/>
          </div>
          <div class="form_row"> 
            <label for="password">E-mail Address</label>
            <input name="email" type="text" id="email" size="25" class="textfield" value="<? echo $_POST['email']; ?>">
          </div>
          <div class="form_row"> 
            <label for="password">Password</label>
            <input name="password" type="password" id="password" size="25" class="textfield">
          </div>
          <div class="form_row"> 
            <label for="password">Confirm Password</label>
            <input name="password2" type="password" id="password2" size="25" class="textfield">
          </div>
	  <div>
	  	<?php  echo recaptcha_get_html($publickey, $error); ?>
	  </div>
	   
          <div> 
            <input type="submit" name="submit" value="Register!" id="msgup" class="button" />
          </div>
         
        </form>
      </div>
	<script src="js/jquery.bar.js" type="text/javascript"></script>
	<script>
		$("#msgup").bar({
			color 			 : '#1E90FF',
			background_color : '#FFFFFF',
			removebutton     : false,
			message			 : '<? echo  $error; ?>',
			time			 : 4000
		});
		
		
		
		$("#msgdown").bar({
			color 			 : '#FF6600',
			background_color : '#FFFFCC',
			position		 : 'bottom',
			removebutton     : false,
			message			 : 'Your profile customization has been saved!',
			time			 : 4000
		});
		
		
		$("#msgupwithremove").bar({
			message			 : 'There was an error!'
		});
	</script> 	
        

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