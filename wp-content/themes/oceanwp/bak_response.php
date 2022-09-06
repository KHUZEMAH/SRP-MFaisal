<?php /* Template Name: Paypal Response */

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

get_header(); 

?>
<style>
.page-template-response #main{
    color: #D1CCCC;
	font-size:18px;
}
.page-template-response{
    background-color: #000;
}
.thank-you-wrap{
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
    border: 1px solid #272c33;
}
.fa-check {
    display: inline-block;
    float: none;
    font-size: 45px;
    color: #02b319;
    margin-bottom: 20px;
}

.thank-you-wrap .fa-check {
    display: inline-block;
    float: none;
    font-size: 45px;
    color: #02b319;
    margin-bottom: 20px;
}

.mb-30 {
    margin-bottom: 30px;
}

.thank-you-wrap h1 {
    margin-bottom: 15px;
}

.thank-you-wrap p {
    text-align: center;
    margin-bottom: 20px;
    line-height: 30px;
}


.thank-you-wrap .table tr td {
    padding: 7px 15px;
    border-bottom: 1px solid #272c33;
}
.thank-you-wrap .table tr th{
    padding: 7px 15px;
    text-transform: capitalize;
    border-bottom: 2px solid #272c33;
}
.text-right{
    text-align:right;
}
.transcation-info{
    padding:30px 0;
}
.transcation-info span{
    display:block;
    padding-bottom: 5px;
    margin-bottom: 5px;
    border-bottom: 1px dashed #272c33;
}

@media screen and (max-width: 767px) {
    .thank-you-wrap {
        width: 100%;
    }
}
    </style>
</style>

    <div id="content-wrap" class="container">
        <?php
          $gift_to_name    = $_SESSION['gift_card_data']['gift_to_name'];
          $gift_to_email   = $_SESSION['gift_card_data']['gift_to_email'];
          $gift_from_name  = $_SESSION['gift_card_data']['gift_from_name'];
          $gift_from_email = $_SESSION['gift_card_data']['gift_from_email'];
          $gift_message    = $_SESSION['gift_card_data']['gift_message'];
          $final_amount    = $_SESSION['gift_card_data']['final_value'];
          $level           = $_SESSION['gift_card_data']['level'];
          $level_name      = $_SESSION['gift_card_data']['level_name'];
          $payment_id      = $_SESSION['gift_card_data']['payment_id'];
          $invoice_number  = $_SESSION['gift_card_data']['invoice_number'];
          $zero_amount     = $_SESSION['gift_card_data']['zero_amount'];

          use PayPal\Api\Payment;
          use PayPal\Api\PaymentExecution;

          use PayPal\Rest\ApiContext;
          use PayPal\Auth\OAuthTokenCredential;

          require ABSPATH.'vendor/autoload.php';

          if( $zero_amount == 'N' )
          {

            $enableSandbox = false;

            $paypalConfig = [
                'client_id' => PAYPAL_CLIENT_ID,
                'client_secret' => PAYPAL_CLIENT_SECRET,
                'return_url' => esc_url( get_permalink( get_page_by_title( 'Response' ) ) ),
                'cancel_url' => esc_url( get_permalink( get_page_by_title( 'Response' ) ) )
            ];

            function getApiContext($clientId, $clientSecret, $enableSandbox = false)
            {
                $apiContext = new ApiContext(
                    new OAuthTokenCredential($clientId, $clientSecret)
                );

                $apiContext->setConfig([
                    'mode' => $enableSandbox ? 'sandbox' : 'live'
                ]);

                return $apiContext;
            }

            $apiContext = getApiContext($paypalConfig['client_id'], $paypalConfig['client_secret'], $enableSandbox);

            if (empty($_GET['paymentId']) || empty($_GET['PayerID'])) {
                throw new Exception('The response is missing the paymentId and PayerID');
            }

            $paymentId = $_GET['paymentId'];
            $payment = Payment::get($paymentId, $apiContext);

            $execution = new PaymentExecution();
            $execution->setPayerId($_GET['PayerID']);

            try {
                // Take the payment
                $payment->execute($execution, $apiContext);

                try {

                    $payment = Payment::get($paymentId, $apiContext);

                    $data = [
                        'transaction_id' => $payment->getId(),
                        'payment_amount' => $payment->transactions[0]->amount->total,
                        'payment_status' => $payment->getState(),
                        'invoice_id' => $payment->transactions[0]->invoice_number
                    ];
                    if ($data['payment_status'] === 'approved') {

                        global $wpdb;
                        $discount_code  = bin2hex(random_bytes(12));

                        ///////////////////////////////////

                        $starts_date  = date("Y-m-d");
                        $expires_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($starts_date)) . " + 365 day"));

                        $table_1 = $wpdb->prefix.'pmpro_discount_codes';
                        $data_1 = array(
                             'code'     => $discount_code,
                             'starts'   => date('Y-m-d',strtotime("-1 days")),
                             'expires'  => $expires_date,
                             'uses'     => 1
                           );
                        $wpdb->insert($table_1,$data_1);
                        $discount_code_id = $wpdb->insert_id;

                        ///////////////////////////////////

                        if($discount_code_id){
                          $table_2 = $wpdb->prefix.'pmpro_discount_codes_levels';
                          $data_2 = array(
                               'code_id'            => $discount_code_id,
                               'level_id'           => $level,
                               'expiration_number'  => 30,
                               'expiration_period'  => 'Day'
                             );
                          $wpdb->insert($table_2,$data_2);
                          $discount_code_level_id = $wpdb->insert_id;
                        }

                        ///////////////////////////////////

                        $post       = array(
                          'post_title'      =>  $discount_code,
                          'post_status'     =>  'publish',
                          'post_type'       =>  'giftcard'
                        );
                        $post_id = wp_insert_post($post);

                        if ( $post_id ) {
                           add_post_meta($post_id, 'gift_to_name', $gift_to_name);                          
                           add_post_meta($post_id, 'gift_to_email', $gift_to_email);                          
                           add_post_meta($post_id, 'gift_from_name', $gift_from_name);                          
                           add_post_meta($post_id, 'gift_from_email', $gift_from_email);                          
                           add_post_meta($post_id, 'gift_message', $gift_message);                          
                           add_post_meta($post_id, 'final_amount', $final_amount);                          
                           add_post_meta($post_id, 'payment_status', 'Complete');                          
                           add_post_meta($post_id, 'level_id', $level);                          
                           add_post_meta($post_id, 'payment_id', $payment_id);                          
                           add_post_meta($post_id, 'invoice_number', $invoice_number);                          
                           add_post_meta($post_id, 'discount_code', $discount_code);                          
                        }

                        if($post_id){

                          $access_url = '<a href="'.get_permalink(1850).'?level='.$level.'&c='.$discount_code.'"><b>'.$discount_code.'</b></a>';

                        //Send Email to receiver
                        $user_template_data = get_option('gift_card_user_email_temp');
                        $user_template  = $user_template_data[1];
                        $user_template_vars = ["!!to_name!!", "!!from_name!!", "!!level_name!!", "!!gift_messsage!!", "!!access_url!!", "!!to_email!!", "!!transaction_amount!!", "!!invoice_number!!", "!!from_email!!", "!!discount_code!!"];
                        $user_dynamic_vars   = [$gift_to_name, $gift_from_name, $level_name, $gift_message, $access_url, $gift_to_email, $final_amount, $invoice_number, $gift_from_email, $discount_code];
                        $user_parsed_template = str_replace($user_template_vars, $user_dynamic_vars, $user_template);

                          $to = $gift_to_email;
                          $subject = $user_template_data[0];

                          $body = $user_parsed_template;

                          /*$body  =  'Hi '.$gift_to_name.'!';
                          $body .=  '<br><br>';
                          $body .=  'You have received a 100% off gift voucher from <b>'.$gift_from_name.'</b>. Take advantage of this generous offer of <b>'.$level_name.'</b> and attend it for free!</b>';
                          $body .=  '<br><br>';
                          $body .=  'P.S. here’s a message from your loved one, just for you!';
                          $body .=  '<br>';
                          $body .=  $gift_message;
                          $body .=  '<br><br>';
                          $body .=  'So let’s slap out some skins! Just click on the discount code below:';
                          $body .=  '<br>';
                          $body .=  '<a href="'.get_permalink(1850).'?level='.$level.'&c='.$discount_code.'"><b>'.$discount_code.'</b></a>';
                          $body .=  '<br><br>';
                          $body .=  'Happy pizza making!';
                          $body .=  '<br><br>';
                          $body .=  'Team Slow Rise Pizza Co.';*/
                          
                          $headers = "MIME-Version: 1.0" . "\r\n";
                          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          $headers .= 'From: <classes@slowrisepizza.com>' . "\r\n";

                          //echo $body;
                          mail($to,$subject,$body,$headers);

                        //Send Email to sender
                        $admin_template_data = get_option('gift_card_admin_email_temp');
                        $admin_template  = $admin_template_data[1];
                        $admin_template_vars = ["!!to_name!!", "!!from_name!!", "!!level_name!!", "!!gift_messsage!!", "!!access_url!!", "!!to_email!!", "!!transaction_amount!!", "!!invoice_number!!", "!!from_email!!", "!!discount_code!!"];
                        $admin_dynamic_vars   = [$gift_to_name, $gift_from_name, $level_name, $gift_message, $access_url, $gift_to_email, $final_amount, $invoice_number, $gift_from_email, $discount_code];
                        $admin_parsed_template = str_replace($admin_template_vars, $admin_dynamic_vars, $admin_template);

                          $to_1 = $gift_from_email;
                          $subject_1 = $admin_template_data[0];
                          $body_1 = $admin_parsed_template;
                          
                          /*$body_1  =  'Thank you <b>'.$gift_from_name.'</b> for purchasing the 100% off gift certificate for <b>'.$level_name.'</b>.';
                          $body_1 .=  '<br><br>';
                          $body_1 .=  'Your transaction summary has been sent to <b>'.$gift_to_email.'</b>.';
                          $body_1 .=  '<br><br>';  
                          $body_1 .=  'Transaction Summary:<br><br>';
                          $body_1 .=  '<b>Class:</b> '.$level_name.'<br>';
                          $body_1 .=  '<b>Price:</b> '.$final_amount.'<br>';
                          $body_1 .=  '<b>Transaction ID:</b> '.$invoice_number.'<br>';
                          $body_1 .=  '<br><br>'; 
                          $body_1 .=  '<b>Send to:</b> '.$gift_to_name.'<br>';
                          $body_1 .=  '<b>Send to Email:</b> '.$gift_to_email.'<br>';
                          $body_1 .=  '<b>Send From:</b> '.$gift_from_name.'<br>';
                          $body_1 .=  '<b>Send From Email:</b> '.$gift_from_email.'<br>';
                          $body_1 .=  '<b>Message:</b> '.$gift_message.'<br>';
                          $body_1 .=  '<br>'; 
                          $body_1 .=  'The following gift code has been sent to <b>'.$gift_to_email.'</b>:';
                          $body_1 .=  '<br><br>';
                          $body_1 .=  $discount_code;
                          $body_1 .=  '<br><br>';  
                          $body_1 .=  'Happy pizza making!';
                          $body_1 .=  '<br>';                         
                          $body_1 .=  'Team Slow Rise Pizza Co';*/
                          
                          $headers_1 = "MIME-Version: 1.0" . "\r\n";
                          $headers_1 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          $headers_1 .= 'From: <classes@slowrisepizza.com>' . "\r\n";

                          //echo $body_1;
                          mail($to_1,$subject_1,$body_1,$headers_1);


                          //Send Email to super admin
                        $super_admin_template_data = get_option('gift_card_super_admin_email_temp');
                        $super_admin_template  = $super_admin_template_data[1];
                        $super_admin_template_vars = ["!!to_name!!", "!!from_name!!", "!!level_name!!", "!!gift_messsage!!", "!!access_url!!", "!!to_email!!", "!!transaction_amount!!", "!!invoice_number!!", "!!from_email!!", "!!discount_code!!"];
                        $super_admin_dynamic_vars   = [$gift_to_name, $gift_from_name, $level_name, $gift_message, $access_url, $gift_to_email, $final_amount, $invoice_number, $gift_from_email, $discount_code];
                        $super_admin_parsed_template = str_replace($super_admin_template_vars, $super_admin_dynamic_vars, $super_admin_template);


                          $to_2 = 'noel@slowrisepizza.com';
                          $subject_2 = $super_admin_template_data[0];
                          $body_2 = $super_admin_parsed_template;
                          /*$body_2  =  'Dear Noel,';
                          $body_2 .=  '<br><br>';
                          $body_2 .=  'A 100% off gift certificate has been purchased by <b>'.$gift_from_name.'</b> for <b>'.$level_name.'</b>.';
                          $body_2 .=  '<br><br>';
                          $body_2 .=  '<b>Transaction Summary:</b>';
                          $body_2 .=  '<br><br>';  
                          $body_2 .=  '<b>Class:</b> '.$level_name.'<br>';
                          $body_2 .=  '<b>Price:</b> '.$final_amount.'<br>';
                          $body_2 .=  '<b>Transaction ID:</b> '.$invoice_number.'<br>';
                          $body_2 .=  '<b>Send to:</b> '.$gift_to_name.'<br>';
                          $body_2 .=  '<b>Send to Email:</b> '.$gift_to_email.'<br>';
                          $body_2 .=  '<b>Send From:</b> '.$gift_from_name.'<br>';
                          $body_2 .=  '<b>Send From Email:</b> '.$gift_from_email.'<br>';
                          $body_2 .=  '<b>Message:</b> '.$gift_message.'<br>';
                          $body_2 .=  '<br>'; 
                          $body_2 .=  'The following gift code has been sent to <b>'.$gift_to_email.'</b>:';
                          $body_2 .=  '<br><br>';
                          $body_2 .=  $discount_code;
                          $body_2 .=  '<br><br>';  
                          $body_2 .=  'Kind regards,';
                          $body_2 .=  '<br>';                         
                          $body_2 .=  'Team Slow Rise Pizza Co';*/
                          
                          $headers_2 = "MIME-Version: 1.0" . "\r\n";
                          $headers_2 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          $headers_2 .= 'From: <classes@slowrisepizza.com>' . "\r\n";

                          //echo $body_2;
                          mail($to_2,$subject_2,$body_2,$headers_2);


                          ?>
                            <script type="text/javascript">
                              dataLayer.push({
                                'event': 'GiftPizzaClassConfirmationClick',
                                'ecommerce': {
                                  'purchase': {
                                    'actionField': {
                                      'id': '<?php echo $invoice_number; ?>',
                                      'revenue': '<?php echo $final_amount; ?>' 
                                    },
                                    'products': [{                            
                                      'name': '<?php echo $level_name; ?>',              
                                      'id': '<?php echo $level; ?>',
                                      'price': '<?php echo $final_amount; ?>',
                                      'quantity': 1
                                    }]
                                  }
                                }
                              }); 
                            </script>
                          <?php
                        }
                        
                        ?>
                        <div class="thank-you-wrap">
                          <?php  $content = "<div class='text-center'><p><i class='fa fa-check'></i></p>
                          <p>Thank you <b>".$gift_from_name."</b> for purchasing the 100% off gift certificate for  <b>".$level_name."</b>.</p>
                           </div>
                           <div class='transcation-info'>
                            <span><b>Transaction ID:</b> ".$invoice_number."</span>
                            <span><b>Class:</b> ".$level_name."</span>
                            <span><b>Send to:</b> ".$gift_to_name." </span>
                            <span><b>Send to Email:</b> ".$gift_to_email."</span>
                            <span><b>Send From:</b> ".$gift_from_name."</span>
                            <span><b>Send From Email:</b> ".$gift_from_email."</span>
                            <span><b>Price:</b> ".$final_amount."</span>
                            <span><b>Message:</b>  ".$gift_message."</span>
                           
                            </div>
                               <div class='text-center'>
                               <a href='".get_site_url()."' class='btn-white'><i class='fa fa-home'></i>&nbsp;Go to Home page&nbsp;<i class='fa  fa-angle-double-right'></i></a>
                               </div>
                                
                            </div>";
                              echo $content;
                            ?>
                        </div>
                        <?php 
                        unset($_SESSION['gift_card_data']);
                        //header('location:payment-successful.html');
                        exit(1);
                    } else {
                        // Payment failed

                    }

                } catch (Exception $e) {
                    // Failed to retrieve payment from PayPal

                }

            } catch (Exception $e) {
                // Failed to take payment

            }
          }else{

            global $wpdb;
            $discount_code  = bin2hex(random_bytes(12));

            ///////////////////////////////////

            $starts_date  = date("Y-m-d");
            $expires_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($starts_date)) . " + 365 day"));

            $table_1 = $wpdb->prefix.'pmpro_discount_codes';
            $data_1 = array(
                 'code'     => $discount_code,
                 'starts'   => date('Y-m-d',strtotime("-1 days")),
                 'expires'  => $expires_date,
                 'uses'     => 1
               );
            $wpdb->insert($table_1,$data_1);
            $discount_code_id = $wpdb->insert_id;

            ///////////////////////////////////

            if($discount_code_id){
              $table_2 = $wpdb->prefix.'pmpro_discount_codes_levels';
              $data_2 = array(
                   'code_id'            => $discount_code_id,
                   'level_id'           => $level,
                   'expiration_number'  => 30,
                   'expiration_period'  => 'Day'
                 );
              $wpdb->insert($table_2,$data_2);
              $discount_code_level_id = $wpdb->insert_id;
            }

            ///////////////////////////////////

            $post       = array(
              'post_title'      =>  $discount_code,
              'post_status'     =>  'publish',
              'post_type'       =>  'giftcard'
            );
            $post_id = wp_insert_post($post);

            if ( $post_id ) {
               add_post_meta($post_id, 'gift_to_name', $gift_to_name);                          
               add_post_meta($post_id, 'gift_to_email', $gift_to_email);                          
               add_post_meta($post_id, 'gift_from_name', $gift_from_name);                          
               add_post_meta($post_id, 'gift_from_email', $gift_from_email);                          
               add_post_meta($post_id, 'gift_message', $gift_message);                          
               add_post_meta($post_id, 'final_amount', $final_amount);                          
               add_post_meta($post_id, 'payment_status', 'Complete');                          
               add_post_meta($post_id, 'level_id', $level);                          
               add_post_meta($post_id, 'payment_id', $payment_id);                          
               add_post_meta($post_id, 'invoice_number', $invoice_number);                          
               add_post_meta($post_id, 'discount_code', $discount_code);                          
            }

            if($post_id){

              $access_url = '<a href="'.get_permalink(1850).'?level='.$level.'&c='.$discount_code.'"><b>'.$discount_code.'</b></a>';

                        //Send Email to receiver
                        $user_template_data = get_option('gift_card_user_email_temp');
                        $user_template  = $user_template_data[1];
                        $user_template_vars = ["!!to_name!!", "!!from_name!!", "!!level_name!!", "!!gift_messsage!!", "!!access_url!!", "!!to_email!!", "!!transaction_amount!!", "!!invoice_number!!", "!!from_email!!", "!!discount_code!!"];
                        $user_dynamic_vars   = [$gift_to_name, $gift_from_name, $level_name, $gift_message, $access_url, $gift_to_email, $final_amount, $invoice_number, $gift_from_email, $discount_code];
                        $user_parsed_template = str_replace($user_template_vars, $user_dynamic_vars, $user_template);

                          $to = $gift_to_email;
                          $subject = $user_template_data[0];

                          $body = $user_parsed_template;

                          /*$body  =  'Hi '.$gift_to_name.'!';
                          $body .=  '<br><br>';
                          $body .=  'You have received a 100% off gift voucher from <b>'.$gift_from_name.'</b>. Take advantage of this generous offer of <b>'.$level_name.'</b> and attend it for free!</b>';
                          $body .=  '<br><br>';
                          $body .=  'P.S. here’s a message from your loved one, just for you!';
                          $body .=  '<br>';
                          $body .=  $gift_message;
                          $body .=  '<br><br>';
                          $body .=  'So let’s slap out some skins! Just click on the discount code below:';
                          $body .=  '<br>';
                          $body .=  '<a href="'.get_permalink(1850).'?level='.$level.'&c='.$discount_code.'"><b>'.$discount_code.'</b></a>';
                          $body .=  '<br><br>';
                          $body .=  'Happy pizza making!';
                          $body .=  '<br><br>';
                          $body .=  'Team Slow Rise Pizza Co.';*/
                          
                          $headers = "MIME-Version: 1.0" . "\r\n";
                          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          $headers .= 'From: <classes@slowrisepizza.com>' . "\r\n";

                          //echo $body;
                          mail($to,$subject,$body,$headers);

                        //Send Email to sender
                        $admin_template_data = get_option('gift_card_admin_email_temp');
                        $admin_template  = $admin_template_data[1];
                        $admin_template_vars = ["!!to_name!!", "!!from_name!!", "!!level_name!!", "!!gift_messsage!!", "!!access_url!!", "!!to_email!!", "!!transaction_amount!!", "!!invoice_number!!", "!!from_email!!", "!!discount_code!!"];
                        $admin_dynamic_vars   = [$gift_to_name, $gift_from_name, $level_name, $gift_message, $access_url, $gift_to_email, $final_amount, $invoice_number, $gift_from_email, $discount_code];
                        $admin_parsed_template = str_replace($admin_template_vars, $admin_dynamic_vars, $admin_template);

                          $to_1 = $gift_from_email;
                          $subject_1 = $admin_template_data[0];
                          $body_1 = $admin_parsed_template;
                          
                          /*$body_1  =  'Thank you <b>'.$gift_from_name.'</b> for purchasing the 100% off gift certificate for <b>'.$level_name.'</b>.';
                          $body_1 .=  '<br><br>';
                          $body_1 .=  'Your transaction summary has been sent to <b>'.$gift_to_email.'</b>.';
                          $body_1 .=  '<br><br>';  
                          $body_1 .=  'Transaction Summary:<br><br>';
                          $body_1 .=  '<b>Class:</b> '.$level_name.'<br>';
                          $body_1 .=  '<b>Price:</b> '.$final_amount.'<br>';
                          $body_1 .=  '<b>Transaction ID:</b> '.$invoice_number.'<br>';
                          $body_1 .=  '<br><br>'; 
                          $body_1 .=  '<b>Send to:</b> '.$gift_to_name.'<br>';
                          $body_1 .=  '<b>Send to Email:</b> '.$gift_to_email.'<br>';
                          $body_1 .=  '<b>Send From:</b> '.$gift_from_name.'<br>';
                          $body_1 .=  '<b>Send From Email:</b> '.$gift_from_email.'<br>';
                          $body_1 .=  '<b>Message:</b> '.$gift_message.'<br>';
                          $body_1 .=  '<br>'; 
                          $body_1 .=  'The following gift code has been sent to <b>'.$gift_to_email.'</b>:';
                          $body_1 .=  '<br><br>';
                          $body_1 .=  $discount_code;
                          $body_1 .=  '<br><br>';  
                          $body_1 .=  'Happy pizza making!';
                          $body_1 .=  '<br>';                         
                          $body_1 .=  'Team Slow Rise Pizza Co';*/
                          
                          $headers_1 = "MIME-Version: 1.0" . "\r\n";
                          $headers_1 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          $headers_1 .= 'From: <classes@slowrisepizza.com>' . "\r\n";

                          //echo $body_1;
                          mail($to_1,$subject_1,$body_1,$headers_1);


                          //Send Email to super admin
                        $super_admin_template_data = get_option('gift_card_super_admin_email_temp');
                        $super_admin_template  = $super_admin_template_data[1];
                        $super_admin_template_vars = ["!!to_name!!", "!!from_name!!", "!!level_name!!", "!!gift_messsage!!", "!!access_url!!", "!!to_email!!", "!!transaction_amount!!", "!!invoice_number!!", "!!from_email!!", "!!discount_code!!"];
                        $super_admin_dynamic_vars   = [$gift_to_name, $gift_from_name, $level_name, $gift_message, $access_url, $gift_to_email, $final_amount, $invoice_number, $gift_from_email, $discount_code];
                        $super_admin_parsed_template = str_replace($super_admin_template_vars, $super_admin_dynamic_vars, $super_admin_template);


                          $to_2 = 'noel@slowrisepizza.com';
                          $subject_2 = $super_admin_template_data[0];
                          $body_2 = $super_admin_parsed_template;
                          /*$body_2  =  'Dear Noel,';
                          $body_2 .=  '<br><br>';
                          $body_2 .=  'A 100% off gift certificate has been purchased by <b>'.$gift_from_name.'</b> for <b>'.$level_name.'</b>.';
                          $body_2 .=  '<br><br>';
                          $body_2 .=  '<b>Transaction Summary:</b>';
                          $body_2 .=  '<br><br>';  
                          $body_2 .=  '<b>Class:</b> '.$level_name.'<br>';
                          $body_2 .=  '<b>Price:</b> '.$final_amount.'<br>';
                          $body_2 .=  '<b>Transaction ID:</b> '.$invoice_number.'<br>';
                          $body_2 .=  '<b>Send to:</b> '.$gift_to_name.'<br>';
                          $body_2 .=  '<b>Send to Email:</b> '.$gift_to_email.'<br>';
                          $body_2 .=  '<b>Send From:</b> '.$gift_from_name.'<br>';
                          $body_2 .=  '<b>Send From Email:</b> '.$gift_from_email.'<br>';
                          $body_2 .=  '<b>Message:</b> '.$gift_message.'<br>';
                          $body_2 .=  '<br>'; 
                          $body_2 .=  'The following gift code has been sent to <b>'.$gift_to_email.'</b>:';
                          $body_2 .=  '<br><br>';
                          $body_2 .=  $discount_code;
                          $body_2 .=  '<br><br>';  
                          $body_2 .=  'Kind regards,';
                          $body_2 .=  '<br>';                         
                          $body_2 .=  'Team Slow Rise Pizza Co';*/
                          
                          $headers_2 = "MIME-Version: 1.0" . "\r\n";
                          $headers_2 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                          $headers_2 .= 'From: <classes@slowrisepizza.com>' . "\r\n";

                          //echo $body_2;
                          mail($to_2,$subject_2,$body_2,$headers_2);


              ?>
                <script type="text/javascript">
                  dataLayer.push({
                    'event': 'GiftPizzaClassConfirmationClick',
                    'ecommerce': {
                      'purchase': {
                        'actionField': {
                          'id': '<?php echo $invoice_number; ?>',
                          'revenue': '<?php echo $final_amount; ?>' 
                        },
                        'products': [{                            
                          'name': '<?php echo $level_name; ?>',              
                          'id': '<?php echo $level; ?>',
                          'price': '<?php echo $final_amount; ?>',
                          'quantity': 1
                        }]
                      }
                    }
                  }); 
                </script>
              <?php
            }
            
            ?>
            <div class="thank-you-wrap">
              <?php  $content = "<div class='text-center'><p><i class='fa fa-check'></i></p>
              <p>Thank you <b>".$gift_from_name."</b> for purchasing the 100% off gift certificate for  <b>".$level_name."</b>.</p>
               </div>
               <div class='transcation-info'>
                <span><b>Transaction ID:</b> ".$invoice_number."</span>
                <span><b>Class:</b> ".$level_name."</span>
                <span><b>Send to:</b> ".$gift_to_name." </span>
                <span><b>Send to Email:</b> ".$gift_to_email."</span>
                <span><b>Send From:</b> ".$gift_from_name."</span>
                <span><b>Send From Email:</b> ".$gift_from_email."</span>
                <span><b>Price:</b> ".$final_amount."</span>
                <span><b>Message:</b>  ".$gift_message."</span>
               
                </div>
                   <div class='text-center'>
                   <a href='".get_site_url()."' class='btn-white'><i class='fa fa-home'></i>&nbsp;Go to Home page&nbsp;<i class='fa  fa-angle-double-right'></i></a>
                   </div>
                    
                </div>";
                  echo $content;
                ?>
            </div>
            <?php 
            unset($_SESSION['gift_card_data']);
            //header('location:payment-successful.html');
            exit(1);
                    
          } 

        ?>
      </div>


<?php get_footer(); ?>
