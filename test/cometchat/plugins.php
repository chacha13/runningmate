<?php

include_once "cometchat_init.php";

if ($userid == 0) { exit; }

function sendMessageTo($to,$message) {
	global $userid;

	if (!empty($to) && !empty($message)) {
		if ($userid != '') {
			$sql = ("insert into cometchat (cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read,cometchat.direction) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."','".getTimeStamp()."',0,1)");
			$query = mysql_query($sql);
			if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
		}
	}
}

function sendSelfMessage($to,$message) {
	global $userid;

	if (!empty($to) && !empty($message)) {
		if ($userid != '') {
			$sql = ("insert into cometchat (cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read, cometchat.direction) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."','".getTimeStamp()."',0,2)");
			$query = mysql_query($sql);
			if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

			if (empty($_SESSION['cometchat_user_'.$to])) {
				$_SESSION['cometchat_user_'.$to] = array();
			}
			
			$_SESSION['cometchat_user_'.$to][] = array("id" => mysql_insert_id(), "from" => $to, "message" => sanitize($message), "self" => 1, "old" => 1, 'sent' => (getTimeStamp()+$_SESSION['timedifference']));
			
		}
	}
}