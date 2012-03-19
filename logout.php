<?php

/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

	include "functions.php";

//after pressing the logout-button go trough this
if($_POST['sent']){
    //delete all sessions variable
    $_SESSION = array();

    //users logout, destroy cookie and session
    if (isset($_COOKIE[session_name()])) {
	   setcookie(session_name(), '', time()-50000, '/');
    }
	session_destroy();
	
	//back to the main page
    header("Location: index.php");
}

if(strlen($_SESSION[USER]) > 6)
	$name = substr($_SESSION[USER], 0, 5) . ".";
else
	$name = $_SESSION[USER];
//the logout formular, only visible when the user is loged in
echo <<<EOM
	<div id='corit' class='corit_standard' style='top:-8px;'>
		<form action='logout.php' method='post'>
			<input type='hidden' name='sent' value='1' /><span id='user'>Hey, $name!</span><br>
			<input id='logout_button' type='submit' value='Abmelden' />
		</form>
	</div>
EOM;
?>