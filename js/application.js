var geocoder, map, addressMarker, gdir, fromAddress, toAddress;

/*
**
* Bootstrap function to setup map and apply
* custom company marker
*/
function initialize() {
  if (GBrowserIsCompatible()) {
    //settings
    map   = new GMap2(document.getElementById("map_canvas"));
    gdir  = new GDirections(map, document.getElementById("directions"));
    
    var companyMarkerImage= "./images/jayhawk.gif";
    var companyLatLng     = new GLatLng(38.957101, -95.251469);
    var companyMarkerSize = new GSize(55, 52); //width, height
    
    var defaultZoomLevel  = 13;
    //end settings
    
    //setup elements
    
    //error handler
    GEvent.addListener(gdir, "error", sendToGoogle);
    
    //set company marker
    var companyMarker = createMarker(companyLatLng, companyMarkerImage, companyMarkerSize);
    
    //set map center
    map.setCenter(companyLatLng, defaultZoomLevel);
    map.addOverlay(companyMarker);
  }
}

/*
**
* Looks up the directions, overlays route on map,
* and prints turn-by-turn to #directions.
*/

function overlayDirections()
{
    fromAddress =
      document.getElementById("street").value
      + " " + document.getElementById("city").value
      + " " + document.getElementById("state").options[document.getElementById("state").selectedIndex].value
      + " " + document.getElementById("zip").value;
    
    var language  = document.getElementById("language").options[document.getElementById("language").selectedIndex].value;
    
    gdir.load("from: " + fromAddress + " to: " + toAddress, { "locale": language });
}


/*
**
* Wrapper function to create/return a marker object
* with custom image
*/
function createMarker(latlng, imageURL, imageSize)
{
  
    var marker      = new GIcon(G_DEFAULT_ICON);
    marker.image    = imageURL;
    marker.iconSize = imageSize;
    
    var options     =  { icon: marker };
    
    return new GMarker(latlng, options);
  
}



/*
**
* Display error to user
*
*/
function handleErrors(){
   if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
     alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
   else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
     alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);
   else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
     alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);
   else if (gdir.getStatus().code == G_GEO_BAD_KEY)
     alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);
   else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
     alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);
   else alert("An unknown error occurred.");
}