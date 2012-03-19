/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

//Define the geocoder for the searching through the world
geocoder = new google.maps.Geocoder();
//Define the info window for every marker
infoWindow = new google.maps.InfoWindow({disableAutoPan: true});

//Define the standard position
var latlng = new google.maps.LatLng(47.800507, 13.0466716);

//Options for the map creation
	//Zoom of the map: 0-20, standard 14
	//Center of the map: Salzburg
	//StreetView symbol visibility: unvisible
	//Navigation control: unvisible
	//Standard map type: Roadmap
var myOptions = {
	zoom: 14,
	center: latlng,
	streetViewControl: false,
	panControl: false,
	//scaleControl: true,
	//scaleControlOptions: {position: google.maps.ControlPosition.BOTTOM_LEFT}, 
	mapTypeId: google.maps.MapTypeId.ROADMAP   
};

//Create the map in the given div element
map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

//add two listener to the map
	//first the listener if the map was moved
	//seconde the listener if the zoom of the map changed
	//if there is such an event call "boundsElements" direct or via a delay function
google.maps.event.addListener(map, 'dragend', boundsElements);
google.maps.event.addListener(map, 'zoom_changed', boundsElements);

//geolocation call to center the map to the users position
findPosition();

//Loop to wait till the map is completely loaded 
//Wait maximum 30 seconds if the map is loaded or not
var i = 0;
while(true){
	if(map.getProjection() != 0){
		window.setTimeout("placeMarkers()", 500);
		break;
	}
	else if(i == 60)
		break;
	else
		window.setTimeout("doNothing()", 500);
	i++;
}