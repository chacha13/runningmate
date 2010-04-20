<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* BASE URL */
define('BASE_URL','/cometchat/');


/* PARAMETER SWITCHES */

// Do you want to show all users online(1) or friends only(0)?
$all_users = 0;				

// Do you want to show Full Name(1) or NickName(0)?
$full_name = 1;				

/* ICONS */

$trayicon[] = array('home.png','Home','/');
$trayicon[] = array('chatrooms.png','Chatrooms',BASE_URL.'modules/chatrooms/index.php','_popup','650','300');
$trayicon[] = array('help.png','Available soon!',BASE_URL.'modules/applications/index.php','_popup','500','300');

/* BANNED WORDS */

$bannedWords = array(

	'BADWORD1','BADWORD2'

); 

/* ADMIN */

define('ADMIN_USER','Username');
define('ADMIN_PASS','Password');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

//include_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."/include/database_config.php";

define('DB_SERVER','localhost');
define('DB_PORT','3306');
define('DB_USERNAME','agilityp');
define('DB_PASSWORD','P@ssword1');
define('DB_NAME','agilityp_running');
define('TABLE_PREFIX','chat_');

define('DB_USERTABLE','se_users');
define('DB_USERTABLE_USERID','user_id');
if ($full_name != 0)
  define('DB_USERTABLE_NAME','user_displayname');
else  
  define('DB_USERTABLE_NAME','user_username');
define('DB_USERTABLE_LINK','user_username');
define('DB_USERTABLE_LASTACTIVITY','user_lastactive');
define('DB_USERTABLE_AVATAR','user_photo');

define('DB_FRIENDTABLE','se_friends');
define('DB_FRIENDTABLE_STATUS','friend_status');
define('DB_FRIENDTABLE_USERDID','friend_user_id1');
define('DB_FRIENDTABLE_FRIENDID','friend_user_id2');

define('DB_ONLINETABLE','se_visitors');
define('DB_ONLINETABLE_ID','visitor_user_id');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LANGUAGE */

$language[0]	=	"Options";
$language[1]	=	"Type your status and hit the enter key!";
$language[2]	=	"My Status";
$language[3]	=	"Available";
$language[4]	=	"Busy";
$language[5]	=	"Invisible";
$language[6]	=	"";
$language[7]	=	"";
$language[8]	=	"Please login to use the ChatBar";
$language[9]	=	"Who\'s Online";
$language[10]	=	"Me";
$language[11]	=	"Go Offline";
$language[12]	=	"Who\'s Online";
$language[13]	=	"Disable sound notifications";
$language[14]	=	"There are no members available on the chat-bar";
$language[15]	=	"New Messages...";
$language[16]	=	""; // Login link when user clicks on yellow triangle (specify only link i.e. http://yoursite.com/login.php)
$language[17]	=	"Offline";

$status['available']	=	"I'm available";
$status['busy']		=	"I'm busy";
$status['offline']	=	"I'm offline";
$status['invisible']	=	"I'm offline";


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* PLUGINS */

$plugins = array(

	'filetransfer',
	'divider',
	'chattime'

);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* SMILEYS */

$smileys = array( 

	':)'	=>	'smiley',
	':-)'	=>	'smiley',
	':('	=>	'smiley-sad',
	':-('	=>	'smiley-sad',
	':D'	=>	'smiley-lol',
	';-)'	=>	'smiley-wink',
	';)'	=>	'smiley-wink',
	':o'	=>	'smiley-surprise',
	':-o'	=>	'smiley-surprise',
	'8-)'	=>	'smiley-cool',
	'8)'	=>	'smiley-cool',
	':|'	=>	'smiley-neutral',
	':-|'	=>	'smiley-neutral',
	":'("	=>	'smiley-cry',
	":'-("	=>	'smiley-cry',
	":p"	=>	'smiley-razz',
	":-p"	=>	'smiley-razz',
	":s"	=>	'smiley-confuse',
	":-s"	=>	'smiley-confuse',
	":x"	=>	'smiley-mad',
	":-x"	=>	'smiley-mad',

);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* COOKIE */

$cookiePrefix = 'cc_';				// Modify only if you have multiple CometChat instances on the same site

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* THEME */

$theme = 'default';					// Default theme, if no cookie preference is found

if ($_COOKIE[$cookiePrefix."theme"]) {
	$theme = $_COOKIE[$cookiePrefix."theme"];
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* MISCELLANEOUS */

$autoPopupChatbox = 0;				// Auto-open chatbox when a new message arrives
$messageBeep = 1;					// Beep on arrival of new messages (user can over-ride this setting)
$minHeartbeat = 3000;				// Minimum poll-time
$maxHeartbeat = 12000;				// Maximum poll-time
define('REFRESH_BUDDYLIST','60');	// Time in seconds after which the user's "Who's Online" list is refreshed
define('ONLINE_TIMEOUT','300');		// Time in sec after which a user is considered offline
define('DISABLE_SMILEYS','0');		// Set to 1 if you want to disable smileys
define('DISABLE_LINKING','0');		// Set to 1 if you want to disable auto linking
define('DISABLE_YOUTUBE','0');		// Set to 1 if you want to disable YouTube thumbnail

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('DEV_MODE','1');					// Set to 1 only during development
define('ERROR_LOGGING','1');			// Set to 1 to log all errors (error.log file)
define('SET_SESSION_NAME','');			// Session name
define('DO_NOT_START_SESSION','0');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','0');	// Set to 1 if you do not want to destroy session on logout

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

error_reporting(E_ALL);
ini_set('display_errors','Off');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

function getUserID() {

          $userid = 0;
	  
          if (!empty($_COOKIE['se_auth_token'])) {
            $sql = ("select session_auth_user_id from ".TABLE_PREFIX."se_session_auth where session_auth_key = '".mysql_real_escape_string($_COOKIE['se_auth_token'])."'");
            $query = mysql_query($sql);
            $session = mysql_fetch_array($query);
            $userid = $session['session_auth_user_id'];		
          }

	return $userid;

}

function getFriendsList($userid,$time) {
	// This is the old friends list function
	// Two new fields have to be returned -> avatar and link
	// The remaining logic is exactly the same as before

global $all_users;

if ($all_users == 1){
  $sql = ("SELECT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LINK.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_AVATAR.", cometchat_status.message, cometchat_status.status FROM ".TABLE_PREFIX.DB_USERTABLE." LEFT JOIN cometchat_status ON ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid WHERE ".TABLE_PREFIX.DB_USERTABLE.".user_enabled = '1' AND ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." <> '".mysql_real_escape_string($userid)."' order by user_displayname asc");}

if ($all_users == 0){
$sql = ("SELECT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LINK.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY.", ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_AVATAR.", cometchat_status.message, cometchat_status.`status` FROM ".TABLE_PREFIX.DB_FRIENDTABLE." INNER JOIN ".TABLE_PREFIX.DB_USERTABLE." ON (".TABLE_PREFIX.DB_FRIENDTABLE.".".DB_FRIENDTABLE_FRIENDID." = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID.") LEFT OUTER JOIN cometchat_status ON (".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid) WHERE ".TABLE_PREFIX.DB_FRIENDTABLE.".".DB_FRIENDTABLE_STATUS." = 1 AND ".TABLE_PREFIX.DB_FRIENDTABLE.".".DB_FRIENDTABLE_USERDID." = '".mysql_real_escape_string($userid)."'");}
  
	return $sql;

}

function getOnlineList($userid) {
	// This is the old friends list function
	// Two new fields have to be returned -> avatar and link
	// The remaining logic is exactly the same as before

$sql = ("SELECT se_visitors.visitor_user_id FROM se_visitors WHERE se_visitors.visitor_user_id = '".mysql_real_escape_string($userid)."' AND se_visitors.visitor_user_id <> 0");
  
	return $sql;

}

function getUserDetails($userid) {
	// This is a new function used to retrieve individual user details

	
}

function updateLastActivity($userid) {
	// Update timestamp

	$sql = ("update `".TABLE_PREFIX.DB_USERTABLE."` set ".DB_USERTABLE_LASTACTIVITY." = '".getTimeStamp()."' where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
 
}

function getUserStatus($userid) {
	$sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where cometchat_status.userid = ".mysql_real_escape_string($userid));
	return $sql;
}

function getLink($link) {
	// You can use this to post process the link which is received from the friends list function
	return "profile.php?user=".$link;
}

function getAvatar($ID, $image) {

      $subdir = 1000;
      if ($image != ''){
        while (($ID-$subdir) > 0){ 
          $subdir = $subdir + 1000;
        }
        return "uploads_user/".$subdir."/".$ID."/".$image;
      } else{
          return BASE_URL."images/noimage.png".$image;
        }		
        
}

function getLoggedInUser($userid) { 
    include_once ("cometchat_init.php"); 

    $loggedInUser = "Guest";

    $sql = ("SELECT ".DB_USERTABLE_NAME." name from ".TABLE_PREFIX.DB_USERTABLE." where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");  
    $result = mysql_query($sql); 
    if ($result && mysql_num_rows($result))  {
        $row = mysql_fetch_assoc($result); 
	$loggedInUser = $row['name']; 
    }

    $pieces = explode(" ", $loggedInUser);

    return $pieces[0]; 
}  

function getTimeStamp() {
	return time();
}

function processTime($time) {
	return time();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	/* Add your own custom hook when user updates status message */
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$unsanitizedmessage) {
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////