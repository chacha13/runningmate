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
ob_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<?

// Below lines are to display file name, temp name and file type , you can use them for testing your script only//////
echo "File Name: ".$_FILES[userfile][name]."<br>";
echo "tmp name: ".$_FILES[userfile][tmp_name]."<br>";
echo "File Type: ".$_FILES[userfile][type]."<br>";
echo "<br><br>";
///////////////////////////////////////////////////////////////////////////
$add="uploads/".$_FILES[userfile][name]; // the path with the file name where the file will be stored, upload is the directory name. 
$tsrc="thumbs/".$_FILES[userfile][name];
//echo $add;
if(move_uploaded_file ($_FILES[userfile][tmp_name],$add)){
$filename = $_FILES[userfile][name];
$filetype = $_FILES[userfile][type];
$insupd = "INSERT INTO photos(user_id, filename, type, thumbnail, caption, created_at) VALUES ('$user_id','$filename', '$filetype', '$tsrc', '$_POST[caption]', '$datevar')";
$updresult = mysql_query($insupd) or die("Invalid query: " . mysql_error());
echo "INSERT INTO photos(user_id, filename, type, thumbnail, caption, created_at) VALUES ('$user_id','$filename', '$filetype', '$thumbnail', '$_POST[caption]', '$datevar')";

chmod("$add",0777);

}else{echo "Failed to upload file Contact Site admin to fix the problem";
exit;}

///////// Start the thumbnail generation//////////////
$n_width=50;          // Fix the width of the thumb nail images
$n_height=50;         // Fix the height of the thumb nail imaage

$tsrc="thumbs/".$_FILES[userfile][name];   // Path where thumb nail image will be stored
//echo $tsrc;
if (!($_FILES[userfile][type] =="image/pjpeg" OR $_FILES[userfile][type]=="image/gif" || $_FILES[userfile][type] =="image/jpeg")){echo "Your uploaded file must be of JPG or GIF. Other file types are not allowed<BR>";
exit;}
/////////////////////////////////////////////// Starting of GIF thumb nail creation///////////
if ($_FILES[userfile][type]=="image/gif")
{
$im=ImageCreateFromGIF($add);
$width=ImageSx($im);              // Original picture width is stored
$height=ImageSy($im);                  // Original picture height is stored
$newimage=imagecreatetruecolor($n_width,$n_height);
imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
if (function_exists("imagegif")) {
header("Location: upload_photo.php");
ImageGIF($newimage,$tsrc);
}
elseif (function_exists("imagejpeg")) {
Header("Content-type: image/jpeg");
ImageJPEG($newimage,$tsrc);
}
chmod("$tsrc",0777);
}////////// end of gif file thumb nail creation//////////

////////////// starting of JPG thumb nail creation//////////
if($_FILES[userfile][type]=="image/pjpeg"){
$im=ImageCreateFromJPEG($add); 
$width=ImageSx($im);              // Original picture width is stored
$height=ImageSy($im);             // Original picture height is stored
$newimage=imagecreatetruecolor($n_width,$n_height);                 
imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
ImageJpeg($newimage,$tsrc);
chmod("$tsrc",0777);
}
////////////////  End of JPG thumb nail creation //////////
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
<? ob_flush(); ?>