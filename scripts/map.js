/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

//variable deklarations
	var map;					//google maps deklaration
	var infoWindow;				//info window of every marker
	var geocoder;				//searchfield where users can type in the city, town
	var bounds;					//frontiers of the map
	
	//arrays for the elements
	var markersArrayWater = [];
	var markersArrayWlan = [];
	var markersArrayPlace = [];
	var markersArrayWC = [];
	var markersArray = [];
	
	//geolocation marker
	var locationMarker = [];
	
	//for checking visibility
	var markersEID = [];
	markersEID.length = 0;
	var tempEIDArray = [];
	
	//check variables 
	var arrayeidfilled = false;
	var uncheckedwc;
	var uncheckedwater;
	var uncheckedwlan;
	var uncheckedplace;
	
//custome icons for every type of the elements		
var customIcons = {
	water: {icon: 'images/water.png'},
	wlan: {icon: 'images/wlan.png'},
	wc: {icon: 'images/wc.png'},
	place: {icon: 'images/place.png'}
};

//send the frontiers of the map to the php file which create the kml file
function downloadKML(){
	var tpr = bounds.getNorthEast();
	var bttml = bounds.getSouthWest();	
				
	var tp = tpr.lat().toString().substr(0,9);
	var rght = tpr.lng().toString().substr(0,9);
	var bttm = bttml.lat().toString().substr(0,9);
	var lft = bttml.lng().toString().substr(0,9);
	
	//hyperlink to the kml creation file
	window.location.href = 'kml_create.php?tp='+tp+'&rght='+rght+'&bttm='+bttm+'&lft='+lft;
}
		
//Because the event bounds_changed fire to often
function boundsElements(){
	//go trough only if the map does completly exists
	if(map.getProjection() != 0){
		//fill the temporary array with the before created markers
			//markersEID is for the now visible markers on the map
			//tempEID is for the before visible markers on the map
		tempEIDArray.length = 0;
		for(var k=0; k<markersEID.length; k++)
			tempEIDArray[k] = markersEID[k];
		markersEID.length = 0;
		
		//LatLng from the actuall map range/region/area
		bounds = map.getBounds();	
		
		// Deletes all markers in the array by removing references to them
		if (markersArray) {
			for (i in markersArray) {
				if(bounds.contains(markersArray[i].getPosition()) == true)
					continue;
				else
					markersArray[i].setMap(null);
			}
		}
		
		//After disable the unvisible markers, look for new markers
		placeMarkers();
		
		//disable the download possibility if there could be too much markers on the map
		if(map.getZoom() < 10){
			$("#kml").attr('onClick', '');
			$("#kml_advice").text('Bitte reinzoomen!');
			$("#kml_advice").css({marginLeft: '-15px', color: '#DDD'});
		}
		//anable the download possibility when the zoom is more than the level 10 out of 20
		else{
			$("#kml").attr('onClick', 'downloadKML()');
			$("#kml_advice").text('Download Wegpunkte');
			$("#kml_advice").css({marginLeft: '0px', color: '#FFF'});
		}
	}
}

//search after the city/land/country/village trough the world
function codeAddress() {
	//getting the value from the adress div out of the search field
	var address = document.getElementById("address").value;
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			//when find something, set the map to the center
			map.setCenter(results[0].geometry.location);
		} else {
			alert("Kein Ergebnis gefunden!");
		}
	});
	
	//after finding the place remove unvisible elements
	boundsElements();
	//and search for new elements
	placeMarkers();
}
	
//Put markers onto the map
function placeMarkers(){
	//get the markers out of the 
	downloadUrl("xml_create.php", function(data) {
		//loading the data of the php based xml file
		var xml = parseXml(data);
		//every marker (= element) get choosen
		var markers = xml.documentElement.getElementsByTagName("element");
		//LatLng from the actuall map range/region/area
		bounds = map.getBounds();	
			
		var m = 0;
		for (var i = 0; i < markers.length; i++) {
				var exsists = false;
				
			//define latitude (Breitengrad) and longitude (Längengrad) into a google maps point
			var point = new google.maps.LatLng(
				parseFloat(markers[i].getAttribute("latitude")),
				parseFloat(markers[i].getAttribute("longitude")));
			
			//Only draw the elements which can be seen in the map
			if (bounds.contains(point) == false)
				continue;
				//Only draw the elements which can be seen and aren't already there
			var eid = markers[i].getAttribute("eid");
				//check if the marker which will be drawn exists already
			//if it already exsists => exsists = true
			if (arrayeidfilled){
				for(var j = 0; j < tempEIDArray.length; j++){
					if(eid == tempEIDArray[j]){
						exsists = true;
						break;
					}
				}
			}
				
			//if the marker already exsists, cancel the creation
			if(exsists)	{
				markersEID[m] = eid;
				m++;
				exsists = false;
				continue;
			}
			
			//define type picture and draw only elements which should be drawn
			var type = markers[i].getAttribute("etype");
			if(type == "wc"){
				if(uncheckedwc)
					continue;
				var htype = "wc.png";
			}
			else if(type == "water"){
				if(uncheckedwater)
					continue;
				var htype = "water.png";
			}
			else if(type == "wlan"){
				if(uncheckedwlan)
					continue;
				var htype = "wlan.png";
			}
			else if(type == "place"){
				if(uncheckedplace)
					continue;
				var htype = "place.png";
			}		
			var htype = "<p style='margin:0px'><img src='images/"+htype+"'\> ";
			
			//once a marker is drawn and don't get erased after an map action it should be drawn again
			markersEID[m] = eid;
			m++;
			
			//getting the information out of the file
			var name = markers[i].getAttribute("title");
			var beginaccess = markers[i].getAttribute("begin_access_time");
			var endaccess = markers[i].getAttribute("end_access_time");
			var activwinter = markers[i].getAttribute("activ_in_winter");
			var type = markers[i].getAttribute("etype");
			var confirmed = markers[i].getAttribute("confirmed");
			var published = markers[i].getAttribute("publish_date");
			var address = markers[i].getAttribute("location");
			
			//shadow of the markers, it is everytime the same shadow
			var shadow = 'images/marker_shadow.png';
		
			//custome icons for every type of the elements
			var icon = customIcons[type] || {};
			
			//creating the marker with icon, shadow, title on the map
			var marker = new google.maps.Marker({
				map: map,
				position: point,
				icon: icon.icon,
				shadow: shadow,
				title: name
			});
			
			//#####################################################################################################
			//INFO WINDOW content BEGIN
			/*if(confirmed == "0")
				hcon = "0.png";
			else if(confirmed == "1")
				hcon = "1.png";
			else if(confirmed == "2")
				hcon = "2.png";
			else
				hcon = "3.png";
			hcon = "<br><span><b>Bestätigung:</b> <img src='images/"+hcon+"'\></span>";	*/
							
			//set title and availability
			var htitle = "<b><u>" + name + "</b></u></p><p style='margin-top:8px; margin-bottom:-15px;'>"+
			"<b>Standort:</b> " + address + "</p>";
			var htime = "<br><span><b>Zugang:</b> "+beginaccess.slice(0, 5)+"-"+endaccess.slice(0, 5)+"</span>";
			
			//choose picture for winter available
			if(activwinter == "1")
				var hwinter = " <br><span><b>Winter:</b> <img src='images/3.png'\></span>";
			else
				var hwinter = " <br><span><b>Winter:</b> <img src='images/0.png'\></span>";
			
			//set date of publication, link for the detail information
			var hpublished = "<br><span><b>Eintragung:</b> "+published+" </span>";
			var l = "&nbsp;";
			var hlink = l+l+l+l+l+l+l+l+l+"<a href='element.php?eid="+eid+"' style='float:right;'>Details</a>";
			
			//set the final text for the info window
			var hoverdiv = "<span style='color:#222; font-size:12px; font-family: verdana, sans-serif;'>";
			var html = hoverdiv + htype + htitle + htime + /*hcon +*/ hwinter + hpublished +/* hlink +*/ "</span>";
			//INFO WINDOW content END
			//#####################################################################################################
			
			//save the markers into four arrays
			//so the markers can be removed by the user from the map
			//with the element control bar
			if(type == "wc")
				markersArrayWC.push(marker);
			else if(type == "water")
				markersArrayWater.push(marker);
			else if(type == "wlan")
				markersArrayWlan.push(marker);
			else if(type == "place")
				markersArrayPlace.push(marker);
			
			//after zoom changing and center changing use this array for deleting the markers
			markersArray.push(marker);
			//every marker gets an info window
			bindInfoWindow(marker, map, infoWindow, html, point);
		}
	});	
	//after the first time placing markers, we can handle with the arrays out of markers
	arrayeidfilled = true;
}
	
//Adding eventlistener to the info window
	//adding the html to the info window
	//by clicking on the marker open the info window
	//set the map center to the marker
	//after changing the center update the map
function bindInfoWindow(marker, map, infoWindow, html, point) {
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
		map.setCenter(point);
		boundsElements();
    });
}
	
//For loading from the server created xml file, which is filled with elements
function downloadUrl(url, callback) {
	var request = window.ActiveXObject ?
	new ActiveXObject('Microsoft.XMLHTTP') :
	new XMLHttpRequest;	//Ajax

	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			request.onreadystatechange = doNothing;
			callback(request.responseText, request.status);
        }
	};

	request.open('GET', url, true);
	request.send(null);
}
	
//loading the xml document via the dom function
//parse the xml document and give the data back
function parseXml(str) {
	if (window.ActiveXObject){
    	var doc = new ActiveXObject('Microsoft.XMLDOM');
		doc.loadXML(str);
		return doc;
    }
	else if (window.DOMParser){
		return (new DOMParser).parseFromString(str, 'text/xml');
	}
}
	
function doNothing() {}

//this function is used to get the users-position and center the map on it
//geolocation is a function offered from google company
function findPosition(){
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position){    
				latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				map.setCenter(latlng);
				//create a selfmade needle position where the user is
				var marker = new google.maps.Marker({
					position: latlng, 
					icon: 'images/needle.png', 
					map: map, 
					title: 'Your position!'
				});
				locationMarker.push(marker);
		});  
	} else{
		//when geolocation isn't working, tell the user to change his browser
		alert("Can't find your position! Please use another browser!");
	}
}