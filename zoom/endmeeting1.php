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

$id = '95650911620';
$start_time = date('Y-m-d', strtotime('2020-12-11T00:32:46Z'));
$start_time_minus_one = date('Y-m-d', strtotime('-1 day', strtotime('2020-12-11T00:32:46Z')));
$end_time = date('Y-m-d', strtotime('2020-12-11T03:54:37Z'));

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

        $access_token = $result_3['access_token'];
        $endpoint   = '/v2/report/webinars/'.$id.'/participants';
        
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
		//print_r($unique_participants);die();
        foreach ($unique_participants as $key => $participant) {
			
			
			/*********** Adding user in master list as well VOD **************/
			
			$merge_fields2 = array(
				"FNAME" => "Faisal",
				"LNAME" => "Saleem",
			);
			$email = "devone@yahoo.com";
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
			
			
            //$to = $participant['user_email'];

            //$is_user = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}zoom_test WHERE webinar_id = ".$id." AND user_email = '$to' AND (start_time = '$today' OR start_time = '$start_time' OR start_time = '$start_time_minus_one') ", OBJECT );
            
            /*if ( !$is_user ) {

                $wpdb->insert($wpdb->prefix.'zoom_test', array(
                    'webinar_id' => 95650911620, 
                    'webinar_title' => 'Test', 
                    'user_email' => $to,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ));
            }*/
        }
        