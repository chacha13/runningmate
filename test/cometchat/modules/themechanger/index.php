<?php

include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php";

$themeslist = '';
$dir = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."themes"; 
$files = scandir($dir); 
foreach ($files as $listedtheme){
	if (is_dir($dir."/".$listedtheme) && $listedtheme != '' && !preg_match('/^\.(.*)/',$listedtheme)) {
		$themename = ucfirst($listedtheme);
		if ($theme != $listedtheme) {
		$themeslist .=  <<<EOD
<a href="javascript:void(0);" onclick="javascript:changeTheme('{$listedtheme}')">{$themename}</a><br/>
EOD;
		}
	}
}

$currenttheme = ucfirst($theme);

echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Chatrooms</title> 
<link type="text/css" rel="stylesheet" media="all" href="themes/{$theme}/themechanger.css" /> 
<script>
function changeTheme(name) {
	set_cookie('theme',name);
	parent.location.reload();
}

function set_cookie(name,value) {
	var today = new Date();
	today.setTime( today.getTime() );
	expires = 1000 * 60 * 60 * 24;
	var expires_date = new Date( today.getTime() + (expires) );
	document.cookie = "{$cookiePrefix}" + name + "=" +escape( value ) + ";path=/" + ";expires=" + expires_date.toGMTString();
}

</script>
</head>
<body>

<div class="container">
<div class="cometchat_tabpopup currentchatroom">

<div class="cometchat_tabcontenttext" id="cometchat_tabcontenttext" style="width:100%;height:100%"><div class="welcomemessage">Current Theme: <b>$currenttheme</b><br/><br/>

<b>Select another theme:</b><br/><br/>{$themeslist}</div></div>

</div>
</div>
</body>
</html>
EOD;
?>