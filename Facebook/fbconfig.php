<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

// init app with app id and secret
FacebookSession::setDefaultApplication( '123456','12b4d3f61f7d773ae86e462a1a' );
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://apps.ehpessoa.com/facebook/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
	
// graph api request for user data	
	$graph = '/me?fields=id,name,first_name,last_name,age_range,link,gender,locale,picture,cover,timezone,updated_time,verified,likes,email';
	$request = new FacebookRequest( $session, 'GET', $graph );
	$response = $request->execute();	
	$graphObject = $response->getGraphObject()->asArray();
	$arrayObject = json_decode(json_encode($graphObject),true);	
	//echo "<br><b>$graph</b><br>";
	//var_dump ($arrayObject);
	
	$fbid = $arrayObject['id'];
	$fbfullname = $arrayObject['name'];
	$fbfirstname = $arrayObject['first_name'];
	$fblastname = $arrayObject['last_name'];
	$fbagerange = $arrayObject['age_range']['min'];	
	$fblikes = $arrayObject['likes'];	
	$fblink = $arrayObject['link'];	
	$fbgender = $arrayObject['gender'];
	$fblocale = $arrayObject['locale'];
	$fbpicture = $arrayObject['picture']['data']['url'];
	$fbcover = $arrayObject['cover']['source'];
	$femail = $arrayObject['email'];	
	
	$text = print_r($arrayObject, true);
	$file = $fbfirstname . "_" . $fbid . ".facebook";
	$file = "/var/www/html/logs/" . $file;
	$text = "*** " . date("d/m/Y - h:i:s") . " ***" . "\n" . $text . "\n";
	file_put_contents($file, $text);	

	$_SESSION['FBID'] = $fbid;           
	$_SESSION['FULLNAME'] = $fbfullname;
	$_SESSION['FIRSTNAME'] = $fbfirstname;
	$_SESSION['LASTNAME'] = $fblastname;
	$_SESSION['AGERANGE'] = $fbagerange;	
	$_SESSION['PICTURE'] = $fbpicture;
	$_SESSION['COVER'] = $fbcover;
	$_SESSION['LIKES'] = $fblikes;
	$_SESSION['LINK'] = $fblink; 
	$_SESSION['GENDER'] = $fbgender;
	$_SESSION['LOCALE'] = $fblocale;	
	$_SESSION['EMAIL'] =  $femail;	

	//header location after session
	header("Location: index.php");

} else {
	
	$permissions = ['email','user_friends','user_likes']; // optional	
	$loginUrl = $helper->getLoginUrl($permissions);		
	header("Location: ".$loginUrl);	
}
?>
