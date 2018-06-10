<?php	
	
	require_once 'init.php';
	if ( !isset($_SESSION['zap']) ) {
		header("Location: index.php");
		exit(0);
	}		
	
	$username = $_SESSION['zap']['username'];
	$source = $_SESSION['zap']['source'];	
	$password = $_SESSION['zap']['sourcePassword']; 
	$replyName = $_SESSION['zap']['replyName'];
	$replyPhone = $_SESSION['zap']['replyPhone'];
	$autoMessage = $_SESSION['zap']['autoMessage'];		
	
	$phones = $_POST['phones']; 
	$message = $_POST['message'];
	$image = $_POST['image'];
	$audio = $_POST['audio'];
	$video = $_POST['video'];	
	
	$path = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/")));
	
	if ( !empty($image) ) {
		$file = $path . "/files/" . $_SESSION['zap']['username'] . "/" . $image;
		if (!file_exists($file)) {
			echo 'File ' . $image . ' not found!';
			exit(0);
		}	
	}
	if ( !empty($audio) ) {					
		$file = $path . "/files/" . $_SESSION['zap']['username'] . "/" . $audio;
		if (!file_exists($file)) {
			echo 'File ' . $audio . ' not found!';
			exit(0);
		}	
	}
	if ( !empty($video) ) {				
		$file = $path . "/files/" . $_SESSION['zap']['username'] . "/" . $video;
		if (!file_exists($file)) {
			echo 'File ' . $video . ' not found!';
			exit(0);
		}	
	}	
	
	// Fill array with all recipients
	$arrayphones = array();
    if ( strpos($phones, ",") == 0 ) { 
	    $i=0;
		if ( endsWith($phones, '.csv') ) { 			
			$group = $path . "/files/" . $_SESSION['zap']['username'] . "/" . $phones;			
			$groupfile = fopen($group, "r") or die("Unable to open file ". $group);		
			while(!feof($groupfile)){
			    $line = fgets($groupfile);
			    if ( $line != "" ) {
			    	$line=str_replace("\r\n","",$line);
					$v=explode(";",$line);								
					$id = $v[1];				
					$arrayphones[$i] =  $id;
					$i++;
				}
			}		
			fclose($groupfile);	
		} else {
			$phones=str_replace("\r\n","",$phones);
			$arrayphones[0] =  $phones;		
		}		
    } else {		
		$i=0;
		$phone = strtok($phones, ",");			
		while ($phone !== false) { 			
			if ( endsWith($phone, '.csv') ) { //this is a group				
				$group = $path . "/files/" . $_SESSION['zap']['username'] . "/" . $phone;
				$groupfile = fopen($group, "r") or die("Unable to open file ". $group);								
				while(!feof($groupfile)){
				    $line = fgets($groupfile);
				    if ( $line != "" ) {
					    $line=str_replace("\r\n","",$line);
						$v=explode(";",$line);								
						$id = $v[1];
						$arrayphones[$i] =  $id;
						$i++;
					}			
				}
				fclose($groupfile);
			} else {
			    $phone=str_replace("\r\n","",$phone);
				$arrayphones[$i] =  $phone;
				$i++;
			}
		    $phone = strtok(",");
		}
	}	

	//Connect to Whatsapp
	$_SESSION['zap']['status'] = 'running'; 
	$w = new WhatsProt($source, $username, false); 
	$w->connect();
	$w->loginWithPassword($password);
	
	// Start sending messages	
	foreach ($arrayphones as $target) {	
		if ( !empty($message) ) {
			$w->sendMessage($target, $message);
			while($w->pollMessage());
			sleep(3);
		}
		if ( !empty($image) ) { 
			$w->sendMessageImage($target, $path . '/files/' . $_SESSION['zap']['username'] . '/' . $image);
			while($w->pollMessage());
			sleep(3);
		}
		if ( !empty($audio) ) {			
			$w->sendMessageAudio($target, $path . '/files/' . $_SESSION['zap']['username'] . '/' . $audio);
			while($w->pollMessage());
			sleep(3);			
		}
		if ( !empty($video) ) {	
			$w->sendMessageVideo($target, $path . '/files/' . $_SESSION['zap']['username'] . '/' . $video);
			while($w->pollMessage());
			sleep(3);
			
		}
	}
	
	//Disconnect Whatsapp	
	$w->Disconnect();	
	$_SESSION['zap']['status'] = 'stopped'; 
	
	if ( count($arrayphones) > 1 ) {
		echo "Your messages have been sent!";	
	} else {
		echo "Your message has been sent!";	
	}
	
	function endsWith($haystack, $needle) {
	    $length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }
	    return (substr($haystack, -$length) === $needle);
	}

	
?>