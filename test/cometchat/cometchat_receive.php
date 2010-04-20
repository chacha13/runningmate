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

include_once "cometchat_init.php";
 
$response = array();
$messages = array();

if ($userid != 0) {
	if (!empty($_POST['chatbox'])) {
		if (!empty($_SESSION['cometchat_user_'.$_POST['chatbox']])) {
			$messages = $_SESSION['cometchat_user_'.$_POST['chatbox']];
		}
	} else {
		if (!empty($_POST['buddylist']) && $_POST['buddylist'] == 1) { getBuddyList(); }
		if (!empty($_POST['initialize']) && $_POST['initialize'] == 1) { 

			$sql = ("select id from cometchat order by id desc limit 1");
			$query = mysql_query($sql);
			if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
			$result = mysql_fetch_array($query);

			$_SESSION['timedifference'] = round((($_POST['currenttime']-getTimeStamp())/60)/30)*60*30;
			
			$response['initialize'] = $result['id'];

			getStatus(); 

			if (!empty($_COOKIE[$cookiePrefix.'state'])) {
				$states = explode(':',urldecode($_COOKIE[$cookiePrefix.'state']));
				
				$openChatboxId = '';

				if ($states[2] != '' && $states[2] != ' ') {
					$openChatboxId = $states[2];
				}
			
				if (!empty($openChatboxId) && !empty($_SESSION['cometchat_user_'.$openChatboxId])) {
					$messages = array_merge($messages,$_SESSION['cometchat_user_'.$openChatboxId]);
				}
			}


		}
		
		getLastTimestamp();
		fetchMessages();
	}

	$sql = updateLastActivity($userid);
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

} else {
	$response['loggedout'] = '1';

	if (DO_NOT_DESTROY_SESSION != 1) {
		session_destroy();
	}
}

function getStatus() {
	global $response;
	global $userid;
	global $status;

	$sql = getUserStatus($userid);
 	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

	$chat = mysql_fetch_array($query);

	if (empty($chat['status'])) {
		$chat['status'] = 'available';
	} else {
		if ($chat['status'] == 'offline') {
			$_SESSION['cometchat_sessionvars']['buddylist'] = 0;
		}
	}
	
	if (empty($chat['message'])) {
		$chat['message'] = $status[$chat['status']];
	}

	$status = array('message' => $chat['message'], 'status' => $chat['status']);
	$response['userstatus'] = $status;
}

function getLastTimestamp() {
	if (empty($_POST['timestamp'])) {
		$_POST['timestamp'] = 0;
	}

	if ($_POST['timestamp'] == 0) {
		foreach ($_SESSION as $key => $value) {
			if (substr($key,0,15) == "cometchat_user_") {
				$temp = end($_SESSION[$key]);
				if ($_POST['timestamp'] < $temp['id']) {
					$_POST['timestamp'] = $temp['id'];
				}
			}
		}

		if ($_POST['timestamp'] == 0) {
			$sql = ("select id from cometchat order by id desc limit 1");
			$query = mysql_query($sql);
			if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
			$chat = mysql_fetch_array($query);

			$_POST['timestamp'] = $chat['id'];
		}
	}
	
}


function getBuddyList() {
	global $response;
	global $userid;
	global $db;
	global $status;

	$time = getTimeStamp();
	$buddyList = array();

	if ((empty($_SESSION['cometchat_buddytime'])) || ($_POST['initialize'] == 1) || (!empty($_SESSION['cometchat_buddytime']) && ($time-$_SESSION['cometchat_buddytime'] > REFRESH_BUDDYLIST))) {
		
		$sql = getFriendsList($userid,$time);
 
		$query = mysql_query($sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }

		while ($chat = mysql_fetch_array($query)) {
                  $Online = 'offline';

                  $onlinesql = getOnlineList($chat['user_id']);
                  $onlinequery = mysql_query($onlinesql);
	          while ($isonline = mysql_fetch_array($onlinequery)) {
                    if ($chat['user_id'] == $isonline['visitor_user_id']){
                      $Online = 'online';}
                  }
                          
			if ((($time-$chat[DB_USERTABLE_LASTACTIVITY]) < ONLINE_TIMEOUT) && $chat['status'] != 'invisible' && $chat['status'] != 'offline'  && $Online != 'offline') {
				if ($chat['status'] != 'busy') {
					$chat['status'] = 'available';
				}
			} else {
				$chat['status'] = 'offline';
			}
                   if ($chat['status'] != 'offline') {
			if ($chat['message'] == null) {
				$chat['message'] = $status[$chat['status']];
			}
			
			$link = getLink($chat[DB_USERTABLE_LINK]);
			$avatar = getAvatar($chat[DB_USERTABLE_USERID],$chat[DB_USERTABLE_AVATAR]);
                        
			if (!empty($chat[DB_USERTABLE_NAME])) {
				$buddyList[] = array('id' => $chat[DB_USERTABLE_USERID], 'n' => $chat[DB_USERTABLE_NAME], 's' => $chat['status'], 'm' => $chat['message'], 'a' => $avatar, 'l' => $link);
			}
                    }

		}

		if (function_exists('hooks_forcefriends') && is_array(hooks_forcefriends())) {
			$buddyList = array_merge(hooks_forcefriends(),$buddyList);
		}

		$_SESSION['cometchat_buddytime'] = $time;	
		$response['buddylist'] = $buddyList;
	}
}
  
function fetchMessages() {
	global $response;
	global $userid;
	global $db;
	global $messages;
	$timestamp = 0;
	
	$sql = ("select cometchat.id, cometchat.from, cometchat.to, cometchat.message, cometchat.sent, cometchat.read from cometchat where ((cometchat.to = '".mysql_real_escape_string($userid)."' and cometchat.direction <> 2) or (cometchat.from = '".mysql_real_escape_string($userid)."' and cometchat.direction <> 1)) and (cometchat.id > '".mysql_real_escape_string($_POST['timestamp'])."' or (cometchat.to = '".mysql_real_escape_string($userid)."' and cometchat.read != 1)) order by cometchat.id");
	$query = mysql_query($sql);
	if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
 
	while ($chat = mysql_fetch_array($query)) {
		$self = 0;
		$old = 0;
		if ($chat['from'] == $userid) {
			$chat['from'] = $chat['to'];
			$self = 1;
			$old = 1;
		}

		if ($chat['read'] == 1) {
			$old = 1;
		}

		$messages[] = array('id' => $chat['id'], 'from' => $chat['from'], 'message' => $chat['message'], 'self' => $self, 'old' => $old, 'sent' => ($chat['sent']+$_SESSION['timedifference']));

		if ($self == 0 && $old == 0 && $chat['read'] != 1) {
			$_SESSION['cometchat_user_'.$chat['from']][] = array('id' => $chat['id'], 'from' => $chat['from'], 'message' => $chat['message'], 'self' => 0, 'old' => 1, 'sent' => ($chat['sent']+$_SESSION['timedifference']));
		}


		$timestamp = $chat['id'];
	}	

	if (!empty($messages)) {
		$sql = ("update cometchat set cometchat.read = '1' where cometchat.to = '".mysql_real_escape_string($userid)."' and cometchat.id <= '".mysql_real_escape_string($timestamp)."'");
		$query = mysql_query($sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysql_error(); }
			
	}
}

if (!empty($messages)) {
	$response['messages'] = $messages;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($response);
exit;