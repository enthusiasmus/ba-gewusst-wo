<html>
<head>
<!-- dynamic title definition -->
<!--  
	/*
	 * made by Lukas Wanko
	 * with encouragement from the University of Applied Science Salzburg
	 */
 -->
<title><?php echo $pagetitle ?></title>
<!-- style sheet for the hole website -->
<link rel="stylesheet" href="style/main.css" type="text/css">
<!-- google font for the navigation buttons -->
<link  href="http://fonts.googleapis.com/css?family=Maven+Pro:400,500,700,900" rel="stylesheet" type="text/css" >
<!-- define the piggy bank symbol as famous icon for this website - piggy bank drawn by Mareike Klein - student of the mozarteum -->
<link rel="icon" href="images/favicon.png" type="image/png">
<!-- so internet explorer get known the new html5 tags -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]--> 
<!-- google maps including: with option "no" user can't scale the map size -->
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<!-- for the google map self -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<!-- for using jquery-->
<script src="scripts/jquery-1.6.1.js"></script>
<script type="text/javascript">
	//handle the login and logout item in the corner right upper corner of the website
	//by click on "Anmelden" a formular appears, clicking again it disappear
	var status = true;
	function clogin(){
		if(status){
			$("form[id=login]").fadeToggle("slow");
			$("span[id=reg]").after("<span id='pass'><a href='mailto:lwanko.mmt-b2010"+
			"@fh-salzburg.ac.at?subject=Passwort%20vergessen'>Passwort?</a></span>");
			status = false;
		}
		else{
			$("form[id=login]").toggle();
			$("span[id=pass]").remove();
			status = true;
		}
		$("div[id=corit]").toggleClass('corit_login');
		$("div[id=opacitycorit]").toggleClass('corit_login');
	}
	
	//depending on the site, different javascripts were loaded
	<?php
		if($pagetitle == "Gewusst-Wo - Neues Element")
			include "scripts/map.js";
		else if($pagetitle == "Gewusst-Wo - Registrierung")
			include "scripts/registration_formular.js";
		else if($pagetitle == "Gewusst-Wo - Startseite")
			include "scripts/map.js";
	?>
	
	//depending on the site, different scripts were loaded after the document-load finished
	$(document).ready(function(){
		<?php
			if($pagetitle == "Gewusst-Wo - Neues Element"){
				include "scripts/map_onload.js";
				include "scripts/element_create_onload.js";
			}
			else if($pagetitle == "Gewusst-Wo - Registrierung")
				include "scripts/registration_formular_onload.js";
			else if($pagetitle == "Gewusst-Wo - Startseite"){
				include "scripts/map_onload.js";
				include "scripts/map_navigation.js";
			}
			else if($pagetitle == "Gewusst-Wo - Beschreibung"){
				include "scripts/description_onload.js";
			}
		?>
	});	
</script>

</head>
<body>
	<!-- top of the website -->
	<header>
        <div id="title">GEWUSST-WO!</div>
		<nav>
            <span><a href="index.php">KARTE</a></span>•<span><a href="description.php">BESCHREIBUNG</a></span>•<span><a href="element_create.php">NEUES ELEMENT</a></span>
        </nav>
        <!-- black balk -->
        <div id="blackbalk"></div>
        <!-- div above corner item with opacity -->
        <div id="opacitycorit" class="corit_standard"></div>
        <!-- top right corner item -->
		<?php
			if (@$_SESSION['USER']){
				//when no user is loged in, display the login posibility
            	include 'logout.php'; 
			}
			else{
				//else there should be the posibility to logout
            	include 'login.php';
			}
		?> 
    </header>