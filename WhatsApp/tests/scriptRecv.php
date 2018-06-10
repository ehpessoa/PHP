<?php

	set_time_limit(0);
	
	include("src/whatsprot.class.php");
	
	$target = "5511971295334"; // Your number with country code	
	$username = "AVON"; // Nickname it will appear on push notifications
	$password = "RWZG2DSU7vvwvA83SI/NKyijqms="; // Your password
			
	$w = new WhatsProt($target, $username, false);	
	$w->eventManager()->bind("onGetImage", "onGetImage");
	$w->eventManager()->bind("onGetProfilePicture", "onGetProfilePicture");	
	$w->connect();
	$w->loginWithPassword($password);
	
	while (true) {			
		$w->pollMessage();
		$msgs = $w->getMessages();		
		 foreach ($msgs as $m) {		    
		    print($m->NodeString("") . "\n");		    
		    if ($m->getAttribute("type") == 'text') {			    
				$text = $m->getChild('enc');
				$text = $text->getData();
				echo $text;			    
		    }
		 }
	 }
	 
?>
