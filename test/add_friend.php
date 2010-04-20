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

$result_session = mysql_query("SELECT * FROM users WHERE id = '$uid'", $connection);
$myrow_session = mysql_fetch_array($result_session);
$sess_full = $myrow_session[1].' '.$myrow_session[2];

	if($_POST['id'] !=''){
		$id = $_POST['id'];
		$ins_sql = "INSERT INTO friendships(user_id, friend_id, status, created_at, accepted_at) VALUES('$uid', '$id', 'pending', '$datevar', '')";
		$ins_suc = mysql_query($ins_sql);
	}
	
		$result_user = mysql_query("SELECT * FROM users WHERE id = '$id'", $connection);
		$myrow_user = mysql_fetch_array($result_user);
		$fullname = $myrow_user[1].' '.$myrow_user[2];

				   require_once 'Swift/lib/swift_required.php';
					//Create the Transport
					$transport = Swift_SmtpTransport::newInstance('mail.agilitypilipinas.com', 26)
					  ->setUsername('no-reply@agilitypilipinas.com')
					  ->setPassword('P@ssword1')
					  ;
					/*
					You could alternatively use a different transport such as Sendmail or Mail:
					//Sendmail
					$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
					//Mail
					$transport = Swift_MailTransport::newInstance();
					*/
					//Create the Mailer using your created Transport
					$mailer = Swift_Mailer::newInstance($transport);
					//Create a message
					$message = Swift_Message::newInstance("You have a friend request from $sess_full")
					  ->setFrom(array('no-reply@agilitypilipinas.com' => 'Runningmate'))
					  ->setTo(array($email, $email => $firstname))
					  ->setBody("Dear $fullname, \n\n $sess_full wants you to be your friend in Runningmate \n\n To accept this person go at this link http://test.agilitypilipinas.ph/accept.php?uid=$uid&action=accept", "text/plain")
					  ;
					//Send the message
					$result = $mailer->send($message);
					/*
					You can alternatively use batchSend() to send the message
					$result = $mailer->batchSend($message);
					*/
				   

?>