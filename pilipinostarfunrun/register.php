<?php
$connection = mysql_connect("localhost", "agilityp", "P@ssword1");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

?>
<html>
<head>
<title>PSNgayon Fun Run - Registration</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="js/datePicker.js"></script>
<link type="text/css" rel="stylesheet" href="application.css" />
<style type="text/css">
.success {
	color: #333;
	background:#FFFDD0;
	width:50%;
	border: 1px solid #000;
	text-align:center;
}

#link{

color: yellow; 
font-size: 8pt; 
background: none; 
cursor: pointer;
padding: 2px;
border:none;


}


</style>
<script type="text/javascript" src="js/date.js"></script>
<link rel="stylesheet" href="stylesheets/datepicker.css" type="text/css">
<script type="text/javascript">
     $(function(){
		$('.date-pick').datePicker({startDate: '1960-01-01', clickInput:true})

            });

</script>

<script type="text/javascript">
function checkval()
{
	
   if(document.getElementById("type_of_race").value == "" || document.getElementById("type_of_race").value == "Select")
    {
        alert("Please Select Type of Race");
        return false;
    }
	else if(document.getElementById("last_name").value == "")
    {
        alert("Please Enter Last Name");
        return false;
    }
	else if(document.getElementById("first_name").value == "")
    {
        alert("Please Enter First Name");
        return false;
    }
	else if(document.getElementById("middle_name").value == "")
    {
        alert("Please Enter Middle Name");
        return false;
    }
	 else if(!document.register.gender[0].checked && !document.register.gender[1].checked)
    {
        alert("please choose your gender");
        return false;
    }
	else if(document.getElementById("birthdate").value == "")
    {
        alert("Please Enter Birth Date");
        return false;
    }
	else if(document.getElementById("age").value == "")
    {
        alert("Please Enter Age");
        return false;
    }
	else if(document.getElementById("nationality").value == "")
    {
        alert("Please Enter Nationality");
        return false;
    }
	else if(document.getElementById("address").value == "")
    {
        alert("Please Enter Address");
        return false;
    }
	else if(document.getElementById("contactno").value == "")
    {
        alert("Please Enter Contact No");
        return false;
    }
	else if(document.getElementById("email").value == "")
    {
        alert("Please Enter Email");
        return false;
    }
	else if(document.getElementById("incase").value == "")
    {
        alert("Please Enter Contact info in case of emergency");
        return false;
    }
	
	else if(document.getElementById("singlet_size").value == "" || document.getElementById("singlet_size").value == "Select")
    {
        alert("Please Select Singlet Size");
        return false;
    }
    	else if(document.getElementById("race_kit").value == "" || document.getElementById("race_kit").value == "Select")
    {
        alert("Please choose the branch that you want");
        return false;
    }
	else if(!document.register.terms.checked)
    {
        alert("please agree to terms and conditions");
        return false;
    }
	else 
    {
      
        return true;
    }

}

</script>
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
		<br/>
			<h3>Rules and Regulations </h3>

			<p>PARTICIPANTS BELOW 18 YEARS OLD MUST HAVE THEIR ENTRIES SIGNED BY A PARENT OR A GUARDIAN.
<br/><br/>RACE BIB NUMBERS AND ELECTRONIC TIMING CHIPS MUST BE WORN AT ALL TIMES DURING THE RACE.
<br/><br/> IT SHOULD BE PINNED IN-FRONT OF YOUR RUNNING SHIRT. NO CHANGE OF CATEGORY.<br/><br/>
ALL PROTESTS RELATED TO THE RESULT MUST BE MADE IN WRITING AND SUBMITTED TO THE RACE ORGANIZER WITHIN 30 MINUTES AFTER THE OFFICIAL ANNOUNCEMENT OF WINNERS. A PROTEST FEE OF PHP500 WILL BE COLLECTED FOR EVERY WRITTEN PROTEST MADE.
THE ORGANIZER&#8217;S DECISION IS FINAL.

</p>

		</div>
		
		
	</div>
	
	<!- -------------------------- CONTENT STARTS HERE -------------------------- ->
	<div id="content-all">
		<!- ---- MGA LAMAN AT INFO PATI MGA REGISTRATION FIELDS DITO NKALAGAY SA DIV NA TO ----- ->
		<div id="laman">
		
			<br/>
			<h2 style="font-size: 20px;letter-spacing: 0px; text-decoration: underline; text-align: center; with: 994px;">ONLINE REGISTRATION FORM</h2>
	                <br/>
	                <div align="right"><a id="link" href="http://pilipinostarfunrun.agilitypilipinas.com/map_and_reg.zip" style="font-size: 8pt; "> Download Maps and Registration Form</a></div>	
			
			<div style="position:relative; height: auto;">
			<fieldset>
			<legend>Enter Your Details</legend>
			<br/>
			<?
				if($_POST['Submit']) 
				{
					$last = $_POST['last_name'];
					$first = $_POST['first_name'];
					$mid = $_POST['middle_name'];
					$age = $_POST['age'];
					$nat = $_POST['nationality'];
					$bday = $_POST['birthdate'];
					$add = $_POST['address'];
					$gender = $_POST['gender'];
					$contact = $_POST['contactno'];
					$email = $_POST['email'];
					$type = $_POST['type_of_race'];
					$incase = $_POST['incase'];
					$singlet = $_POST['singlet_size'];
					$time = time(); 
					$dateformat = date("Y-m-j H:i:s", $time);
					$race_kit = $_POST['race_kit'];
					
					
					$dupname = mysql_query("SELECT * FROM runners where last_name= '$last' and first_name='$first' ", $connection);
                                        $row = mysql_fetch_array($dupname);
                                        
                                        if($row == '')
                                        {
					
					
			
				$sql = "insert runners(last_name, first_name, middle_name, age, birthdate, contactno, nationality, gender, email, type_of_race, singlet_size, incase, address, created_at, race_kits_claim) values('$last', '$first', '$mid', $age, '$bday', '$contact', '$nat', '$gender', '$email', '$type', '$singlet', '$incase', '$add', '$dateformat', '$race_kit')";
				$update_query = mysql_query($sql);
				
					require_once 'Swift/lib/swift_required.php';
					$transport = Swift_SmtpTransport::newInstance('mail.agilitypilipinas.com', 26)
					  ->setUsername('no-reply@agilitypilipinas.com')
					  ->setPassword('P@ssword1');
					$mailer = Swift_Mailer::newInstance($transport);
					$message = Swift_Message::newInstance('[Successful Registration] Pilipino Star Ngayon Fun Run')
					  ->setFrom(array('no-reply@agilitypilipinas.com' => 'Runningmate'))
					  ->setCc(array('maiamahit@yahoo.com', 'nikki_gabitan@yahoo.com.ph'))
					  ->setTo(array($email, $email => $first))
					  ->setBody("Congratulations <br /><br />You have successfully registered to the upcoming Pilipino Star Ngayon Fun Run. <br /><br />The following information has been sent to us: <br /> <br />Name: $last, $first $mid<br />Email Address: $email <br />Race type: $type <br />Singlet Size: $singlet<br />Mobile No.: $contact<br />Birthday: $bday<br/>Claiming your race kit at: $race_kit<br /><br />Fees for 3K, 5K, and 10K <br /><br /><table border=0><th>Distance</th><th>Fee</th><tr><td>3K & 5K</td><td>350</td></tr><tr><td>10K</td><td>400</td></tr></table>
						<br /> Includes: Race Bib, Timing Chip, Singlet & Route Map <br /> <br />
						Registration, Payment & Redemption <br />
						Late Registration begins May 7, 2010 <br />
						LATE REGISTRANTS, singlet is subject to availability<br /><br />
						PSN, INC-R. Oca, corner Railroad St. Port Area, Mla <br />
						9am-5pm(Mon-Fri) <br /><br />
						Payment instructions<br /><br />
						Please make a cash deposit on the ff account:<br />
						Account Name: Pilipino Star Ngayon Inc.<br />
						Account No[BDO].: 2588-011-642<br />
						Account No[BPI].: 004993-0220-85 <br /><br />
						See you on May 15, 2010, 5am at SM Mall of Asia.<br/><br/>
						Goodluck, <br /><br />
						--Pilipino Star Ngayon<br /><br />
						The Runningmate Team
", "text/html");
					$result = $mailer->send($message);
				 
				 echo '<script>';
				echo 'window.location.replace("confirm.php?msg=assss4533lgmb")';
				echo '</script>';
				}
				else{
				    echo '<script>';
				    echo 'alert("You are already registered!")';
				    echo '</script>';
				
				}
		
			
				
				}
			
			
			
			
			?>
			
			
			
			
			
			<form name="register" method="post" action="register.php" onSubmit="return checkval()">
			
			 <div class="form_row">
			<label>Type of Race: </label>
			 <select name="type_of_race" size="1" id="type_of_race">
			  <option selected>Select</option>
			  <option value="3K">3K</option>
			  <option value="5K">5K</option>
			  <option value="10K">10K</option>
			</select>
		 </div>
		 
			<div class="form_row">
			<label>Last Name: </label>
			<input type="text" name="last_name" id="last_name" size="30"/>
			</div>
			
			<div class="form_row">
			<label>First Name: </label>
			<input type="text" name="first_name" id="first_name" size="30"/>
			</div>
			
			<div class="form_row">
			<label>Middle Name: </label>
			<input type="text" name="middle_name" id="middle_name" size="30"/>
			</div>
			
			<div class="form_row">
        	<label>Gender: </label>
            	 <input name="gender" type="radio"  value="Male">Male
				<input name="gender" type="radio" value="Female">Female
			</div>
			
			<div class="form_row">
			<label>Date of Birth: </label>
				<input type="text" name="birthdate" id="birthdate" class="date-pick"/>
			</div>
			
			<div class="form_row">
			
			<label>Age: </label>
			<input type="text" name="age" id="age" size="5"/>
			</div>
			
			<div class="form_row">
			<label>Nationality: </label>
			<input type="text" name="nationality" id="nationality" size="30"/>
			</div>
			
			<div class="form_row">
			<label>Address: </label>
			<input type="text" name="address" id="address" size="80"/>
			</div>
			
			<div class="form_row">
			<label>Contact No: </label>
			<input type="text" name="contactno" id="contactno" size="30"/>
			</div>
			
			<div class="form_row">
			<label>Email: </label>
			<input type="text" name="email" id="email" size="30"/>
			</div>
			
			<div class="form_row">
			<label style="font-size:8.5pt;">In Case of Emergency:</label>&nbsp;
			<input type="text" name="incase" id="incase" size="40"/> &nbsp;(name and contact no.)
			</div>
			
			<div class="form_row">
			<label>Singlet Size: </label>
			 <select name="singlet_size" id="singlet_size">
			  <option selected>Select</option>
			  <option value="S">Small</option>
			  <option value="M">Medium</option>
			  <option value="L">Large</option>
			  <option value="XL">X-Large</option>
			</select>
			</div>

	<div class="form_row">
			<label>Claiming race kits: </label>
			 <select name="race_kit" id="race_kit">
			  <option selected>Select</option>
			  <option value="R.O.X. Recreational Outdoor Exchange">R.O.X. Recreational Outdoor Exchange</option>
			  <option value="Boni High Street, Global City">Boni High Street, Global City</option>
			  <option value="CHRIS SPORTS SM NORTH EDSA F-104 Ground Floor, Quezon City">CHRIS SPORTS SM NORTH EDSA F-104 Ground Floor, Quezon City</option>
			  <option value="CHRIS SPORTS SM MEGAMALL Bldg. B Lower Ground Floor">CHRIS SPORTS SM MEGAMALL Bldg. B Lower Ground Floor</option>
<option value="CHRIS SPORTS MALL OF ASIA Main mall 2nd Floor Bay Blvd 
Manila">CHRIS SPORTS MALL OF ASIA Main mall 2nd Floor Bay Blvd 
Manila</option>
<option value="7">CHRIS SPORTS SM SUCAT F-106 Ground Floor SM Super Center</option>
			</select>
			</div>
			
			<label for="payment">
				Payment: 
			</label>	
			<div id="terms">
			     Acct. Name : Pilipino Star Ngayon Inc. <br />
			     (BDO) Acct. No. 2588-011-642 <br />
			      Bank/Branch:Bank of the Philippine Islands <br/>
				 (BPI) Acct. No. 004993-0220-85
			<ol>
			<li>Write your name on the deposit slip and fax to 527-6852</li>
			<li>Present your ID at the Registration Booth between 4:00am  5:30am on the day of the event to claim your Race Kit.</li>
			<li>For inquiries call 527-6852 or 521-3995.</li>
			</ol>
			</div>	

		<br />  
		<div>
			<label>Terms & Conditon:  </label>
		<div id="terms" style="text-transform:titlecase;">
         I understand that my participation in any of the 3, 5 and 10 km 
		 runs involves risks in running or walking a public road and 
		 such hazards include those from and not limited to motorists, 
		 participants, spectators, weather conditions and my own health. 
		 I voluntarily assume such risks and hold the organizers free and harmless 
		 from any liability, claim or action arising from any injury, disability or 
		 damage that i may suffer. I certify that i am physically fit to participate in this 
		 event and that i have been examined by a competent medical personnel who allowed me to 
		 participate herein. I give my consent to the organizers to administer emergency medical treatment 
		 in the event that is needed. Finally, i authorize the organizers to use my name, image and voice 
		 without any payment in any broadcast and print media for the purpose of promoting and marketing the event 
		 and the sponsorships and for any other legitimate purpose.
         </div>
   </div>
	   <br />
		 
		  <div class="form_row">
		  <label>Yes, I accept </label>  
		 <input name="terms" type="checkbox" id="terms" value="1" />
		 
		  </div>
		  <br/>
		  <div>
		   <input type="submit" name="Submit" value="Submit" class="submit">
			<input name="Reset" type="reset" id="Reset" value="Reset">
		  </div>
			</form>
			
			</fieldset>	
				
			</div>
			
			<p id="yellow-text" style="position: relative; margin: 20px 0px 10px 0px;">Media Partners:</p>
			<img src="images/sponsors.gif" />
			
		</div>
		<!- ----- HANGGANG DITO UNG LAMAN ------ ->
	</div>
	
	<div id="footer"></div>
</body>
</html>