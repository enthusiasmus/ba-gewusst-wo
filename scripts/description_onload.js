/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

//for the description, click at one topic, the other disappear and the selected one shows up
//when the same tag gets clicked, toggle only the visibility of the next element
$(".des_text").click(function(){
    if($(this).next(".appear_text").is(":visible"))
		  $(this).next(".appear_text").hide();
	else{
		$(".appear_text").hide();
		$(this).next(".appear_text").toggle();
	}
});