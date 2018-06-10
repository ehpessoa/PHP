<?php

	require_once '../init.php';
	if ( !isset($_SESSION['zap']) ) {
		header("Location: ../index.php");
		exit(0);
	}	
	
?>
<html>		
	<head>	
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>List Files</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Styles -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">		
		<link href="../style/messager.css" rel="stylesheet">		
		
		<!-- Javascript -->
		<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
		<!-- Chosen "fork" originally from here due ability to add number not found in list: https://github.com/koenpunt/chosen  -->
		<script type="text/javascript" src="chosen/chosen.jquery.min.js"></script>
		<!-- Blockui fork from: http://www.malsup.com/jquery/block/-->
		<script type="text/javascript" src="//scottjehl.github.io/iOS-Orientationchange-Fix/ios-orientationchange-fix.js"></script>
		<script type="text/javascript" src="//bainternet-js-cdn.googlecode.com/svn/trunk/js/jQuery%20BlockUI%20Plugin/2.39/jquery.blockUI.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="//cdn.jsdelivr.net/gmap3/5.0b/gmap3.min.js"></script>
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places" ></script>
		
	</head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<body>
	
		<div class="container">
			<div class="row">
				<div class="col-xs-12">				
					<div class="panel panel-default">						
						<div class="panel-heading">
							<h2>Uploaded Files</h2>
						</div> 
						<div class="panel-body">
							<form class="form-horizontal" id="whatsappform" role="form">								
								<div class="form-group">
									<ul>																					
									<?php 
									
										$dir = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/"))-7) . '/files/' . $_SESSION['zap']['username'];
										$dh  = opendir($dir);												
										echo "<img src='images/line.gif' width='90%' height='1'>";										
										while (false !== ($filename = readdir($dh))) {										
										    if ( ($filename != '.') && ($filename != '..') ) {
											    echo "<p>";
											    echo "<li><font size='3'>" . $filename . "</font>";
											    echo "&nbsp;&nbsp;<a href='../upload/download.php?f=$filename'><img src='images/file_download.gif' alt='Download'></a>";											    
											    if ( endsWith($filename, '.csv') ) {											    											    	
											    	echo "&nbsp;&nbsp;<a href='../edit.php?f=$filename'><img src='images/file_edit.png' alt='Edit'></a>";											    	
										    	}
										    	echo "&nbsp;&nbsp;<a href='../delete.php?f=$filename'><img src='images/file_delete.png' alt='Delete'></a>";
											    echo "</li>";												   											    		    
											    echo "<img src='images/line.gif' width='90%' height='1'>";
											    echo "</p>";											    
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
									</ul>									
								</div>								
							</form>
						</div>
					</div> <!-- /.panel panel-default -->
				</div> <!-- /.col -->
			</div> <!-- /.row -->			
			</div>	
			<p align="center"><a href="../sender.php">Back to Messager Center</a></p>
			</div>				
		</div> <!-- /.container -->
		
	</body>
</html>
