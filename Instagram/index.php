<?php
require 'src/Instagram.php';
header ('Content-type: text/html; charset=ISO-8859-1');

use MetzWeb\Instagram\Instagram;
// initialize class
$instagram = new Instagram(array(
    'apiKey' => 'b36f07db7f4e31cf8e1b147a8',
    'apiSecret' => 'bccc14edc4a564dc348ab3f500',
    'apiCallback' => 'http://apps.ehpessoa.com/instagram/success.php' // must point to success.php
));
// create login URL
$loginUrl = $instagram->getLoginUrl();
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
						<section>			
							<div class="align-center">
								<img src="../images/it4mob_apps.jpg"><br><br>
							</div>										
												
							<div class="align-center">									
								<p>Você gostaria de conhecer melhor os seus clientes? Veja como prover serviços com a cara do seu cliente, utilize todo o potencial das redes sociais de forma fácil e com informações em tempo real. Faça o seu <em>cliente</em> se sentir <em>especial</em>.</p>								
								<a class="login" href="<?php echo $loginUrl ?>"><img src="../images/instagram-big.png" alt="Instagram logo"></a>
								<p><br>Entre com a sua conta do Instagram</p>
							</div>										
						</section>						
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
