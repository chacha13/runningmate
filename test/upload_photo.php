<?php
session_start();
	if(!isset($_SESSION['user_id']))
	{
		echo '<script>';
		echo 'window.location.replace("login.php")';
		echo '</script>';
	}
$connection = mysql_connect ("localhost", "agilityp", "P@ssword1");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

$user_id = $_SESSION['user_id'];

/*if($_POST['submit'])
{
		if($_FILES['photofile']) 
		{ 
			if(move_uploaded_file($_FILES['photofile']['tmp_name'], "uploads/" . $_FILES['photofile']['name']))
			{ 
				  $filename = $_FILES['photofile']['name'];
				  $filetype = $_FILES['photofile']['type'];
				  $thumbnail = make_thumb($_FILES['photofile']['name'], 50);
				  $datevar = date("Y-m-d H:i:s");
				  $insupd = "INSERT INTO photos(user_id, filename, type, thumbnail, caption, created_at) VALUES ('$user_id','$filename', '$filetype', '$thumbnail', '$_POST[caption]', '$datevar')";
				  $updresult = mysql_query($insupd) or die("Invalid query: " . mysql_error());
				  $upd_suc = mysql_affected_rows();
			 }
		}
		
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="generator" content="WebMotionUK" />
	<title>Runningmate / Photo Upload</title>
	<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
</head>
<body>
</div>
<div id="bg">
    <div id="wrapper">

      
    <div class="top"> <a href="index.php">Home</a> <a href="profile.php">Profile</a> <a href="account.php">Account</a> <a href="upload_photo.php">Upload</a> <a href="logout.php">Logout</a>
      <div class="clear"></div>

</div>


      <div>  

        <div class="left" style="width: 450px; padding-right: 20px;">
      
<h1>Upload Photo</h1>

<form id="form1" name="form1" enctype="multipart/form-data" action="addimgck.php" method="post">


<div>
<label>Photo</label>
<input name="userfile" type="file" id="userfile" />
</div>

<div>
<label>Caption </label>
<textarea name="caption" id="caption"></textarea>
</div>

<div>
<input name="submit" type="submit" value="Upload It!" class="button">
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