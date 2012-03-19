<?php
	/*
	* made by Lukas Wanko
	* with encouragement from the University of Applied Science Salzburg
	*/

	//for login, logout and cookies possibility
	@session_start();
    include "config.php";
	
	//define the pdo data base access
    $dtdb = new PDO($DSN, $DB_USER, $DB_PASS)
        or die ("Kein Zugriff auf die Datenbank $DBO");

	//data base set to utf8
    $dtdb->exec('SET CHARACTER SET utf8');
	@define('DB_CHARSET', 'utf8');
	@define('DB_COLLATE', 'utf8_general_ci');
	
    if( get_magic_quotes_gpc() == 1) die("diese Applikation braucht get_magic_quotes_gpc() OFF");
?>