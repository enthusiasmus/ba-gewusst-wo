/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

//After loading the registration formular
//When filling out the formular the data get checked
//with calling the handle_name, handle_email and check_input function
$("input[name=usr]").bind('keyup', function(){
	$.get('username_free.php', { 'usr': $("input[name=usr]").val() }, handle_name);
});
$("input[name=email]").bind('keyup', function(){
	$.get('email_free.php', { 'email': $("input[name=email]").val() }, handle_email);
});
$("input[name=pwd_repeat]").bind('keyup', function(){
	handle_passwd();
});
$("input[name=pwd]").bind('keyup', function(){
	handle_passwd();
});
$("input[name=location]").bind('keyup', function(){
	check_input();
});

//set the send button disabled
$("input[name=button]").attr('disabled', true);