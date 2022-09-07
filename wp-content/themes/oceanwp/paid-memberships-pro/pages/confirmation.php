<?php session_start();?>
<div class="<?php echo pmpro_get_element_class( 'pmpro_confirmation_wrap' ); ?>">
<?php
	global $table_prefix, $wpdb, $current_user, $pmpro_invoice, $pmpro_msg, $pmpro_msgt;

	if($pmpro_msg)
	{
	?>
		<div class="<?php echo pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ); ?>"><?php echo wp_kses_post( $pmpro_msg );?></div>
	<?php
	}

	if(empty($current_user->membership_level))
		$confirmation_message = "<p>" . __('Your payment has been submitted. Your membership will be activated shortly.', 'paid-memberships-pro' ) . "</p>";
	else
		$confirmation_message = "<p>" . sprintf(__('Thank you for your membership to %s. Your %s membership is now active.', 'paid-memberships-pro' ), get_bloginfo("name"), $current_user->membership_level->name) . "</p>";

	//confirmation message for this level
	$level_message = $wpdb->get_var("SELECT l.confirmation FROM $wpdb->pmpro_membership_levels l LEFT JOIN $wpdb->pmpro_memberships_users mu ON l.id = mu.membership_id WHERE mu.status = 'active' AND mu.user_id = '" . $current_user->ID . "' LIMIT 1");
	if(!empty($level_message))
		$confirmation_message .= "\n" . stripslashes($level_message) . "\n";
?>

<?php if(!empty($pmpro_invoice) && !empty($pmpro_invoice->id)) { ?>

	<?php
		$pmpro_invoice->getUser();
		$pmpro_invoice->getMembershipLevel();

		$confirmation_message .= "<p>" . sprintf(__('Below are details about your membership account and a receipt for your initial membership invoice. A welcome email with a copy of your initial membership invoice has been sent to %s.', 'paid-memberships-pro' ), $pmpro_invoice->user->user_email) . "</p>";

		// Check instructions
		if ( $pmpro_invoice->gateway == "check" && ! pmpro_isLevelFree( $pmpro_invoice->membership_level ) ) {
			$confirmation_message .= '<div class="' . pmpro_get_element_class( 'pmpro_payment_instructions' ) . '">' . wpautop( wp_unslash( pmpro_getOption("instructions") ) ) . '</div>';
		}

		/**
		 * All devs to filter the confirmation message.
		 * We also have a function in includes/filters.php that applies the the_content filters to this message.
		 * @param string $confirmation_message The confirmation message.
		 * @param object $pmpro_invoice The PMPro Invoice/Order object.
		 */
		$confirmation_message = apply_filters("pmpro_confirmation_message", $confirmation_message, $pmpro_invoice);

		echo wp_kses_post( $confirmation_message );
	?>
	<h3>
		<?php printf(__('Invoice #%s on %s', 'paid-memberships-pro' ), $pmpro_invoice->code, date_i18n(get_option('date_format'), $pmpro_invoice->timestamp));?>
	</h3>
	<a class="<?php echo pmpro_get_element_class( 'pmpro_a-print' ); ?>" href="javascript:window.print()"><?php _e('Print', 'paid-memberships-pro' );?></a>
	<ul>
		<?php do_action("pmpro_invoice_bullets_top", $pmpro_invoice); ?>
		<li><strong><?php _e('Account', 'paid-memberships-pro' );?>:</strong> <?php echo esc_html( $current_user->display_name );?> (<?php echo esc_html( $current_user->user_email );?>)</li>
		<li><strong><?php _e('Membership Level', 'paid-memberships-pro' );?>:</strong> <?php echo esc_html( $current_user->membership_level->name);?></li>
		<?php if($current_user->membership_level->enddate) { ?>
			<li><strong><?php _e('Membership Expires', 'paid-memberships-pro' );?>:</strong> <?php echo date_i18n(get_option('date_format'), $current_user->membership_level->enddate)?></li>
		<?php } ?>
		<?php if($pmpro_invoice->getDiscountCode()) { ?>
			<li><strong><?php _e('Discount Code', 'paid-memberships-pro' );?>:</strong> <?php echo esc_html( $pmpro_invoice->discount_code->code );?></li>
		<?php } ?>
		<?php do_action("pmpro_invoice_bullets_bottom", $pmpro_invoice); ?>
	</ul>
	<hr />
	<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice_details' ); ?>">
		<?php if(!empty($pmpro_invoice->billing->name)) { ?>
			<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice-billing-address' ); ?>">
				<strong><?php _e('Billing Address', 'paid-memberships-pro' );?></strong>
				<p><?php echo esc_html( $pmpro_invoice->billing->name );?><br />
				<?php echo esc_html( $pmpro_invoice->billing->street );?><br />
				<?php if($pmpro_invoice->billing->city && $pmpro_invoice->billing->state) { ?>
					<?php echo esc_html( $pmpro_invoice->billing->city );?>, <?php echo esc_html( $pmpro_invoice->billing->state );?> <?php echo esc_html( $pmpro_invoice->billing->zip );?> <?php echo esc_html( $pmpro_invoice->billing->country );?><br />
				<?php } ?>
				<?php echo formatPhone($pmpro_invoice->billing->phone)?>
				</p>
			</div> <!-- end pmpro_invoice-billing-address -->
		<?php } ?>

		<?php if ( ! empty( $pmpro_invoice->accountnumber ) || ! empty( $pmpro_invoice->payment_type ) ) { ?>
			<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice-payment-method' ); ?>">
				<strong><?php _e('Payment Method', 'paid-memberships-pro' );?></strong>
				<?php if($pmpro_invoice->accountnumber) { ?>
					<p><?php echo esc_html( ucwords( $pmpro_invoice->cardtype ) ); ?> <?php _e('ending in', 'paid-memberships-pro' );?> <?php echo esc_html( last4($pmpro_invoice->accountnumber ) );?></p>
					<p><?php _e('Expiration', 'paid-memberships-pro' );?>: <?php echo esc_html( $pmpro_invoice->expirationmonth );?>/<?php echo esc_html( $pmpro_invoice->expirationyear );?></p>
				<?php } else { ?>
					<p><?php echo esc_html( $pmpro_invoice->payment_type ); ?></p>
				<?php } ?>
			</div> <!-- end pmpro_invoice-payment-method -->
		<?php } ?>

		<div class="<?php echo pmpro_get_element_class( 'pmpro_invoice-total' ); ?>">
			<strong><?php _e('Total Billed', 'paid-memberships-pro' );?></strong>
			<p><?php if($pmpro_invoice->total != '0.00') { ?>
				<?php if(!empty($pmpro_invoice->tax)) { ?>
					<?php _e('Subtotal', 'paid-memberships-pro' );?>: <?php echo pmpro_formatPrice($pmpro_invoice->subtotal);?><br />
					<?php _e('Tax', 'paid-memberships-pro' );?>: <?php echo pmpro_formatPrice($pmpro_invoice->tax);?><br />
					<?php if(!empty($pmpro_invoice->couponamount)) { ?>
						<?php _e('Coupon', 'paid-memberships-pro' );?>: (<?php echo pmpro_formatPrice($pmpro_invoice->couponamount);?>)<br />
					<?php } ?>
					<strong><?php _e('Total', 'paid-memberships-pro' );?>: <?php echo pmpro_formatPrice($pmpro_invoice->total);?></strong>
				<?php } else { ?>
					<?php echo pmpro_formatPrice($pmpro_invoice->total);?>
				<?php } ?>
			<?php } else { ?>
				<small class="<?php echo pmpro_get_element_class( 'pmpro_grey' ); ?>"><?php echo esc_html( pmpro_formatPrice(0) );?></small>
			<?php } ?></p>
			<span style="display:none;" id="transection_amount"> <?php echo $pmpro_invoice->total;?> </span>
			<span style="display:none;" id="transection_id"> <?php echo $pmpro_invoice->id;?> </span>
			<input type="hidden" id="invoice_final_id" value="<?php echo $pmpro_invoice->id;?>">
			<input type="hidden" id="invoice_final_total" value="<?php echo pmpro_formatPrice($pmpro_invoice->total);?>">
		</div> <!-- end pmpro_invoice-total -->

	</div> <!-- end pmpro_invoice -->
	<hr />
<?php
	}
	else
	{
		$confirmation_message .= "<p>" . sprintf(__('Below are details about your membership account. A welcome email has been sent to %s.', 'paid-memberships-pro' ), $current_user->user_email) . "</p>";

		/**
		 * All devs to filter the confirmation message.
		 * Documented above.
		 * We also have a function in includes/filters.php that applies the the_content filters to this message.
		 */
		$confirmation_message = apply_filters("pmpro_confirmation_message", $confirmation_message, false);

		echo wp_kses_post( $confirmation_message );
	?>
	<ul>
		
		<?php
		
		$tblname = 'pmpro_membership_orders';
		$tbl2name = 'pmpro_discount_codes_uses';
		$tbl3name = 'pmpro_discount_codes';
        $wp_track_table = $table_prefix . "$tblname ";
        $wp_track_table2 = $table_prefix . "$tbl2name ";
        $wp_track_table3 = $table_prefix . "$tbl3name ";
		
        // get order id
		$order_id = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM {$wp_track_table} WHERE user_id = '$current_user->id' ORDER BY id desc "), ARRAY_A );
        $o_id = $order_id[0]["id"];
		
		// get order total amount after discount  
		$order_total = $wpdb->get_results( $wpdb->prepare( "SELECT total FROM {$wp_track_table} WHERE id = '$o_id' "), ARRAY_A );
		
		// get coupon code id
		$discount_code_id = $wpdb->get_results( $wpdb->prepare( "SELECT code_id FROM {$wp_track_table2} WHERE order_id = '$o_id' "), ARRAY_A );
		if($discount_code_id){
			$code_id = $discount_code_id[0]['code_id'];
			
			// if code exists then get discount code
			$discount_code = $wpdb->get_results( $wpdb->prepare( "SELECT code FROM {$wp_track_table3} WHERE id = '$code_id' "), ARRAY_A );

		}
		?>		
		<?php
		if ($order_id[0]["id"]){
		?>
		<li><strong><?php _e('Transaction# ', 'paid-memberships-pro' );?>:</strong><span id="transection_id"><?php echo $order_id[0]["id"]; ?></span></li>
		<?php	
		}
		?>
		
		<?php
		if ($discount_code){
		?>
		<li><strong><?php _e('Discount Code ', 'paid-memberships-pro' );?>:</strong><span id="discount_code"> <?php echo $discount_code[0]["code"]; ?> </span></li>
		<?php	
		}
		?>
		
		
		<li><strong><?php _e('Order Total# ', 'paid-memberships-pro' );?>:</strong><span id="transection_amount"> <?php echo $order_total[0]["total"]; ?> </span></li>
		
		
		
		
		<li><strong><?php _e('Account', 'paid-memberships-pro' );?>:</strong> <?php echo esc_html( $current_user->display_name );?> (<?php echo esc_html( $current_user->user_email );?>)</li>
		<li><strong><?php _e('Membership Level', 'paid-memberships-pro' );?>:</strong> <?php if(!empty($current_user->membership_level)) echo esc_html( $current_user->membership_level->name ); else _e("Pending", 'paid-memberships-pro' );?></li>
	</ul>
	<input type="hidden" id="invoice_final_id" value="<?php echo $order_id[0]['id']; ?>">
	<input type="hidden" id="invoice_final_total" value="<?php echo $order_total[0]['total']; ?>">
<?php
	}
?>
<p class="<?php echo pmpro_get_element_class( 'pmpro_actions_nav' ); ?>">
	<?php if ( ! empty( $current_user->membership_level ) ) { ?>
		<a href="<?php echo pmpro_url( 'account' ); ?>" class="btn-white"><?php _e( 'View Your Membership Account &rarr;', 'paid-memberships-pro' ); ?></a>
	<?php } else { ?>
		<?php _e( 'If your account is not activated within a few minutes, please contact the site owner.', 'paid-memberships-pro' ); ?>
	<?php } ?>
</p> <!-- end pmpro_actions_nav -->
</div> <!-- end pmpro_confirmation_wrap -->
