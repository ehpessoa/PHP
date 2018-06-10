<?php
require 'src/Instagram.php';
use MetzWeb\Instagram\Instagram;
$instagram = new Instagram('b36f07dbf57f4eba93121cf8e1b147a8');
$result = $instagram->getPopularMedia();
?>
<!DOCTYPE html>
<head>    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - fotos populares</title>
    <link href="https://vjs.zencdn.net/4.2/video-js.css" rel="stylesheet">
    <link href="images/style.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/4.2/video.js"></script>
</head>
<body>
<div class="container">
    <header class="clearfix">
        <img src="images/instagram.png" alt="Instagram logo">

        <h1>Instagram <span>fotos populares</span></h1>
    </header>
    <div class="main">
        <ul class="grid">
            <?php
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
                $comment = (!empty($media->caption->text)) ? $media->caption->text : '';
                $content .= "<div class=\"content\">
                           <div class=\"avatar\" style=\"background-image: url({$avatar})\"></div>
                           <p>{$username}</p>
                           <div class=\"comment\">{$comment}</div>
                         </div>";
                // output media
                echo $content . '</li>';
            }
            ?>
        </ul>
    </div>
</div>
<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // rollover effect
        $('li').hover(
            function () {
                var $image = $(this).find('.media');
                var height = $image.height();
                $image.stop().animate({marginTop: -(height - 82)}, 1000);
            }, function () {
                var $image = $(this).find('.media');
                var height = $image.height();
                $image.stop().animate({marginTop: '0px'}, 1000);
            }
        );
    });
</script>
</body>
</html>