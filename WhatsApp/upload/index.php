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
	
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>
<link href="style/style.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			uploadProgress: OnProgress, //upload progress callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
		

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#FileInput').val()) //check empty input filed
		{
			$("#output").html("You have to select one file");
			return false
		}
		
		var fsize = $('#FileInput')[0].files[0].size; //get file size
		var ftype = $('#FileInput')[0].files[0].type; // get file type
		
		//alert('ftype: ' + ftype);
		
		//allow file types 
		switch(ftype)		
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html':
			case 'text/xml':
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'audio/mp3': 
			case 'video/quicktime':
			case 'video/mp4':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 5 MB (1048576)
		if(fsize>5242880) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

}); 

</script>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<body>
	
		<div class="container">
			<div class="row">
				<div class="col-xs-12">				
					<div class="panel panel-default">						
						<div class="panel-heading">
							<h2>File Uploader</h2>
						</div> 
						<div class="panel-body">
											
								<div class="form-group">	
								
									<div id="upload-wrapper">
									<div align="center">								
									<form action="processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
										<input name="FileInput" id="FileInput" type="file" />
										<input type="submit"  id="submit-btn" value="Upload" />
										<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
									</form>
									<div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
									<div id="output"></div>								
									</div>
								</div>
									
								</div>								
							
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
