<html>
<head>
<title>PSNgayon Fun Run</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="application.css" />
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
			<? if($_GET['msg'] == 'assss4533lgmb'){ ?>
			
			<br/>
			<h1>Congratulations</h1>
<br/><br/>
			<p>You have successfully registered to the "Bigay-TODO sa Pagtakbo Fun Run for a Cause". We will contact you for verification and instructions to claim your race kit.  </p>
			
			<p>See you at the Race!!!</p>
		</div>
		<? } else{
				echo '<script>';
				echo 'window.location.replace("register.php")';
				echo '</script>';
		
		}?>
		
	</div>
	
	<!- -------------------------- CONTENT STARTS HERE -------------------------- ->
	<div id="content-all">
		<!- ---- MGA LAMAN AT INFO PATI MGA REGISTRATION FIELDS DITO NKALAGAY SA DIV NA TO ----- ->
		<div id="laman">
		
			
			
			
			<div style="position:relative; height: 102px;">
			
				<div style="float: left; width: 150px; height: 100px;clear:right;">
					
				</div>
			</div>
			
			<p id="yellow-text" style="position: relative; margin: 20px 0px 10px 0px;">Media Partners:</p>
			<img src="images/sponsors.gif" />
			
		</div>
		<!- ----- HANGGANG DITO UNG LAMAN ------ ->
	</div>
	
	<div id="footer"></div>
</body>
</html>