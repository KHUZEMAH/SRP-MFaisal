<?php
require_once 'config.php';
include('../wp-load.php');
define('WP_USE_THEMES', false);
global $wpdb;
$options = get_option( 'my_option_name' );
$word = 'private';

$timezone   =   -7; //(GMT -7:00) EST (U.S. & Canada)
$today      =   gmdate("Y-m-d", time() + 3600*($timezone+date("I")));

$access_token   = trim(fgets(fopen('data_files/access_token.txt', 'r')));
$refresh_token  = trim(fgets(fopen('data_files/refresh_token.txt', 'r')));

// Start - Triggered with Meeting End Hook
// 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $data = file_get_contents("php://input");
    $decode = json_decode($data);

    $id = $decode->payload->object->id;
    //$uuid = $decode->payload->object->uuid;
    $topic = $decode->payload->object->topic;
    $start_time = date('Y-m-d', strtotime($decode->payload->object->start_time));
    $start_time_minus_one = date('Y-m-d', strtotime('-1 day', strtotime($decode->payload->object->start_time)));
    $end_time = date('Y-m-d', strtotime($decode->payload->object->end_time));

    if (json_last_error() !== JSON_ERROR_NONE) {
        die(header('HTTP/1.0 415 Unsupported Media Type'));
    }

    $hook_file  = 'data_files/hook.json';
    $log_file   = 'data_files/log.json';

    file_put_contents($hook_file, "");
    file_put_contents($hook_file, print_r($id, true) . PHP_EOL, FILE_APPEND);

    file_put_contents($log_file, "");
    file_put_contents($log_file, print_r($decode, true) . PHP_EOL, FILE_APPEND);
}
// End - Triggered with Meeting End Hook
//

if ($options['send_email'] == '1')
{
    if (!preg_match("/\b".$word."\b/i", $topic))
    {
        // Start - Refresh Token
        //
        $client_3 = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
         
        $response_3 = $client_3->request('POST', '/oauth/token', [
            "headers" => [
                "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
            ],
            'form_params' => [
                "grant_type" => "refresh_token",
                "refresh_token" => $refresh_token
            ]
        ]);

        $result_3 = json_decode($response_3->getBody()->getContents(), true);

        file_put_contents('data_files/access_token.txt', "");
        file_put_contents('data_files/access_token.txt', print_r($result_3['access_token'], true) . PHP_EOL, FILE_APPEND);

        file_put_contents('data_files/refresh_token.txt', "");
        file_put_contents('data_files/refresh_token.txt', print_r($result_3['refresh_token'], true) . PHP_EOL, FILE_APPEND);
        // End - Refresh Token
        //

        // Start - Get Webinar Participants 
        // 
        $webinarID = trim(fgets(fopen('data_files/hook.json', 'r')));
        $access_token = $result_3['access_token'];
        $endpoint   = '/v2/report/webinars/'.$webinarID.'/participants';
        
        function getAllParticipants($ep, $at, $nt) {

            $client     = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('GET', $ep.'?next_page_token='.$nt, [
                "headers" => [
                    "Authorization" => "Bearer ". $at
                ],
                'http_errors' => false
            ]);

            $response = json_decode($response->getBody()->getContents(), true);
            $participants = $response['participants'];

            if($response['next_page_token'] != '')
            {
                $participants = array_merge($participants, getAllParticipants($ep, $at, $response['next_page_token']));
            }
            return $participants;
        }

        $all_participants = getAllParticipants($endpoint, $access_token, '');
        // End - Get Webinar Participants
        //

        // Start - Filter Unique Participants 
        //
        function unique_multidim_array($array, $key) {
            $temp_array = array();
            $i = 0;
            $key_array = array();
           
            foreach($array as $val) {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
                $i++;
            }
            return $temp_array;
        }

        $unique_participants = unique_multidim_array($all_participants,'user_email');
        // End - Filter Unique Participants 
        // 

        foreach ($unique_participants as $key => $participant) {

            if ($key == 0) {
                continue;
            }

            $to = $participant['user_email'];

            $is_user = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}zoom WHERE webinar_id = ".$id." AND user_email = '$to' AND (start_time = '$today' OR start_time = '$start_time' OR start_time = '$start_time_minus_one') ", OBJECT );
            
            if ( !$is_user ) {
                
                $subject = "SlowRisePizza - Zoom Webinar (".$topic." - ID: ".$id.")";

                $message = "
                <html>
                <head>
                <title>Slow Rise Pizza Co - Zoom Webinar</title>
                </head>
                <body>
                <p><b>Thank you for attending the Live Zoom Webinar.</b></p>
                <p><b>We appreciate your support and feedback.</b> Please click <a href='".get_permalink( 2055 )."'>".get_permalink( 2055 )."</a> to give your feedback about our services.</p>
                </body>
                </html>
                ";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <info@slowrisepizza.com>' . "\r\n";

                //Start - Discount Codes
                //
                if (mail($to,$subject,$message,$headers)) {

                    $wpdb->insert($wpdb->prefix.'zoom', array(
                        'webinar_id' => $id, 
                        'webinar_title' => $topic, 
                        'user_email' => $to,
                        'start_time' => $start_time,
                        'end_time' => $end_time
                    ));

                    $discount_codes = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pmpro_group_discount_codes WHERE is_used = '0'", OBJECT );

                    if (count($discount_codes) > 0)
                    {
                        foreach ($discount_codes as $key1 => $discount_code) {

                            $wpdb->update( 
                                "{$wpdb->prefix}pmpro_group_discount_codes", 
                                array( 
                                    'is_used' => '1', 
                                ), 
                                array( 'id' => $discount_code->id ),  
                            );

                            /*********** Start - MailChimp **************/

                            $full_name =  $participant['name'];

                            if(strpos($full_name, ' ') !== false) {
                                $name_arr = explode(" ",$full_name);
                                $first_name = $name_arr[0];
                                $last_name  = $name_arr[1];
                            } else {
                                $first_name = $full_name;
                                $last_name  = '';
                            }

                            $mailChimpData = array(
                                "email_address" => $participant['user_email'], 
                                "status" => "subscribed",
                                "merge_fields" => array(
                                    "FNAME" => $first_name,
                                    "LNAME" => $last_name,
                                    "DISCOUNT" => $discount_code->code,
                                    "LEVEL" => $topic,
                                )
                            );

                            $ch = curl_init('https://'.MAILCHIMP_DC.'.api.mailchimp.com/3.0/lists/'.MAILCHIMP_LIST_ID.'/members/');
                            curl_setopt_array($ch, array(
                                CURLOPT_POST => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_HTTPHEADER => array(
                                    'Authorization: apikey '.MAILCHIMP_API_KEY,
                                    'Content-Type: application/json'
                                ),
                                CURLOPT_POSTFIELDS => json_encode($mailChimpData)
                            ));
                            $server_output = curl_exec($ch);
                            $decode = json_decode($server_output);
							
							/*********** Adding user in master list as well VOD **************/

                                $merge_fields3 = array(
                                    "FNAME" => $first_name,
                                    "LNAME" => $last_name,
                                );
                                $email = $participant['user_email'];
                                $list_id = '68d48f4e7e';
                                $api_key = '034e69d26f94c9f0ed455feb76806ff0-us17';

                                $data_center = substr($api_key,strpos($api_key,'-')+1);

                                $url = 'https://'. $data_center .'.api.mailchimp.com/3.0/lists/'. $list_id .'/members';

								$json = json_encode([
									'email_address' => $email,
									'status'        => 'subscribed', //pass 'subscribed' or 'pending'
									'merge_fields'  => $merge_fields3,
								]);

								$ch2 = curl_init($url);
								curl_setopt($ch2, CURLOPT_USERPWD, 'user:' . $api_key);
								curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
								curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
								curl_setopt($ch2, CURLOPT_POST, 1);
								curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($ch2, CURLOPT_POSTFIELDS, $json);
								$result = curl_exec($ch2);
								$status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
								curl_close($ch2);
								
								/*********** Adding tags in user's profile **************/
								
								require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

								$mailchimp = new MailchimpMarketing\ApiClient();
								$mailchimp->setConfig([
									'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
									'server' => 'us17',
								]);
								
								$list_id = '68d48f4e7e';
								$subscriber_hash = md5($email);
								
								$response = $mailchimp->lists->updateListMemberTags($list_id, $subscriber_hash, [
								   "tags" => [
									 ["name" => "ZOOM", "status" => "active"]
								   ]
								]);
			
								/*********** End adding tags in user's profile **************/
			
							
							

                            if ($decode->status == 400)
                            {
                                $auth = base64_encode( 'user:'.MAILCHIMP_API_KEY );
                                $ch1 = curl_init();
                                curl_setopt($ch1, CURLOPT_URL, 'https://'.MAILCHIMP_DC.'.api.mailchimp.com/3.0/lists/'.MAILCHIMP_LIST_ID.'/members/'.md5($response['participants'][$key]['user_email']));
                                curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.$auth));
                                curl_setopt($ch1, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
                                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
                                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, "PUT");
                                curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($mailChimpData));
                                curl_exec($ch1);
								
								/*********** Adding user in master list as well VOD **************/

                                $merge_fields2 = array(
                                    "FNAME" => $first_name,
                                    "LNAME" => $last_name,
                                );
                                $email = $participant['user_email'];
                                $list_id = '68d48f4e7e';
                                $api_key = '034e69d26f94c9f0ed455feb76806ff0-us17';

                                $data_center = substr($api_key,strpos($api_key,'-')+1);

                                $url = 'https://'. $data_center .'.api.mailchimp.com/3.0/lists/'. $list_id .'/members';

								$json = json_encode([
									'email_address' => $email,
									'status'        => 'subscribed', //pass 'subscribed' or 'pending'
									'merge_fields'  => $merge_fields2,
								]);

								$ch2 = curl_init($url);
								curl_setopt($ch2, CURLOPT_USERPWD, 'user:' . $api_key);
								curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
								curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
								curl_setopt($ch2, CURLOPT_POST, 1);
								curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($ch2, CURLOPT_POSTFIELDS, $json);
								$result = curl_exec($ch2);
								$status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
								curl_close($ch2);
								
								/*********** Adding tags in user's profile **************/
								
								require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

								$mailchimp = new MailchimpMarketing\ApiClient();
								$mailchimp->setConfig([
									'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
									'server' => 'us17',
								]);
								
								$list_id = '68d48f4e7e';
								$subscriber_hash = md5($email);
								
								$response = $mailchimp->lists->updateListMemberTags($list_id, $subscriber_hash, [
								   "tags" => [
									 ["name" => "ZOOM", "status" => "active"]
								   ]
								]);
								
								/*********** End adding tags in user's profile **************/
								
								/*********** End adding user in master list as well VOD **************/
											
                            }
                            /*********** End - MailChimp **************/

                            if($key1 == 0){
                                break;
                            }
                        }

                    } else {

                        $to = 'noel@slowrisepizza.com';
                        $subject = "SlowRisePizza - Discount Codes Used";
                        $message = "
                        <html>
                        <head>
                        <title>SlowRisePizza - Discount Codes Used</title>
                        </head>
                        <body>
                        <p>Dear Noel,</p>
                        <p>All discount codes have been used or there exists no discount code.</p>
                        <p>Thanks</p>
                        </body>
                        </html>
                        ";

                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= 'From: <info@slowrisepizza.com>' . "\r\n";

                        mail($to,$subject,$message,$headers);
                    }
                }
                //End - Discount Codes
                //
            }
        }
    }
}