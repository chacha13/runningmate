<?php
session_start();
	if(!isset($_SESSION['user_id']))
	{
		echo '<script>';
		echo 'window.location.replace("login.php")';
		echo '</script>';
	}
$connection = mysql_connect ("localhost", "", "");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

$user_id = $_SESSION['user_id'];

$result_user = mysql_query("SELECT * FROM users WHERE id = '$user_id'", $connection);
$myrow_user = mysql_fetch_array($result_user);

$full_name = $myrow_user[1].' '.$myrow_user[2];
//echo $full_name;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Runningmate / Home</title>
<script type="text/javascript" src="javascripts/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
<style type="text/css">
li {
margin: 0px;
        padding-left:5px;
	width: 400px;
	list-style:none;
        color: #444;
	border-bottom: 1px solid #d8dfea;
	line-height: 20px;
	font-size:11px;
	font-weight: normal;
	display:block;
        /*color: #3B5998;*/
}
li:hover  {
	color: #FFF;
        background-color: #dea9a8;
	/*background-color:#3B5998;*/
}
</style>

</head>

<body>
<div id="bg">
    <div id="wrapper">

      
    <div class="top"> <a href="index.php">Home</a> <a href="profile.php">Profile</a> <a href="account.php">Account</a> <a href="logout.php">Logout</a>
      <div class="clear"></div>
 
      </div>
      <div>  
<div class="left front_column_r">
<form name="search" action="search.php" method="get">
	<div id="search_box">
	      Search Runners: <input id="q" name="q" type="text">
	      <input type="submit" name="submit" value="Search" class="button" />
	      <? //<a href="javascript:void(0);" id="search_x" onclick="jq('#q').val('');" style="margin-left: -15px; z-index: 1000;">x</a> ?>
	</div>
</form>
</div>

	<div class="left" style="width: 450px; padding-right: 20px;">
		<h1>Account Settings</h1>
		Email Address: <? echo $myrow_user['email'];?>
	    	
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