<?php
session_start();

$connection = mysql_connect ("localhost", "", "");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

$aid = $_GET['aid'];

if($aid){
$upd_sql = "UPDATE users SET activation_code = 1 WHERE activation_code = '$aid'";
$upd_rows = mysql_query($upd_sql);
$upd_suc = mysql_affected_rows();
}
?>
<html>
<head>
<title>Runningmate / Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
<script src="javascripts/button.js" type="text/javascript"></script>
</head>

<body>
</div>
<div id="bg">
    <div id="wrapper">

      
    <div class="top"> <a href="#">Home</a> <a href="login.php">Login</a> 
      <div class="clear"></div>

</div>


      <div>  

        <div class="left" style="width: 450px; padding-right: 20px;">
      
        <h1>Account Activation</h1>
<? if($upd_suc > 0)
{
echo "You have successfully activated your account. You can now <a href=login.php>login</a> to check out your profile. Vökuró!!!!";
}
?>
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