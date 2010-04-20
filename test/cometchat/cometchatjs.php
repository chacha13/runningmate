<?php

global $userid;

include_once (dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");

$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;

if (phpversion() >= '4.0.4pl1' && (strstr($useragent,'compatible') || strstr($useragent,'Gecko'))) {
        if (extension_loaded('zlib')) {
                ob_start('ob_gzhandler');
        }
}

header('Content-type: text/javascript;charset=utf-8');
header('Expires: '.gmdate("D, d M Y H:i:s", time() + 3600*24*365).' GMT');

$settings = '';

for ($i=0;$i<count($language);$i++) {
        $settings .= "_2[".$i."] = '".$language[$i]."';\n";
}

for ($i=0;$i<count($trayicon);$i++) {
        $settings .= "_3[".$i."] = ['".implode("','",$trayicon[$i])."'];\n";
}

$settings .= "var _4 = ['".implode("','",$plugins)."'];\n";
$settings .= "var _4aa = '".getLoggedInUser($userid)."';";

$settings .= "var _5 = ".$autoPopupChatbox.";";
$settings .= "var _6 = ".$messageBeep.";";
$settings .= "var _7 = '".$theme."';";
$settings .= "var _8 = ".$minHeartbeat.";";
$settings .= "var _9 = ".$maxHeartbeat.";";
$settings .= "var _a = '".$cookiePrefix."';";

include_once (dirname(__FILE__)."/js/libraries.js");echo "\n\n";

include_once (dirname(__FILE__)."/js/cometchat.js");echo "\n\n";

foreach ($plugins as $plugin) {
        if ($plugin != 'divider') {
                include_once (dirname(__FILE__)."/plugins/".$plugin."/init.js");echo "\n\n";
        }
}
//$x0c="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
//$x0d="\x64irn\141\155\145";include($x0d(__FILE__)."\x2f\154\151c\145\x6es\x65.\160\x68p");
//echo $x0c($x0c($license));
echo ('jqcc(document)["ready"]( function(){  jqcc["cometchat"](); jqcc["cometchat"]["eabad1be5eed94cb0232f71c2e5ce5"]()  }) ');