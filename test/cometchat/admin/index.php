<?php
 
/*

CometChat
Copyright (c) 2009 Inscripts

CometChat ('the Software') is a copyrighted work of authorship. Inscripts 
retains ownership of the Software and any copies of it, regardless of the 
form in which the copies may exist. This license is not a sale of the 
original Software or any copies.

By installing and using CometChat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

CometChat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each 
installed instance of the Software, a separate license is required. 
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts. 

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form. 

The Software source code may be altered (at your risk) 

All Software copyright notices within the scripts must remain unchanged (and visible). 

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to, 
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets, 
software piracy, and patents held by individuals, corporations, or other entities. 

If any of the terms of this Agreement are violated, Inscripts reserves the right 
to revoke the Software license at any time. 

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include_once dirname(dirname(__FILE__))."/cometchat_init.php";

$usertable = DB_USERTABLE;
$usertable_username = DB_USERTABLE_NAME;
$usertable_userid = DB_USERTABLE_USERID;

$body = '';

if (!empty($_POST['username'])) { $_SESSION['cometchat_admin_user'] = $_POST['username']; }
if (!empty($_POST['password'])) { $_SESSION['cometchat_admin_pass'] = $_POST['password']; }

authenticate();

if (!empty($_GET['action'])) {
	if (function_exists($_GET['action'])) {
		call_user_func($_GET['action']);
	}
} else {
	$_GET['action'] = "spy";
	spy();
}

function onlineusers() {
	global $db;

	$sql = ("select count(distinct(cometchat.from)) users from cometchat where ('".getTimeStamp()."'-cometchat.sent)<300");

	$query = mysql_query($sql); 
	$chat = mysql_fetch_array($query);

	return $chat['users'];
}

function logsview() {
	global $db;
	global $usertable;
	global $usertable_username;
	global $usertable_userid;
	global $body;	

	$data = array();

	if (!empty($_GET['id'])) {
		$data = preg_split("/,/",base64_decode($_GET['id']));
	}

	$userid = $_GET['userid'];

	$sql = ("select m1.*, f.$usertable_username fromu, t.$usertable_username tou from cometchat m1, ".TABLE_PREFIX."$usertable f, ".TABLE_PREFIX."$usertable t  
	where  f.$usertable_userid = m1.from and t.$usertable_userid = m1.to and ((m1.from = '".mysql_real_escape_string($userid)."') or (m1.to = '".mysql_real_escape_string($userid)."')) and m1.id >= $data[0] and m1.id < $data[1] order by id");

	$query = mysql_query($sql); 

	$chatdata = '';
	$previd = '';
	$lines = 0;
	$s = 0;
	while ($chat = mysql_fetch_array($query)) {

		if ($s == 0) { $s = $chat['sent']; }		
		$requester = $chat['fromu'];
		if ($chat['from'] == $userid) {
			$requester = $chat['tou'];
			$chat['fromu'] = 'Me';
		}

		$time = date('g:iA', $chat['sent']);
		$chat['message'] = strip_tags($chat['message']);
		
		$display = $chat['fromu'].':';
		$chatnoline = '';
		if ($previd == $chat['fromu']) {
			$display = '';
			$time = '';
			$chatnoline = '';
		}
$lines++;
		$chatdata = <<<EOD
 $chatdata
<div class="chat chatnoline">
<div class="chatrequest" style="text-align:right;padding-right:5px;"><b>$display</b></div>
<div class="chatmessage chatnowrap">{$chat['message']}</div>
<div class="chattime">$time</div>
<div style="clear:both"></div>
</div> 

EOD;
		$previd = $chat['fromu'];
	}

	$time = date('M jS Y', $s);

	$body = <<<EOD
	<script>
		jQuery(document).ready(function () {
 
		});
	</script>
	<div class="chatbar"><div style="float:left">Chat Conversation with $requester ($lines lines) on $time</div><div style="float:right;padding-right:7px;"><a href="index.php?action=logs&userid=$userid">Back</a></div><div style="clear:both"></div></div>
	$chatdata
EOD;

	template();
}

function logs() {
	global $db;
	global $usertable;
	global $usertable_username;
	global $usertable_userid;
	global $body;	

	if (!empty($_GET['id'])) { logsview(); }
	if (!empty($_GET['userid'])) { userlogs(); }

	$sql = ("select distinct(f.$usertable_userid) userid, f.$usertable_username username  from cometchat m1, ".TABLE_PREFIX."$usertable f
	where  f.$usertable_userid = m1.from order by username asc");

	$query = mysql_query($sql); 

	$chatdata = '';

	while ($chat = mysql_fetch_array($query)) {

		$chatdata = <<<EOD
 $chatdata
<div class="chat" id="{$chat['userid']}"  style="width:140px;float:left;margin-right:10px;">
			<div class="chatrequest">{$chat['username']}</div>
			<div style="clear:both"></div>
</div> 

EOD;
 
	}

	$chatdata .= '	<div style="clear:both"></div>';

	$body = <<<EOD
	<script>
		jQuery(document).ready(function () {
			$('.chat').mouseover(function() {
				$(this).addClass('chatbg');
			});

			$('.chat').mouseout(function() {
				$(this).removeClass('chatbg');
			});

			$('.chat').click(function() {
				var id = $(this).attr('id');
				location.href = "?action=logs&userid="+id;
			});
		});
	</script>	
				<div class="chatbar"><div style="float:left">Please select a user</div><div style="clear:both"></div></div>
	$chatdata
EOD;

	template();


}

function userlogs() {
	global $db;
	global $usertable;
	global $usertable_username;
	global $usertable_userid;
	global $body;	

	if (!empty($_GET['id'])) { logsview(); }

	if (empty($_GET['userid'])) { logs(); } else { $userid = $_GET['userid']; }



	$sql = ("select m1.*, f.$usertable_username fromu, t.$usertable_username tou from cometchat m1, ".TABLE_PREFIX."$usertable f, ".TABLE_PREFIX."$usertable t  
	where  f.$usertable_userid = m1.from and t.$usertable_userid = m1.to and ((m1.from = '".mysql_real_escape_string($userid)."') or (m1.to =  '".mysql_real_escape_string($userid)."')) and (m1.sent) > ALL
	(select (m2.sent)+1800 from cometchat m2
	where ((m2.to = m1.to and m2.from = m1.from) or (m2.to = m1.from and m2.from = m1.to))
	and m2.sent <= m1.sent and m2.id < m1.id) order by id desc");

	$query = mysql_query($sql); 

	$chatdata = '';
	$previd = 1000000;
	$requester2 = '';
	while ($chat = mysql_fetch_array($query)) {

		$requester = $chat['fromu'];
		if ($chat['from'] == $userid) {
			$requester = $chat['tou'];
			$requester2 = $chat['fromu'];
			$chat['fromu'] = 'Me';
		}

		$time = date('g:iA M dS', $chat['sent']);
		$chat['message'] = strip_tags($chat['message']);
		$encode = base64_encode($chat['id'].",".$previd);


		$chatdata = <<<EOD
 $chatdata
<div class="chat" id="{$encode}">
			<div class="chatrequest">$requester</div>
			<div class="chatmessage"><b>{$chat['fromu']}</b>: {$chat['message']}</div>
			<div class="chattime">$time</div>
			<div style="clear:both"></div>
</div> 

EOD;
		$previd = $chat['id'];
	}

	$chatdata .= '';

	$body = <<<EOD
	<script>
		jQuery(document).ready(function () {
			$('.chat').mouseover(function() {
				$(this).addClass('chatbg');
			});

			$('.chat').mouseout(function() {
				$(this).removeClass('chatbg');
			});

			$('.chat').click(function() {
				var id = $(this).attr('id');
				location.href = "?action=logs&userid=$userid&id="+id;
			});
		});
	</script>	

<div class="chatbar"><div style="float:left">Chat Conversation of $requester2</div><div style="float:right;padding-right:7px;"><a href="index.php?action=logs">Back</a></div><div style="clear:both"></div></div>

	$chatdata
EOD;

	template();
}

function spy() {
	global $body;

	$body = <<<EOD
	<script>
		jQuery(document).ready(function () {
			jQuery.cometchatspy();
		 
		});
	</script>
	<div id="data"></div>
EOD;

	template();
}

function spydata() {
	global $db;
	
	$usertable = DB_USERTABLE;
	$usertable_username = DB_USERTABLE_NAME;
	$usertable_userid = DB_USERTABLE_USERID;

	$response = array();
	$messages = array();
	
	$criteria = "cometchat.id > '".mysql_real_escape_string($_POST['timestamp'])."' and ";
	$criteria2 = 'desc';

	if (empty($_POST['timestamp'])) {
		$criteria = '';
		$criteria2 = 'desc limit 20';
		
	}

	$sql = ("select cometchat.id, cometchat.from, cometchat.to, cometchat.message, cometchat.sent, cometchat.read, f.$usertable_username fromu, t.$usertable_username tou from cometchat, ".TABLE_PREFIX."$usertable f, ".TABLE_PREFIX."$usertable t where $criteria f.$usertable_userid = cometchat.from and t.$usertable_userid = cometchat.to order by cometchat.id $criteria2");

	$query = mysql_query($sql); 
 

	$timestamp = $_POST['timestamp'];
	
	while ($chat = mysql_fetch_array($query)) {
	
		$time = date('g:iA M dS', $chat['sent']);

		array_unshift($messages,  array('id' => $chat['id'], 'from' => $chat['from'], 'to' => $chat['to'], 'fromu' => $chat['fromu'], 'tou' => $chat['tou'], 'message' => $chat['message'], 'time' => $time));
		
		if ($chat['id'] > $timestamp) {
			$timestamp = $chat['id'];
		}
	}

	$response['timestamp'] = $timestamp;

	if (!empty($messages)) {
		$response['messages'] = $messages;
	}

	$response['online'] = onlineusers();
	
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($response);
	exit;
}

function chatrooms() {
	global $db;
	global $body;	

	$sql = ("select * from cometchat_chatrooms where (('".getTimeStamp()."'-lastactivity<600) or createdby = 0) order by name asc");

	$query = mysql_query($sql); 

	$chatdata = '';

	while ($chat = mysql_fetch_array($query)) {

	if ($chat['createdby'] == 0) {
		$chatdata = <<<EOD
 $chatdata
<div class="chat" id="{$chat['id']}"  style="width:140px;float:left;margin-right:10px;">
			<div class="chatrequest">{$chat['name']}</div>
			<div style="clear:both"></div>
</div> 

EOD;
	} else {

		$chatdata = <<<EOD
 $chatdata
<div class="chat" id="{$chat['id']}"  style="background-color:#e1f6ff; width:140px;float:left;margin-right:10px;">
			<div class="chatrequest">{$chat['name']}</div>
			<div style="clear:both"></div>
</div> 

EOD;
	

	}
 
	}

	$chatdata .= '	<div style="clear:both"></div>';

	$body = <<<EOD
	<script>
		jQuery(document).ready(function () {
			$('.chat').mouseover(function() {
				$(this).addClass('chatbg');
			});

			$('.chat').mouseout(function() {
				$(this).removeClass('chatbg');
			});

			$('.chat').click(function() {
				var id = $(this).attr('id');
				deletechatroom(id);
			});
		});

		function addchatroom() {
			var name = prompt("Please enter the chatroom name", "");
			if (name != '' && name != null) {
				name = name.replace(/^\s+|\s+$/g,"");
				$.post("index.php?action=createchatroom", {name: name} , function(data){				
					if (data) {
						window.location.reload();
					}

				});
			}
		}

		function deletechatroom(id) {
			var condition = confirm("Are you sure you want to delete this chatroom?");
			if (condition) {
			
				$.post("index.php?action=deletechatroom", {id: id} , function(data){				
					if (data) {
						window.location.reload();
					}

				});
			}
		}

	</script>	
<div class="chatbar"><div style="float:left">Please click on a chatroom to delete</div><div style="float:right;padding-right:7px;"><a href="javascript:void(0)" onclick="javascript:addchatroom()">Add new chatroom</a></div><div style="clear:both"></div></div>
	$chatdata
EOD;

	template();


}

function createchatroom() {
	$name = $_POST['name'];
	$sql = ("insert into cometchat_chatrooms (name,createdby,lastactivity) values ('".mysql_real_escape_string(sanitize($name))."', '0','".getTimeStamp()."')");
	$query = mysql_query($sql);
	echo mysql_insert_id();
	exit(0);
}

function deletechatroom() {
	$id = $_POST['id'];
	$sql = ("delete from cometchat_chatrooms where id = '".mysql_real_escape_string(sanitize($id))."'");
	$query = mysql_query($sql);
	echo mysql_insert_id();
	exit(0);
}

function authenticate() {
	if (empty ($_SESSION['cometchat_admin_user']) || empty ($_SESSION['cometchat_admin_pass']) || !($_SESSION['cometchat_admin_user'] == ADMIN_USER && $_SESSION['cometchat_admin_pass'] == ADMIN_PASS)) {
		global $body;
		$body = <<<EOD
			<form method="post" action="?login">
			<div class="chatbar"><div style="float:left">Please login with your username and password</div><div style="clear:both"></div></div>
<div class="chat chatnoline">Username: <input type="text" name="username"></div>
<div class="chat chatnoline">Password: <input type="password" name="password"></div>
<div class="chat chatnoline"><input type="submit" value="Login"></div>
			</form>
EOD;
		template();
	}
}

function logout() {
	unset($_SESSION['cometchat_admin_user']);
	unset($_SESSION['cometchat_admin_pass']);
global $body;
		$body = <<<EOD
<script>
window.location.reload();
</script>
EOD;
template();
}

function template() {

	global $body;

	$online = onlineusers();

	$tabs = array("Spy","Logs","Chatrooms","Logout");

	$tabstructure = '';

	foreach ($tabs as $tab) {
		$tabslug = strtolower($tab);
		$tabslug = str_replace(" ","",$tabslug);
	    $tabslug = str_replace("/","",$tabslug);

		$current = '';
		if (!empty($_GET['action']) && $_GET['action'] == $tabslug) {
			$current = 'class="current"'; 
		}

		if ($tabslug == 'spy') {
			$tab .= " <em id=\"online\" class=\"count\">$online</em>";
		}
		
		$tabstructure .= <<<EOD
		  <li $current>
			<a href="?action={$tabslug}">{$tab}</a>
		  </li>
EOD;

	}

	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>CometChat Administration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="admin.css" media="all" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="admin.js"></script>
</head>
		<body>
<div id="container">
		<div style="float:right;padding-bottom:30px;padding-right:20px"><img src="logo.gif"></div>
		<div style="clear:both"></div>
	<div id="views">
		<ol class="tabs">
	{$tabstructure}
    </ol>
  </div>
  <div style="clear:both"></div>
  <div id="content">
		$body
  </div>
<div style="text-align:center;padding-top:10px"><a href="http://www.cometchat.com" target="_blank">Powered by CometChat</a></div>
</div>
</body>
</html>

EOD;

exit();
}
 