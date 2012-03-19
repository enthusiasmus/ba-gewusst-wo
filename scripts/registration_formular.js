/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

//Deklarations for variables if the data formular is okay
var name_allowed = true;
var email_allowed = true;

//Handle the username if it is free
//get the data from the username_free.php, which is checking the database
//display a text field if the name is free or not
function handle_name(data) {
	$('span#message_username').remove();
	if(data == 1){
		$("input[name=usr]").after("<span class='message_no' class='no' "
		+"id='message_username'>Bereits vergeben!</span>");
		$("input[name=button]").attr('disabled', true);
		email_allowed = false;
	}
	else{
		$("input[name=usr]").after("<span class='message_yes' id='message_username'>Noch nicht vergeben!</span>");
		email_allowed = true;
	}
	check_input();
}	

//Handle availability of the email
//get the data from the email_free.php, which is checking the database
//display a text field if the email is free or not
function handle_email(data) {
	if($('input[name=email]').val().toString().length > 3){
		$('span#message_email').remove();
		if(data == 1){
			$("input[name=email]").after("<span class='message_no' id='message_email'>Bereits vergeben!</span>");
			$("input[name=button]").attr('disabled', true);
			name_allowed = false;
		}
		else{
			$("input[name=email]").after("<span class='message_yes' id='message_email'>Noch nicht vergeben!</span>");
			name_allowed = true;
		}
		check_input();
	}
}	
	
//Handle the correctness of the passworda
	//In length and in if the user can remember his typed password
//display a text field if the passwords are equal or long enough
function handle_passwd() {
	if($("input[name=pwd]").val().toString().length > 1){
		$('span#message_password').remove();
		$('span#message_length').remove();
		
		if($("input[name=pwd]").val() != $("input[name=pwd_repeat]").val())
			var data = 0;
		else
			var data = 1;
			
		if($("input[name=pwd]").val().toString().length < 5)
			var leng = 0;
		else
			var leng = 1;
	
		if(!leng || !data){
			if(!data){
				$("input[name=pwd_repeat]").after("<span class='message_no' id='message_password'>"+
				"Passwörter stimmen nicht überein!</span>");
				$("input[name=button]").attr('disabled', true);
			}
			if(!leng){
				$("input[name=pwd]").after("<span class='message_no' id='message_length' style='position:absolute; width:300px;'>"+
				"Passwort zu kurz!</span>");
				$("input[name=button]").attr('disabled', true);
			}
			if(!leng && !data)
				return 0;
		}	
		
		if(leng || data){
			if(data){
				$("input[name=pwd_repeat]").after("<span class='message_yes' id='message_password'>"
				+"Passwörter stimmen überein</span>");
			}
			if(leng){
				$("input[name=pwd]").after("<span class='message_yes' id='message_length' style='position:absolute; width:300px;'>"
				+"Passwort lang genug!</span>");
			}
			if(leng && data)
				return 1;
		}
		check_input();
	}
}

//If all the requirements succeded the user can registrat
	//Value check of the input formular for the older browser which 
	//don't understand the "required" attribute at the input-tags
function check_input(){
	if($("input[name=usr]").val() != "" && $("input[name=pwd]").val() != "" &&
	$("input[name=pwd_repeat]").val() != "" && $("input[name=location]").val() != "" 
	&& handle_passwd() && name_allowed && email_allowed){		
		$("input[name=button]").attr('disabled', false);
	}
}