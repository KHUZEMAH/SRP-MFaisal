<?php
/**
 * The template for displaying the footer.
 *
 * @package OceanWP WordPress theme
 */

?>

 </main><!-- #main -->

 <?php do_action( 'ocean_after_main' ); ?>

 <?php do_action( 'ocean_before_footer' ); ?>

 <?php
 // Elementor `footer` location.
 if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
  ?>

  <?php do_action( 'ocean_footer' ); ?>

 <?php } ?>

 <?php do_action( 'ocean_after_footer' ); ?>

</div><!-- #wrap -->

<?php do_action( 'ocean_after_wrap' ); ?>

</div><!-- #outer-wrap -->

<?php do_action( 'ocean_after_outer_wrap' ); ?>

<?php
// If is not sticky footer.
if ( ! class_exists( 'Ocean_Sticky_Footer' ) ) {
 get_template_part( 'partials/scroll-top' );
}
?>

<?php
// Search overlay style.
if ( 'overlay' === oceanwp_menu_search_style() ) {
 get_template_part( 'partials/header/search-overlay' );
}
?>

<?php
// If sidebar mobile menu style.
if ( 'sidebar' === oceanwp_mobile_menu_style() ) {

 // Mobile panel close button.
 if ( get_theme_mod( 'ocean_mobile_menu_close_btn', true ) ) {
  get_template_part( 'partials/mobile/mobile-sidr-close' );
 }
 ?>

 <?php
 // Mobile Menu (if defined).
 get_template_part( 'partials/mobile/mobile-nav' );
 ?>

 <?php
 // Mobile search form.
 if ( get_theme_mod( 'ocean_mobile_menu_search', true ) ) {
  get_template_part( 'partials/mobile/mobile-search' );
 }
}
?>

<?php
// If full screen mobile menu style.
if ( 'fullscreen' === oceanwp_mobile_menu_style() ) {
 get_template_part( 'partials/mobile/mobile-fullscreen' );
}
?>

<?php wp_footer(); ?>
<script>
    jQuery(document).ready(function(){
        jQuery('#tribe-events-events-bar-keyword').on('focus',function(){
            jQuery(this).attr('autocomplete', 'off');
        });
    });
</script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/owl.carousel.min.js"></script>

<script type="text/javascript">
 
 function validateEmail(email) {
   const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   return re.test(email);
 }

 jQuery('#subscription_submit').click(function(){
  const email = jQuery("#email").val();
  if(email == '') {
   jQuery("#msg").text('Please enter email.').show().css("backgroundColor", "#dd3333").delay(2000).hide(0);
  }else{
   if (!validateEmail(email)) {
       jQuery("#msg").text('Please enter a valid email.').show().css("backgroundColor", "#dd3333").delay(2000).hide(0);

   } else {
     var data = {
     'action': 'subscribe_mailchimp',
        'email': jQuery("#email").val(),
    };
    var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
    jQuery.post(ajaxurl, data, function (response) {
        jQuery("#msg").text("You've successfully subscribed.").show().css("backgroundColor", "#000").delay(2000).hide(0);
        jQuery("#email").val('');
    });   
   }
  }
 });

</script>
<script>

jQuery(window).scroll(function(){
  if (jQuery(window).scrollTop() >= 150) {
    jQuery('#site-header').addClass('sticky-custom');
    jQuery('body').addClass('clear_intial');
   }
   else {
    jQuery('#site-header').removeClass('sticky-custom');
    jQuery('body').removeClass('clear_intial');
   }
});

</script>
<script src="//cdn.jsdelivr.net/jquery.touchswipe/1.6.15/jquery.touchSwipe.min.js"></script>
<script>
  !function(e){var r=[],t=!1,a=!1,i={interval:250,force_process:!1},n=e(window),p=[];function o(){return e(this).is(":appeared")}function f(){return!e(this).data("_appear_triggered")}function u(){a=!1;for(var e=0,t=r.length;e<t;e++){var i=r[e].filter(o);if(i.filter(f).data("_appear_triggered",!0).trigger("appear",[i]),p[e]){var n=p[e].not(i);n.data("_appear_triggered",!1).trigger("disappear",[n])}p[e]=i}}e.expr.pseudos.appeared=e.expr.createPseudo((function(r){return function(r){var t=e(r);if(!t.is(":visible"))return!1;var a=n.scrollLeft(),i=n.scrollTop(),p=t.offset(),o=p.left,f=p.top;return f+t.height()>=i&&f-(t.data("appear-top-offset")||0)<=i+n.height()&&o+t.width()>=a&&o-(t.data("appear-left-offset")||0)<=a+n.width()}})),e.fn.extend({appear:function(r,t){return e.appear(this,t),this}}),e.extend({appear:function(n,o){var f=e.extend({},i,o||{});if(!t){var s=function(){a||(a=!0,setTimeout(u,f.interval))};e(window).scroll(s).resize(s),t=!0}f.force_process&&setTimeout(u,f.interval),function(e){r.push(e),p.push()}(n)},force_appear:function(){return!!t&&(u(),!0)}})}("undefined"!=typeof module?require("jquery"):jQuery);
</script>

<?php 
  $level1 = $wpdb->get_row("SELECT * FROM {$wpdb->pmpro_membership_levels} WHERE id = 1 ");
  $level2 = $wpdb->get_row("SELECT * FROM {$wpdb->pmpro_membership_levels} WHERE id = 2 ");
  $level3 = $wpdb->get_row("SELECT * FROM {$wpdb->pmpro_membership_levels} WHERE id = 3 ");
?>

<script type="text/javascript">
  
	jQuery(function() {
	  var lavel_desktop_viewed = 0
	  var lavel_one_viewed = 0
	  var lavel_two_viewed = 0
	  var lavel_three_viewed = 0
	jQuery('#OnDemand1').appear(function() {
      
    });
	jQuery('#OnDemand2').appear(function() {
      
    });
	jQuery('#OnDemand3').appear(function() {
      
    });
	  
	
    if(window.matchMedia("(max-width: 991px)").matches){
        // The viewport is less than 768 pixels wide
        jQuery(document).on('appear', '#OnDemand1', function() {
			if(lavel_one_viewed == 0){
				dataLayer.push({
					'event': 'OnDemandImpressions',
					'ecommerce': {
						'checkout': {
							'actionField': {'step': 1, 'list': 'On-Demand Classes'},
							'impressions': [
							{
								 'name': '<?php echo html_entity_decode($level1->name); ?>',
								 'id': '<?php echo $level1->id; ?>',		
								 'price': '<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>',						 
								 'list': 'On-Demand Classes',
								 'position': 1
							}]	
						}					  
					}
				});
				
				// Measures product impressions and also tracks a standard				
				dataLayer.push({
					'event': 'OnDemandImpressions2',
				    'ecommerce': {
					'currencyCode': 'USD',
					'impressions': [
					 {
					   'name': '<?php echo html_entity_decode($level1->name); ?>',
					   'id': '<?php echo $level1->id; ?>',
					   'price': '<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>',
					   'list': 'On-Demand Classes',
					   'position': 1
					 }					 
					 ]
				  }
				});
				
				lavel_one_viewed++;
				
			}			
		});	
		
		jQuery(document).on('appear', '#OnDemand2', function() {
			if(lavel_two_viewed == 0){
				dataLayer.push({
					'event': 'OnDemandImpressions',
					'ecommerce': {
						'checkout': {
							'actionField': {'step': 1, 'list': 'On-Demand Classes'},
						    'impressions': [
						    {
								'name': '<?php echo html_entity_decode($level2->name); ?>',
								'id': '<?php echo $level2->id; ?>',
								'price': '<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>',
								'list': 'On-Demand Classes',
								'position': 2
						    }]	
						}					  
					}
				});
				
				// Measures product impressions and also tracks a standard				
				dataLayer.push({
					'event': 'OnDemandImpressions2',
					'ecommerce': {
					'currencyCode': 'USD',
					'impressions': [					 
					 {
					   'name': '<?php echo html_entity_decode($level2->name); ?>',
					   'id': '<?php echo $level2->id; ?>',
					   'price': '<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>',
					   'list': 'On-Demand Classes',
					   'position': 2
					 }				 
					 ]
				  }
				});
				
				lavel_two_viewed++;				
			}			
		});	
			
		jQuery(document).on('appear', '#OnDemand3', function() {
			if(lavel_three_viewed == 0){
				dataLayer.push({
					'event': 'OnDemandImpressions',
					'ecommerce': {
						'checkout': {
							'actionField': {'step': 1, 'list': 'On-Demand Classes'},
							'impressions': [
						    {
								'name': '<?php echo html_entity_decode($level3->name); ?>',
								'price': '<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>',
								'id': '<?php echo $level3->id; ?>',
								'list': 'On-Demand Classes',
								'position': 3
						    }
							]	
						}
					  
					}
				});
				
				// Measures product impressions and also tracks a standard				
				dataLayer.push({
					'event': 'OnDemandImpressions2',
					'ecommerce': {
					'currencyCode': 'USD',
					'impressions': [					
					 {
					   'name': '<?php echo html_entity_decode($level3->name); ?>',
					   'id': '<?php echo $level3->id; ?>',
					   'price': '<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>',
					   'list': 'On-Demand Classes',
					   'position': 3
					 }					 
					 ]
				  }
				});
				lavel_three_viewed++;				
			}			
		});
	
    } else{
        // The viewport is at least 992 pixels wide
        jQuery(document).on('appear', '#OnDemand1', function() {
			if(lavel_desktop_viewed == 0){
				dataLayer.push({
					'event': 'OnDemandImpressions',
					'ecommerce': {
						'checkout': {
							'actionField': {'step': 1, 'list': 'On-Demand Classes'},
							'impressions': [
						   {
							 'name': '<?php echo html_entity_decode($level1->name); ?>',
							 'id': '<?php echo $level1->id; ?>',
							 'list': 'On-Demand Classes',
							 'position': 1
						   },
						   {
							 'name': '<?php echo html_entity_decode($level2->name); ?>',
							 'id': '<?php echo $level2->id; ?>',
							 'list': 'On-Demand Classes',
							 'position': 2
						   },
						   {
							 'name': '<?php echo html_entity_decode($level3->name); ?>',
							 'id': '<?php echo $level3->id; ?>',
							 'list': 'On-Demand Classes',
							 'position': 3
						   }
						   ]
						}					  
					}
				});				
				
				// Measures product impressions and also tracks a standard				
				dataLayer.push({
					'event': 'OnDemandImpressions2',
					'ecommerce': {
					'actionField': {'list': 'On-Demand Classes'},	
					'currencyCode': 'USD',
					'impressions': [
					 {
					   'name': '<?php echo html_entity_decode($level1->name); ?>',
					   'id': '<?php echo html_entity_decode($level1->id); ?>',
					   'price': '<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>',
					   'list': 'On-Demand Classes',
					   'position': 1
					 },
					 {
					   'name': '<?php echo html_entity_decode($level2->name); ?>',
					   'id': '<?php echo html_entity_decode($level2->id); ?>',
					   'price': '<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>',
					   'list': 'On-Demand Classes',
					   'position': 2
					 },
					 {
					   'name': '<?php echo html_entity_decode($level3->name); ?>',
					   'id': '<?php echo html_entity_decode($level3->id); ?>',
					   'price': '<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>',
					   'list': 'On-Demand Classes',
					   'position': 3
					 }					 
					 ]
				  }
				});
				
				
				lavel_desktop_viewed++;
			}
		});
	}
	});

    jQuery('body').swipe( {
       swipeLeft: function () {
        jQuery.sidr('close', 'sidr');
          console.log("swipe left");
      },
      threshold: 45
  });
    
	jQuery('#sidr').swipe( {
        swipeLeft: function () {
        jQuery.sidr('close', 'sidr');
          console.log("swipe menu");
    },
		threshold: 45
    });

	jQuery('a[href^="<?php echo get_permalink( 1850 ).'?level=1'; ?>"]').click(function() {
		dataLayer.push({
		  'event': 'ProductClick',
		  'ecommerce': {
			'checkout': {
			  'actionField': {'step': 2, 'list': 'On-Demand Classes'},
			  'products': [{
				'name': '<?php echo html_entity_decode($level1->name); ?>',              
				'id': '<?php echo $level1->id; ?>',
				'price': '<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>'
			   }]
			 }
		   }
		});
	
		// for product list
		dataLayer.push({
			'event': 'productClick2',
			'ecommerce': {
			  'click': {
				'actionField': {'list': 'On-Demand Classes'},
				'products': [{
				   'name': '<?php echo html_entity_decode($level1->name); ?>',              
				   'id': '<?php echo $level1->id; ?>',
				   'price': '<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>',
				   'position': 1
				 }]
			   }
			 }
		});
	});
	
	jQuery('a[href^="<?php echo get_permalink( 1850 ).'?level=2'; ?>"]').click(function() {
		dataLayer.push({
			'event': 'ProductClick',
			'ecommerce': {
			'checkout': {
			  'actionField': {'step': 2, 'list': 'On-Demand Classes'},
			  'products': [{
				'name': '<?php echo html_entity_decode($level2->name); ?>',              
				'id': '<?php echo $level2->id; ?>',
				'price': '<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>'
			   }]
			 }
		   }
		});
	
	// for product list
	dataLayer.push({
		'event': 'productClick2',
		'ecommerce': {
		  'click': {
			'actionField': {'list': 'On-Demand Classes'},
			'products': [{
			   'name': '<?php echo html_entity_decode($level2->name); ?>',              
			   'id': '<?php echo $level2->id; ?>',
			   'price': '<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>',
			   'position': 2
			 }]
		   }
		 }
	});
	
  });
  
	jQuery('a[href^="<?php echo get_permalink( 1850 ).'?level=3'; ?>"]').click(function() {
		dataLayer.push({
		    'event': 'ProductClick',
			'ecommerce': {
			'checkout': {
			  'actionField': {'step': 2, 'list': 'On-Demand Classes'},
			  'products': [{
				'name': '<?php echo html_entity_decode($level3->name); ?>',              
				'id': '<?php echo $level3->id; ?>',
				'price': '<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>'
			   }]
			 }
		   }
		});
	
		// for product list
		dataLayer.push({
			'event': 'productClick2',
			'ecommerce': {
			  'click': {
				'actionField': {'list': 'On-Demand Classes'},
				'products': [{
				   'name': '<?php echo html_entity_decode($level3->name); ?>',              
				   'id': '<?php echo $level3->id; ?>',
				   'price': '<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>',
				   'position': 3
				 }]
			   }
			 }
		});	
	});

  <?php
  if(is_page(1850)){
  ?>
	var visit_count = 0;
	// for paypal button click
    jQuery('#pmpro_btn-submit-paypalexpress').click(function() {
		
		if (jQuery('#username').hasClass('pmpro_error')){
					
			jQuery("#pmpro_message_bottom").text('Username Already Taken');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;
		}
		else if (jQuery('#password2').hasClass('pmpro_error')){
						
			jQuery("#pmpro_message_bottom").text('Confirm Password Not Matched');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;
		}
		else if (jQuery('#bemail').hasClass('pmpro_error')){
						
			jQuery("#pmpro_message_bottom").text('Email Already Taken');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;
		}
		else if (jQuery('#bconfirmemail').hasClass('pmpro_error')){
						
			jQuery("#pmpro_message_bottom").text('Confirm Email Not Matched');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;		
		}
		
		var urlParams = new URLSearchParams(window.location.search);	

		setTimeout( function(){

			if(urlParams.get('review') === null) {
				var cost = jQuery("#pmpro_level_cost p:nth-child(2)").find("strong").text(); 
					if (cost) {
				  var post_coupon_price = cost.replace('$', '');
				}
				if(urlParams.get('level')=='1'){
					var prod_name 	= "<?php echo html_entity_decode($level1->name); ?>";
					var prod_id 	= "<?php echo $level1->id; ?>";
				}else if(urlParams.get('level')=='2'){
					var prod_name 	= "<?php echo html_entity_decode($level2->name); ?>";
					var prod_id 	= "<?php echo $level2->id; ?>";
				}else if(urlParams.get('level')=='3'){
					var prod_name 	= "<?php echo html_entity_decode($level3->name); ?>";
					var prod_id 	= "<?php echo $level3->id; ?>";
				}
			}else{
				if(urlParams.get('level')=='1'){
					var prod_name 	= "<?php echo html_entity_decode($level1->name); ?>";
					var prod_id 	= "<?php echo $level1->id; ?>";
					var post_coupon_price = "<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>";
				}else if(urlParams.get('level')=='2'){
					var prod_name 	= "<?php echo html_entity_decode($level2->name); ?>";
					var prod_id 	= "<?php echo $level2->id; ?>";
					var post_coupon_price = "<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>";
				}else if(urlParams.get('level')=='3'){
					var prod_name 	= "<?php echo html_entity_decode($level3->name); ?>";
					var prod_id 	= "<?php echo $level3->id; ?>";
					var post_coupon_price = "<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>";
				}
			}
			
			<?php if ( !is_user_logged_in() ) { ?>

				if ( jQuery('#username').val()!='' && jQuery('#password').val()!='' && jQuery('#password2').val()!='' && jQuery('#bemail').val()!='' && jQuery('#bconfirmemail').val()!='' ){
				
					if(urlParams.get('review') === null) {

						if(urlParams.get('level')=='1'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level1->name); ?>',              
									  'id': '<?php echo $level1->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								 }
							});			
						  
							// for product list
							dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},	
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level1->name); ?>',              
									'id': '<?php echo $level1->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});

						}else if(urlParams.get('level')=='2'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level2->name); ?>',              
									  'id': '<?php echo $level2->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								}
							});
						  
							// for product list
							dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level2->name); ?>',              
									'id': '<?php echo $level2->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});
							
						}else if(urlParams.get('level')=='3'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level3->name); ?>',              
									  'id': '<?php echo $level3->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								}
							});
						  
						  dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level3->name); ?>',              
									'id': '<?php echo $level3->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});			
						}
					}
				}
			<?php }else{ ?>

				if ( jQuery('#first_name').val()!='' && jQuery('#last_name').val()!='' ){
				
					if(urlParams.get('review') === null) {

						if(urlParams.get('level')=='1'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level1->name); ?>',              
									  'id': '<?php echo $level1->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								 }
							});			
						  
							// for product list
							dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},	
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level1->name); ?>',              
									'id': '<?php echo $level1->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});

						}else if(urlParams.get('level')=='2'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level2->name); ?>',              
									  'id': '<?php echo $level2->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								}
							});
						  
							// for product list
							dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level2->name); ?>',              
									'id': '<?php echo $level2->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});
							
						}else if(urlParams.get('level')=='3'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level3->name); ?>',              
									  'id': '<?php echo $level3->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								}
							});
						  
						  dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level3->name); ?>',              
									'id': '<?php echo $level3->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});			
						}
					}
				}

			<?php } ?>
		}, 1000 );
		
	});
	
	
	// 100 percent discount and click
	jQuery('#pmpro_btn-submit').click(function() {
		
		if (jQuery('#username').hasClass('pmpro_error')){
					
			jQuery("#pmpro_message_bottom").text('Username Already Taken');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;
		}
		else if (jQuery('#password2').hasClass('pmpro_error')){
						
			jQuery("#pmpro_message_bottom").text('Confirm Password Not Matched');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;
		}
		else if (jQuery('#bemail').hasClass('pmpro_error')){
						
			jQuery("#pmpro_message_bottom").text('Email Already Taken');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;
		}
		else if (jQuery('#bconfirmemail').hasClass('pmpro_error')){
						
			jQuery("#pmpro_message_bottom").text('Confirm Email Not Matched');
			jQuery("#pmpro_message_bottom").addClass('pmpro_error');
			jQuery("#pmpro_message_bottom").show();
			return false;		
		}
				
		var urlParams = new URLSearchParams(window.location.search);

		setTimeout( function(){ 

			if(urlParams.get('review') === null) {
				var cost = jQuery("#pmpro_level_cost p:nth-child(2)").find("strong").text(); 
	  			if (cost) {
				  var post_coupon_price = cost.replace('$', '');
				}
				if(urlParams.get('level')=='1'){
					var prod_name 	= "<?php echo html_entity_decode($level1->name); ?>";
					var prod_id 	= "<?php echo $level1->id; ?>";
				}else if(urlParams.get('level')=='2'){
					var prod_name 	= "<?php echo html_entity_decode($level2->name); ?>";
					var prod_id 	= "<?php echo $level2->id; ?>";
				}else if(urlParams.get('level')=='3'){
					var prod_name 	= "<?php echo html_entity_decode($level3->name); ?>";
					var prod_id 	= "<?php echo $level3->id; ?>";
				}
			}else{
				if(urlParams.get('level')=='1'){
					var prod_name 	= "<?php echo html_entity_decode($level1->name); ?>";
					var prod_id 	= "<?php echo $level1->id; ?>";
					var post_coupon_price = "<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>";
				}else if(urlParams.get('level')=='2'){
					var prod_name 	= "<?php echo html_entity_decode($level2->name); ?>";
					var prod_id 	= "<?php echo $level2->id; ?>";
					var post_coupon_price = "<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>";
				}else if(urlParams.get('level')=='3'){
					var prod_name 	= "<?php echo html_entity_decode($level3->name); ?>";
					var prod_id 	= "<?php echo $level3->id; ?>";
					var post_coupon_price = "<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>";
				}
			}

			if(urlParams.get('review') === null) {

				if(post_coupon_price!='0.00') {

					if ( jQuery('#first_name').val()!='' && jQuery('#last_name').val()!='' ){
	
						if(urlParams.get('level')=='1'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level1->name); ?>',              
									  'id': '<?php echo $level1->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								 }
							});			
						  
							// for product list
							dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},	
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level1->name); ?>',              
									'id': '<?php echo $level1->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});

						}else if(urlParams.get('level')=='2'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level2->name); ?>',              
									  'id': '<?php echo $level2->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								}
							});
						  
							// for product list
							dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},	
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level2->name); ?>',              
									'id': '<?php echo $level2->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});
					
						}else if(urlParams.get('level')=='3'){
							dataLayer.push({
								'event': 'CheckoutClick',
								'ecommerce': {
								  'checkout': {
									'actionField': {'step': 3, 'list': 'On-Demand Classes'},
									'products': [{
									  'name': '<?php echo html_entity_decode($level3->name); ?>',              
									  'id': '<?php echo $level3->id; ?>',
									  'price': post_coupon_price
									 }]
								   }
								}
							});
						  
						  dataLayer.push({
								'event': 'addToCart',
								'ecommerce': {
								'actionField': {'list': 'On-Demand Classes'},	
								'currencyCode': 'USD',
								'add': {                                
								  'products': [{                        
									'name': '<?php echo html_entity_decode($level3->name); ?>',              
									'id': '<?php echo $level3->id; ?>',
									'price': post_coupon_price
								   }]
								}
							  }
							});			
						}
					}
				}else{
					dataLayer.push({
						'event': 'checkout',
						'ecommerce': {
							'actionField': {'list': 'On-Demand Classes'},
							'products': [{
								'name': prod_name,              
							  	'id': prod_id,
							  	'price': post_coupon_price
							}]
						}
					});
				}

				if(post_coupon_price!='0.00') {

					if(urlParams.get('level')=='1'){
						var prod_name 	= "<?php echo html_entity_decode($level1->name); ?>";
						var prod_id 	= "<?php echo $level1->id; ?>";
					}else if(urlParams.get('level')=='2'){
						var prod_name 	= "<?php echo html_entity_decode($level2->name); ?>";
						var prod_id 	= "<?php echo $level2->id; ?>";
					}else if(urlParams.get('level')=='3'){
						var prod_name 	= "<?php echo html_entity_decode($level3->name); ?>";
						var prod_id 	= "<?php echo $level3->id; ?>";
					}

					dataLayer.push({
					    'event': 'checkout',
					    'ecommerce': {
					        'actionField': {'list': 'On-Demand Classes'},
					        'products': [{
					          	'name': prod_name,
					          	'id': prod_id,
					          	'price': post_coupon_price
					       }]
					   }
					});
				}				
			
			}else{

				dataLayer.push({
				    'event': 'checkout',
				    'ecommerce': {
				        'actionField': {'list': 'On-Demand Classes'},
				        'products': [{
				          	'name': prod_name,
				          	'id': prod_id,
				          	'price': post_coupon_price
				       }]
				   }
				});
			}
			

		}, 1000 );
    });
	
	//Apply Button
	jQuery('#other_discount_code_button').click(function() {

		if(urlParams.get('level')=='1'){
			var prod_name 	= "<?php echo html_entity_decode($level1->name); ?>";
			var prod_id 	= "<?php echo $level1->id; ?>";
		}else if(urlParams.get('level')=='2'){
			var prod_name 	= "<?php echo html_entity_decode($level2->name); ?>";
			var prod_id 	= "<?php echo $level2->id; ?>";
		}else if(urlParams.get('level')=='3'){
			var prod_name 	= "<?php echo html_entity_decode($level3->name); ?>";
			var prod_id 	= "<?php echo $level3->id; ?>";
		}
		
		setTimeout( function(){
			if(urlParams.get('review') === null) {
				var cost = jQuery("#pmpro_level_cost p:nth-child(2)").find("strong").text(); 
	  			if (cost) {
				 	var post_coupon_price = cost.replace('$', '');
					if(post_coupon_price=='0.00') {
						dataLayer.push({
							'event': 'CheckoutClick',
							'ecommerce': {
							  'checkout': {
								'actionField': {'step': 3, 'list': 'On-Demand Classes'},
								'products': [{
								  'name': prod_name,              
								  'id': prod_id,
								  'price': post_coupon_price
								 }]
							   }
							}
						});

						dataLayer.push({
							'event': 'addToCart',
							'ecommerce': {
							'actionField': {'list': 'On-Demand Classes'},	
							'currencyCode': 'USD',
							'add': {                                
							  'products': [{                        
								'name': prod_name,              
								'id': prod_id,
								'price': post_coupon_price
							   }]
							}
						  }
						});
					}
				}
			}		 
		}, 1000 );	
	});
	
	// for product list
	var urlParams = new URLSearchParams(window.location.search);
	if(urlParams.get('review') === null) {
	 	if(urlParams.get('level')=='1'){
	        dataLayer.push({
				'event': 'ProductDetailView',
			    'ecommerce': {
				'detail': {
					'actionField': {'list': 'On-Demand Classes'},    
					'products': [{
						'name': '<?php echo html_entity_decode($level1->name); ?>',              
						'id': '<?php echo $level1->id; ?>',
						'price': '<?php echo number_format((float)$level1->initial_payment, 2, '.', ''); ?>'
				   }]
				 }
			   }
			});
	    }else if(urlParams.get('level')=='2'){
	        dataLayer.push({
				'event': 'ProductDetailView',
			    'ecommerce': {
				'detail': {
				  'actionField': {'list': 'On-Demand Classes'},    
				  'products': [{
					'name': '<?php echo html_entity_decode($level2->name); ?>',              
	                'id': '<?php echo $level2->id; ?>',
	                'price': '<?php echo number_format((float)$level2->initial_payment, 2, '.', ''); ?>'
				   }]
				 }
			   }
			});
	    }else if(urlParams.get('level')=='3'){
	        dataLayer.push({
				'event': 'ProductDetailView',
			    'ecommerce': {
				'detail': {
				  'actionField': {'list': 'On-Demand Classes'},    
				  'products': [{
					'name': '<?php echo html_entity_decode($level3->name); ?>',              
	                'id': '<?php echo $level3->id; ?>',
	                'price': '<?php echo number_format((float)$level3->initial_payment, 2, '.', ''); ?>'
				   }]
				 }
			   }
			});
	    } 
	}
	  
  <?php
  }
  ?>
  
  <?php
	if(is_page(1851)){
	?>
	jQuery(document).ready(function(){
		var urlParams = new URLSearchParams(window.location.search);
		var transection_id 		= 	jQuery('#transection_id').text();
		var transection_amount 	= 	parseInt(jQuery('#transection_amount').text().trim()).toFixed(2);
		var invoice_final_id 	= 	jQuery("#invoice_final_id").val();
		var invoice_final_total = 	jQuery("#invoice_final_total").val().replace('$', '');
 			
		
		var discount_code = "";
		discount_code 		= 	jQuery('#discount_code').text();
		//alert(transection_id);
		if(urlParams.get('level')=='1'){        		
			// for product list
			dataLayer.push({
				'event': 'ConfirmationClick2',
				'ecommerce': {
				'purchase': {
				  'actionField': {
					'id': invoice_final_id,
					'revenue': invoice_final_total,
					'coupon': discount_code,	
				  },
				  'products': [{                            
					'name': '<?php echo html_entity_decode($level1->name); ?>',              
					'id': '<?php echo $level1->id; ?>',
					'price': invoice_final_total,
					'quantity': 1,
					'coupon': discount_code
				   }]
				}
			  }
			});	
			
			// for checkout
			dataLayer.push({
			    'event': 'ConfirmationClick',
			    'ecommerce': {
					'checkout': {
						'purchase': {
							'actionField': {
								'step': 4,
								'list': 'On-Demand Classes',
								'revenue': invoice_final_total,
								'id': transection_id,
								'coupon': discount_code,
								},
							'products': [{
								'name': '<?php echo html_entity_decode($level1->name); ?>',              
								'id': '<?php echo $level1->id; ?>',
								'price': invoice_final_total,
								'quantity': 1,
								'coupon': discount_code
							}]	
						}						
				    }
			    }
			});	
			
		}else if(urlParams.get('level')=='2'){        		
			// for product list
			dataLayer.push({
				'event': 'ConfirmationClick2',
				'ecommerce': {
				'purchase': {
				  'actionField': {
					'id': invoice_final_id,
					'revenue': invoice_final_total,
					'coupon': discount_code,	
				  },
				  'products': [{                            
					'name': '<?php echo html_entity_decode($level2->name); ?>',              
					'id': '<?php echo $level2->id; ?>',
					'price': invoice_final_total,
					'quantity': 1,
					'coupon': discount_code
				   }]
				}
			  }
			});
			
			// for checkout
			dataLayer.push({
			    'event': 'ConfirmationClick',
			    'ecommerce': {
					'checkout': {
						'purchase': {
							'actionField': {
								'step': 4,
								'list': 'On-Demand Classes',
								'revenue': invoice_final_total,
								'id': transection_id,
								'coupon': discount_code,
								},
							'products': [{
								'name': '<?php echo html_entity_decode($level2->name); ?>',              
								'id': '<?php echo $level2->id; ?>',
								'price': invoice_final_total,
								'quantity': 1,
								'coupon': discount_code
							}]	
						}						
					}
			    }
			});	
		
      }else if(urlParams.get('level')=='3'){
        		
			// for product list
			dataLayer.push({
				'event': 'ConfirmationClick2',
				'ecommerce': {
				'purchase': {
				  'actionField': {
					'id': invoice_final_id,
					'revenue': invoice_final_total,
					'coupon': discount_code,	
				  },
				  'products': [{                            
					'name': '<?php echo html_entity_decode($level3->name); ?>',              
					'id': '<?php echo $level3->id; ?>',
					'price': invoice_final_total,
					'quantity': 1,
					'coupon': discount_code
				   }]
				}
			  }
			});
			
			// for checkout
			dataLayer.push({
				'event': 'ConfirmationClick',
				'ecommerce': {
					'checkout': {
						'purchase': {
							'actionField': {
								'step': 4,
								'list': 'On-Demand Classes',
								'revenue': invoice_final_total,
								'id': transection_id,
								'coupon': discount_code,
								},
							'products': [{
								'name': '<?php echo html_entity_decode($level3->name); ?>',              
								'id': '<?php echo $level3->id; ?>',
								'price': invoice_final_total,
								'quantity': 1,
								'coupon': discount_code
							}]	
						}						
					}
			    }
			});			
		}
	});
	
  
	<?php
	}

	if(is_page(1849)){ 
		global $current_user;	
		$user_id 				= (string)$current_user->ID;
		$membership_level_id 	= $current_user->membership_level->ID;
		$subscription_id		= $current_user->membership_level->subscription_id;

		$order = $wpdb->get_row("SELECT * FROM {$wpdb->pmpro_membership_orders} WHERE `user_id` = {$user_id} AND `membership_id` = {$membership_level_id} ORDER BY `id` DESC LIMIT 0, 1");
	?>
		jQuery('.pmpro_yeslink').click(function(){
			var urlParams = new URLSearchParams(window.location.search);
			if(urlParams.get('levelstocancel')=='1'){
				var prod_name 	= "<?php echo html_entity_decode($level1->name); ?>";
				var prod_id 	= "<?php echo $level1->id; ?>";
			}else if(urlParams.get('levelstocancel')=='2'){
				var prod_name 	= "<?php echo html_entity_decode($level2->name); ?>";
				var prod_id 	= "<?php echo $level2->id; ?>";
			}else if(urlParams.get('levelstocancel')=='3'){
				var prod_name 	= "<?php echo html_entity_decode($level3->name); ?>";
				var prod_id 	= "<?php echo $level3->id; ?>";
			}

	    	dataLayer.push({
			  	'ecommerce': {
				    'refund': {
				      	'actionField': {'list': 'On-Demand Classes', 'id': '<?php echo $subscription_id; ?>'}, 
				      	'products': [{
				      		'id': prod_id, 
				      		'name': prod_name, 
				      		'price': '<?php echo number_format((float)$order->subtotal, 2, '.', ''); ?>', 
				      		'quantity': 1
				       	}]
				    }
			  	}
			});
	    });
	<?php	
	}
	?>	

</script>


<script type="text/javascript">

 // ecommerce mailchip work starts here
 
 // mailchip work starts here

    <?php
	if(is_page(1850)){
		if (isset($_GET['mc_cid'])){
			$campaignID = $_GET['mc_cid'];
	?>
			var data = {
				'action': 'store_campaign_id',
				'campaignID': '<?php echo $campaignID;?>',			
			};
			var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
			jQuery.post(ajaxurl, data, function (response) {
				console.log(response);
			});

	<?php
		}
	}
	

    if(is_page(1851)){
		global $current_user;
		
        if (isset($_SESSION['mc_cid'])){
			
			$user_id = (string)$current_user->ID;
			$campaign_id = $_SESSION['mc_cid'];
			$product_id = $_GET['level'];
			

			if($product_id == "1"){
				$product_price =  number_format((float)$level1->initial_payment, 2, '.', '');
			}elseif($product_id == "2"){
				$product_price =  number_format((float)$level2->initial_payment, 2, '.', '');
			}elseif($product_id == "3"){
				$product_price =  number_format((float)$level3->initial_payment, 2, '.', '');
			}
        
    ?>        
			jQuery(document).ready(function(){
				
				var transection_id 		= 	jQuery('#transection_id').text();
				var transection_amount 	= 	parseInt(jQuery('#transection_amount').text().trim()).toFixed(2);
				
				var discount_code = "";
				discount_code 		= 	jQuery('#discount_code').text();
				
				
			
				
				var data = {
					'action': 'orders_mailchimp',
					'user_id': '<?php echo $user_id;?>',
					'product_id': '<?php echo $product_id;?>',
					'campaign_id': '<?php echo $campaign_id;?>',
					'order_total': transection_amount,
					'transection_id': transection_id,
					'product_price': transection_amount,
					'discount_code': discount_code,
				};
				var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
				jQuery.post(ajaxurl, data, function (response) {
					console.log(response);
				});
			});
    <?php
		}
	}
	
    ?>


    jQuery('#orders').click(function(){
        var data = {
            'action': 'orders_mailchimp',
            'email': '',
        };
        var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
        jQuery.post(ajaxurl, data, function (response) {
            console.log(response);
        });
    });

    jQuery('#stores').click(function(){
        var data = {
            'action': 'store_mailchimp',
            'email': '',
        };
        var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
        jQuery.post(ajaxurl, data, function (response) {
            console.log(response);
        });
    });

    jQuery('#stores_user').click(function(){
        var data = {
            'action': 'mailchimp_store_customer',
            'email': '',
        };
        var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
        jQuery.post(ajaxurl, data, function (response) {
            console.log(response);
        });
    });

    jQuery('#stores_product').click(function(){
        var data = {
            'action': 'mailchimp_store_product',
            'email': '',
        };
        var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
        jQuery.post(ajaxurl, data, function (response) {
            console.log(response);
        });
    });

    jQuery('#get_stores').click(function(){
        var data = {
            'action': 'get_mailchimp_stores',
            'email': '',
        };
        var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
        jQuery.post(ajaxurl, data, function (response) {
            console.log(response);
        });
    });
	
	// ecommerce mailchip work ends here
</script>
<script>
	jQuery(document).ready(function(){
	jQuery('#tribe-events-events-bar-keyword').on('focus',function(){
	jQuery(this).attr('autocomplete', 'off');
	});
	});
	</script>
</body>
</html>
