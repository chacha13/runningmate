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

$stringIp = $_SERVER['REMOTE_ADDR'];
$intIp = ip2long($stringIp);


$upd = mysql_query("UPDATE users SET ip = '$intIp' WHERE id = '$user_id'", $connection);
include_once("functions.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Runningmate / Home</title>
<script type="text/javascript" src="javascripts/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
<link type="text/css" rel="stylesheet" media="all" href="stylesheets/chat.css" />
<link type="text/css" rel="stylesheet" media="all" href="stylesheets/etc.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>



<script type="text/javascript">
$(document).ready(function()
{
$(".comment_button").click(function(){

var element = $(this);
var I = element.attr("id");

$("#slidepanel"+I).slideToggle(300);
$(this).toggleClass("active"); 

return false;});});
</script>
<script type="text/javascript">
$(document).ready(function()
{
$(".comment_submit").click(function(){


var element = $(this);
var Id = element.attr("id");

var test = $("#textboxcontent"+Id).val();
var dataString = 'textcontent='+ test + '&msg_id=' + Id;

if(test=='')
{
alert("Your comment can't be blank");
}
else
{
$("#flash"+Id).show();
$("#flash"+Id).fadeIn(400).html('<img src="ajax-loader.gif" align="absmiddle"><font size="2">loading.....</font>');


$.ajax({
type: "POST",
url: "insert_comment.php",
data: dataString,
cache: false,
success: function(html){
$("#loadplace"+Id).append(html);
$("#flash"+Id).hide();

}
});

}

return false;});});
</script>

<script type="text/javascript">
$(document).ready(function() {
$(".like").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "like.php",
   data: info,
   success: function(){}
 });
 
  $(this).html('<span class="like">Unlike</span>');  
	
return false;

});

});
</script>

<?
	$result_pic2 = mysql_query("SELECT * FROM photos WHERE user_id = '$user_id'", $connection);
	$myrow_pic2 = mysql_fetch_array($result_pic2);
	
	$result_feeds2 = mysql_query("SELECT * FROM message_feeds WHERE user_id = '$user_id' ORDER BY created_at DESC", $connection);
	$myrow_feeds2 = mysql_fetch_array($result_feeds2);
?>
<script type="text/javascript">
$(document).ready(function(){
	$("form#submit_wall").submit(function() {
 
	var message_wall = $('#message_wall').attr('value');
	var datevar      = $('#datevar').attr('value');
 		if(message_wall == '') {
 			alert("Ooops. . . This field can't be empty.");
 		}
 		else{
		$.ajax({
			type: "POST",
			url: "insert.php",
			data: "message_wall="+ message_wall+ "& datevar="+ datevar,
			success: function(){
				$("ul#wall").prepend("<li style='display:none'><img src='uploads/<? echo $myrow_pic2[2]?>' align='left' hspace='15px' width='50' height='40' style='margin-left: 5px;' /><a href='profile.php?uid=<? echo $user_id?>'><? echo $full_name?></a> "+message_wall+"<br />"+"<small>"+datevar+"<a href='#' class='like' id='<? echo $myrow_feeds2[0] ?>'>"+"Like"+"</a></small>"+"</li>");
				$("ul#wall li:first").fadeIn();
			}
		});
		}
	return false;
	});
});
</script>
</head>

<body>
<div id="bg">
    <div id="wrapper">

      
    <div class="top"> <a href="index.php">Home</a> <a href="profile.php">Profile</a> <a href="account.php">Account</a> <a href="upload_photo.php">Upload</a> <a href="logout.php">Logout</a>
      <div class="clear"></div>

      </div>
      <div>  
<div class="left front_column_r">
<form name="search" action="search.php" method="get">
	<div id="search_box">
	      Search Runners: <input id="q" name="q" type="text">
	      <input type="submit" name="submit" value="Search" class="button" />
	</div>
</form>
</div>

        <div class="left" style="width: 450px; padding-right: 20px; margin: 0 auto;">
      
<h1>Message Feeds</h1>


<form action="" id="submit_wall">
<input type="hidden" id="datevar" value="<?php echo date("M jS 'y g:i A")?>" />

<div>
<label for="message_wall">What's running on your mind?</label>
<span class="counter"></span>
<textarea id="message_wall"></textarea>
</div>
<div>
<button type="submit">Run It!</button>
</div>
<h2>Runningmate Feeds</h2>

<ul id="wall">
<?
$result_feeds = mysql_query("SELECT * FROM message_feeds WHERE user_id = '$user_id' ORDER BY created_at DESC", $connection);
$myrow_feeds = mysql_fetch_array($result_feeds);

if($myrow_feeds !=""){
	do {
	$result_likes = mysql_query("SELECT * FROM message_feeds_like WHERE post_id = '$myrow_feeds[0]' AND user_id = '$user_id' AND like_id = 1", $connection);
	$myrow_likes = mysql_fetch_array($result_likes);
	
	$result_comments = mysql_query("SELECT * FROM message_feed_comments WHERE post_id = '$myrow_feeds[0]' ORDER BY created_at DESC LIMIT 5", $connection);
	$myrow_comments = mysql_fetch_array($result_comments);
	
	$result_pic = mysql_query("SELECT * FROM photos WHERE user_id = '$user_id'", $connection);
	$myrow_pic = mysql_fetch_array($result_pic);
	
		echo '<li>';
		if($myrow_pic[2] != '') {
			echo '<img src="';
			echo $myrow_pic[4];
			echo '" align="left" hspace="15px" style="margin-left: 5px;"/>';
		}
		else {
			echo '<img src="http://i.zdnet.com/blogs/no_smoking_signsvg.png';
			echo '" align="left" hspace="15px" width="50" height="40" style="margin-left: 5px;"/>';
		}
		echo '<a href="profile.php?uid='.$myrow_user[0].'">';
		echo $full_name;
		echo '</a>';
		echo ' '; 
		echo $myrow_feeds[2];
                echo '<br />';
                echo '<span class="fbx-tiny">';
                echo date("M jS 'y g:i A", strtotime($myrow_feeds[3]));
                if($myrow_feeds[0] == $myrow_likes[0] && $myrow_likes[1] == $user_id && $myrow_likes[2] == 1) {
                echo '';
                	echo 'Unlike';
                echo '</a>';
                }
                else
                {
                	echo ' <a href="#" class="like" id="'.$myrow_feeds[0].'">';
                	echo 'Like';
                	echo '</a>';
                }
                
                ?>
                
                <a href="#" class="comment_button" id="<?php echo $myrow_feeds[0]; ?>">Comment</a>
		
		</span>
		
				<div id="flash<?php echo $myrow_feeds[0]; ?>" class='flash_load'></div>
				
		
		<br />
		<? if($myrow_comments !='') { ?>
			
			<? echo "<b>Comments</b><br />"; ?>
			<div id="loadplace<?php echo $myrow_feeds[0]; ?>"></div>
			<?
			do
			{
				echo '<div style="margin-left:75px; margin-right:10px;">';
				echo $myrow_comments[3];
				echo '<br />';
				echo '<small>';
				echo date("M jS 'y g:i A", strtotime($myrow_comments[4]));
				echo '</small>';
				echo '<br /></small></div>';
				
			}while($myrow_comments = mysql_fetch_array($result_comments));	
		}
		else {
			echo "";
		}
		?>
		<div class='panel' id="slidepanel<?php echo $myrow_feeds[0]; ?>">
		<form action="" method="post" name="<?php echo $myrow_feeds[0]; ?>" style="border: 0 none none; margin: 0; padding: 0;">
		<input type="hidden" name="msg_id" id="msg_id" value="<? echo $myrow_feeds[0];?>" />
		<textarea style="width:300px;height:33px; font: 11px Helvetica, Arial, sans-serif;" id="textboxcontent<?php echo $myrow_feeds[0]; ?>" ></textarea><br />
		<input type="submit" value=" Comment_Submit "  class="comment_submit" id="<?php echo $myrow_feeds[0]; ?>" />
		
		</form>
		</div>
		
<?                
	}while($myrow_feeds = mysql_fetch_array($result_feeds));
}
else{
		echo "";
}
?>

</ul>

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