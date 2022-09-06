<?php
//ALTER TABLE `wphs_pmpro_group_discount_codes` ADD `is_used` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `order_id`; 

include('../wp-load.php');
define('WP_USE_THEMES', false);
global $wpdb;

$emails = array('waqas@gmail.com', 'shahid@gmail.com', 'hamza@gmail.com', 'faisal@gmail.com');

foreach ($emails as $key => $email) {
	$discount_codes = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pmpro_group_discount_codes WHERE is_used = '0'", OBJECT );
	foreach ($discount_codes as $key1 => $discount_code) {
		echo $discount_code->code.'-';
		echo $discount_code->id.'-';

		$wpdb->update( 
		    "{$wpdb->prefix}pmpro_group_discount_codes", 
		    array( 
		        'is_used' => '1', 
		    ), 
		    array( 'id' => $discount_code->id ),  
		);

		if($key1 == 0){
			break;
		}
	}
}