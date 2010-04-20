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

function sanitize($text) {
	global $smileys;
	global $bannedWords;
	$text = htmlspecialchars($text, ENT_NOQUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n"," <br> ",$text);

	for ($i=0;$i < count($bannedWords);$i++){ 
		$text = str_ireplace($bannedWords[$i],$bannedWords[$i][0].str_repeat("*",strlen($bannedWords[$i])-1),$text);      
	}

	$search  = "/([\S]+?\.(a[cdefgilmnoqrstuwz]|b[abdefghijmnorstvwyz]|c[acdfghiklmnoruvxyz]|d[ejkmnoz]|e[ceghrst]|f[ijkmnor]|g[abdefghilmnpqrstuwy]|h[kmnrtu]|i[delmnoqrst]|j[emop]|k[eghimnprwyz]|l[abcikrstuvy]|m[acdghklmnopqrstuvwxyz]|n[acefgilopruz]|om|p[aefghklmnrstwy]|qa|r[eouw]|s[abcdeghijklmnortuvyz]|t[cdfghjkmnoprtvwz]|u[augkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw]|aero|arpa|biz|com|coop|edu|info|int|gov|mil|museum|name|net|org|pro)(\b|\W(?<!&|=)(?!\.\s|\.{3}).*?))(\s|$)/i";
	
	if (DISABLE_LINKING != 1) { 
		$text = preg_replace_callback($search, "autolink", $text);  
	}

	if (DISABLE_SMILEYS != 1) { 
		foreach ($smileys as $pattern => $result) {
			$text = str_ireplace($pattern,'<img class="cometchat_smiley" height="16" width="16" src="'.BASE_URL.'images/smileys/'.$result.'.png" alt="'.$pattern.'">',$text);
		}
	}

	return $text;
}

function autolink($matches) {
	$link = $matches[0];

	if (preg_match("/\@/",$matches[0])) {
		$text = "<a href=\"mailto: {$link}\">{$matches[0]}</a>"; 
	} else {
		if (!preg_match("/(file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp):\/\//",$matches[0])) {
			$link = "http://".$matches[0];
		}

		if (DISABLE_YOUTUBE != 1 && preg_match('#(?:<\>]+href=\")?(?:http://)?((?:[a-zA-Z]{1,4}\.)?youtube.com/(?:watch)?\?v=(.{11}?))[^"]*(?:\"[^\<\>]*>)?([^\<\>]*)(?:)?#',$link,$match)) {
			
			/* 
			
			// Bandwidth intensive function to fetch details about the YouTube video

			$contents = file_get_contents("http://gdata.youtube.com/feeds/api/videos/{$match[2]}?alt=json");

			$data = json_decode($contents);
			$title = $data->entry->title->{'$t'};

			if (strlen($title) > 50) {
				$title = substr($title,0,50)."...";
			}

			$description = substr($data->entry->content->{'$t'},0,100);
			$length = sec2hms($data->entry->{'media$group'}->{'yt$duration'}->seconds);
			$rating = $data->entry->{'gd$rating'}->average; 
			
			*/

			$text = '<a href="'.$link.'" target="_blank">'.$link.'</a><br/><a href="'.$link.'" target="_blank" style="display:inline-block;margin-bottom:3px;margin-top:3px;"><img src="http://img.youtube.com/vi/'.$match[2].'/default.jpg" border="0" style="padding:0px;display: inline-block; width: 120px;height:90px;">
			<div style="margin-top:-30px;text-align: right;width:110px;margin-bottom:10px;">
			<img height="20" border="0" width="20" style="opacity: 0.88;" src="'.BASE_URL.'images/play.gif"/>
			</div></a>'; 

		} else {
			$text = $matches[0];

			if (strlen($matches[0]) > 30) {
				$left = substr($matches[0],0,22);
				$right = substr($matches[0],-5);
				$matches[0] = $left."...".$right;		
			}

			$text = "<a href=\"{$link}\" target=\"_blank\" title=\"{$text}\">{$matches[0]}</a>"; 
		}
	}


	return $text;
}


function sec2hms ($sec, $padHours = true) {
	$hms = "";
	$hours = intval(intval($sec) / 3600); 
	if ($hours != 0) {
		$hms .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':' : $hours. ':';
	}

	$minutes = intval(($sec / 60) % 60); 
	$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
	$seconds = intval($sec % 60); 
	$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	return $hms;
}