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

$uid = $_SESSION['user_id'];

$result_sess = mysql_query("SELECT * FROM users WHERE id = '$uid'", $connection);
$myrow_sess = mysql_fetch_array($result_sess);
$sess_full = $myrow_sess[1].' '.$myrow_sess[2];

if($_POST['textcontent'] !='')

{
	$msg_id = $_POST['msg_id'];
	$datevar = date("Y-m-d H:i:s");
	$textcontent = strip_tags($_POST['textcontent']);
	$ins_sql = "INSERT INTO message_feed_comments(post_id, user_id, message, created_at) VALUES('$msg_id', '$uid', '$textcontent', '$datevar')";
	$ins_rows = mysql_query($ins_sql);
	
	$result_post = mysql_query("SELECT * FROM message_feeds WHERE id = '$msg_id'", $connection);
	$myrow_post = mysql_fetch_array($result_post);
	
	$result_user = mysql_query("SELECT * FROM users WHERE id = '$myrow_post[1]'", $connection);
	$myrow_user = mysql_fetch_array($result_user);
	$fullname = $myrow_user[1].' '.$myrow_user[2];
	
	
				   /*require "Mail.php";

				   // Identify the sender, recipient, mail subject, and body
				   $sender    = "Runningmate <webmaster@runningmate.ph>";
				   $recipient = $myrow_user['email'];
				   $subject   = "$sess_full commented on your post at Runningmate";
				   $body      = "Dear $fullname, \n\n";
				   $body     .= "$sess_full commented dated $datevar \n\n";
				   $body     .= "'$textcontent'";
				
				   // Identify the mail server, username, password, and port
				   $server   = "ssl://mail.runningmate.ph";
				   $username = "webmaster@runningmate.ph";
				   $password = "P@ssword1";
				   $port     = "465";
				
				   // Set up the mail headers
				   $headers = array(
				      "From"    => $sender,
				      "To"      => $recipient,
				      "Subject" => $subject
				   );
				
				   // Configure the mailer mechanism
				   $smtp = Mail::factory("smtp",
				      array(
				        "host"     => $server,
				        "username" => $username,
				        "password" => $password,
				        "auth"     => true,
				        "port"     => 465
				      )
				   );
				
				   // Send the message
				   $mail = $smtp->send($recipient, $headers, $body);
				
				   if (PEAR::isError($mail)) {
				      echo ($mail->getMessage());
				   }*/
}

?>

<div class="load_comment">
	<?php echo $textcontent; ?>
	<br />
	<?php echo date("M jS 'y g:i A", strtotime($datevar));?> | 
	<? echo '<a href="#">X</a>'; ?>
</div>


 