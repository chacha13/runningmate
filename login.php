<?php
session_start();

$connection = mysql_connect ("localhost", "agilityp", "P@ssword1");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);


$user_id = $_SESSION['user_id'];
include_once("functions.php");
if($_POST['submit']) {
	$password = encode5t($_POST['password']);
	$result_login = mysql_query("SELECT * FROM users WHERE email = '$_POST[email]' AND password = '$password' AND activation_code = 1", $connection);
	$myrow_login = mysql_fetch_array($result_login);
	$num = mysql_num_rows($result_login);
	$_SESSION['user_id'] = $myrow_login[0];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Runningmate / Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-
8859-1" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery_menu.js"></script>
<script type="text/javascript" src="js/hover_menu.js"></script>
<link rel="stylesheet" type="text/css" href="css/hover_menu.css" />
<link rel="stylesheet" type="text/css" href="css/runningmate.css" />
<style type="text/css">
#login-holder{
	padding:0px;
	position: relative;
	border: 0px solid black;
	width: 600px;
	height: auto;
	margin-top: 125px;
	margin-right: auto;
	margin-left: auto;
	overflow: auto;
}

#login-left{

	float: left; 
	width: 284px; 
	height: auto;
	position:relative; 
	padding: 0px 0px 0px 0px;
	
}

#login-info{
	width: 284px; 
	height: auto; 
	text-align: right; 
	line-height:30px; 
	margin: 0px; 
	padding:0px;
}

#login-button-div{

	width: 284px; 
	position:relative; 
	margin: 10px 0px 0px 0px; 
	padding:0px; 
	height:auto; 
	overflow: auto;
		
}

#login-image{
	float: left; 
	width: 223px; 
	height: 72px; 
	position:relative; 
	margin: 30px 0px 0px 10px; 
	padding: 0px 0px 0px 0px;
}


input.buttons{
color: #fff;
text-decoration: underline;
background-color: #df560a;
padding: 4px; 
border: 0;
font-size: 9pt;
height: 25px;
}
.notice {
	color: #333;
	background:#fff9d7;
	border: 1px solid #e2c822;
}


.error {
	color: #333;
	background:#ffebe8;
	border: 1px solid #dd3c10;
}

</style>
</head>
<body id="bodyInit">
<!- -------------------------------------------------HEADER START------------------------------------------------ ->
<!- ------------------------------------------------------------------------------------------------------------- ->

<div id="header-div"> 
  <div id="header-center"> 
    <!- ---------------SEARCH----------------- ->
    <div id="header-search"> 
      <div id="header-button" style="float:right;"> <a href="#"> Search Runner</a> 
      </div>
      <div style="float:right;  padding-right: 10px;"> 
        <input name="" id="header-text" type="text" />
      </div>
    </div>
    <!- ---------------SEARCH----------------- ->
  </div>
</div>
<!- -------------------------------------------------HEADER END--------------------------------------------------- ->
<!- ------------------------------------------------------------------------------------------------------------- ->

<!- -----START NG MENU HOLDER------- ->
<div id="content-menu"> 
  <div id="page-wrap"> 
    <div id="home-button" class="button"> <a href="Home.htm"><img src="images/menu_home.gif" alt="Home" width="66" height="11" class="button" border="none"/></a> 
    </div>
    <div id="connect-button" class="button"> <a href="Login.htm"><img src="images/menu_connect.gif" alt="Be a Runningmate!" width="88" height="11" border="none" class="button"></a> 
    </div>
    <div id="races-button" class="button" style="position:relative;"> <a href="#"><img src="images/menu_races.gif" alt="See your recent races." width="50" height="11" border="none" class="button"></a> 
    </div>
    <div id="races-button" class="button" style="float: right; position:relative;"> 
      <a href="#"><img src="images/logout.gif" alt="Logout your account" width="37" height="14" border="none" class="button"></a> 
    </div>
    <div class="clear"></div>
  </div>
</div>
<!- -----END NG MENU HOLDER------- ->
   
  <!- ----------------------------------------------------------------------------------------------------- ->
  <!- -----START NG FRONT CONTENT HOLDER------- ->

<div id="content-profile-holder" style="height: 550px;"> 
   <form name="login" id="login" method="post" action="login.php">
	         <?php
          	 if($_POST['submit']) {
		  	if($_POST['email'] != '' && $_POST['password'] != '')
			{
				if($num > 0)
				{
					echo '<script>';
					echo 'document.login.action = "index.php";';
					echo 'document.login.target = "_parent";';
				 	echo 'document.login.submit();';							 
					echo '</script>';  
				}
				else
				{
					echo "<div class=error>Wrong email/password combination</div>"; 	
				}
			}
		}
			
		?>
  <div style="height:20px; position:relative;"></div>
  <!- ----SPACER SA TAAS----- ->
  <!- ----HOLDER NG LOGIN WINDOW----- ->
  <div id="login-holder"> 
    <!- ---- LOGIN SA LEFT----- ->
   

    <div id="login-left"> 
      <div id="login-info"> 
        <img src="images/login-line.gif" /> Login to your runningmate account 
        <p>Email Address &nbsp; 
          <input name="email" id="login-text" type="text" style="width: 145px;"/>
        </p>
       Password &nbsp; 
        <input name="password" id="login-text" type="password" style="width: 145px;"/></p> 
        <div id="miniText" style="height: 20px;">Forgot your Password? <a href="forgot_password.php" >Click 
          Here</a></div>
      </div>
      <div id="login-button-div"> 
        <div id="header-button" style="height: 22px; padding:7px 0px 0px 0px; margin: 0px; text-align: center; width:77px; float:right; position:relative;"> 
        	<input type="submit" name="submit" value="Sign In" class="buttons" />
        </div>
        <? //<div id="header-button" style="height: 22px; padding:7px 0px 0px 0px; margin: 0px; margin-right: 3px; text-align: center; width:77px; float:right; position:relative;"> <a href="#"> Login</a> </div> ?>
      </div>
    </div>
    </form>
    <!- ---- END LOGIN SA LEFT----- ->
    <div id="login-image"> 
      <img src="images/login.gif" /> </div>
  </div>
  <!- ----END HOLDER NG LOGIN WINDOW----- ->
</div>
<!- -----END NG FRONT CONTENT HOLDER------- ->









  
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
  <div style="position: relative;"> <a href="index.php">Home</a> | <a href="login.php">Connect</a> 
    | <a href="#">Races</a></div>
  <div style="height: 10px; width: 700px; margin: auto;font-size: 10px;"> All 
    Rights Reserved. Copyrights 2010. Runningmate Team. </div>
</div>
	<!- ----------------- UNTIL HERE FOOTER  --------------- ->





</body>
</html>