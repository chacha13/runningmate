<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAyvLH69Fw5WP1g3t_zAQEYhSTGyZqpGrvGj6Y6AURwNfG3trA4xRq6_OhIavzrhXeIPszlhLe6FYpeg&sensor=true" type="text/javascript"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("jquery", "1.3.2");
	//map.setCenter(new GLatLng(40.00400., -83.09363), 15)
</script>
<script type="text/javascript">
	google.setOnLoadCallback(function() {
		function load() {
			if(GBrowserIsCompatible()) {
			var map = new GMap2(document.getElementById("map"));
			map.setCenter(new GLatLng(40.004003, -83.019363), 15);
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
});

</script>
<body onload="load()" onunload="GUnload()">
	<div id="map" style="width: 500px; height: 300px;"></div>
</body>
</html>