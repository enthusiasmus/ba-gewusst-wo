<!-- site for the description of the website, so every user simple can work with it -->
<?php

	/*
	* made by Lukas Wanko
	* with encouragement from the University of Applied Science Salzburg
	*/

	$pagetitle = "Gewusst-Wo - Beschreibung";
	include "functions.php";
	include "header.php";
?>
<div id="impressum" style="height:400px; width:800px; overflow:visible; margin-left:-400px;">
    <h1>Beschreibung</h1>
    <div style="margin-left:20px;">
    <p>Hier werden alle Elemente dieser Seite detailiert erklärt.</p>
	<h2 class="des_text" style="text-decoration:underline;">Was kann diese Internetseite?</h2>
    <p class="appear_text">Sie wird dafür verwendet, um weltweite eine Sammlung von besonderen <b>gratis</b> Orten zu erstellen.</p>
    <h2 class="des_text" style="text-decoration:underline;">Was sind besondere Orte?</h2>
    <p class="appear_text">Orte wo es gratis Trink- oder WC-Möglichkeiten gibt, freizugänglich WLAN-Hotspots und Orte die kaum bekannt sind, allerdings umbedingt werden sollten.</p>
    <h2 class="des_text" style="text-decoration:underline;">Für was stehen die Symbole der Karte?</h2>
    <div class="appear_text">
    	<img src="images/water.png" width="21" height="36" alt="wasser" />
        <img src="images/wc.png" width="21" height="36" alt="wc" />
        <img src="images/wlan.png" width="21" height="36" alt="wlan" />
        <img src="images/place.png" width="21" height="36" alt="orte" />
   	  <p>Grün: Trinken. Rot: Toilette. Blau: Wlan. Gelb: Orte.</p>
  	</div>
    <h2 class="des_text" style="text-decoration:underline;">Kann auch ich Orte hinzufügen?</h2>
    <p class="appear_text">Du sollst sogar! <a href="registration.php">Registrier</a> dich einfach und melde dich anschließend an!</p>
    <h2 class="des_text" style="text-decoration:underline;">Wie kann ich Orte hinzufügen?</h2>
    <p class="appear_text">Nachdem du dich angemeldet hast, wirst du direkt zur richtigen Seite geleitet. Hier kannst du direkt ein Formular ausfüllen, wenn du die Koordinaten schon bei der Hand hast. Hast du die Koordinaten noch nicht, nimm den Weg über die Karte. Auf dieser kannst du einen Marker mit Rechtsklick plazieren. Nach Speichern werden die Koordinaten in das Formular einfach mitübernommen.</p>
    <h2 class="des_text" style="text-decoration:underline;">Bei mir erscheint beim Laden immer so ein Kästchen?</h2>
    <p class="appear_text">Das ist okay. Dieses Kästchen wird falls dein Browser es unterstützt von Geo-Location erstellt. Hier wirst du danach gefragt, ob deine Position verwendet darf. Klickst du auf ja, wird die Karte direkt auf deinen Standort zentriert.</p>
    <h2 class="des_text" style="text-decoration:underline;">Kann ich die Daten auch daheim offline verwenden?</h2>
    <p class="appear_text">Ja, kannst du. Genau für diesen Zweck kann jeder Benutzer die Markerinformationen von den Markern die momentan auf dem Bildschirm sichtbar sind, als KML-Datei herunterladen. Diese können dann z.B. in Google-Earth geöffnet werden.</p>
	</div>
</div>

<?php
	include "footer.php";
?>