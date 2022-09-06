<?php
require_once 'config.php';

// Start - Triggered with Meeting End Hook 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$data = file_get_contents("php://input");
	$decode = json_decode($data);

	$uuid = $decode->payload->object->uuid;

    if (json_last_error() !== JSON_ERROR_NONE) {
        die(header('HTTP/1.0 415 Unsupported Media Type'));
    }

	$file = 'hook.json';

	file_put_contents($file, "");
    file_put_contents($file, print_r($uuid, true) . PHP_EOL, FILE_APPEND);
}
// End - Triggered with Meeting End Hook
 
$url = "https://zoom.us/oauth/authorize?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URI;
//header('Location: '.$url);
?>
  
<a href="<?php echo $url; ?>">Login with Zoom</a>