<?php

include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php";

function sendmessage() {
	global $userid;
	global $db;
	
	if (!empty($_POST['message']) && !empty($_POST['currentroom'])) {
		$to = $_POST['currentroom'];
		$message = $_POST['message'];

		if ($userid != '') {
			$sql = ("update cometchat_chatrooms set lastactivity = '".getTimeStamp()."' where id = '".mysql_real_escape_string($to)."'");
			$query = mysql_query($sql);

			$sql = ("insert into cometchat_chatroommessages (userid,chatroomid,message,sent) values ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string(sanitize($message))."','".getTimeStamp()."')");
			$query = mysql_query($sql);
			echo mysql_insert_id();
			exit(0);
		}

	}
}

function heartbeat() {
	$response = array();
	$messages = array();

	global $userid;
	global $db;
	global $language;

	$usertable = DB_USERTABLE;
	$usertable_username = DB_USERTABLE_NAME;
	$usertable_userid = DB_USERTABLE_USERID;

	$time = getTimeStamp();
	$chatroomList = array();

	if ((empty($_SESSION['cometchat_chatroomslist'])) || (!empty($_SESSION['cometchat_chatroomslist']))) {

		if (!empty($_POST['currentroom']) && $_POST['currentroom'] != 0) {
			$sql = ("insert into cometchat_chatrooms_users (userid,chatroomid,lastactivity) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string($_POST['currentroom'])."','".mysql_real_escape_string($time)."') on duplicate key update chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."', lastactivity = '".mysql_real_escape_string($time)."'");
			$query = mysql_query($sql);
		}

		$sql = ("select cometchat_chatrooms.id, cometchat_chatrooms.name, cometchat_chatrooms.lastactivity, cometchat_chatrooms.createdby, (SELECT count(userid) online FROM cometchat_chatrooms_users where cometchat_chatrooms_users.chatroomid = cometchat_chatrooms.id and  '$time'-lastactivity<120) online  from cometchat_chatrooms where (createdby = 0 OR (createdby <> 0 AND ('".mysql_real_escape_string($time)."'-lastactivity < 600))) order by name asc");
 
		$query = mysql_query($sql);
 

		while ($chatroom = mysql_fetch_array($query)) {
			$chatroomList[] = array('id' => $chatroom['id'], 'name' => $chatroom['name'], 'online' => $chatroom['online']);
		}

		$response['chatrooms'] = $chatroomList;


		$sql = ("SELECT chatroomid FROM cometchat_chatrooms_users WHERE userid=".$userid);
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$mychatroom = $row['chatroomid'];

		$sql = ("SELECT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username FROM ".TABLE_PREFIX.DB_USERTABLE.", cometchat_chatrooms_users WHERE cometchat_chatrooms_users.userid = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." AND '$time'-cometchat_chatrooms_users.lastactivity<120 AND cometchat_chatrooms_users.chatroomid = ".$mychatroom." ORDER BY ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." asc");
 
		$query = mysql_query($sql);

		while ($userlist = mysql_fetch_array($query)) {
			$usernameList[] = array('userid' => $userlist['userid'], 'name' => $userlist['username']);
		}

		if (!empty($usernameList)) {
			$response['usernames'] = $usernameList;
		}


		$_SESSION['cometchat_chatroomslist'] = $time;

	}

	if (!empty($_POST['currentroom']) && $_POST['currentroom'] != 0) {
		$reverse = 1;
		$sql = ("select cometchat_chatroommessages.id, cometchat_chatroommessages.message, cometchat_chatroommessages.sent, m.$usertable_username `from`, cometchat_chatroommessages.userid fromid, m.$usertable_userid userid from cometchat_chatroommessages, ".TABLE_PREFIX."$usertable m where cometchat_chatroommessages.chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."' and m.$usertable_userid = cometchat_chatroommessages.userid order by cometchat_chatroommessages.id desc limit 10");

		if ($_POST['timestamp'] != 0) {
			$sql = ("select cometchat_chatroommessages.id, cometchat_chatroommessages.message, cometchat_chatroommessages.sent, m.$usertable_username `from`, cometchat_chatroommessages.userid fromid, m.$usertable_userid userid from cometchat_chatroommessages, ".TABLE_PREFIX."$usertable m where cometchat_chatroommessages.chatroomid = '".mysql_real_escape_string($_POST['currentroom'])."' and m.$usertable_userid = cometchat_chatroommessages.userid and cometchat_chatroommessages.id > '".mysql_real_escape_string($_POST['timestamp'])."' order by cometchat_chatroommessages.id desc");
			$reverse = 0;
		}

		$query = mysql_query($sql);

		while ($chat = mysql_fetch_array($query)) {
			if ($userid == $chat['userid']) {
				$chat['from'] = $language[10];
				$chat['fromid'] = 0;
			}

			array_unshift($messages,array('id' => $chat['id'], 'from' => $chat['from'], 'fromid' => $chat['fromid'], 'message' => $chat['message'], 'sent' => ($chat['sent']+$_SESSION['timedifference'])));
		}

		if (!empty($messages)) {
			$response['messages'] = $messages;
		}

	}


	header('Content-type: application/json; charset=utf-8');
	echo json_encode($response);
	exit;
}

function createchatroom() {
	global $userid;
	$name = $_POST['name'];

		if ($userid != '') {
			$time = getTimeStamp();

			$sql = ("insert into cometchat_chatrooms (name,createdby,lastactivity) values ('".mysql_real_escape_string(sanitize($name))."', '".mysql_real_escape_string($userid)."','".getTimeStamp()."')");
			$query = mysql_query($sql);
			$currentroom = mysql_insert_id();

			$sql = ("insert into cometchat_chatrooms_users (userid,chatroomid,lastactivity) values ('".mysql_real_escape_string($userid)."','".mysql_real_escape_string($currentroom)."','".mysql_real_escape_string($time)."') on duplicate key update chatroomid = '".mysql_real_escape_string($currentroom)."', lastactivity = '".mysql_real_escape_string($time)."'");
			$query = mysql_query($sql);
			
			echo $currentroom;
			exit(0);
		}
}

if (!empty($_GET['action']) && function_exists($_GET['action'])) {
	call_user_func($_GET['action']);
}