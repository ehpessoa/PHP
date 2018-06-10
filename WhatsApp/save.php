<?php

	require_once 'init.php';
	if ( !isset($_SESSION['zap']) ) {
		header("Location: index.php");
		exit(0);
	}		
	
	
	$list = $_POST['data'];	
	$filename = $_POST['filename'];
	
	//echo $list;
	
	save_grid($list, $filename);
		
	function save_grid($list, $filename) {
		
		$path = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/")));
		$file = fopen($path . "/files/" . $_SESSION['zap']['username'] . '/' . $filename, "w") or die("Unable to open file $filename"); 
		
		$item = strtok($list, ",");
		while ($item !== false) {
			if ( $item != ';' && $item != ',' && $item != 'null;null' && $item != 'null;null;null;null' ) { 			    	
				fwrite($file, $item . PHP_EOL);
			}
	    	$item = strtok(",");
		}		
		fclose($file);
		
		echo "File successfully updated!";
		
	}
	
?> 