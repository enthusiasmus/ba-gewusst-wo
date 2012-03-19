/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

//Create the control checkboxes which one of the four map elements should be shown 
var control = "<span><input name='water' checked='checked' type='checkbox'/>Wasser</span>"+
"<span><input name='wc' checked='checked' type='checkbox'/>WC</span>"+
"<span><input name='wlan' checked='checked' type='checkbox'/>WLAN</span>"+
"<span><input name='place' checked='checked' type='checkbox'/>Plätze</span>";
$("#blackbalk").after("<span id='element_control'>"+control+"</span>");
		
//When the checkboxes get unchecked the markers on the map should be removed and vice versa
//Here is the management-function for the wc-elements
$("input[name=wc]").change(function(){
	if($("input[name=wc]").attr('checked') != "checked"){
		uncheckedwc = true;
		if (markersArrayWC) {
			for (i in markersArrayWC)
				markersArrayWC[i].setMap(null);
		}
	}
	else{
		uncheckedwc = false;
		if (markersArrayWC) {
			for (i in markersArrayWC)
				markersArrayWC[i].setMap(map);
		}
	}
});

//Here is the management-function for the water-elements
$("input[name=water]").change(function(){
	if($("input[name=water]").attr('checked') != "checked"){
		uncheckedwater = true;
		if (markersArrayWater) {
			for (i in markersArrayWater)
				markersArrayWater[i].setMap(null);
		}
	}
	else{
		uncheckedwater = false;
		if (markersArrayWater) {
			for (i in markersArrayWater)
				markersArrayWater[i].setMap(map);
		}
	}
});

//Here is the management-function for the wlan-elements
$("input[name=wlan]").change(function(){
	if($("input[name=wlan]").attr('checked') != "checked"){
		uncheckedwlan = true;
		if (markersArrayWlan) {
			for (i in markersArrayWlan)
				markersArrayWlan[i].setMap(null);
		}
	}
	else{
		uncheckedwlan = false;
		if (markersArrayWlan) {
			for (i in markersArrayWlan)
				markersArrayWlan[i].setMap(map);
		}
	}	
});

//Here is the management-function for the place-elements
$("input[name=place]").change(function(){
	if($("input[name=place]").attr('checked') != "checked"){
		uncheckedplace = true;
		if (markersArrayPlace) {
			for (i in markersArrayPlace)
				markersArrayPlace[i].setMap(null);
		}
	}
	else{
		uncheckedplace = false;
		if (markersArrayPlace) {
			for (i in markersArrayPlace)
				markersArrayPlace[i].setMap(map);
		}
	}	
});

//if the browser supported geolocation create an option for the own position
if(navigator.geolocation){
	//Create a checkbox if the own position via geolocation should be shown on the map or not
	$("#element_control").before("<span id='mylocation'><input name='mylocation' checked='checked' type='checkbox'/>Meine Position</span>");
	//Handle the checkbox above
	$("input[name=mylocation]").change(function(){
		if($("input[name=mylocation]").attr('checked') != "checked"){
			locationMarker[0].setMap(null);
			locationMarker.length = 0;
		}
		else{
			findPosition();
		}
	});
}

//Input form to look at another place of our world in this map
$("#element_control").before("<span id='search_field'><img id='i2' src='images/search.png'/>"+
"<input id='address' autofocus placeholder='Suche... '><img id='i1' src='images/loupe.png' onclick='codeAddress()'/></span>");

//Button to download the waypoints which are currently shown on the map
$("#search_field").before("<span id='kml' onClick='downloadKML()'><img src='images/kml.png'/><span id='kml_advice'>Download Wegpunkte</span></span>");