<?php

	require_once 'init.php';	
	
	$errormessage = "";	
	if ($_SERVER['REQUEST_METHOD'] == "POST") { 		
				
		$path = substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/")));
		$users = simplexml_load_file($path . '/data/users.xml');		
		foreach ($users->user as $user){
 			if ($_POST["password"] == $user->password ) { 		 			
	 			if ( (int)date("Ymd") <= (int)$user->expires ) {		 						
					$_SESSION['zap'] = array(
					    'status' => 'stopped',
					    'username' => (string)$user->username,
					    'source' => (string)$user->source,
					    'sourcePassword' => (string)$user->sourcePassword,
					    'replyPhone' => (string)$user->replyPhone,
					    'replyName' => (string)$user->replyName,
					    'autoMessage' => (string)$user->autoMessage
					);
					set_user_folder($path, $user->username);
					header("Location: sender.php");
					exit(0);		 				
	 			} else {
		 			$errormessage = $user->expiresMessage;
		 			break;
	 			}
	        }	
        }    
	} else {		
		if ( isset($_SESSION) && isset($_SESSION['zap']) ) {
			unset($_SESSION['zap']);
		} 
	}
	
	function set_user_folder($path, $username) {
		
		$newpath = $path . '/files/' . $username;
		if ( !is_dir($newpath) ) {			
			$ret = mkdir($newpath);
			return $ret === true || is_dir($newpath);
		}	
		
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Styles -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<style type="text/css">

					body {
				padding-top: 40px;
				padding-bottom: 40px;
				background-color: #f5f5f5;
			}
			/*h2 {
				font-size: 24px;
			}
			.form-signin, .danger {
				max-width: 300px;
				padding: 20px 40px;
				margin: 10px auto;
				background-color: #fff;
				border: 1px solid #e5e5e5;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
				-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				box-shadow: 0 1px 2px rgba(0,0,0,.05);
			}
			.form-signin input[type="password"] {
				font-size: 16px;
				height: auto;
				margin-bottom: 15px;
				padding: 7px 9px;
			}*/
			.danger {
				background-color: pink;
				padding: 10px;
			}
		</style>
		
	</head>
	<body>
		<?php			
			if ( $errormessage != "" ) {				
				echo "<script>alert('$errormessage');</script>";			
			}
		?>		
	
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Login</h2>
						</div>
						<div class="panel-body">
							<form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form">
								<input type="hidden" name="action" value="login">
								
								<div class="row">
									<div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-10">
										<div class="form-group">
											<input class="form-control input-lg" type="password" name="password" placeholder="Password">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-10">
										<button class="btn btn-success btn-lg btn-block" type="submit">Sign in</button>
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
