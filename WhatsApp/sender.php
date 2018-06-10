<?php

	require_once 'init.php';
	if ( !isset($_SESSION['zap']) ) {
		header("Location: index.php");
		exit(0);
	}		
	
	
	if (isset($_POST["act"]) && $_POST["act"] == 'logout' ) {
		unset($_SESSION['zap']);
		exit(0);
	}
	$sendto="none";
	if (isset($_GET["sendto"])) {
		$sendto = $_GET["sendto"];	
	}
	
?>

<!DOCTYPE html>
<html>		
	<head>	
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $_SESSION['zap']['username'] ?> Messager Center</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

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
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script type="text/javascript">		
		
		function send() {
			
			if( !$('#selectTo').val()) {
				alert('You have to select at least one people!');
				return false;
			}					
		    var phones = new Array();//storing the selected values inside an array
		    $('#selectTo :selected').each(function(i, selected) {
		        phones[i] = $(selected).val();
		    });
		    if ( (phones.length > 1) &&  ($("#action").val() == 'sendMessage') ) {
			    var t = phones.length * 5;
			    var m = ' seconds ';
			    if ( t > 60 ) {
				    m = ' minutes ';
				    t = t/60;			    
			    }
			    var msg = 'You have selected more then one people. This process will take around ' + t + m;
			    	msg += 'so I suggest to send it as Broadcast. Are you sure you want to proceed with send by Message?';
			    var r = confirm(msg);
				if (r == false) {
					return;
				}					
		    } 		    
		    $("#conteudo").html('Please wait, sending messages...').addClass('blink');
		    
		    var action = $("#action").val() + '.php';		    
		    var message = $("#message").val();
			var image = $("#image").val();
			var audio = $("#audio").val();
			var video = $("#video").val();			
			var dataString = 'phones='+ phones + '&message=' + message + '&image='+ image + '&audio='+ audio + '&video='+ video; 
		    $.ajax({
		        type: "POST",
		        url: action,
		        data: dataString,
		        success:function(data){
					$("#conteudo").removeClass('blink').addClass('h3').html('');					
					alert(data);
		        }
		    });
		}
		
		function logout() {
			var msg = 'Are you sure you want to log out?';
			var r = confirm(msg);
			if (r == false) {
				return;
			}  
			var s = 'act=logout';
		    $.ajax({
		        type: 'POST',
		        url: 'sender.php',
		        data: s, 		        
		        success:function(data){
					location.href='index.php';					
		        }
		    });
        				
    	}		
		
		</script>

	</head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">				
					<div class="panel panel-default">						
						<div class="panel-heading">
							<h2><?php echo $_SESSION['zap']['username'] ?> Messager Center</h2>
						</div> 
						<div class="panel-body">
							<form class="form-horizontal" id="whatsappform" role="form">								
								<div id="results"></div>
								<div id="inboundMessage"></div>
								
								<div class="form-group">
									<label class="control-label hidden-xs col-sm-2" for="action">Action</label>
									<div class="col-xs-12 col-sm-10">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-wrench"></i></span>
											<select class="form-control" id="action" name="action">
												<option value="sendMessage">Send a Message</option>												
												<option value="sendBroadcast">Send Broadcast</option>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label hidden-xs col-sm-2" for="to">To</label>
									<div class="col-xs-12 col-sm-10">												
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<select class="form-control" id="selectTo" name="selectTo" data-placeholder="Choose a person/group.." size="6" multiple="multiple"> 											
											<?php											
											$path = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/")));
											
											$file = $path . "/files/" . $_SESSION['zap']['username'] . "/users.csv";
											if (file_exists($file)) {
												// Load users
												$users = fopen($file, "r") or die("Unable to open file users.csv!");		
												while(!feof($users)){
												    $line = fgets($users);
												    if ( $line != "" ) {
													    $line=str_replace("\r\n","",$line);
														$v=explode(";",$line);		
														$name = $v[0];
														$id = $v[1];
														if ( $id == $sendto )
															echo "<option value='$id' selected>$name</option>";
														else 
															echo "<option value='$id'>$name</option>";
												    }
												}
												fclose($users);
											}
											
											$file = $path . "/files/" . $_SESSION['zap']['username'] . "/groups.csv";
											if (file_exists($file)) {
												// Load groups
												$groups = fopen($file, "r") or die("Unable to open file groups.csv!");		
												while(!feof($groups)){
												    $line = fgets($groups);
												    if ( $line != "" ) {
												    $line=str_replace("\r\n","",$line);
													$v=explode(";",$line);		
													$name = $v[0]; //name of group
													$id = $v[3]; //file with contacts
													if ( $id == $sendto )
														echo "<option value='$id' selected>$name</option>";
													else 
														echo "<option value='$id'>$name</option>";
												    }
												}
												fclose($users);											
											}
											
											?>
											</select>
										</div>
										<div align="center" >
											<label class="lb">											
											<img src="images/upload.png"><a href="upload/index.php">upload files</a>&nbsp;
											<img src="images/files.png"><a href="upload/listfiles.php">users/media files</a>&nbsp;
											<img src="images/messages.png"><a href="receiver.php">received messages</a>&nbsp;
											</label>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label hidden-xs col-sm-2" for="faketextbox">Message</label>
									<div class="col-xs-12 col-sm-10">
										<input class="form-control" type="text" id="message" name="message">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label hidden-xs col-sm-2" for="image">Image</label>
									<div class="col-xs-12 col-sm-10">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
											<input class="form-control" type="text" id="image" name="image" placeholder="Enter an uploaded file...">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label hidden-xs col-sm-2" for="audio">Audio</label>
									<div class="col-xs-12 col-sm-10">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-music"></i></span>
											<input class="form-control" type="text" id="audio" name="audio" placeholder="Enter an uploaded file...">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label hidden-xs col-sm-2" for="video">Video</label>
									<div class="col-xs-12 col-sm-10">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-video-camera"></i></span>
											<input class="form-control" type="text" id="video" name="video" placeholder="Enter an uploaded file...">
										</div>
									</div>
								</div>
								
								<div class="form-group">																					
									<div align="center" class="panel-heading" id="conteudo">&nbsp;</div>
								</div>	
		   
								<div class="form-group">
									<div id="formcontrols" class="col-sm-push-2 col-md-push-2 col-lg-push-2 col-xs-6 col-sm-5">	
										<button type="button" id="sendbutton" onclick="send();" class="btn btn-primary btn-block">Send</button>
									</div>
									<div class="col-sm-push-1 col-md-push-2 col-lg-push-2 col-xs-6 col-sm-5">
										<button type="button" id="logoutbutton" onclick="logout();" class="btn btn-danger btn-block">Log Out</button>
									</div>									
								</div>
								
							</form>
						</div>
					</div> <!-- /.panel panel-default -->
				</div> <!-- /.col -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</body>
</html>
