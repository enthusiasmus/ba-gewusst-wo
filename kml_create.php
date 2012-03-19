<?php

/*
* made by Lukas Wanko
* with encouragement from the University of Applied Science Salzburg
*/

	//File for the users kml download
	
	include "functions.php";
	// Get necessary informtion about the frontiers from the map
	$tp = $_GET['tp'];
	$bttm = $_GET['bttm'];
	$rght = $_GET['rght'];
	$lft = $_GET['lft'];
	// Select all the rows in the elements table
	$query = $dtdb->prepare("SELECT title, description, latitude, longitude FROM elements WHERE latitude < ? AND latitude > ? AND longitude > ? AND longitude < ?");
	$query->execute(array($_GET['tp'], $_GET['bttm'], $_GET['lft'], $_GET['rght']));
	// Control the query
	if (!$query)
		die('Abfrage leider fehlerhaft!');
	// Parse the selection
	function parseToXML($htmlStr)
	{
		$xmlStr=str_replace('<','&lt;',$htmlStr);
		$xmlStr=str_replace('>','&gt;',$xmlStr);
		$xmlStr=str_replace('"','&quot;',$xmlStr);
		$xmlStr=str_replace("'",'&#39;',$xmlStr);
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		$xmlStr=str_replace("ä",'&#228;',$xmlStr);
		$xmlStr=str_replace("ü",'&#252;',$xmlStr);
		$xmlStr=str_replace("ö",'&#246;',$xmlStr);
		$xmlStr=str_replace("Ä",'&#196;',$xmlStr);
		$xmlStr=str_replace("Ü",'&#220;',$xmlStr);
		$xmlStr=str_replace("Ö",'&#214;',$xmlStr);
		$xmlStr=str_replace("ß",'&#223;',$xmlStr);
		return $xmlStr;
	}
	//File definition	
	header("Content-type: text/xml; charset=utf-8");
	header('Content-Disposition: attachment; filename="Markierungen.kml"');
	
	// Start XML file, echo parent node and header
	echo "<?xml".' '."version=\"1.0\" encoding=\"UTF-8\"?>\r\n"; 
	echo '<kml xmlns="http://www.opengis.net/kml/2.2">';
	echo "\r\n<Document>\r\n";
	
	// Iterate through the rows, printing XML nodes for each
	while ($row = $query->fetch()){
	  // ADD TO XML DOCUMENT NODE
	  echo "\t<Placemark>\r\n";
	  echo "\t\t<name>" . parseToXML($row['title']) . "</name>\r\n";
	  echo "\t\t<description>" . parseToXML($row['description']) . "</description>\r\n";
	  echo "\t\t<Point>\r\n";
	  	echo "\t\t\t<coordinates>" . $row['longitude'] . ", " . $row['latitude'] . "</coordinates>\r\n";
	  echo "\t\t</Point>\r\n";
	  echo "\t</Placemark>\r\n";
	}
	// End XML file
	echo "</Document>\r\n";
	echo "</kml>"
?>