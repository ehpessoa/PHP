<?php
session_start(); 
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
							
								<?php if (isset($_SESSION['FBID'])): ?> <!--  After user login  -->
																
								<header>
									<div class="title">
										<h2>Bem Vindo <?php echo $_SESSION['FIRSTNAME']; ?>!!!</h2>
										<p>&nbsp;</p>
									</div>
									<div class="meta">									
										<a href="<?php echo $_SESSION['LINK']; ?>" target="_blank" class="author"><span class="name"><?php echo $_SESSION['FULLNAME']; ?></span>&nbsp;<img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture"></a>
										<br>
										<a href="logout.php">Sair</a>
									</div>
								</header>
								
								<section>
									<h3>MEU PERFIL</h3>
									<div class="row">										
										<div class="6u$ 12u$(medium)">										
											<ol>
												<li>Nome: <?php echo $_SESSION['FULLNAME']; ?></li>												
												<li>Email: <?php echo $_SESSION['EMAIL']; ?></li>
												<li>Sexo: <?php echo $_SESSION['GENDER']; ?></li>										
												<li>Idioma: <?php echo $_SESSION['LOCALE']; ?></li>
												<li>Link: <a href="<?php echo $_SESSION['LINK']; ?>" target="_blank">https://www.facebook.com/<?php echo $_SESSION['FBID']; ?></a></li>
										</ol>
											
										</div>
									</div>
								
								</section>
								
								<?php if (isset($_SESSION['LIKES'])): ?>
									<section>
										<h3>MEUS GOSTOS</h3>
										<div class="row">										
											<div class="6u$ 12u$(medium)">										
												<ol>	
												<?php	
												foreach ($_SESSION['LIKES']['data'] as $row) {
											    	echo "<li>" . $row['name'];										    	
											    	echo "&nbsp;<a href='https://www.facebook.com/" . $row['id'] . "' target='_blank'>Link</a></li>";  	
												}	
												?>
												</ol>
												
											</div>
										</div>									
									</section>		
								<?php endif ?>											
								
								<?php if (isset($_SESSION['POSTS'])): ?>
									<section>
										<h3>MEUS POSTS</h3>
										<div class="row">										
											<div class="6u$ 12u$(medium)">										
												<ol>	
												<?php	
												foreach ($_SESSION['POSTS']['data'] as $row) {
											    	echo "<li>" . $row['message'];
											    	if ( isset( $row['story'] ) ) {
											    		echo " " . $row['story'];   
													}
											    	echo "&nbsp;<a href='https://www.facebook.com/" . $row['id'] . "' target='_blank'>Link</a></li>";  	
												}	
												?>
												</ol>
												
											</div>
										</div									
									</section>		
								<?php endif ?>	
								
								<section>
									<h3>Mais informações sobre...</h3>
									<div class="row">										
										<div class="6u$ 12u$(medium)">										
											<ol>
												<li>Amigos</li>
												<li>Livros</li>
												<li>Músicas</li>
												<li>Filmes</li>
												<li>Trabalho</li>
												<li>Eventos</li>
												<li>Shows</li>
											</ol>
										</div>
									</div>
								</section>																
													
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
										<a href="fbconfig.php"><img src="../images/facebook_logo.png"></a>
										<p><br>Entre com a sua conta do Facebook</p>
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