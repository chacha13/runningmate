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

include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php";

$body = '';

logs();

function logsview() {
	global $db;
	$usertable = DB_USERTABLE;
	$usertable_username = DB_USERTABLE_NAME;
	$usertable_userid = DB_USERTABLE_USERID;
	global $body;	
	global $userid;

	$data = array();

	if (!empty($_GET['id'])) {
		$data = preg_split("/,/",base64_decode($_GET['id']));
	}

	$sql = ("select m1.*, f.$usertable_username fromu, t.$usertable_username tou from cometchat m1, ".TABLE_PREFIX."$usertable f, ".TABLE_PREFIX."$usertable t  where  f.$usertable_userid = m1.from and t.$usertable_userid = m1.to and ((m1.from = '".mysql_real_escape_string($userid)."') or (m1.to = '".mysql_real_escape_string($userid)."')) and m1.id >= $data[0] and m1.id < $data[1] order by id");

	if (!empty($_GET['history'])) {
		$history = $_GET['history'];
		$sql = ("select m1.*, f.$usertable_username fromu, t.$usertable_username tou from cometchat m1, ".TABLE_PREFIX."$usertable f, ".TABLE_PREFIX."$usertable t  where  f.$usertable_userid = m1.from and t.$usertable_userid = m1.to and ((m1.from = '".mysql_real_escape_string($userid)."' and m1.to = '".mysql_real_escape_string($history)."') or (m1.to = '".mysql_real_escape_string($userid)."' and m1.from = '".mysql_real_escape_string($history)."')) and m1.id >= $data[0] and m1.id < $data[1] order by id");
	}  

	$query = mysql_query($sql); 

	$chatdata = '';
	$previd = '';
	$lines = 0;
	$s = 0;
	while ($chat = mysql_fetch_array($query)) {

		if ($s == 0) { $s = $chat['sent']; }		
		$requester = $chat['fromu'];
		if ($chat['from'] == '1') {
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

	if (!empty($_GET['history'])) {
		$history = '?history='.$_GET['history'];
	}

	$body = <<<EOD
	<script>
		jQuery(document).ready(function () {
 
		});
	</script>
	<div class="chatbar"><div style="float:left">Chat Conversation with $requester ($lines lines)<br> on $time</div><div style="float:right;padding-right:7px;"><a href="index.php$history">Back</a></div><div style="clear:both"></div></div>
	$chatdata
EOD;

	template();
}

function logs() {
	global $db;
	$usertable = DB_USERTABLE;
	$usertable_username = DB_USERTABLE_NAME;
	$usertable_userid = DB_USERTABLE_USERID;
	global $body;	
	global $userid;


	if (!empty($_GET['id'])) { logsview(); }

		$sql = ("select m1.*, f.$usertable_username fromu, t.$usertable_username tou from cometchat m1, ".TABLE_PREFIX."$usertable f, ".TABLE_PREFIX."$usertable t  
	where  f.$usertable_userid = m1.from and t.$usertable_userid = m1.to and ((m1.from = '".mysql_real_escape_string($userid)."') or (m1.to = '".mysql_real_escape_string($userid)."')) and (m1.sent) > ALL
	(select (m2.sent)+1800 from cometchat m2
	where ((m2.to = m1.to and m2.from = m1.from) or (m2.to = m1.from and m2.from = m1.to))
	and m2.sent <= m1.sent and m2.id < m1.id) order by id desc");
	
	if (!empty($_GET['history'])) {
		$history = $_GET['history'];

		$sql = ("select m1.*, f.$usertable_username fromu, t.$usertable_username tou from cometchat m1, ".TABLE_PREFIX."$usertable f, ".TABLE_PREFIX."$usertable t  
	where  f.$usertable_userid = m1.from and t.$usertable_userid = m1.to and ((m1.from = '".mysql_real_escape_string($userid)."' and m1.to = '".mysql_real_escape_string($history)."') or (m1.to = '".mysql_real_escape_string($userid)."' and m1.from = '".mysql_real_escape_string($history)."')) and (m1.sent) > ALL
	(select (m2.sent)+1800 from cometchat m2
	where ((m2.to = m1.to and m2.from = m1.from) or (m2.to = m1.from and m2.from = m1.to))
	and m2.sent <= m1.sent and m2.id < m1.id) order by id desc");
	}  

	$query = mysql_query($sql); 

	$chatdata = '<table>';
	$previd = 1000000;

	while ($chat = mysql_fetch_array($query)) {

		$requester = $chat['fromu'];
		if ($chat['from'] == '1') {
			$requester = $chat['tou'];
			$chat['fromu'] = 'Me';
		}

		$time = date('g:iA M dS', $chat['sent']);
		$chat['message'] = strip_tags($chat['message']);
		$encode = base64_encode($chat['id'].",".$previd);


		$chatdata = <<<EOD
 $chatdata
<div class="chat" id="{$encode}">
			 
			<div class="chatmessage"><b>{$chat['fromu']}</b>: {$chat['message']}</div>
			<div class="chattime">$time</div>
			<div style="clear:both"></div>
</div> 

EOD;
		$previd = $chat['id'];
	}

	$chatdata .= '</table>';

	$history = '';

	if (!empty($_GET['history'])) {
		$history = '+"&history='.$_GET['history'].'"';
	}

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
				location.href = "?action=logs&id="+id$history;
			});
		});
	</script>	
	$chatdata
EOD;

	template();
}


function template() {
global $body;

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Chat History</title> 

<style>
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
	font-weight: inherit;
	font-style: inherit;
	font-size: 100%;
	font-family: inherit;
	vertical-align: baseline;
}

#container {
	margin:0 auto;
	width: 400px;
	padding:20px;
}

#content {
	border-left: 1px solid #ccc;
	border-right: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
	padding: 15px;
}

.message {
	padding: 0px;
	width: 200px;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
 	background-color: #eeeeee;  
	border-bottom: 1px solid #ccc;
	margin-bottom: 5px;
 
	-moz-border-radius-topleft:7px;
	-moz-border-radius-topright:7px;
}

.messageright {
	float:left;
	padding-left: 10px;
	padding-right: 10px;
	padding-top: 10px;
	padding-bottom: 10px;
	width: 265px;
/*	border-left: 1px dotted #0f5d7e; */
}

.messagetime {
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:9px;
	font-weight: bold;
	color: #666666;
}

.chat {
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
	color: #666666;
	padding-top:7px;
	padding-bottom:7px;
	border-bottom:1px solid #ccc;
	display: block;
	width: 350px;
}

.chat a {
	text-decoration: none;
	color: black;
}

a {
	color: black;
}

.chatrequest {
	float:left;
	width:50px;
	padding-left: 5px;
	height: 12px;
	overflow: hidden;
}

.chatmessage {
	float:left;
	width: 220px;

	padding-left:5px;
}

.chattime {
	font-size: 10px;
	float:right;
	text-align: right;
	padding-right: 5px;
}

.chatbg {
	background-color: #efefef;
}

.chatnoline {
	border-bottom: 0px !important;
}

.chattopline {
	border-top:1px solid #ccc;
}

.chatnowrap {
	height: default;
	overflow: show;
}

.chatbar {
	font-weight: bold;
	background-color: #eeeeee;
	border-bottom:1px solid #ccc;
 	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
	color: #666666;
	padding-top:7px;
	padding-bottom:7px;
	padding-left: 7px;
}

 
body {
	overflow-y:scroll;
}


</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

</head>
<body>
<div style="width:98%;margin:0 auto;margin-top: 5px;">
<div style="border-left: 1px solid #11648F;border-top: 1px solid #11648F;border-right: 1px solid #11648F;background-color:#3E92BD;color:#fff;padding:5px;font-weight:bold;font-family:'lucida grande',tahoma,verdana,arial,sans-serif;font-size: 14px;letter-spacing:0px;padding-left:10px;text-align:left;">Chat History</div>

<div style="border-left: 1px solid #cccccc;border-bottom: 1px solid #cccccc;border-right: 1px solid #cccccc;background-color:#fffff;color:#333;padding:5px;font-weight:normal;font-family:'lucida grande',tahoma,verdana,arial,sans-serif;font-size:11px;padding:10px 10px;text-align:left;margin-bottom:10px;">

$body

</div>
</div>
</div>
</body>
</html>
EOD;
exit;
}