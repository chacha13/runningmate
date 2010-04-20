<?php
session_start();

$connection = mysql_connect ("localhost", "agilityp", "P@ssword1");
if ($connection == false)
{
	echo mysql_errno().": ".mysql_error()."<BR>";
	exit;
}
mysql_select_db("agilityp_running", $connection);

if(isset($_POST['submit'])) {
$ins_sql = "INSERT INTO markers(lat, lng, datetime) VALUES('$_POST[lat]', '$_POST[lng]', '')";
$ins_suc = mysql_query($ins_sql);
header("Location: input.php");
}
?>
<title>Sample Google Map</title>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAyvLH69Fw5WP1g3t_zAQEYhSTGyZqpGrvGj6Y6AURwNfG3trA4xRq6_OhIavzrhXeIPszlhLe6FYpeg&sensor=true" type="text/javascript"></script>

<script language="text/javascript">
function initialize() {
	
    if (GBrowserIsCompatible()) {
	var map = new GMap2(document.getElementById("map"));
      	map.setCenter(new GLatLng(37.4419, -122.1419), 13);
      	map.setUIToDefault(); 

      // Get course
      GDownloadUrl("output-xml-02.php", function(data) {
        var xml = GXml.parse(data);
        var markers = xml.documentElement.getElementsByTagName("marker");
        var points = new Array(0); // For polyline
        for (var i = 0; i < markers.length; i++) {
          var datetime = markers[i].getAttribute("datetime");
          var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                                  parseFloat(markers[i].getAttribute("lng"))); // For markers
          points[i] = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                                  parseFloat(markers[i].getAttribute("lng"))); // For polyline
          var marker = createMarker(point, datetime);
          map.addOverlay(marker);
        }
        
        var polyline = new GPolyline(points, "#6ec6c6", 4);
        map.addOverlay(polyline);
        map.setCenter(point, 9);
        var html = "";
        html += "<div id=\"infobox\">";
        html += "Shila ito yun";
        html += "<br />" + datetime;
        html += "<br />Shila ito yun";
        html += "</div>";
        map.openInfoWindowHtml(point, html);
      });
    }
  }

	function updateLocation(point) {
	  document.getElementById('lat').value = point.y;
	  document.getElementById('long').value = point.x;
	  map.clearOverlays();
	  map.addOverlay(new GMarker(new GLatLng(point.y, point.x)));
	}

</script>
<?php

  $showbutton = TRUE;

  if (isset($_POST['submit'])) { // If form submitted

    // Get vars
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    // Check string lengths
    if (strlen($lat) < 6) {
      $problem = TRUE;
      $response0 = "LATITUDE too short.<br />";
    }
    if (strlen($lng) < 6) {
      $problem = TRUE;
      $response1 = "LONGITUDE too short.<br />";
    }

    // Check if numeric
    if(!is_numeric($lat)) {
      $problem = TRUE;
      $response0a = "LATITUDE not numeric.<br />";
    }
    if(!is_numeric($lng)) {
      $problem = TRUE;
      $response1a = "LONGITUDE not numeric.<br />";
    }

    if (!$problem) { // If no problem, connect to database
      require("path/to/your_connection_script.php");
      // Build MySQL query
      $query = "INSERT INTO markers (lat, lng, datetime)
      VALUES ('$lat', '$lng', NOW())";
      // Run query
      $result = @mysql_query ($query);
      // Check result
      if ($result) {
        mysql_close();
        $response2 = "MySQL query OK.<br />";
      } else { // No result
        $response2 = "MySQL query didn't run.<br />";
      }
      $response3 = "Co-ordinates entered."; // End
      $showbutton = FALSE;
    } else { // Problem
      $response3 = "Try again."; // End
    }

  }

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="text" name="lat" size="12" maxlength="12" value="
<?php if (isset($_POST['submit'])) echo $_POST['lat']; ?>"
tabindex="1"><br />
<input type="text" name="lng" size="12" maxlength="12" value="
<?php if (isset($_POST['submit'])) echo $_POST['lng']; ?>"
tabindex="2"><br />
<?php
  if ($showbutton == TRUE) {
 // Only show the Insert button if form not yet submitted
?>
<input type="submit" name="submit" value="Insert" tabindex="3">
<?php } ?>
</form>
<?php

  // Response section
  if (isset($_POST['submit'])) {
    echo "\n";
    echo $response0;
    echo $response0a;
    echo $response1;
    echo $response1a;
    echo $response2;
    echo $response3;
  }

?>
<script type="text/javascript">
 function initialize() {
    if (GBrowserIsCompatible()) {

      // Get map (Version 2)
      var map = new GMap2(document.getElementById("map"));
      map.setUIToDefault(); // Default user interface

      // Get course
      GDownloadUrl("output-xml.php", function(data) {
        var xml = GXml.parse(data);
        var markers =
        xml.documentElement.getElementsByTagName("marker");
        var points = new Array(0); // For polyline
        // Loop through the markers
        for (var i = 0; i < markers.length; i++) {
          var datetime = markers[i].getAttribute("datetime");
          var point =
          new GLatLng(parseFloat(markers[i].getAttribute("lat")),
          parseFloat(markers[i].getAttribute("lng")));
          points[i] =
          new GLatLng(parseFloat(markers[i].getAttribute("lat")),
          parseFloat(markers[i].getAttribute("lng")));
          var marker = createMarker(point, datetime);
          map.addOverlay(marker);
        } // End loop
        // Polyline
        var polyline = new GPolyline(points, "#ff0000", 4);
        map.addOverlay(polyline);
        // Set map centre (to last point), zoom level
        map.setCenter(point, 9);
        // InfoWindow HTML (last marker)
        var html = "";
        html += "<div id=\"infobox\">";
        html += "<3<3<3<3<3<3<3<3<3<3<3";
        html += "<br />" + datetime;
        html += "<br /><3<3<3<3<3<3<3<3<3<3<3";
        html += "</div>";
        map.openInfoWindowHtml(point, html);
      });
    }
  }

  // General markers
  function createMarker(point, datetime) {
    var marker = new GMarker(point, datetime);
    var html = "<div id=\"infobox\">Co-ords: " + point + "<br />"
    + datetime + "<br /><a href=\"/map\">Re-load</a></div>";
    GEvent.addListener(marker, 'click', function() {
      marker.openInfoWindowHtml(html);
    });
    return marker;
  }
</script>
<body onload="initialize()" onunload="GUnload()">
<div id="map" style="width: 500px; height: 300px"></div>

</body>