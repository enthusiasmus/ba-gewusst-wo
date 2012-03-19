<?php 

	/*
	* made by Lukas Wanko
	* with encouragement from the University of Applied Science Salzburg
	*/

	$pagetitle = "Gewusst-Wo - Neues Element";
	include "functions.php";
	include "header.php"; 	
	
//no creation possibility when the user isn't loged in
if (!$_SESSION['USER']){
		echo "<div style='position:absolute; top:150px; left:50%; margin-left:-250px;'>";
		echo "<p>Um ein neues Element hinzufügen zu können, müssen Sie sich bitte zuerst anmelden.</p>";
		echo "<p>Wenn Sie noch keinen Benutzernamen haben, können Sie sich kostenlos <a style='color:#000;' href='registration.php'>registrieren</a>.</p>";
		echo "</div>";
		include "footer.php"; 
		exit;
}

//if the user sent the formular for creating a new element
if($_POST['esent']){	

	//escape the input of the user
	$latitude = htmlspecialchars($_POST['latitude']);
	$longitude = htmlspecialchars($_POST['longitude']);
	$location = htmlspecialchars($_POST['location']);
	
	$begin_access_h = htmlspecialchars($_POST['begintime_h']);
	$begin_access_m = htmlspecialchars($_POST['begintime_m']);
	$end_access_h = htmlspecialchars($_POST['endtime_h']);
	$end_access_m = htmlspecialchars($_POST['endtime_m']);
	
	$begin_access_time = $begin_access_h . ":" . $begin_access_m . ":" . "00";
	$end_access_time = $end_access_h . ":" . $end_access_m . ":" . "00";
	
	$activ_in_winter = htmlspecialchars($_POST['activwinter']);
	$title = htmlspecialchars($_POST['title']);
	$publish_date = date("d.m.Y");
	$etype = htmlspecialchars($_POST['etype']);
	$description = htmlspecialchars($_POST['beschreibung']);
	$confirmed = 1;

	//preparing the sql statement and execute it
	$insertion = $dtdb->prepare(
			"INSERT INTO elements(latitude,longitude,location,begin_access_time,end_access_time,
			activ_in_winter,title,publish_date,confirmed,etype,description)
			VALUES(?,?,?,?,?,?,?,?,?,?,?)");	
	$query = $insertion->execute(array($latitude,$longitude,$location,$begin_access_time,
			 $end_access_time,$activ_in_winter,$title,$publish_date,$confirmed,$etype,$description));	
	
	//if the insertion went wrong display it
	if(!$query) {
		echo "<div style='position:absolute; top:150px; left:50%; margin-left:-150px;'>";
	 	echo("<p>Fehler beim Speichern in der Datenbank: <br>");
	 	echo("Bitte gehen Sie zurück zum Formular!</p>");
		echo "</div>";
	 	include "footer.php";
	 	exit;
	}
	
	//if the insertion worked thanks the user for the insertion
	echo "<div style='position:absolute; top:150px; left:50%; margin-left:-80px;'>";
	echo("<p>Vielen Dank für Ihren Beitrag!<br>");
	//echo("Nach zwei Bestätigungen wird das Element freigeschaltet.</p>");
	echo "</div>";
}
else {
?>	
	<div id="create_content">
		<?php echo "<h1>".$pagetitle."</h1>";?>
		
        <!-- user can choose between to ways to create a new element -->
		<div id="create_choice">
			<p>Vielen Dank, dass Sie ein weiteres Element eintragen wollen.</p>
			<span id="choice1">Punkt zuerst auf der Karte suchen</span>
			<span id="choice2">Habe die Koordinaten schon bei der Hand</span>
		</div>
        
		<!-- choice two - formular to filled out - when you already have the coordinates of your item -->
		<div id="create_manual">
		<form id="create_form" action="element_create.php" method="post">
				<div id="first_row">
					<input type="hidden" name="esent" value="1" />
					<p>Titel: <input name="title" maxlength="50" size="50" required style="width:300px"/></p>
					<p>Beschreibung:<br /><textarea name="beschreibung" rows="9" cols="43" style="width:340px"></textarea></p>
				</div>
				<div id="second_row">
					<p style="margin-left:20px;">Längengrad: <input name="longitude" maxlength="10" size="10" required placeholder='13.12345'/>
                    <span>Breitengrad: <input name="latitude" maxlength="10" size="10" required placeholder='47.12345'/></span>
                    </p>
					<p style="margin-left:38px;">Standort: <input name="location" maxlength="40" size="40" required/></p><br>
					<div>
						<p style="margin-left:-1px;">Zugangszeiten: 
                        <input style="width:40px;" name="begintime_h" maxlength="2" size="2" value="00" type="number" step="1" min="00" max="23"/>:
						<input style="width:40px; margin-left:-5px;" name="begintime_m" maxlength="2" size="2" value="00" type="number" step="1" min="00" max="59"/> Uhr bis 
						<input style="width:40px;" name="endtime_h" maxlength="2" size="2" value="23" type="number" step="1" min="00" max="23"/>:
						<input style="width:40px; margin-left:-5px;" name="endtime_m" maxlength="2" size="2" value="59" type="number" step="1" min="00" max="59"/> Uhr</p>
					</div>
					<p style="margin-top:35px">Typ des Elementes: 
						<input type="radio" name="etype" value="water" checked="checked">Water
						<input type="radio" name="etype" value="wc">WC
						<input type="radio" name="etype" value="wlan">Wlan
						<input type="radio" name="etype" value="place">Place
					</p>
					<p>Erhältlich im Winter: <input name="activwinter" type="checkbox" value="1"/></p>
				</div>
			<div id="create_send"><p><button style="width:150px;"/>Eintragen</button></p></div>
		</form>
		</div>
        <!-- choice one - map, searchfield and save button -->
        <div id="create_map">
        	<div id="search_field">
                <input id="address" required/>
                <button style="margin-left:260px; margin-top:-1px; width:100px;" onclick='codeAddress()'>Ort suchen</button>
                <span style="position:absolute; top:356px; left:0px; margin-left:-423px;">Vor dem Speichern markieren Sie bitte den Standort (mit Rechtsklick).</span> <button style="margin-left:160px; width:200px; margin-top:330px;" id="save_new">Speichern</button></div>
            </div>
        	<div id="map_canvas"></div>
        </div>
    </div>
<?php
}
	include "footer.php"; 
?>