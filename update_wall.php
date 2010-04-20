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
$fullname = $myrow_user['firstname'].' '.$myrow_user['lastname'];

include_once('functions.php');

if(isset($_POST['content'])){
	
	$msg2 = strip_tags($_POST['content']);
        $datevar = date("Y-m-d H:i:s");
	
	$sql = 'INSERT INTO message_feeds(user_id, message, created_at) VALUES("'.$user_id.'","'.$msg2.'", "'.$datevar.'")';
	mysql_query($sql);
	
	$result_msg = mysql_query("SELECT * FROM message_feeds WHERE user_id = '$user_id' ORDER created_at DESC", $connection);
	$myrow_msg = mysql_fetch_array($result_msg);
	$id = $myrow_msg[0];
	$msg = $myrow_msg[2];
	$msg = toLink($msg);
	
	$result_pic = mysql_query("SELECT * FROM photos WHERE user_id = '$user_id'", $connection);
	$myrow_pic = mysql_fetch_array($result_pic);
} 

?>

<li class="bar<?php echo $id; ?>">
<div align="left" class="post_box">
<span style="padding:10px"><?php echo toLink($msg2); ?> </span>
<span class="delete_button"><a href="#" id="<?php echo $id; ?>" class="delete_update">X</a></span>
<span class='feed_link'><a href="#" class="comment" id="<?php echo $id; ?>">comment</a></span>
</div>
<div id='expand_box'>
<div id='expand_url'></div>
</div>
<div id="fullbox" class="fullbox<?php echo $id; ?>">
<div id="commentload<?php echo $id; ?>" >

</div>
<div class="comment_box" id="c<?php echo $id; ?>">
<form method="post" action="" name="<?php echo $id; ?>">
<textarea class="text_area" name="comment_value" id="textarea<?php echo $id; ?>">
</textarea><br />
<input type="submit" value=" Comment " class="comment_submit" id="<?php echo $id; ?>"/>
</form>
</div>
</div>
</li>