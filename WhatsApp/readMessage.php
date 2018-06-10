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
		
	$path = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/")));
	$file = $path . "/data/hist_" . $source . "_" . date("Ymd") . ".dat";		
	if (file_exists($file)) {
		$infile = fopen($file, "r") or die("Unable to open file ". $file);
		if ( filesize($file) > 0 ) { 
			$message = fread($infile,filesize($file));
			echo $message;		
		}
		fclose($infile); 	
	}
	
	if ( $_SESSION['zap']['status'] == 'stopped' ) {
		
		//Generate history files
		$file = "data/hist_" . $source . "_" . date("Ymd") . ".dat";
		file_put_contents($file, "", FILE_APPEND);	
		
		//Connect to Whatsapp	
		$_SESSION['zap']['status'] = 'running'; 		
		$w = new WhatsProt($source, $username, false);	
		$w->eventManager()->bind("onGetImage", "onGetImage");
		$w->eventManager()->bind("onGetProfilePicture", "onGetProfilePicture");	
		$w->connect();
		$w->loginWithPassword($password);
		
		while ( $w->pollMessage() ) { 
			$msgs = $w->getMessages();		
			foreach ($msgs as $m) {		    
			    $m->NodeString("");	
			    if ($m->getAttribute("type") == 'text') {
				    	
				    $name = $m->getAttribute("notify"); 
				    $from = $m->getAttribute("from"); 
					$body = $m->getChild('enc');
					$body = $body->getData();
					$phone = substr($from, 0, strpos($from, '@'));
					$when = date("d/m/Y h:i:s");
					$text = "You received a message from $name on $when. As messages are encrypted you won't be able to read them on this $source, so please get in contact with $name by $phone or <a href='sender.php?sendto=$phone'>click here</a> to reply back.<br><br>";
			 		file_put_contents($file, $text, FILE_APPEND);
			 		
					//Check if user belongs to a group, if so, them the autoMessage goes to group leader
					$userfile = find_user_file($phone);
					$arraymessages = find_reply_phone($userfile); 
					if ( count($arraymessages) > 1 ) {						
						$replyName = $arraymessages['replyName']; 
						$replyPhone = $arraymessages['replyPhone'];	
					}
							 		
					// As message is encrypted, send a reply to user.				
					$autoMessage = str_replace("[name]", $name, $autoMessage);
					$autoMessage = str_replace("[source]", $source, $autoMessage); 
					$autoMessage = str_replace("[replyPhone]", $replyPhone, $autoMessage); 
					$autoMessage = str_replace("[replyName]", $replyName, $autoMessage); 					
					
					$w->sendMessage($phone, $autoMessage); 
					sleep(3);
					
			    }
			}
		}		
		
		//Disconnect Whatsapp
		$w->Disconnect();		
		$_SESSION['zap']['status'] = 'stopped';	
	}
	
	function find_reply_phone($userfile) {				
			
		$found=false;
		$file = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/"))) . '/files/' . $_SESSION['zap']['username'] . '/'. 'groups.csv';
		$groupfile = fopen($file, "r") or die("Unable to open file ". $file);
		$i=0;		
		while(!feof($groupfile)){
		    $line = fgets($groupfile);
		    if ( $line != "" ) { 
		    	$line=str_replace("\r\n","",$line);
				$v=explode(";",$line);	
				if (  $v[3] == $userfile ) { //finding firts phone, return ignoring other ones 
					$arrayphones = array(
					    'replyName' => $v[1],
					    'replyPhone' => $v[2]
					);
					$found=true;
					fclose($groupfile);	
					return $arrayphones;
				}						
			}
		}
		if ( !$found ) {
			fclose($groupfile);	
			return array();
		}
	}


	function find_user_file($number) {
		
		$path = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/"))) . '/files/' . $_SESSION['zap']['username']; 
		$dh  = opendir($path);		
		while (false !== ($filename = readdir($dh))) {	  
		    if ( ($filename != '.') && ($filename != '..') ) {
			    if ( endsWith($filename, '.csv') ) {
					$content=file_get_contents($path . '/' . $filename);
					if ( strpos($content,$number) > 0  ){
						return $filename;
					} 				    
			    }			
			}
		}
	}
	
	function endsWith($haystack, $needle) {
	    $length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }
	    return (substr($haystack, -$length) === $needle);
	}
	
	
	
?>
