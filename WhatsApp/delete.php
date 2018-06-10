<?php

	require_once 'init.php';	
	if ( !isset($_SESSION['zap']) ) {
		header("Location: index.php");
		exit(0);
	}		
	
	
	$filename = "";
	$delete_action = "";	
	if ( isset($_GET['f']) ) {
		$filename = $_GET['f'];
	}
	if ( isset($_GET['act']) ) {
		$delete_action = $_GET['act'];
	}		
	
	if ( $delete_action == 'confirmed' ) {
		$file = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/"))) . '/files/' . $_SESSION['zap']['username'] . '/'. $filename;
		if (file_exists($file)) {
			unlink($file);
			header("Location: upload/listfiles.php");
			exit(0);
		}	
	} else {
		echo "<script>\n";
		echo "var msg = 'Are you sure you want to delete $filename?';\n";
	    echo "var r = confirm(msg);\n";
		echo "if (r == false) {\n";
		echo "	location.href='upload/listfiles.php';\n";
		echo "} else {\n";
		echo "	location.href='delete.php?f=$filename&act=confirmed';\n";
		echo "}\n";
		echo "</script>\n";
	}
	
?> 