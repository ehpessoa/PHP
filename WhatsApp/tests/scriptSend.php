<?php

	require_once 'src/whatsprot.class.php';
	
	echo "Define who is the source\n"; 
	$source = "5511971295334";		//first attempt
	//$source = "5511950254263";	//second attempt
	$nickname = "AVON";
	$password = "RWZG2DSU7vvwvA83SI/NKyijqms="; 
	
	echo "Define who is the target and message\n"; 		
	$target = "5511989620797"; 
	
	//Define the other messages			
	$video = "marinho.mp4";
	
	echo "Connect to source and login to Whatssapp\n";
	$w = new WhatsProt($source, $nickname, false); 
	$w->connect(); 
	$w->loginWithPassword($password); 
	
	echo "Compose message and send to target\n";	
	//$w->sendBroadcastMessage($target, $message);		
	//$w->sendMessage($target, $message); 	
	//$w->sendMessageImage($target, $image); 	
	//$w->sendMessageAudio($target, $audio); 
	$w->sendMessageVideo($target, $video); 
	//$w->pollMessage();
	while($w->pollMessage());	
	
	$w->Disconnect();
	
	echo "Message has been sent"; 
			

?>
