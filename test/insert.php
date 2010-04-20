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

if($_POST['message_wall'] !=''){
	/* Connection to Database */
	
	/* Remove HTML tag to prevent query injection */
	$message = strip_tags($_POST['message_wall']);
        $datevar = date("Y-m-d H:i:s");
	
	$sql = 'INSERT INTO message_feeds(user_id, message, created_at) VALUES("'.$user_id.'",
				"'.$message.'", "'.$datevar.'")';
				 mysql_query($sql);
	echo $message;
	echo 'Likesasas';
				 } else { echo '0'; }
?>