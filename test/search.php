<?php
session_start();
	if(!isset($_SESSION['user_id']))
	{
		echo '<script>';
		echo 'window.location.replace("login.php")';
		echo '</script>';
	}
$connection = mysql_connect ("localhost", "", "");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

$user_id = $_SESSION['user_id'];

$rs = mysql_query("SELECT * FROM users WHERE email = 'aloys.mendoza@gmail.com'", $connection);
$ms = mysql_fetch_array($rs);

include_once("functions.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Runningmate / Home</title>
<script type="text/javascript" src="javascripts/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="stylesheets/application.css" />
<style type="text/css">
.fb6 {
width: 400px;
border: 1px solid #cccccc;
background:#fff;
text-align:left;
}


.fb6a, .fb6b, .fb6c {
	float: left;
}


.fb6b {
	padding:10px;
	width: 190px;
}

.fb6b a {
font-size:12px;
color: #3B5998;
text-decoration: none;
}

.fb6b a:hover {
text-decoration: underline;
}


.fb6c a {

}


.fb6c a {

	color: #3B5998;
	text-decoration:none;
}

.fb6c a:hover {
	color: #FFF;
	background:#3B5998;
	}


.fb6c li {
margin: 0px;
padding-left:5px;
	width: 75px;
	list-style:none;
	color: #3B5998;
	border-bottom: 1px solid #d8dfea;
	line-height: 15px;
	font-size:11px;
	font-weight: normal;
		display:block;
}

.fb6c li:hover  {
	color: #FFF;
	background-color:#3B5998;
}


.fb6cname {
	font-weight:normal;
	font-size: 11px;
	color:#999999;
}

.fbpost {
	font-size: x-small;
}


.fb, .fb1, .fb2, .fb3, .fb4, .fb5, .fb6 {
padding: 10px;
font-family: "lucida grande", tahoma, verdana, arial, sans-serif;
font-size: 12px;
font-weight: bold;
}


</style>
<script type="text/javascript">
$(document).ready(function() {
$(".follow").click(function(){
var element = $(this);
var noteid = element.attr("id");
var info = 'id=' + noteid;

 $.ajax({
   type: "POST",
   url: "add_friend.php",
   data: info,
   success: function(){}
 });
 
  $(this).html('<span class="friendreq">Friend Requested</span>');  
	
return false;

});

});
</script>
</head>

<body>
<div id="bg">
    <div id="wrapper">

      
    <div class="top"> <a href="index.php">Home</a> <a href="profile.php">Profile</a> <a href="logout.php">Logout</a>
      <div class="clear"></div>
 
      </div>
      <div>  
<div class="left front_column_r">
<form name="search" action="search.php" method="get">
	<div id="search_box">
	      Search Runners: <input id="q" name="q" type="text">
	      <input type="submit" name="submit" value="Search" class="button" />
	      <? //<a href="javascript:void(0);" id="search_x" onclick="jq('#q').val('');" style="margin-left: -15px; z-index: 1000;">x</a> ?>
	</div>
</form>
</div>

        <div class="left" style="width: 450px; padding-right: 20px;">
 <?php

  // Get the search variable from URL

  $var = $_GET['q'] ;
  $trimmed = trim($var);
  $limit=10; 
?>     
<h1>Search Result</h1>
<?
if($var !=''){
$query = "select * from users where firstname LIKE \"%$trimmed%\" OR lastname like \"%$trimmed%\" OR email like \"%$trimmed%\"
  order by lastname"; // EDIT HERE and specify your table and field names for the SQL query

 $numresults=mysql_query($query);
 $numrows=mysql_num_rows($numresults);

// If we have no results, offer a google search as an alternative

if ($numrows == 0)
  {
  echo "<h4>Results</h4>";
  echo "<p>Sorry, your search: &quot;" . $trimmed . "&quot; returned zero results</p>";

// google
 echo "<p><a href=\"http://www.google.com/search?q=" 
  . $trimmed . "\" target=\"_blank\" title=\"Look up 
  " . $trimmed . " on Google\">Click here</a> to try the 
  search on google</p>";
  }

// next determine if s has been passed to script, if not use 0
  if (empty($s)) {
  $s=0;
  }

// get results
  $query .= " limit $s,$limit";
  $result = mysql_query($query) or die("Couldn't execute query");

// display what the person searched for
echo "<p>You searched for: &quot;" . $var . "&quot;</p>";

// begin to show results set
echo "Results<br />";


// now you can display the results returned

  
  while ($row = mysql_fetch_array($result)) {
  
  $result_friend = mysql_query("SELECT * FROM friendships WHERE friend_id = '$row[0]' AND status = 'pending'", $connection);
  $myrow_friend = mysql_fetch_array($result_friend);
  
  $result_accept = mysql_query("SELECT * FROM friendships WHERE friend_id = '$row[0]' AND status = 'accepted'", $connection);
  $myrow_accept = mysql_fetch_array($result_accept);
  
  	echo '<div class="fb6">';
	echo '<div class="fb6a">';
	echo '<img src="http://photos-d.ak.fbcdn.net/hphotos-ak-snc3/hs115.snc3/16241_174754310886_516455886_3447346_7929532_n.jpg" width="87" align="absmiddle" height="124"></div>';

	echo '<div class="fb6b">'; 
        echo '<span class="fb6cname">Name: </span>';
        
        echo '<a href="profile.php?uid='.$row[0].'">';
        echo $row['firstname'].' '.$row['lastname'];
        echo '</a>';
	echo '<br><br></div>';
  
  	echo '<div class="fb6c">';
	echo '<ul>';
	if($row[0] == $user_id){
		echo '<li>This is you</li>';
	        echo '<li>V&#246;kur&#243; Bj&#246;rk</li>';
        }
        else {
        	if($myrow_friend[2] == $row[0] && $myrow_friend['status'] == 'pending' && $myrow_friend[1] == $user_id) {
        		echo '<li>Friend Requested</li>';
        	}
        	else if($myrow_accept[2] == $row[0] && $myrow_accept['status'] == 'accepted') {
        		echo "";
        	}
        	else {
        		echo '<li><a href="#" class="follow" id="'.$row[0].'">Add as V&#246;kur&#243;</a></li>';
        	}
	        echo '<li><a href="#">Send Message</a></li>';
        }
        echo '</ul>';
        echo '</div><br style="clear: both;"></div>';

  }
  

  $currPage = (($s/$limit) + 1);
  echo "<br />";

  if ($s>=1) { 
  $prevs=($s-$limit);
  print "&nbsp;<a href=\"$PHP_SELF?s=$prevs&q=$var\">&lt;&lt; Prev 10</a>&nbsp&nbsp;";
  }
  
  $pages=intval($numrows/$limit);

  if ($numrows%$limit) {
  $pages++;
  }
  
  if (!((($s+$limit)/$limit)==$pages) && $pages!=1) {
  $news = $s+$limit;

  echo "&nbsp;<a href=\"$PHP_SELF?s=$news&q=$var\">Next 10 &gt;&gt;</a>";
  }

  $a = $s + ($limit) ;
  if ($a > $numrows) { $a = $numrows ; }
  $b = $s + 1 ;
  echo "<p>Showing results $b to $a of $numrows</p>";
 }
?>



    
</div>

        

<div class="clear"></div>
</div>

<div id="footer">
  <p>
This app was built with <strong>27</strong> man hours by <a href="http://2amiserv.ph" target="_blank">2AM Interactive</a>
</p>
  <p>
<a href="http://tangkilikan.com.ph" target="_blank">Tangkilikan.com.ph</a> | <a href="http://runningmate.ph" target="_blank">Runningmate.ph</a>

</p>
</div>

      </div>
    </div>
</body>
</html>