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

$result_user = mysql_query("SELECT * FROM users WHERE id = '$user_id'", $connection);
$myrow_user = mysql_fetch_array($result_user);

$fullname = $myrow_user[1].' '.$myrow_user[2];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Runningmate / Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js/jquery_menu.js"></script>
<script type="text/javascript" src="js/hover_menu.js"></script>
<link rel="stylesheet" type="text/css" href="css/hover_menu.css" />
<link rel="stylesheet" type="text/css" href="css/runningmate.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
  
 
<script type="text/javascript">

$(function() {
$(".wall_update").click(function() {
	var element = $(this);
    	var boxval = $("#content").val();
    	var dataString = 'content='+ boxval;
	
	if(boxval == '')
	{
		alert("They tried to make me go to rehab I said no, no, no. . . <3");
	}
	else
	{
		$("#flash").show();
		$("#flash").fadeIn(400).html('<img src="images/ajax-loader.gif" align="absmiddle">&nbsp;<span class="loading">Loading Update...</span>');
		$.ajax({
			type: "POST",
  			url: "update_wall.php",
   			data: dataString,
  			cache: false,
  			success: function(html){
  				$("ol#update").prepend(html);
  				$("ol#update li:first").slideDown("slow");
   				document.getElementById('content').value='';
   				$('#content').value='';
   				$('#content').focus();
  				$("#flash").hide();
	
  			}
 		});
	}
	return false;
});


		$(function() {
			$(".delete_update").click(function() {
			var element = $(this);
			var I = element.attr("id");
			 
			
			if(confirm("Sure you want to delete this update? There is NO undo!")) {
			$.ajax({
			type: "POST",
			url: "delete_wall.php",
			data: 'id='+ I ,
			cache: false,
			success: function()
			{
				$('li#list'+I).fadeOut('slow', function() {$(this).remove();}); 
			}
			});
			}
			
			return false;
			});
		});

			

//Wall comment delete

$('.cdelete_update').live("click",function() 
{
var ID = $(this).attr("id");

var dataString = 'com_id='+ ID;

if(confirm("Sure you want to delete this update? There is NO undo!"))
{
$.ajax({
		type: "POST",
  url: "delete_comment.php",
   data: dataString,
  cache: false,
  success: function(html){
 
 $("#comment"+ID).slideUp();
	
  }
 });

}

});

});


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
<style type="text/css">
input.buttons{
color: #fff;
text-decoration: underline;
background-color: #df560a;
padding: 4px; 
border: 0;
font-size: 9pt;
height: 25px;
}
</style>
<style type="text/css">
.update_box
{
background-color:#D3E7F5; border-bottom:#ffffff solid 1px; padding-top:3px
}
a
	{
	text-decoration:none;
	color:#d02b55;
	}
	a:hover
	{
	text-decoration:underline;
	color:#d02b55;
	}
	*{margin:0;padding:0;}
	ol.timeline{
		list-style:none;
		font-size:1.2em;
	}ol.timeline li{ 
		display:none;
		position:relative; 
	}ol.timeline li:first-child{border-top:1px dashed #006699;}
	.delete_button
	{
	float:right; margin-right:10px; width:20px; height:20px
	}
	
	.cdelete_button
	{
	float:right; margin-right:10px; width:20px; height:20px
	}
	
	.feed_link
	{
	font-style:inherit; font-family:Georgia; font-size:13px;padding:10px; float:left; width:350px
	}
	.comment
	{
	color:#0000CC; text-decoration:underline
	}
	.delete_update
	{
	font-weight:bold;
	
	}
	.cdelete_update
	{
	font-weight:bold;
	
	}
	.post_box
	{
	height:55px;border-bottom:1px dashed #006699;background-color:#F3F3F3;  width:499px;padding:.7em 0 .6em 0;line-height:1.1em;
	
	}
	#fullbox
	{
	margin-top:6px;margin-bottom:6px; display:none;
	}
	.comment_box
	{
	    display:none;margin-left:90px; padding:10px; background-color:#d3e7f5; width:300px;  height:50px;
	
	}
	.comment_load
	{
	  margin-left:90px; padding:10px; background-color:#d3e7f5; width:300px; height:30px; font-size:15px; border-bottom:solid 1px #FFFFFF;
	
	}
	.text_area
	{
	width:290px;
	font-size:12px;
	height:30px;
	
	}
</style>


<?
	$result_pic2 = mysql_query("SELECT * FROM photos WHERE user_id = '$user_id'", $connection);
	$myrow_pic2 = mysql_fetch_array($result_pic2);
	
	$result_feeds2 = mysql_query("SELECT * FROM message_feeds WHERE user_id = '$user_id' ORDER BY created_at DESC", $connection);
	$myrow_feeds2 = mysql_fetch_array($result_feeds2);
?>

</head>
<body id="bodyInit">
<div id="header-div"> 
  <div id="header-center"> 
    <div id="header-search"> 
      <div style="float:right;"> 
      <form name="search" action="search.php" method="get">
      	<input type="submit" name="submit" value="Search Runner" class="buttons" />
      </div>
      <div style="float:right;  padding-right: 10px;"> 
        <input name="q" id="header-text" type="text" />
      </div>
      </form>
    </div>
  </div>
</div>


<div id="content-body">

 
  
<div id="content-menu"> 
  <div id="page-wrap"> 
    <div id="home-button" class="button"> <a href="index.php"><img src="images/menu_home.gif" alt="home" width="66" height="11" class="button" border="none"/></a> 
    </div>
    <div id="connect-button" class="button"> <a href="community.php"><img src="images/menu_connect.gif" alt="connect" width="88" height="11" border="none" class="button"></a> 
    </div>
    <div id="races-button" class="button"> <a href="races.php"><img src="images/menu_races.gif" alt="race" width="50" height="11" border="none" class="button"></a> 
    </div>
    <? if($_SESSION['user_id'] !='') {?>
      <div id="races-button" class="button" style="float: right; position:relative;"> 
      <a href="logout.php"><img src="images/logout.gif" alt="Logout your account" width="37" height="14" border="none" class="button"></a> 
    </div>
    <? } else { ?>
    
    <? }?>
    <div class="clear"></div>
  </div>
</div>

<? if($user_id !='') { ?>
  <!- ----------------------------------------------------------------------------------------------------- ->
  <!- -----START NG FRONT CONTENT HOLDER------- ->
  
	
<div id="content-profile-holder"> 
  <div style="height:20px;"></div>
  <!- ----SPACER SA TAAS----- ->
  <div id="profile-sidebar"> 
    <div style="height: 10px;"></div>
    <img src="images/avatar.gif" border="none"/> 
    <div style="margin-top: 10px; text-align: right;"> 
      <h1><? echo $fullname; ?></h1>
      <p>In running Condition</p>
      <p>&nbsp;</p>
      <p>Longest Run so far</p>
      <p>00:00:45</p>
    </div>
    <div style="height: 20px;"></div>
    <!- ---------------ACCORDION MENU START --------------- ->
    <div style="margin-left: 10px; width: 160px; text-align: right;"> 
      <h2>Profile</h2>
      <h2>Runningmates</h2>
      <h2>Running Groups</h2>
      <h2>Events</h2>
    </div>
    <!- ---------------ACCORDION MENU END   --------------- ->
  </div>


  
  <div id="profile-content"> 
    <div style="border-bottom: 1px solid #df560a; height: 125px;"> 
      <div id="post-mind">
      <h1> What is running on your mind?</h1> 
      <form  method="post" name="form" action="">
      <textarea cols="30" rows="2" style="width: 570px; height: 70px; font-weight:bold" name="content" id="content" maxlength="145" ></textarea>
      </div>
    </div>
    <div style="height: 10px;"></div>
    
    <div style="position: relative; height: 50px;"> 
      <div id="post-submit"> 
        <div style="float:right;"><input type="submit"  value="Update"  id="v" name="submit" class="wall_update"/></div>
      </div>
        
      
      </form>
<?
$result_post = mysql_query("SELECT * FROM message_feeds WHERE user_id = '$uid' ORDER BY created_at", $connection);
$myrow_post = mysql_fetch_array($result_post);
?>


</div>
<div style="height:7px"></div>
<div id="flash" align="left"></div>
<ol id="update" class="timeline">
      <!- ------------------END OF MAIN REPLY ------------------------ ->
      <? /*<li id="main-reply"> 
        <div style="float: left; position:relative; width: 70px; margin:0px ; padding: 20px 0px 0px 0px;"> 
          <img src="images/test_reply_avatar.gif" width="50px" height="50px"/> 
        </div>
        <!- --------- REPLY HERE ------ ->
        <div style="width: 420px; text-align: left;margin: 0;padding: 1em  2em  2em 1em;float:right; position:relative;"> 
          <h1>Nick says:</h1>
          <p>&nbsp;</p>
          <p style="text-align: justify;" class="replyPost">Lorem ipsum dolor 
            sit amet, consectetuer adipiscing elit. Morbi malesuada, ante at feugiat 
            tincidunt, enim massa gravida metus, commodo lacinia massa diam vel 
            eros. Proin eget urna. Nunc fringilla neque vitae odio. Vivamus vitae 
            ligula.</p>
          <p style="text-align: justify;" class="replyPost"><a href="#" class="btn-delete">Delete</a> 
            | <a href="#" class="btn-unapprove">Unapprove</a> | <a href="#" class="btn-spam">Like</a></p>
        </div>
      </li> */?>

    </ol>
   

<ul id="reply">
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
	
	echo '<li class="main-reply" id="list'.$myrow_feeds[0].'">';
        echo '<div style="float: left; position:relative; width: 70px; margin:0px ; padding: 20px 0px 0px 0px;">';
        if($myrow_pic[2] != '') {
			echo '<img src="uploads/';
			echo $myrow_pic[2];
			echo '" align="left" hspace="15px" width="50" height="40" style="margin-left: 5px;"/>';
	}
	else { 
        	echo '<img src="images/test_reply_avatar.gif" width="50px" height="50px"/>';
        } 
        echo '</div>'; 
        
        //Rely Here
        echo '<div style="width: 420px; text-align: left;margin: 0;padding: 1em  2em  2em 1em;float:right; position:relative;">'; 
        echo '<h1>'.$fullname.' says</h1>'; 
        echo '<p>&nbsp;</p>'; 
        echo '<p style="text-align: justify;" class="replyPost">'.toLink($myrow_feeds[2]).'</p><br />'; 
        echo '<p style="text-align: justify; font-size: 10pt;" class="replyPost">'; ?>
        
        <a href="#" class="comment_button" id="<?php echo $myrow_feeds[0]; ?>">Comment</a>
<?
        echo ' | <a href="#" id="'.$myrow_feeds[0].'" class="delete_update">Delete</a> | <a href="#" class="btn-spam">Like</a></p>'; 
?>
		<? /*<div class='panel' id="slidepanel<?php echo $myrow_feeds[0]; ?>">
			<form action="" method="post" name="<?php echo $myrow_feeds[0]; ?>" style="border: 0 none none; margin: 0; padding: 0;">
			<input type="hidden" name="msg_id" id="msg_id" value="<? echo $myrow_feeds[0];?>" />
			<textarea style="width:300px;height:33px; font: 11px Helvetica, Arial, sans-serif;" id="textboxcontent<?php echo $myrow_feeds[0]; ?>" ></textarea><br />
			<input type="submit" value=" Comment_Submit "  class="comment_submit" id="<?php echo $myrow_feeds[0]; ?>" />
			</form>
		</div>*/ ?>
<?
        echo '</div>'; 
      	echo '</li>';
      	}while($myrow_feeds = mysql_fetch_array($result_feeds)); 
}
else{
		echo "";
}
?>

</ul>
    
  </div>

  

  <div id="profile-ads"> 
  	<div style=" border: thin solid #e57537; height: 300px; position:relative;">ads here</div>
  	<div style=" border: thin solid #e57537; height: 300px; position:relative;">ads here</div>
	<div style=" border: thin solid #e57537; height: 300px; position:relative;">ads here</div>

  
  </div>
  
</div>
	<!- -----END NG FRONT CONTENT HOLDER------- ->


<? } else{ ?>   






<div id="content-front-holder"> 
  <div id="content-flash"> 
  
  </div>
  <div id="content-side"> 
    <!- -----START NG FRONT CONTENT HOLDER------- ->
    <div id="side-not-yet-img"></div>
    <div id="side-run-info" style="width: 225px; height: 100px;"> 
      <div align="center"><font id="blueText"> <font id="blueBoldText"> runningmate.ph 
        </font>is positioning itself to be the most comprehensive web portal that 
        is decided to the sport of running here in the philippines. It will help 
        promote the sports via our very own social network. </font> </div>
      &nbsp; </div>
    <div id="side-info" style="width: 250px; height: auto; text-align: right; line-height:30px;"> </p> 
      Login to your runningmate account 
      <form name="form1" id="form1" action="index.php" method="post">
      
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
				else
				{
					echo '<script>';
					echo 'document.form1.action = "login.php";';
					echo 'document.form1.target = "_parent";';
				 	echo 'document.form1.submit();';							 
					echo '</script>';  	
				}
			}
			
	?>
      <p>Email Address: &nbsp; 
        <input name="email" id="login-text" type="text" style="width: 145px;"/>
      </p>
      Password &nbsp; 
      <input name="password" id="login-text" type="password" style="width: 145px;"/></p>
      <div id="miniText" style="height: 20px;">Forgot your Password? <a href="lost_password.php" >Click 
        Here</a></div></p>
      </div>
    <div style="margin-left: autopx; margin-right: auto; margin-top:20px; text-align: center;"> 
      <input type="submit" name="submit" value="Run the Streets" class="buttons" /> 
    </div>
    <div style="width: 250px; height: auto; text-align:center; padding-top: 20px; padding-left: 20px;"> </p> 
      If you do not have a runningmate account, </p>Click <a href="signup.php">here </a>to 
      get started. </div>
  </div>
</div>
<!- -----END NG FRONT CONTENT HOLDER------- ->

  
<div id="content-bottom-holder"> 
  <!- -----START NG BOTTOM CONTENT HOLDER------- ->
  <div id="content-bottom-column"> 
    <div style="height: 58px;"><img src="images/comment_icon.gif" /></div>
    <div id="side-run-info" style="height: 100px;"> 
      <div><font id="blueBoldText">Write everything you want!</font>&nbsp;</br></div>
      <font id="blueText"> 
      <p>&nbsp;</p>
      Share all the races you have been through and have others read it as well. 
      Make your account you onlone blog for all you running needs. </p> </font> 
    </div>
  </div>
  <div id="content-bottom-column"> 
    <div style="height: 58px;"><img src="images/clndar_icon.gif" /></div>
    <div id="side-run-info" style="height: 100px;"> 
      <div><font id="blueBoldText">Write everything you want!</font>&nbsp;</br></div>
      <font id="blueText"> 
      <p>&nbsp;</p>
      Share all the races you have been through and have others read it as well. 
      Make your account you onlone blog for all you running needs. </p> </font> 
    </div>
  </div>
  <div id="content-bottom-column"> 
    <div style="height: 58px;"><img src="images/user_icon.gif" /></div>
    <div id="side-run-info" style="height: 100px;"> 
      <div><font id="blueBoldText">Write everything you want!</font>&nbsp;</br></div>
      <font id="blueText"> 
      <p>&nbsp;</p>
      Share all the races you have been through and have others read it as well. 
      Make your account you onlone blog for all you running needs. </p> </font> 
    </div>
  </div>
</div> 
<!- -----END NG BOTTOM CONTENT HOLDER------- ->
<? }?>


<div style="height: 15px;"></div>
<div id="footer-holder"> 
  <div style="height: 20px;"></div>
  <h1>www.runningmate.ph</h1>
  <div style="height: 20px;"></div>
  <div style="height: 50px; width: 700px; margin: auto;"> runningmate.ph is positioning 
    itself to be the most comprehensive web portal that is decided to the sport 
    of running here in the philippines. It will help promote the sports via our 
    very own social network. </div>
  <div style="position: relative;"> <a href="#">Home</a> | <a href="#">Connect</a> 
    | <a href="#">Races</a></div>
  <div style="height: 10px; width: 700px; margin: auto;font-size: 10px;"> All 
    Rights Reserved. Copyrights 2010. Runningmate Team. </div>
</div>






</body>
</html>