<?php

/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

	include "functions.php";
	
	// Start XML file, create parent node
	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("element");
	$parnode = $dom->appendChild($node);
	
	// Select all the rows in the elements table
	$query = $dtdb->prepare("SELECT * FROM elements");
	$query->execute();
	
	// Control the query
	if (!$query)
		die('Abfrage leider fehlerhaft!');
	
	// Create XML file
	header("Content-type:text/xml"); 
	
	// Iterate through the rows, adding XML nodes for each row
	while ($row = $query->fetch()){  
		// ADD TO XML DOCUMENT NODE  
		$node = $dom->createElement("element");  
		$newnode = $parnode->appendChild($node);   
		$newnode->setAttribute("etype", $row['etype']);  
		$newnode->setAttribute("title",$row['title']);
		$newnode->setAttribute("location", $row['location']);  
		$newnode->setAttribute("latitude", $row['latitude']);  
		$newnode->setAttribute("longitude", $row['longitude']);  
		$newnode->setAttribute("begin_access_time", $row['begin_access_time']);  
		$newnode->setAttribute("end_access_time", $row['end_access_time']);  
		$newnode->setAttribute("activ_in_winter", $row['activ_in_winter']);
		$newnode->setAttribute("publish_date",$row['publish_date']);
		$newnode->setAttribute("confirmed", $row['confirmed']);  
		$newnode->setAttribute("eid", $row['eid']);  
		$newnode->setAttribute("description", $row['description']);  
	} 
	
	echo $dom->saveXML();
?>