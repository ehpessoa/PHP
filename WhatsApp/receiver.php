<?php

	require_once 'init.php';	
	if ( !isset($_SESSION['zap']) ) {
		header("Location: index.php");
		exit(0);
	}		
	
	
	$_SESSION['zap']['status'] = 'stopped';
	
	$username = $_SESSION['zap']['username'];
	$source = $_SESSION['zap']['source'];	
	$password = $_SESSION['zap']['sourcePassword']; 
	$replyName = $_SESSION['zap']['replyName'];
	$replyPhone = $_SESSION['zap']['replyPhone'];
	$autoMessage = $_SESSION['zap']['autoMessage'];
	
		
?>	
<html>
<head></head>

	<!-- styles specific to demo site -->
	<link type="text/css" href="style/demo.css" rel="stylesheet" media="all" />
	<!-- styles needed by jScrollPane - include in your own sites -->
	<link type="text/css" href="style/jquery.jscrollpane.css" rel="stylesheet" media="all" />
	
	<!-- Styles -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">		
	<link href="style/messager.css" rel="stylesheet">		
	
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


	<script type="text/javascript">
	
	
	function ajaxFunction()	{
		
		var httpxml;
		try	{
			// Firefox, Opera 8.0+, Safari
			httpxml=new XMLHttpRequest();
		} catch (e) {
			// Internet Explorer
			try {
				httpxml=new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					httpxml=new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {
					alert("Your browser does not support AJAX!");
					return false;
				}
			}
		}
		
		function stateChanged() {
			if(httpxml.readyState==4) {
				var message=httpxml.responseText;
				myForm.message.value=message;
				document.getElementById("messages").innerHTML=message;				
			}
		}
	
		function getFormData(myForm) { 
			var myParameters = new Array(); 
			for (var i=0 ; i < myForm.elements.length; i++) { 
				var sParam = encodeURIComponent(myForm.elements[i].name); 
				sParam += "="; 
				sParam += encodeURIComponent(myForm.elements[i].value); 
				myParameters.push(sParam); 
			} 
			return myParameters.join("&"); 
		} 
	
		var url="readMessage.php";
		var myForm = document.forms[0]; 			
		var parameters=getFormData(myForm);		
		httpxml.onreadystatechange=stateChanged;
		httpxml.open("POST", url, true)
		httpxml.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		httpxml.send(parameters)
	
	}
	
	function timer(){
		ajaxFunction();
		setTimeout('timer()',1000);
	}
	
	</script>
	
<body onload="timer()">

		<div class="container">
			<div class="row">
				<div class="col-xs-12">		
					<div class="panel panel-default">
											
						<div class="panel-heading">							
							<h2>Messages sent to <?php echo $source ?></h2>
						</div> 
						
						<div class="panel-body">
						
							<form class="form-horizontal" name="myForm" >
								<input type="hidden" name="source" value="<?php echo $source ?>">	
								<input type="hidden" name="message" value="">								
								<div class="form-group">								
								<p align="center"><a href="sender.php">Back to Messager Center</a></p>
								<div class="col-xs-12 col-sm-10">
									<div id="messages">									
									</div>	
								</div>								
								</div>						
							</form>						
																
							
						</div>
					</div> <!-- /.panel panel-default -->
				</div> <!-- /.col -->
			</div> <!-- /.row -->			
			</div>
			
			
			
			</div>				
		</div> <!-- /.container -->


	
	
</body>
</html>
