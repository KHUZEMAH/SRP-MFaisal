<?php
require_once 'vendor/autoload.php';
 
define('CLIENT_ID', 'hHQNBXB0SWqgxElXpPHHw');					//eecD8UMkSFa3xfGlYRDOsw
define('CLIENT_SECRET', 'ZfI02YwRumjJFosTrmKxj5iA543ovnFr');	//OmTuW66SKeg91eu3gA2ec2EpkMhqPiTk
define('REDIRECT_URI', sprintf( 
		"%s://%s%s", 
		isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'], 
		'/zoom/callback.php' 
	) 
);

define('MAILCHIMP_LIST_ID', '25335a8c6a');
define('MAILCHIMP_DC', 'us17');
define('MAILCHIMP_API_KEY', '034e69d26f94c9f0ed455feb76806ff0-us17');