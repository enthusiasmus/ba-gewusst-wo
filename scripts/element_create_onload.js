/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

//Map has to been created when the site gets loaded
$("#map_canvas").css({width: '800px', height: '300px', position: 'absolute', zIndex: '10', left: '-2000px', top: '70px'});
//change the position of the search field, hide it and set the save button in the search field disabled
$("#search_field").css({width: '300px', height: '20px', position: 'absolute', left: '566px', top: '30px'});
$("#search_field").hide();
$("button[id=save_new]").attr('disabled', true);

//the user can choose the way over the map or direct over the formular
//fade out the choice-option and fade in the map
$('#choice1').click(function(){	
		$("#create_choice").fadeToggle("slow", "linear");
		$("#create_content").animate({"marginLeft": "-=200px"}, "slow");
		$('#map_canvas').animate({"marginLeft": "+=2000px"}, "slow");
		$("#create_content").css({width: '830px'});
		$("#search_field").fadeToggle("slow", "linear");
});

//fade out the choice-option and fade in the formular
$('#choice2').click(function(){	
		$("#create_choice").fadeToggle("slow", "linear");
		$("#create_content").animate({"marginLeft": "-=200px"}, "slow");
		$('#create_manual').slideUp(300).delay(800).fadeIn(400);
		$("#create_content").css({width: '830px'});
});

//With a right mouse click a marker is placed 
var newMarker = [];
google.maps.event.addListener(map, "rightclick", function(event) {
	//by klicking somewhere else the first one gets deleted 
	if (newMarker) {
		for (i in newMarker)
			newMarker[i].setMap(null);
		newMarker.length = 0;
	}

	//and a new one is placed
	//trackable marker creation
	marker = new google.maps.Marker({
        position: event.latLng,
		draggable: true,
	    map: map
    });
	
	newMarker.push(marker);
	
	//When the marker gets placed the user can do the next step
	$("button[id=save_new]").attr('disabled', false);
});

//When saving the marker, go to the formular and adopt the coordinates
	//Move the map and the search field away and slide up the formular
	//get the coordinates into the formular
$('#save_new').click(function(){	
		$('#map_canvas').animate({"marginLeft": "+=4200px"}, "slow");
		$('#search_field').animate({"marginLeft": "+=4200px"}, "slow");
		$('#create_manual').slideUp(300).delay(300).fadeIn(400);
		
		var lat = newMarker[0].getPosition().lat().toString().substr(0,9);
		var lng = newMarker[0].getPosition().lng().toString().substr(0,9);
		$('input[name=longitude]').val(lng);
		$('input[name=latitude]').val(lat);
});