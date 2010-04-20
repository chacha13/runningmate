<?php
session_start();
$connection = mysql_connect ("localhost", "", "");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

include_once("functions.php");
if($_POST['submit']) {

	$password = encode5t($_POST['password']);
	$result_login = mysql_query("SELECT * FROM users WHERE email = '$_POST[email]' AND password = '$password' AND activation_code = 1", $connection);
	$myrow_login = mysql_fetch_array($result_login);
	$num = mysql_num_rows($result_login);
	$_SESSION['user_id'] = $myrow_login[0];
	$_SESSION['full_name'] = $myrow_login[1].' '.$myrow_login[2];
}

?>
<html>
<head>
<title>Runningmate / Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
</head>

<body>

<div id="bg">
    <div id="wrapper">

      
    <div class="top"> <a href="login.php">Login</a> <a href="register.php">Signup</a> 
      <div class="clear"></div>

</div>


      <div>  

        <div class="left" style="width: 450px; padding-right: 20px;">
      
<h1>Login to Runningmate</h1>

<form name="form1" action="login.php" method="post">

        <?php
		  	if($_POST['email'] != '' && $_POST['password'] != '')
			{
				if($num > 0)
				{
					echo '<script>';
					echo 'document.form1.action = "index.php";';
					echo 'document.form1.target = "_parent";';
				 	echo 'document.form1.submit();';							 
					echo '</script>';
				}
				else if($_POST['email'] == $myrow_login['email'] && '$password' == $myrow_login['password'] && $myrow_login['activation_code'] !=''){
					echo '<div class="notice">This account is not yet activated.</div>';
				}
				else
				{
					echo '<div class="error">Wrong username/password combination</div>';	
				}
			}
			
		  ?>
<div>
<label>E-mail Address</label>
<input type="text" name="email" size="25" />
</div>

<div>
<label>Password</label>
<input type="password" name="password" size="25" />
</div>

<div>
<input name="submit" type="submit" value="Login!" class="button">
</div>
 </form>

<a href="lost_password.php">Forgot your password?</a>
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