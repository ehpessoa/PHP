<?php

	$p = $path = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/")));
	$f = $_GET['f'];	
	$filepath = $p . '/files/' . $_SESSION['zap']['username'] . '/' . $f;

    header('Content-Type: application/download');    
    header("Content-Disposition: attachment; filename=\"" . basename($f) . "\"");
    header("Content-Length: " . filesize($filepath));    

    $fp = fopen($filepath, "r");
    fpassthru($fp);
    fclose($fp);
?>