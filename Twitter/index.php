<?php
//start session
session_start();
header ('Content-type: text/html; charset=ISO-8859-1');
// Include config file and twitter PHP Library by Abraham Williams (abraham@abrah.am)
include_once("config.php");
include_once("inc/twitteroauth.php");

if( isset($_SESSION['request_vars']) ) { 
	//Connect to twitter							
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['request_vars']['oauth_token'], $_SESSION['request_vars']['oauth_token_secret']);								

	$credentials = $connection->get("account/verify_credentials");
	$content = print_r($credentials, true);			
	$token = print_r($_SESSION['request_vars'], true);			
	$body = "*** " . date("d/m/Y - h:i:s") . " ***" . "\n" . $token . "\n" . $content;
	$file = "/var/www/html/logs/" . $credentials->screen_name . "_" . $credentials->id . ".twiter";
	file_put_contents($file,$body);
}
			
?>
<html>
	<head>
		<title>Mídias Sociais</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="../assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="../assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="../assets/css/ie8.css" /><![endif]-->
	</head>
	<body>
		<?php include_once("../analyticstracking.php") ?>
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="http://it4mob.com">it4mob.com</a></h1>
						<nav class="links">
							<ul>
								<li><a href="../facebook/index.php">Facebook</a></li>
								<li><a href="../twitter/index.php">Twitter</a></li>
								<li><a href="../instagram/index.php">Instagram</a></li>
								<li><a href="../linkedin/index.php">LinkedIn</a></li>
								<li><a href="../youtube/index.php">YouTube</a></li>
							</ul>
						</nav>
						<nav class="main">
							<ul>								
								<li class="menu">
									<a class="fa-bars" href="#menu">Menu</a>
								</li>
							</ul>
						</nav>						
					</header>		
					
					<!-- Menu -->
					<section id="menu">
						
						<!-- Links -->
							<section>
								<ul class="links">															
									<li>
										<a href="../facebook/index.php">
											<p>Facebook</p>										
										</a>
									</li>
									<li>
										<a href="../twitter/index.php">
											<p>Twitter</p>											
										</a>
									</li>
									<li>
										<a href="../instagram/index.php">
											<p>Instagram</p>										
										</a>
									</li>
									<li>
										<a href="../linkedin/index.php">
											<p>LinkedIn</p>										
										</a>
									</li>
									<li>
										<a href="../youtube/index.php">
											<p>YouTube</p>											
										</a>
									</li>									
								</ul>
							</section>

					</section>								
				
				<!-- Main -->
					<div id="main">
							<article class="post">							
							
								<?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'verified'): ?> <!--  After user login  -->
																
								<header>
									<div class="title">
										<h2>Bem Vindo <?php echo $_SESSION['request_vars']['screen_name']; ?>!!!</h2>
										<p>&nbsp;</p>
									</div>
									<div class="meta">									
										<a href="#" class="author"><span class="name"><?php echo $credentials->name; ?></span>										
										&nbsp;<img src="<?php echo $credentials->profile_image_url; ?>"</a>
										<br>		
														
										<a href="logout.php?logout">Sair</a>
									</div>
								</header>
							
								<section>
									<h3>MEU PERFIL</h3>
									<div class="row">										
										<div class="6u$ 12u$(medium)">										
											<ol>
												<li>Nome: <?php echo $credentials->name; ?></li>	
												<li>Twitter: <a href="https://twitter.com/<?php echo $credentials->screen_name; ?>" target="_blank">https://twitter.com/<?php echo $credentials->screen_name; ?></a></li>		
												<li>Descrição: <?php echo mb_convert_encoding($credentials->description, 'iso-8859-1','utf-8'); ?></li>										
												<li>Localização: <?php echo mb_convert_encoding($credentials->location, 'iso-8859-1','utf-8'); ?></li>	
												<li>Horário: <?php echo $credentials->time_zone; ?></li>	
												<li>Seguidores: <?php echo $credentials->followers_count; ?></li>	
												<li>Seguindo: <?php echo $credentials->friends_count; ?></li>
											</ol>											
										</div>
									</div>								
								</section>								
									
								<?php
								//If user wants to tweet using form.
								if(isset($_POST["updateme"])) {
									//Post text to twitter 
									$my_update = $connection->post('statuses/update', array('status' => $_POST["updateme"]));
									die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
								}								
								//Get latest tweets
								$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $_SESSION['request_vars']['screen_name'], 'count' => 5));
								
								?>								
								<?php if (isset($my_tweets)): ?>
									<section>
										<h3>Meus Tweets</h3>
										<div class="row">										
											<div class="6u$ 12u$(medium)">										
												<ol>	
												<?php													
												foreach ($my_tweets  as $my_tweet) {
													echo '<li>'. mb_convert_encoding($my_tweet->text, 'iso-8859-1','utf-8') .' <br />-<i>'.$my_tweet->created_at.'</i></li>';											
												}	
												?>
												</ol>												
											</div>
										</div									
									</section>		
								<?php endif ?>									
													
								<section>
									<h3>Interações automáticas..</h3>
									<div class="row">										
										<div class="6u$ 12u$(medium)">										
											<ol>
												<li>Mensagens</li>
												<li>Fotos</li>
												<li>Vídeos</li>
											</ol>
										</div>
									</div>
								</section>										
								<?php else: ?>     <!-- Before login --> 	
								
								<section>						
									<div class="align-center">
										<img src="../images/it4mob_apps.jpg"><br><br>
									</div>										
											
									<div class="align-center">
										<p>Você gostaria de conhecer melhor os seus clientes? Veja como prover serviços com a cara do seu cliente, utilize todo o potencial das redes sociais de forma fácil e com informações em tempo real. Faça o seu <em>cliente</em> se sentir <em>especial</em>.</p>
										<a href="process.php"><img src="../images/twitter_logo.png"></a>
										<p><br>Entre com a sua conta do Twitter</p>
									</div>										
								</section>																						
								
								<?php endif ?>		
								
							</article>
							
					</div>

			

			</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="../assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="../assets/js/main.js"></script>

	</body>
</html>