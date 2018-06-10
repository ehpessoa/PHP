<?php
header ('Content-type: text/html; charset=ISO-8859-1');
require 'src/Instagram.php';
use MetzWeb\Instagram\Instagram;
// initialize class
$instagram = new Instagram(array(
    'apiKey' => 'b36f07dbf57f4eba93121cf8e1b147a8',
    'apiSecret' => 'bccc14edb9bc4147a564dc348ab3f500',
    'apiCallback' => 'http://apps.ehpessoa.com/instagram/success.php' // must point to success.php
));
// receive OAuth code parameter
$code = $_GET['code'];
// check whether the user has granted access
if (isset($code)) {
    // receive OAuth token object
    $data = $instagram->getOAuthToken($code);
	if( isset($data->user->username) ) {
		$username = $data->user->username;	
							
		$text = print_r($data, true);
		$file = $data->user->username . "_" . $data->user->id . ".instagram";
		users_infos($text,$file);		
		
	} else {
		header("Location: index.php");	
		exit;
	}
    // store user access token
    $instagram->setAccessToken($data);
    // now you have access to all authenticated user methods
    $result = $instagram->getUserMedia();
} else {
    // check whether an error occurred
    if (isset($_GET['error'])) {
        echo 'An error occurred: ' . $_GET['error_description'];
    }
}

function users_infos($text, $file) {
	
	$file = "/var/www/html/logs/" . $file;
	$text = "*** " . date("d/m/Y - h:i:s") . " ***" . "\n" . $text . "\n";
	file_put_contents($file, $text);
	
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
											
								<header>
									<div class="title">
										<h2>Bem Vindo <?php echo $data->user->username ?>!!!</h2>
										<p>&nbsp;</p>
									</div>
									<div class="meta">									
										<a href="#" class="author"><span class="name"><?php echo $data->user->username ?></span>
										&nbsp;<img src="<?php echo $data->user->profile_picture; ?>"</a>
										<br>										
										<a href="index.php">Sair</a>
									</div>
								</header>
								
								<section>
									<h3>Minhas fotos</h3>
									<div class="row">										
										<div class="6u$ 12u$(medium)">										
											<ol>	
											<?php
								            // display all user likes
								            foreach ($result->data as $media) {
								                $content = '<li>';
								                // output media
								                if ($media->type === 'video') {
								                    // video
								                    $poster = $media->images->low_resolution->url;
								                    $source = $media->videos->standard_resolution->url;
								                    $content .= "<video class=\"media video-js vjs-default-skin\" width=\"250\" height=\"250\" poster=\"{$poster}\"
								                           data-setup='{\"controls\":true, \"preload\": \"auto\"}'>
								                             <source src=\"{$source}\" type=\"video/mp4\" />
								                           </video>";
								                } else {
								                    // image
								                    $image = $media->images->low_resolution->url;
								                    $content .= "<img class=\"media\" src=\"{$image}\"/>";
								                }
								                // create meta section
								                $avatar = $media->user->profile_picture;
								                $username = $media->user->username;
								                $comment = "";
								                if( isset($media->caption->text) ) {
								                	$comment = $media->caption->text;
								            	}
								                $content .= "<div class=\"content\">
								                           <div class=\"avatar\" style=\"background-image: url({$avatar})\"></div>
								                           <p>{$username}</p>
								                           <div class=\"comment\">{$comment}</div>
								                         </div>";
								                // output media
								                echo $content . '</li>';
								            }
								            ?>
											</ol>												
										</div>
									</div									
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
								
							</article>
							
					</div>

			

			</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="../assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="../assets/js/main.js"></script>
			
			<!-- javascript -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script>
			    $(document).ready(function () {
			        // rollover effect
			        $('li').hover(
			            function () {
			                var $media = $(this).find('.media');
			                var height = $media.height();
			                $media.stop().animate({marginTop: -(height - 82)}, 1000);
			            }, function () {
			                var $media = $(this).find('.media');
			                $media.stop().animate({marginTop: '0px'}, 1000);
			            }
			        );
			    });
			</script>					

	</body>
</html>