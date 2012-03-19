<?php
/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

include "functions.php";

if(@$_POST['slogin']){

	//getting username and password after user sent the login formular
    $username = $_POST['username'];
    $password = md5($_POST['password']);
	$userdb = "leer";
	$passdb = "leer";
	
	$error = array();
	
	//if there is an username and a password look it up in the data base
	if(strlen($username) > 1 && strlen($password) > 3){
		$userlogin = $dtdb->prepare("SELECT username, passwd FROM usernames where username = :u");
		$userlogin->bindValue(':u', $username, PDO::PARAM_INT);
		$userlogin->execute();		
		
		if(!$userlogin){
			$error[] = "Fehler bei der Datenbankabfrage!";
			$pagetitle = "Fehler";
		}
		$userlogin = $userlogin->fetchObject();

		$userdb = $userlogin->username;
		$passdb = $userlogin->passwd;
	}
	//else write error message
	else{
		$error[] = "Benutzername oder Passwort zu kurz!";
		$pagetitle = "Fehler";
	}
	
	//check if the password and the username exsist and match
	if($username == $userdb && $password == $passdb){
		$_SESSION['USER'] = $username;
        header("Location: element_create.php");
    }
	//else write error message
	else{
		$error[] = "Benutzername und Passwort stimmen nicht überein!";
		$pagetitle = "Fehler";
	}
	
	//if there is a login failure display it
	if($pagetitle == "Fehler"){
		$_POST['slogin'] = 0;
		$pagetitle = "Login fehlgeschlagen";
		include "header.php";
		echo "<div style='position:absolute; top:150px; left:50%; margin-left:-150px;'>";
			echo "<p><span style='font-size:16px;'>Login leider fehlgeschlagen!</span>";
			if(count($error) > 0){
				echo "<ul>";
				foreach ($error as $message)
					echo "<li>".$message."</li>";
				echo "</ul>";
			}
			echo "\r\nBitte probieren Sie es erneut!</p>";
		echo "</div>";
		include "footer.php";
	}		
}
?>

<!-- formular to login -->
<div id="corit" class="corit_logout">
	<form id="login" action="login.php" method="post" style="display: none;">
		<input type="hidden" name="slogin" value="1" />
        <span id='login_user'>Benutzername: <input name='username' /></span>
        <span id="login_password">Passwort: <input type='password' name='password' /></span>
        <span id="login_button"><input type='submit' value='Login'/></span>
    </form>
	<span id="log" onClick="clogin()">Anmelden</span><br />
	<span id="reg"><a href="registration.php">Registrieren</a></span>
</div>