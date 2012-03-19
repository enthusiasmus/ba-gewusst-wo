<?php
	/*
	* made by Lukas Wanko
	* with encouragement from the University of Applied Science Salzburg
	*/

	//checking for the email availability 
    include "functions.php";
	
	$user = $dtdb->prepare("SELECT uid FROM usernames Where email = :u");
    $user->bindValue(':u', $_GET['email'], PDO::PARAM_INT);
    $user->execute();
    $user = $user->fetchObject();
	$uid = $user->uid;
	
	if($uid) 
		echo 1;
	else 
		echo 0;  
?>