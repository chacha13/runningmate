<?php
include('ps_pagination.php');
$connection = mysql_connect("localhost", "agilityp", "P@ssword1");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

$result = mysql_query("SELECT * FROM runners", $connection);
$row = mysql_fetch_array($result);
?>
<html>
<head>
<title>PSNgayon Fun Run - List of Participants</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="js/datePicker.js"></script>
<link type="text/css" rel="stylesheet" href="application.css" />
<style type="text/css">
table { background:#D3E4E5;
 border:1px solid gray;
 border-collapse:collapse;
 color:#fff;
 font:normal 9px verdana, arial, helvetica, sans-serif;
}
caption { border:1px solid #5C443A;
 color:#5C443A;
 font-weight:bold;
 letter-spacing:20px;
 padding:6px 4px 8px 0px;
 text-align:center;
 text-transform:uppercase;
}
td, th { color:#363636;
 padding:.4em;
}
tr { border:1px dotted gray;
}
thead th, tfoot th { background:#5C443A;
 color:#FFFFFF;
 padding:3px 10px 3px 10px;
 text-align:left;
 text-transform:uppercase;
}
tbody td a { color:#363636;
 text-decoration:none;
}
tbody td a:visited { color:gray;
 text-decoration:line-through;
}
tbody td a:hover { text-decoration:underline;
}
tbody th a { color:#363636;
 font-weight:normal;
 text-decoration:none;
}
tbody th a:hover { color:#363636;
}
tbody td+td+td+td a { background-image:url('bullet_blue.png');
 background-position:left center;
 background-repeat:no-repeat;
 color:#03476F;
 padding-left:15px;
}
tbody td+td+td+td a:visited { background-image:url('bullet_white.png');
 background-position:left center;
 background-repeat:no-repeat;
}
tbody th, tbody td { text-align:left;
 vertical-align:top;
}
tfoot td { background:#5C443A;
 color:#FFFFFF;
 padding-top:3px;
}
.odd { background:#fff;
}
tbody tr:hover { background:#99BCBF;
 border:1px solid #03476F;
 color:#000000;
}
.success {
	color: #333;
	background:#FFFDD0;
	width:50%;
	border: 1px solid #000;
	text-align:center;
}


</style>
<script type="text/javascript" src="js/date.js"></script>
<link rel="stylesheet" href="stylesheets/datepicker.css" type="text/css">

</head>
<body id="bodyInit">

	<div id="header-div"></div>
	<div id="body-div">
		<div id="body-menu">
			<a href="index.htm">home </a>
			<a href="register.php">register </a>
			<a href="list.php">see who's running </a>			
		</div>
		<div id="main-text-div">
			<h1>ADOPT-A-SCHOOL </h1>

			<p>is one of our projects through our umbrella program; BUILDING GREAT BRIDGES (BGB) through Education. Now our ninth year, we chose to adopt San Isidro Elementary School in Naguillan, La Union. Part of the school  building was damaged by typhoon Pepeng last November 2009 leaving part of the school building abandoned. The damaged rooms used to be occupied by grades 2 and 4 pupils.</p>
		</div>
		<div id="main-text-div" style="width: 694px; height: 100px;">
			<p>The water from the behind the school overflowed half the  height of the single story building. For now, grades 2 and 4 pupils share classrooms with other classes until another classroom would be built for them.</p>

			<p><span id="highlight">Operation Damayan </span>aim to build two classrooms and a library for 150 pupils of San Isidro Elem. School. Construction of the proposed classrooms and library is scheduled immediately in time for the opening of school year this June 2010.</p>
		</div>
		
		
	</div>
	
	<!- -------------------------- CONTENT STARTS HERE -------------------------- ->
	<div id="content-all">
		<!- ---- MGA LAMAN AT INFO PATI MGA REGISTRATION FIELDS DITO NKALAGAY SA DIV NA TO ----- ->
		<div id="laman">
		
			
			<h2 style="font-size: 20px;letter-spacing: 0px; text-decoration: underline; text-align: center; with: 994px;">LIST OF PARTICIPANTS</h2>
		
		
			
			
			<div style="position:relative; height: auto;">
			<? if($row !='') {?>

                                   <? $sql1 = "SELECT * FROM runners";
					$pager = new PS_Pagination($connection, $sql1, 30, 10);
					$rs = $pager->paginate();
					if(!$rs) die(mysql_error());
					
				?>

				  <table width="90%" align="center">
				  <tr>
				  <th>Surname</th>
				  <th>Firstname</th>
				  <th>Race Type</th>
				  </tr>
				  <?php
				  	while($row = mysql_fetch_assoc($rs))
					{
						$surname = $row['last_name'];
						$firstname = $row['first_name'];
						$type = $row['type_of_race'];
						
						echo '<tr>';
						echo "<td>$surname</td>";
						echo "<td>$firstname</td>";
						echo "<td>$type</td>";	
						echo '</tr>';
					} 
				 ?>
				  </table><br/>
                                  <?  echo '<center>'.$pager->renderFullNav().'</center>';
				      echo "<br />\n";
					//Display the link to first page: First	    
                                   ?>
			<? }else {?>
				<h2>No participants yet</h2>
			
			<? } ?>
					</div>
			
			<p id="yellow-text" style="position: relative; margin: 20px 0px 10px 0px;">Media Partners:</p>
			<img src="images/sponsors.gif" />
			
		</div>
		<!- ----- HANGGANG DITO UNG LAMAN ------ ->
	</div>
	
	<div id="footer"></div>
</body>
</html>