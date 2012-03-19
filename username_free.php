<?php

/*
 * made by Lukas Wanko
 * with encouragement from the University of Applied Science Salzburg
 */

	//checking for the username availibility
    include "functions.php";
	
	$user = $dtdb->prepare("SELECT uid FROM usernames Where username = :u");
    $user->bindValue(':u', $_GET['usr'], PDO::PARAM_INT);
    $user->execute();
    $user = $user->fetchObject();
	$uid = $user->uid;
	
	if($uid) 
		echo 1;
	else 
		echo 0;  
?>