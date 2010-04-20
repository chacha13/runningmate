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

}
?>
<title>Sample Google Map</title>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAyvLH69Fw5WP1g3t_zAQEYhSTGyZqpGrvGj6Y6AURwNfG3trA4xRq6_OhIavzrhXeIPszlhLe6FYpeg&sensor=true" type="text/javascript"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1.3.2");
</script>
<script type="text/javascript">
google.setOnLoadCallback(function() {
	$(function() {
	 var new_icon = new GIcon()  
	 new_icon.image = "http://www.seriousrunning.com/v2/runner_icon.png"  
	 new_icon.size = new GSize(16,16)  
	 new_icon.iconAnchor = new GPoint(8,9)  
	 new_icon.infoWindowAnchor = new GPoint(7,7)   
	  
	 var opt  
	 opt = {}  
	  
	 opt.icon = new_icon  
	 opt.draggable = true  
	 opt.clickable = true  
	 opt.dragCrossMove = true  
	 
	 var points = [];
	 var start;
	 
		if(GBrowserIsCompatible()) { 
		var map = new GMap2(document.getElementById("map_canvas"));
		map.setCenter(new GLatLng(17.091442, 120.452270), 9);
		map.setUIToDefault();
		map.enableGoogleBar();
		
		
		GEvent.addListener(map, "click", function(overlay, latlng) {
	        		var marker = new GMarker(latlng, opt);
				map.addOverlay(marker);
				var lat = marker.getLatLng().lat();
				var lng = marker.getLatLng().lng();
				
				var html = "<table>" +
	                         "<tr><td>Decription:</td> <td><textarea>Epal lahat ng mukhang kepellas</textarea></td> </tr>" +
	                         "<tr><td></td><td><input type='button' value='Save & Close' onclick='saveData()'/></td></tr>";
	
		              	marker.openInfoWindow(html);
	
				points.push(latlng);
				if(points.length > 1) {
					var polyline = new GPolyline(points, "#8B795E", 5);
		        		map.addOverlay(polyline);
	        		}

			$.post(
			   "loc.php",
			   {latitude: lat, longitude: lng},
			   function(responseText) { 
				$("#result").html(responseText);
			   },
			   "html"
			);
	});
	
	

	}
});
});
</script>

<body onload="initialize()" onunload="GUnload()">
<div id="map_canvas" style="width: 100%; height: 80%; border: 1px pink solid; padding: 5px;"></div>
<div id="result"></div>
</body>