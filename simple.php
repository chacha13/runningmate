<?php
  //settings
  
    $T1O    = "1450 Jayhawk Blvd #223 Lawrence, KS 66045"; //company address
  
  //end settings
  
  //they seem to have JS disabled, let's redirect them to
  //Google Maps and prefill the query
  if($_POST['submit']) {
    $FROM  = $_POST['street'] . " " . $_POST['city'] . ", " . $_POST['state'] . " " . $_POST['zip'];
    $LOC   = $_POST['language'];
    
    $url   = "http://maps.google.com/maps?hl=".urlencode($LOC)."&q=from:".urlencode($FROM)."+to:".urlencode($TO)."&ie=UTF8";
    
    header("Location: " . $url);
  }
?>
<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAyvLH69Fw5WP1g3t_zAQEYhSTGyZqpGrvGj6Y6AURwNfG3trA4xRq6_OhIavzrhXeIPszlhLe6FYpeg&sensor=true" type="text/javascript"></script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1.3.2");
	//map.setCenter(new GLatLng(40.00400., -83.09363), 15)
</script>
<script type="text/javascript">
google.setOnLoadCallback(function() {
    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(13.4419, 122.1419), 8);
        map.setUIToDefault();
        GEvent.addListener(map, "click", function(overlay, latlng) {
				var marker = new GMarker(latlng);
				map.addOverlay(marker);
				var lat = marker.getLatlng().lat();
				var lng = marker.getLatLng().lng();
				$.post (
					"update.php",
					(latitude: lat, longitude: lng),
					function(responseText) {
						$("#result").html(responseText);
					},
					"html"
				);
			});
		}
      }
    }
});
    </script>
    <style type="text/css">
    html, body {
  background: #0022b4;
  font-family: Helvetica, Arial, sans-serif;
  font-size: 16px;
}


#pagewrap {
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  
  background: white;
  
  overflow: auto;
  
  margin: 0 auto;
  padding: 10px;
  position: relative;
  width: 900px;
}

  .title {
    text-align: center;
  }
  
  #pagewrap>div {
    float: left;
    width: 49%;
  }
  
/* Map View */
        
        #map_canvas { height: 450px; border: solid thin black; }
        
        
/* Directions */
        #directions {
          float: none;
          width: 100% !important;
        }
  
  
/* Addresses */
        
        #addresses { color: white; }
        
            .address-panel {
              -moz-border-radius: 10px;
              -webkit-border-radius: 10px;
              
              background-color: #e8000d;
              
              overflow: auto;
              
              margin: 0 auto;
              margin-bottom: 10px;
              padding: 10px;
              width: 90%;
            }
                .address-panel>form>div {
                  margin-bottom: 10px;
                }
            
                  .address-form-column {
                    float: left;
                  }
                
                    .address-panel label {
                      display: block;
                    }
                    .address-panel input, .address-panel select { margin-left: 5px; }
                      .address-panel #street { width: 95%; }
                      .address-panel #state { width: 60%; }
                      .address-panel .button { text-align: right; padding-top: 15px; clear: both; }
    </style>
  </head>
  <body onload="initialize()" onunload="GUnload()">
    <div id="pagewrap">
      
      <h1 class="title">How To Find Us!</h1>
      
      <div id="map_canvas"></div>
      
      
      
      
      <div id="addresses">
          <div class="address-panel">
              <h2>Our Address</h2>
              <address>
                1450 Jayhawk Blvd #223<br />
                Lawrence, KS<br />
                66045
              </address>
          </div>
          
          <div class="address-panel">
              <h2>Your Address</h2>
              
              <form action="./index.php" onsubmit="overlayDirections();return false;" method="post">
                  <div>
                    <label for="street">Street Address</label>
                    <input id="street" name="street_address" type="text" />
                  </div>
                  <div>
                    <div class="address-form-column">
                      <label for="city">City</label>
                      <input id="city" name="city" type="text" />
                    </div>
                    
                    <div class="address-form-column">
                      <label for="state">State</label>
                      <select id="state" name="state">
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                      </select>
                    </div>
                    
                    <div class="address-form-column">
                      <label for="zip">Zip Code</label>
                      <input id="zip" name="zip_code" type="text" maxlength="5" size="5" />
                    </div>
                  </div>
                  
                  <div class="button">
                    <select id="language" name="language">
                      <option value="en" selected>English</option>
                      <option value="fr">French</option>                  
                      <option value="de">German</option>
                      <option value="ja">Japanese</option>
                      <option value="es">Spanish</option>
                    </select>
                    <input name="submit" type="submit" value="Get Directions" />
                  </div>
              </form>
          </div>
      </div>
      
      <div id="directions"></div>
      
    </div>
    <h2>Lottery Draw<br>
<?php
$balls = range(1,49);
shuffle($balls);
$pick = array_slice($balls,0,6);
$drawn = implode(", ",$pick);
sort($pick);
$ascend = implode(" ... ",$pick);

print ("Suggest you play $drawn<p>");
print ("We'll go through those again in ascending order ...<br>");
print $ascend;

?>
</h2></font>
  </body>
</html>