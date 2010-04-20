<?php 

include "config.php";

$baseURL = BASE_URL;

echo <<<EOD

Open the file /templates/header_global.tpl<br/>
<br/>
Find and replace <br/>
<br/>
&lt;head&gt;<br/>
<br/>
With<br/>
<br/>
&lt;head&gt;<br/>
&lt;!-- CometChat Header Code Start --&gt;<br/>
&lt;script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js">&lt;/script&gt; <br/>
&lt;script>jqcc=jQuery.noConflict(false);&lt;/script&gt; <br/> 
&lt;!-- CometChat Hearder Code End --&gt;
<br/>
<br/>
<br/>
Open the file /templates/footer.tpl<br/>
<br/>
Find and replace<br/>
<br/>
&lt;/body&gt;<br/>
<br/>
With<br/>
<br/>
&lt;!-- CometChat Footer Code Start --&gt;<br/>
&lt;link type="text/css" rel="stylesheet" media="all" href="{$baseURL}cometchatcss.php" charset="utf-8" /&gt; <br/>
&lt;script type="text/javascript" src="{$baseURL}cometchatjs.php" charset="utf-8"&gt;&lt;/script&gt; <br/> 
&lt;!-- CometChat Footer Code End --&gt;<br/>
&lt;/body&gt;<br/>
<br/>
<br/>
Refer to the Readme.txt File if Cometchat conflicts with your signup page.  (Returns confirmation code as incorrect)
EOD;

?>