<?php

	require_once 'init.php';
	if ( !isset($_SESSION['zap']) ) {
		header("Location: index.php");
		exit(0);
	}		
	
    
    $f = "";
    $content="";
    if ( isset($_GET['f']) ) {
	    $f = $_GET['f'];
		$file = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/"))) . '/files/' . $_SESSION['zap']['username'] . '/' . $f;		
		if (file_exists($file)) {		
			$infile = fopen($file, "r") or die("Unable to open file " . $file);
			if ( filesize($file) > 0 ) { 
				$content = fread($infile,filesize($file));
			}
			fclose($infile); 	
		}
		//echo $f;
	} else {
		header("Location: sender.php");
		exit(0); 
	}
?>
<!doctype html>
<html>

<head>
 
  <title>Edit Files</title>

	<!--
	Loading Handsontable (full distribution that includes all dependencies apart from jQuery)
	-->
	<script data-jsfiddle="common" src="dist/handsontable.full.js"></script>
	<link data-jsfiddle="common" rel="stylesheet" media="screen" href="dist/handsontable.full.css">
	
	<!--
	Loading demo dependencies. They are used here only to enhance the examples on this page
	-->
	<link data-jsfiddle="common" rel="stylesheet" media="screen" href="demo/css/samples.css">
	<script src="demo/js/samples.js"></script>
	<script src="demo/js/highlight/highlight.pack.js"></script>
	<link rel="stylesheet" media="screen" href="demo/js/highlight/styles/github.css">
	<link rel="stylesheet" href="demo/css/font-awesome/css/font-awesome.min.css">
	
	<!--
	GitHub buttons. Don't copy this to your project :)
	-->
	<link rel="stylesheet" media="screen" href="demo/github-buttons/github-buttons.css">
	<script src="demo/github-buttons/github-buttons.js" async></script>
  
  
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
		  
</head>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<body class="home">

<div id="container">
	
	<div class="panel panel-default">	
						
		<div class="panel-heading">
			<h2>Editing "<?php echo $f ?>"</h2>
			<b><i><div align="center" id="conteudo">&nbsp;</div></i></b>
		</div>
		<p align="center">Back to <a href="upload/listfiles.php">Uploaded Files</a> or <a href="sender.php">Messager Center</a></p>
			
		<div id="example" style="width: 600px; height: 300px; overflow: hidden;"></div>
		
			<script>
			
			var objectData = [	
				<?php	
				$item = strtok($content, "\r\n");
				while ($item !== false) { 					
				    if ( $item != "" ) {
						$item=str_replace("\r\n","",$item); 
						//echo "line: '$item'\n";
						$v=explode(";",$item); 
						//print_r($v); 
						//print "f:'$f'\n";
						if ( $f == 'groups.csv' ) { //Group name;Leader name;Leader phone;Group users file
							//echo 'entrou aqui';
							$groupname = $v[0];
							$leadername = $v[1];
							$leaderphone = $v[2];
							$groupfile = $v[3];
							echo "{groupname: '$groupname', leadername: '$leadername', leaderphone: '$leaderphone', groupfile: '$groupfile'},\n";
						} else { //User name;User phjone
							$name = $v[0];
							$phone = $v[1];
							echo "{name: '$name', phone: '$phone'},\n";
						}
					}		
				    $item = strtok("\r\n");
				}		
				?>
		    ],
		    container = document.getElementById('example'), hot;
		    
		  	hot = new Handsontable(container, {
			    data: objectData,
			    colHeaders: true,
			    <?php 	    
			    if ( $f == 'groups.csv' ) { //Group name;Leader name;Leader phone;Group users file	        
			    	echo "colHeaders: ['Name of Group ', 'Leader of Group', 'Phone of Leader', 'Filename of Group'],\n";
					echo "columns: [{data: 'groupname'},{data: 'leadername'},{data: 'leaderphone'},{data: 'groupfile'}],\n";
				    echo "colWidths: [150, 150, 130, 150],\n";
				} else { //User name;User phone
					echo "colHeaders: ['Name of User', 'Phone of User'],\n";
			    	echo "columns: [{data: 'name'},{data: 'phone'}],\n";
				    echo "colWidths: [300, 280],\n";
				}
				?>
				minSpareRows: 10,
		  	});	
			
			function save(hot){		
				
				var a = hot.getData();
				var str = '';
				var data = '';
				for (k1 in a) {
					var b = a[k1];
					var i=1;
					for (k2 in b) {
						var c = b[k2];	
						
						<?php						 
						if ( $f == 'groups.csv' ) { //Group name;Leader name;Leader phone;Group users file
							echo "if ( i==1 || i==2 || i==3 ) {\n";
							echo "	str+=c+';';\n";
							echo "	i++;\n";
							echo "} else {\n";
							echo "	str+=c+',';\n";
							echo "	data+=str;\n";
							echo "	i=1;\n";
							echo "	str='';\n";
							echo "	}\n"; 
						} else { //User name;User phone	
							echo "if ( i==1 ) {\n";
							echo "	str+=c+';';\n";
							echo "	i++;\n";
							echo "} else {\n";
							echo "	str+=c+',';\n";
							echo "	data+=str;\n";
							echo "	i=1;\n";
							echo "	str='';\n";
							echo "	}\n"; 
						}
						?>																			
					}
				}
				
				var dataString = 'filename=<?php echo $f ?>&data=' + data; 
			    $.ajax({
			        type: "POST",
			        url: 'save.php',
			        data: dataString,
			        success:function(data){
				        alert(data);		       
						//$("#conteudo").html(data);
			        }
			    });
			    				
			}
		
			</script>		
		
		</div> 		
		
			<div class="form-group">
				<div id="formcontrols" class="col-sm-push-2 col-md-push-2 col-lg-push-2 ">
					<button type="button" id="savebutton" onclick="save(hot)" class="btn btn-primary btn-block">Save</button>				
				</div>				
			</div>
					
	</div>
	

</body>
</html>
