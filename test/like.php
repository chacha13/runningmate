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

$uid = $_SESSION['user_id'];


	if($_POST['id'] !=''){
		$id = $_POST['id'];
		$datevar = date("Y-m-d H:i:s");
		$ins_sql = "INSERT INTO message_feeds_like(post_id, user_id, like_id) VALUES('$id', '$uid', '1')";
		$ins_suc = mysql_query($ins_sql);
	}
	
		//$result_user = mysql_query("SELECT * FROM users WHERE id = '$id'", $connection);
		//$myrow_user = mysql_fetch_array($result_user);
		//$fullname = $myrow_user[1].' '.$myrow_user[2];

			      	   /*require "Mail.php";

				   // Identify the sender, recipient, mail subject, and body
				   $sender    = "Runningmate <webmaster@runningmate.ph>";
				   $recipient = $myrow_user['email'];
				   $subject   = "You have a friend request from $sess_full";
				   $body      = "Dear $fullname, \n\n";
				   $body .= "$sess_full wants you to be your friend in Runningmate \n\n";
				   $body .= "To accept this person go at this link http://test.runningmate.ph/accept.php?uid=$uid&action=accept";
				
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
				   


?>