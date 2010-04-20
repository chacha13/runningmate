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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="css/runningmate.css" />
	<script type="text/javascript" src="js/jquery_menu.js"></script>
		<script type="text/javascript" src="js/hover_menu.js"></script>	
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Runningmate / Sign Up</title>
		<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
		<link rel="stylesheet" href="css/template.css" type="text/css" media="screen" title="no title" charset="utf-8" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
		<script src="js/jquery.validationEngine.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="css/hover_menu.css" />
		
		
		<script>	
		$(document).ready(function() {
			// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
			
			$("#formID").validationEngine()
			
			
			//$.validationEngine.loadValidation("#date")
			//alert($("#formID").validationEngine({returnIsValid:true}))
			//$.validationEngine.buildPrompt("#date","This is an example","error")	 		 // Exterior prompt build example								 // input prompt close example
			//$.validationEngine.closePrompt(".formError",true) 							// CLOSE ALL OPEN PROMPTS
		});
		
		// JUST AN EXAMPLE OF VALIDATIN CUSTOM FUNCTIONS : funcCall[validate2fields]
		function validate2fields(){
			if($("#firstname").val() =="" || $("#lastname").val() == ""){
				return true;
			}else{
				return false;
			}
		}
	</script>	
<style type="text/css">
input.buttons{
color: #fff;
text-decoration: underline;
background-color: #df560a;
padding: 4px; 
border: 0;
font-size: 9pt;
margin-right: 40px;
height: 25px;
}

input {
	height: 18px;
	padding: 3px 0 3px 5px;
	border: none;
	color: #819ca5;
	background-color: #fcefe8;
	
}

.yay, .oops     {font-size:.8em;text-align:center;padding:10px;color:#fff;font-weight:700;}
.yay            {background:#090;}
.oops           {background:#f30;}
div.error       {font-size:.8em;font-weight:700;padding:5px 0 0;color:#f30;margin:0 0 0 90px;}
</style>

<script type= "text/javascript">

var RecaptchaOptions = {
theme: 'custom',
lang: 'en',
custom_theme_widget: 'recaptcha_widget'
};

</script>
</head>

<body id="bodyInit">

<div id="header-div"> 
  <div id="header-center"> 
    <div id="header-search"> 
      <div style="float:right;"> <input class="buttons" type="submit" value="Search Runner"/>
      </div>
      <div style="float:right;  padding-right: 10px;"> 
        <input name="q" type="text" style="background: #fff;width: 160px;height: 18px;padding: 3px 0 3px 5px;border: none;color: #000000;" />
      </div>
    </div>
  </div>
</div>

<div id="content-menu"> 
  <div id="page-wrap"> 
    <div id="home-button" class="button"> <a href="index.php"><img src="images/menu_home.gif" alt="Home" width="66" height="11" class="button" border="none"/></a> 
    </div>
    <div id="connect-button" class="button"> <a href="login.php"><img src="images/menu_connect.gif" alt="Be a Runningmate!" width="88" height="11" border="none" class="button"></a> 
    </div>
    <div id="races-button" class="button" style="position:relative;"> <a href="races.php"><img src="images/menu_races.gif" alt="See your recent races." width="50" height="11" border="none" class="button"></a> 
    </div>

    <div class="clear"></div>
  </div>
</div>
  
	
<div id="content-profile-holder" style="height: auto; overflow:auto;"> 
  <div style="height:20px; position:relative;"></div>
  <div id="register-holder"> 
    <!- ---- LOGIN SA LEFT----- ->
    <div id="register-image"> <img src="images/register.gif" width="287" height="190" /> 
    </div>
    <!- ---- END LOGIN SA LEFT----- ->
    <div id="register-fields"> <img src="images/register-header.gif" /> 
      <!- NOTE: I-ON ITONG DIV NA TO KPAG MAY ERROR, just set the display to block ->
      <div id="register-error" style="display: block;"> Fill all the required 
        fields below. </div>
      <!- ----SPACER SA TAAS----- ->
      <div style="height:18px; position:relative;"></div>
      <!- Andito na ung lahat ng mga fields ->
      <form id="formID" class="formular" method="post" action="register.php">
      <table width="100%" border="0" cellspacing="5" cellpadding="2">
        <tr> 
          <td width="30%" valign="middle" align="right">First Name</td>
          <td width="5%">&nbsp;</td>
          <td width="50%"><input value="" class="validate[required,custom[onlyLetter],length[0,100],funcCall[validate2fields]] text-input" name="firstname" id="firstname" type="text" style="width:130px;"/> 
            <strong>*</strong></td>
          <td width="5%"></td>
        </tr>
        <tr> 
          <td width="30%" valign="middle" align="right">Last Name</td>
          <td width="5%">&nbsp;</td>
          <td width="50%" valign="top"><input name="lastname" id="lastname" class="validate[required,custom[onlyLetter],length[0,100],funcCall[validate2fields]] text-input" type="text" style="width:130px;"/> 
            <strong>*</strong></td>
          <td width="5%"></td>
        </tr>
        <tr> 
          <td width="30%" valign="middle" align="right">Email</td>
          <td width="5%">&nbsp;</td>
          <td width="53%"><input name="email" id="email" class="validate[required,custom[email]] text-input" type="text" style="width:180px;"/> 
            <strong>*</strong></td>
          <td width="1%"></td>
        </tr>
        <tr> 
          <td width="30%" valign="middle" align="right">&nbsp;</td>
          <td width="5%">&nbsp;</td>
          <td width="53%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="30%" valign="middle" align="right">Password</td>
          <td width="5%">&nbsp;</td>
          <td width="53%"><input name="password" id="password" class="validate[required,length[6,11]] text-input" type="password" style="width:180px;"/> 
            <strong>*</strong></td>
          <td width="1%"></td>
        </tr>
        <tr> 
          <td width="30%" valign="middle" align="right">Confirm Password</td>
          <td width="5%">&nbsp;</td>
          <td width="53%"><input name="password2" id="password2" class="validate[required,confirm[password]] text-input" type="password" style="width:180px;"/> 
            <strong>*</strong></td>
          <td width="1%"></td>
        </tr>
      
      </table>
      <!- FIELDS END ->
      <!- ----SPACER SA TAAS----- ->
      <div style="height:30px; position:relative;"></div>
	  	  
  	  <!- ETO NA UNG SA CAPCHA ->
  	  <div id="recaptcha_widget" style="display: none;">
<div id="recaptcha_image"></div>
<div class="recaptcha_only_if_incorrect_sol" style="color: red;">Incorrect please try again</div>
<span class="recaptcha_only_if_image">Enter the words above</span>
<span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="recaptcha_response_field" name="recaptcha_response_field" type="text">
<br />
<strong style="font-size: 10px;"><a href="javascript:Recaptcha.reload();">Get Another Captcha</a></strong>

<!--div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div><br />
<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div><br /><br />
<div><a href="javascript:Recaptcha.showhelp()">Help</a><br />
</div-->
<script type="text/javascript" src="http://api.recaptcha.net/challenge?k=<?php echo $publickey;?>&lang=en"></script>

<noscript>
<iframe src="http://api.recaptcha.net/noscript?k=<?php echo $publickey;?>&lang=en" height="200" width="500" frameborder="0"></iframe>
<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
<input type="'hidden'" name="'recaptcha_response_field'" value="'manual_challenge'">
</noscript>

</div>
	  
	  
	  
      <!- ----SPACER SA TAAS----- ->
      <div style="height:30px; position:relative;"></div>
      
      <input name="submit" class="buttons" type="submit" value="Register!"/>

        </form>
    </div>
  </div>
  <!- ----END HOLDER NG LOGIN WINDOW----- ->
</div>
	<!- -----END NG FRONT CONTENT HOLDER------- ->


</div>






  
	<!- ----------------------------------------------------------------------------------- ->
	<!- ----------------- FOOTER  --------------- ->
	<div style="height: 15px;"></div>
	
<div id="footer-holder"> 
  <div style="height: 20px;"></div>
  <h1>www.runningmate.ph</h1>
  <div style="height: 20px;"></div>
  <div style="height: 50px; width: 700px; margin: auto;"> runningmate.ph is positioning 
    itself to be the most comprehensive web portal that is decided to the sport 
    of running here in the philippines. It will help promote the sports via our 
    very own social network. </div>
  <div style="position: relative;"> <a href="Home.htm">Home</a> | <a href="Login.htm">Connect</a> 
    | <a href="#">Races</a></div>
  <div style="height: 10px; width: 700px; margin: auto;font-size: 10px;"> All 
    Rights Reserved. Copyrights 2010. Runningmate Team. </div>
</div>
	<!- ----------------- UNTIL HERE FOOTER  --------------- ->





</body>
</html>