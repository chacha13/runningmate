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

if($_POST['id'])
{
	$id = $_POST['id'];
	$id = mysql_escape_string($id);
	$sql = "delete from message_feeds where id = '$id'";
	mysql_query($sql);
	
	$delete_comments = mysql_query("DELETE FROM message_feed_comments WHERE post_id = '$id'", $connection);
	$del_suc = mysql_affected_rows();
	
	$delete_likes = mysql_query("DELETE FROM message_feeds_comment WHERE post_id = '$id'", $connection);
	$del_likes = mysql_affected_rows();
}
?>