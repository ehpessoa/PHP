<?php

	set_time_limit(0);
	
	require_once 'src/whatsprot.class.php';	
	
	date_default_timezone_set("Brazil/East");
	
	if ( !isset($_SESSION) ) {		
		session_start(); 
	}
	
?>
