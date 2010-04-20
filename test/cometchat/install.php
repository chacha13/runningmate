<?php

include (dirname(__FILE__))."/cometchat_init.php";

$body = '';
$path = '';

if (empty($_GET)) {
	$body = <<<EOD
<form method="post" action="?step=2">
<strong>NULL and integration done by Spiderman</strong><br/><br/>This Integration was made for SE version 3.17 to 3.20 :
<br/><br/>
<input type="image" src="images/nextstep.gif">
</form>
EOD;
} else {

if ($_GET['step'] == "2") {

$rollback = 0;
$errors = '';

	$content = <<<EOD
RENAME TABLE `cometchat` to `cometchat_old`;
RENAME TABLE `cometchat_status` to `cometchat_status_old`;

CREATE TABLE  `cometchat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL,
  `read` int(10) unsigned NOT NULL,
  `direction` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) DEFAULT CHARSET=utf8;

CREATE TABLE  `cometchat_chatroommessages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL,
  `chatroomid` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `chatroomid` (`chatroomid`),
  KEY `sent` (`sent`)
) DEFAULT CHARSET=utf8;

CREATE TABLE  `cometchat_chatrooms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `lastactivity` int(10) unsigned NOT NULL,
  `createdby` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `lastactivity` (`lastactivity`),
  KEY `createdby` (`createdby`)
) DEFAULT CHARSET=utf8;

CREATE TABLE  `cometchat_chatrooms_users` (
  `userid` int(10) unsigned NOT NULL,
  `chatroomid` int(10) unsigned NOT NULL,
  `lastactivity` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`userid`),
  KEY `chatroomid` (`chatroomid`),
  KEY `lastactivity` (`lastactivity`)
) DEFAULT CHARSET=utf8;

CREATE TABLE  `cometchat_status` (
  `userid` int(10) unsigned NOT NULL,
  `message` text ,
  `status` varchar(10) default NULL,
  PRIMARY KEY  (`userid`)
) DEFAULT CHARSET=utf8;

EOD;
 
	$q = preg_split('/;[\r\n]+/',$content);

	foreach ($q as $query) {
		if (strlen($query) > 4) {
		$result = mysql_query($query);
			if (!$result) {
				$rollback = 1;
				$errors .= mysql_error()."<br/>\n";
			}
		}
	}

	$extra = '';

	$baseurl = preg_replace('/install.php/i','',str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']));

	$file = 'config.php';
	$content = @file_get_contents($file);

	if ($content != '') {

		$myvar = "define('BASE_URL','{$baseurl}');";

		$content = str_replace("define('BASE_URL','cometchat/');",$myvar, $content);

		$f = @fopen($file,'w');
		if($f) {
		  @fwrite($f, $content);
		  @fclose($f);
		} else {
		  $extra = "In config.php set the BASE_URL to {$baseurl} i.e. <b>define('BASE_URL','{$baseurl}');</b>";
		}
	}

	$body = "Database was successfully configured. <br/><a href=\"code.php\">Click here to view the footer code</a><br/><br/>$extra";			
}

}



?>
<html>
<head>
<title>CometChat Setup</title>
<style>
body {
padding:0;
margin:0;
font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size: 14px;
color: #333333;

}
.setup {
width: 398px;
padding:10px;
}

td {
font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size: 14px;
color: #333333;

}

.textbox {
width: 200px;
font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size: 14px;
color: #333333;
border: 1px dotted black;
}
</style>
</head>
<body>
<img src="images/setup.gif"><br clear="all"/>
<img src="<?php echo $path;?>" height=1 width=1>
<div class="setup"><?php echo $body;?>
</div>
</body>
</html>