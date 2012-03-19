<!-- Site for the registration -->
<?php

/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

	$pagetitle = "Gewusst-Wo - Registrierung";
	include "functions.php";
	include "header.php"; 

//if the formular was sent get through this prozess, else see at the bottom
if($_POST['sent']){

	//escape the data from the formular
	$username = htmlspecialchars($_POST['usr']);
	$passwd = md5(htmlspecialchars($_POST['pwd']));
	$location = htmlspecialchars($_POST['location']);
	$email = htmlspecialchars($_POST['email']);
	
	//check the data, else write into error array
	$error = array();
	if(!strpos($email, '@') || !strpos($email, '.'))
		$error[] = 'Ihre E-Mail-Adresse ist fehlerhaft!';
	if(strlen($passwd) < 5)
		$error[] = 'Ihr Passwort ist nicht sicher genug!';

	//if there is an error exit and display why
	if(count($error) > 0) {
	  echo("<p style='position:absolute; top:150px; left:50%; margin-left:-100px;'>Fehler beim Speichern in der Registrierung: <br>");
		  if(count($error) > 0){
			echo "<ul>";
			foreach ($error as $message)
				echo "<li>".$message."</li>";
			echo "</ul>";
		  }
		  
	  echo("Bitte gehen Sie zurück zum Formular!</p>");
	  include "footer.php";
	  exit;
	}	
	
	//prepare sql statement and excute
	$insertion = $dtdb->prepare("INSERT INTO usernames(username,passwd,location,email) VALUES(?,?,?,?)");	
	$query = $insertion->execute(array($username,$passwd,$location,$email));	
	
	//display if there is an execution failure
	if(!$query){
		echo("<p style='position:absolute; top:150px; left:50%; margin-left:-100px;'>Fehler beim Speichern in der Registrierung: <br>"); 
		echo("Bitte gehen Sie zurück zum Formular!</p>");
		include "footer.php";
		exit;
	}
	
	//else thanks for the registration
	echo("<p style='position:absolute; top:150px; left:50%; margin-left:-80px;'>Vielen Dank für Ihre Registrierung!</p>");
	}
//before the gets registrated, the user see the the registration formular, which has to get filled out
else {
?>
    <form id="form_reg" action="registration.php" method="post">
   		<input type="hidden" name="sent" value="1" />
        <?php echo "<span id='fr_title'><h1>".$pagetitle."</h1></span>";?>
        <p id="fr_user">Benutzername: <input name="usr" size="30" maxlength="30" required/></p>
        <p id="fr_email">E-Mail: <input name="email" type="email" size="30" maxlength="60" required/></p>
        <p id="fr_pass">Passwort: <input type="password" name="pwd" size="40" maxlength="40" required/>
        <span id="fr_pass_wd">Wiederholung: <input type="password" name="pwd_repeat" size="40" maxlength="40" required/></span></p>
        <p id="fr_location">Wohnort: <input name="location" size="50" maxlength="50" onkeyup="check_input()" required/></p>
        <input id="fr_send" type="submit" value="Registrieren" name="button"/>
    </form>
<?php
}
	include "footer.php"; 
?>