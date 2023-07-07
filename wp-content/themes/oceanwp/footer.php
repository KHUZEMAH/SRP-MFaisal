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
<div class="container">
    <button id="openEventModal" class="event-ico"><i class="far fa-calendar-alt"></i></button>
</div>
<div class="event-modal">
  <div class="event-modal-body">
    <button id="eventModalclose" title="Close" class="modal-close">x</button>
    <h1>Live Zoom Class Schedule</h1>
     <?php echo do_shortcode('[tribe_mini_calendar count="1"]'); ?>
    </div>
</div>
<?php
// If full screen mobile menu style.
if ( 'fullscreen' === oceanwp_mobile_menu_style() ) {
 get_template_part( 'partials/mobile/mobile-fullscreen' );
}
?>

<?php wp_footer(); ?>


<script>
    jQuery(document).ready(function(){
		jQuery('#openEventModal').click(function(){
          jQuery('.event-modal').toggleClass('triggered-modal');
		  jQuery('body').toggleClass('overley-modal');
		})
		jQuery('#eventModalclose').click(function(){
          jQuery('.event-modal').removeClass('triggered-modal');
		  jQuery('body').removeClass('overley-modal');
		})
		jQuery(document).click(function (e) {
			if (jQuery(e.target).is('.event-modal')) {
				jQuery('.event-modal').removeClass('triggered-modal');
		        jQuery('body').removeClass('overley-modal');
			}
		});
		
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

var Anchors = document.getElementsByClassName("menu-link");

for (var i = 0; i < Anchors.length ; i++) {
	var hrefs = Anchors[i].getAttribute("href");
	try{
		Anchors[i].addEventListener("click", 
        function (event) {
			jQuery('body').removeClass('clear_intial');
        }, 
        false);
	}
	catch(e){ console.log(e); }
    
}


jQuery(window).scroll(function(){
  if (jQuery(window).scrollTop() >= 150) {
    jQuery('#site-header').addClass('sticky-custom');
    jQuery('body').addClass('clear_intial');
        document.body.style.marginTop = 130 + 'px';
   }
   else {
    jQuery('#site-header').removeClass('sticky-custom');
    jQuery('body').removeClass('clear_intial');
		document.body.style.marginTop = 0;
		document.body.style.paddingTop = 0;
   }
});

</script>

<script>
  !function(e){var r=[],t=!1,a=!1,i={interval:250,force_process:!1},n=e(window),p=[];function o(){return e(this).is(":appeared")}function f(){return!e(this).data("_appear_triggered")}function u(){a=!1;for(var e=0,t=r.length;e<t;e++){var i=r[e].filter(o);if(i.filter(f).data("_appear_triggered",!0).trigger("appear",[i]),p[e]){var n=p[e].not(i);n.data("_appear_triggered",!1).trigger("disappear",[n])}p[e]=i}}e.expr.pseudos.appeared=e.expr.createPseudo((function(r){return function(r){var t=e(r);if(!t.is(":visible"))return!1;var a=n.scrollLeft(),i=n.scrollTop(),p=t.offset(),o=p.left,f=p.top;return f+t.height()>=i&&f-(t.data("appear-top-offset")||0)<=i+n.height()&&o+t.width()>=a&&o-(t.data("appear-left-offset")||0)<=a+n.width()}})),e.fn.extend({appear:function(r,t){return e.appear(this,t),this}}),e.extend({appear:function(n,o){var f=e.extend({},i,o||{});if(!t){var s=function(){a||(a=!0,setTimeout(u,f.interval))};e(window).scroll(s).resize(s),t=!0}f.force_process&&setTimeout(u,f.interval),function(e){r.push(e),p.push()}(n)},force_appear:function(){return!!t&&(u(),!0)}})}("undefined"!=typeof module?require("jquery"):jQuery);
</script>

<?php 
  $level1 = $wpdb->get_row("SELECT * FROM {$wpdb->pmpro_membership_levels} WHERE id = 1 ");
  $level2 = $wpdb->get_row("SELECT * FROM {$wpdb->pmpro_membership_levels} WHERE id = 2 ");
  $level3 = $wpdb->get_row("SELECT * FROM {$wpdb->pmpro_membership_levels} WHERE id = 3 ");
  
  
  $all_levels = $wpdb->get_results("SELECT * FROM {$wpdb->pmpro_membership_levels}");
  //var_dump($all_levels);
?>
<!-- ----------- GTM work start -----------  -->
<script>
	
	<?php
	// if is category page
	if(is_page(4502)){
	?>	
		// method calls on below document ready function from category page (explore-classes)
		// Function covered GTM checkout Step 1 and enhance-ecommerce step 1 from product listing page
		function onDemandGTMStep1(onDemandTabTriggerCount){
						
			// get all product ids from on-demand-class listing
			var onDemandIDs = [];
			jQuery("#onDemandRow").find("div.col-md-3").each(function(){ onDemandIDs.push(this.id); });
			
			
			// if user scroll up and down on a page, we have to record GTM values only once 
			// 1) set "viewed variable" to prevent record duplicate impressions
			// 2) initialize onDemandIDs in jQuery to prevent jquery issues
			var onDemandViewed = {};
			for (let i = 0; i < onDemandIDs.length; ++i) {
				onDemandViewed['on_demand_lavel_'+i+'_viewed'] = 0;
				jQuery('#'+onDemandIDs[i]).appear(function() {});
			}

			
			// The viewport is less than 768 pixels wide (mobile and tabs)
			if(window.matchMedia("(max-width: 991px)").matches){
				
				// loop through all "on-demand-class" products to get data dynamically  
				for (let i = 0; i < onDemandIDs.length; ++i) {
					
					// capture record when product appear in screen (capturing product with product div ID)
					jQuery(document).on('appear', '#'+onDemandIDs[i], function() {
						
						// use above dynamically created variable to make sure data capturing not repeated 
						if(onDemandViewed['on_demand_lavel_'+i+'_viewed'] == 0 && onDemandTabTriggerCount == 0){
							
							// prepare data
							var name = jQuery('#'+onDemandIDs[i]+ ' h3').text();
							var price = jQuery('#'+onDemandIDs[i]).attr('data-price_with_symbol');
							//var price= jQuery('#'+onDemandIDs[i]+ ' p strong').text();
							// get product id by splicting string "onDemandClass-1"
							var toSplit = onDemandIDs[i].split('-');
							var id = toSplit.pop();
							
							// GTM checkout step 1 capture impression from product listing page
							dataLayer.push({
								'event': 'Checkout_Product_Impressions',
								'ecommerce': {
									'checkout': {
										'actionField': {'step': 1, 'list': 'On-Demand Classes'},
										'impressions': [
										{
											 'name': name,
											 'id': id,		
											 'price': price,
											 'category': 'Subscription',		
											 'list': 'On-Demand Classes',
											 'position': 1
										}]	
									}					  
								}
							});
							
							// GTM enhance-ecommerce step 1 capture impression from product listing page				
							dataLayer.push({
								'event': 'EE_Product_Impressions',
								'ecommerce': {
								'currencyCode': 'USD',
								'impressions': [
								 {
								   'name': name,
								   'id': id,
								   'price': price,
								   'category': 'Subscription',
								   'list': 'On-Demand Classes',
								   'position': 1
								 }]
							  }
							});
							
							onDemandViewed['on_demand_lavel_'+i+'_viewed']++;
						}			
					});	
				}
			}
			
			// The viewport is at least 992 pixels wide (desktop and big screens)
			else{
				
				// loop through all "on-demand-class" products to get data dynamically  
				for (let i = 0; i < onDemandIDs.length; ++i) {
					
					// capture record when product appear in screen (capturing product with product div ID)
					jQuery(document).on('appear', '#'+onDemandIDs[i], function() {
						
						// use above dynamically created variable to make sure data capturing not repeated 
						if(onDemandViewed['on_demand_lavel_'+i+'_viewed'] == 0 && onDemandTabTriggerCount == 0){
							
							// prepare data
							var name = jQuery('#'+onDemandIDs[i]+ ' h3').text();
							var price = jQuery('#'+onDemandIDs[i]).attr('data-price_with_symbol');
							//var price= jQuery('#'+onDemandIDs[i]+ ' p strong').text();
							// get product id by splicting string "onDemandClass-1"
							var toSplit = onDemandIDs[i].split('-');
							var id = toSplit.pop();
							
							// GTM checkout step 1 capture impression from product listing page
							dataLayer.push({
								'event': 'Checkout_Product_Impressions',
								'ecommerce': {
									'checkout': {
										'actionField': {'step': 1, 'list': 'On-Demand Classes'},
										'impressions': [
										{
											 'name': name,
											 'id': id,		
											 'price': price,	
											 'category': 'Subscription',	
											 'list': 'On-Demand Classes',
											 'position': 1
										}]	
									}					  
								}
							});
							
							// GTM enhance-ecommerce step 1 capture impression from product listing page				
							dataLayer.push({
								'event': 'EE_Product_Impressions',
								'ecommerce': {
								'currencyCode': 'USD',
								'impressions': [
								 {
								   'name': name,
								   'id': id,
								   'price': price,
								   'category': 'Subscription',
								   'list': 'On-Demand Classes',
								   'position': 1
								 }]
							  }
							});
							
							onDemandViewed['on_demand_lavel_'+i+'_viewed']++;
						}			
					});	
				}
			}	
		}

		// Function covered GTM checkout Step 2 and enhance-ecommerce step 2 (when click on any product from listing page)
		function GTMStep2(name,price,id,list){
			
			if(list == 'giftClass'){
				var listName = 'Gift a Class';
			}else{
				var listName = 'On-Demand Classes';
			}
			
			// GTM checkout step 2 capture product click from listing page
			dataLayer.push({
			  'event': 'Checkout_Product_Click',
			  'ecommerce': {
				'checkout': {
				  'actionField': {'step': 2, 'list': listName},
				  'products': [{
					'name': name,              
					'id': id,
					'price': price,
					'category': 'Subscription',
				   }]
				 }
			   }
			});
		
			// GTM enhance-ecommerce step 2 capture product click from listing page
			dataLayer.push({
				'event': 'EE_Product_Click',
				'ecommerce': {
				  'click': {
					'actionField': {'list': listName},
					'products': [{
					   'name': name,              
					   'id': id,
					   'price': price,
					   'category': 'Subscription',
					   'position': 1
					 }]
				   }
				 }
			});
		}
		
		jQuery(document).ready(function(){
			
			/* ****** GTM Step1 ***** */
			
			// set counter to get number of time functions triggered
			// we have to avoid duplication of record in GTM, we use these variables in functions to add a check
			onDemandTabTriggerCount = 0
			
			// get user's current selected tab
			if(jQuery('#tab-odc').hasClass('current')){
				var currentTab = 'onDemandTab';
				onDemandGTMStep1(onDemandTabTriggerCount);
				onDemandTabTriggerCount++
			}	
			
			/* ****** Step2 ***** */
			
			// on click any product from category listing page
			// gather data from dom
			jQuery(".expoler-item").click(function (e) {
				
				//e.preventDefault();
				
				var name = jQuery(this).closest(".col-md-3").find('h3').text();
				var price = jQuery(this).closest(".col-md-3").attr('data-price_with_symbol');
				
				// we have dynamic ids like 'giftClass-8','onDemandClass-5' first part is list name and second product id
				var colID = jQuery(this).closest(".col-md-3").attr('id'); 
				var parts = colID.split('-');
				var id = parts.pop();
				var list = parts.join('-');
				
				// method to trigget GTM step 2 process
				GTMStep2(name,price,id,list);
				
			  });
		});	
	<?php
	}
	?>	
</script>

<script>
	<?php
	if(is_product()){
	?>	
		// Function for capture product data on product details page load
		function eeProductDetailView(product_id,product_name,product_price,category){
			
			// GTM enhance-ecommerce step 3 capture product data on product details page load	
			dataLayer.push({
				'event': 'EE_Product_Detail_View',
				'ecommerce': {
				'detail': {
					'actionField': {'list': 'On-Demand Classes'},    
					'products': [{
						'name': product_name,              
						'id': product_id,
						'price': product_price,
						'category': category,
				   }]
				 }
			   }
			});
		}	
		
		// GTM enhance-ecommerce step 4 capture product data on add to cart click
		function captureAddToCart(product_id,product_name,product_price,category){
			
			// enhance-ecommerce capture add_to_cart click
			dataLayer.push({
				'event': 'EE_Add_Cart',
				'ecommerce': {
				'actionField': {'list': 'On-Demand Classes'},	
				'currencyCode': 'USD',
					'add': {                                
					  'products': [{
							'name': product_name,              
							'id'  : product_id,
							'price':product_price,
							'category': category,							
						}]
					}
				}
			});
		}
		
		jQuery(document).ready(function(){
			
			<?php
			// get the product information in product details page
			$product_id    = get_the_id();
			$product 	   = wc_get_product( $product_id );
			$product_name  = $product->get_name();
			$product_price =  '$'.$product->get_price();
			?>

			var product_id    = '<?php echo $product_id ?>';	
			var product_name  = '<?php echo $product_name ?>';
			var product_price = '<?php echo $product_price ?>';
			var category      = 'Subscription';
			
			var is_error_on_page = jQuery('ul.woocommerce-error').text();
			
			
			if(!is_error_on_page){
				
				// on page load capture product detail view impression for enhance ecommerce
				eeProductDetailView(product_id,product_name,product_price,category);				
				
			}
			
			
			
			// on click add to cart button on product details page	
			jQuery(document).on('click', '.single_add_to_cart_button', function (e) {
				
				//e.preventDefault();
				
				// check duplicate cart 
				/*var data = {
					'action': 'validate_duplicate_cart',
					'product_id': '<?php echo $product_id;?>',			
				};
				var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
				jQuery.post(ajaxurl, data, function (response) {
					console.log(response);
				});*/
				
				// check if page has any error 
				var is_error_on_page = jQuery('ul.woocommerce-error').text();
				
					
				// if checkbox is checked then need to add validation
				// we are adding validation here because based on this we have to record GTM add to cart steps
				if(jQuery('#gifting_0_option').is(":checked")){
					
					var emailval = jQuery('.recipient_email').val();
					var verifyemailval = jQuery('.custom_gift_veify_email').val();
					
					// compare email and verify email field values
					if(emailval !== verifyemailval ){
						jQuery('.woocommerce-notices-wrapper').append('<ul class="woocommerce-error" role="alert"><li>Email and verify email must be same.</li></ul>');
						
						jQuery('html, body').animate({
							scrollTop: jQuery("#main").offset().top
						}, 2000);
						
						return false;
						
					}
					category = 'Gift';
					
					if(!is_error_on_page){
						
						// Process GTM add to cart as a "Gift"
						captureAddToCart(product_id,product_name,product_price,category);	
					}
					
				}
				
				// gift checkbox is not checked so its a normal subscription
				else{

					if(!is_error_on_page){
						// Process GTM add to cart as a "Subscription"
						captureAddToCart(product_id,product_name,product_price,category)	
					}	
					
							
				}
					
			});
			
		});	
		
	<?php
	}
	?>
</script>

<script>
	<?php
	if(is_cart()){ 
	?>
		
		function GTMcartStep(){

			var itemsArray = [];

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			
				$product = $cart_item['data'];
				$product_id = $cart_item['product_id'];
				$quantity = $cart_item['quantity'];
				$price = WC()->cart->get_product_price( $product );
				$product_name  = $product->get_name();
				$product_price =  '$'.$product->get_price();
			
			?>
			var category = "Subscription";
			if(jQuery('#gifting_<?php echo $cart_item_key ?>_option').is(":checked"))
				category = "Gift";

			// store products data in array
			itemsArray.push(
				{
				  'name': '<?php echo $product_name; ?>',
				  'id': '<?php echo $product_id; ?>',
				  'price': '<?php echo $product_price; ?>',
				  'category': category,
				}     
			);
			
			<?php } ?>

		
			// GTM checkout step 3 capture products on cart page when proceding to checkout
			dataLayer.push({
				'event': 'Checkout_Checkout_Click',
				'ecommerce': {
					'checkout': {
						'actionField': {'step': 3, 'list': 'On-Demand Classes'},
						'products': [itemsArray]
					}
				}
			});			
				  
			
					
			// GTM enhance-ecommerce step 5 capture products data on cart page		
			dataLayer.push({
				'event': 'EE_Checkout_Click',
				'ecommerce': {
					'actionField': {'list': 'On-Demand Classes'},
					'products': [itemsArray]
			   }
			});	
		}
		
		
		jQuery(document).ready(function(){
			jQuery('.checkout-button').on('click',function(){
				GTMcartStep();
			});
		});
		
	<?php
	} 
	?>
</script>

<script>
<?php if (is_checkout() && !is_wc_endpoint_url('order-received')){ ?>

	function createCookie(name, value, days){
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString();
		}
		else var expires = "";               

		document.cookie = name + "=" + value + expires + "; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}

	jQuery(document).ready(function(){
		
		// check if cookie is set 
		isCookieSet = readCookie("purchased_click");
		if(!isCookieSet){
			// creating cookie to use in confirmation page to handle refresh scenarion
			createCookie('purchased_click', 'yes', 2);
		}
	});			

<?php } ?>

<?php if (is_checkout() && is_wc_endpoint_url('order-received')){ ?>

	function createCookie(name, value, days){
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString();
		}
		else var expires = "";               

		document.cookie = name + "=" + value + expires + "; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}


	function GTMthankyouPageStep(){

		var itemsArray = [];

			<?php
			$split_uri = explode('/',$_SERVER['REQUEST_URI']);
			$order_id = $split_uri[3];
			$order = wc_get_order( $order_id );
			$order_total = 	$order->get_total();



			foreach ( $order->get_items() as $item_id => $item ) {
			
				$name = $item->get_name();
				$product_id = $item->get_product_id();
				$price = $item->get_total();
				$quantity = $item->get_quantity();
				
				$giftMeta = $item->get_meta( 'wcsg_recipient', true );

				if($giftMeta){
					$category = "Gift";
				}else{
					$category = "Subscription";
				}
				
			
			?>
				// store products data in array
				itemsArray.push(
					
					{                            
						'name'		: '<?php echo $name; ?>',              
						'id'		: '<?php echo $product_id; ?>',
						'price'		: '<?php echo $price; ?>',
						'quantity'	: '<?php echo $quantity; ?>',
						'category'	: '<?php echo $category; ?>',
						'coupon'	: ''
					}
				);
			
			<?php } ?>

	
		// GTM enhance-ecommerce step 5 capture products data on thank you page
			dataLayer.push({
				'event': 'EE_Purchase',
				'ecommerce': {
					'purchase': {
						'actionField': {
							'list'		: 'On-Demand Classes',
							'id'		: '<?php echo $order_id; ?>',
							'revenue'	: '<?php echo $order_total; ?>',
							'coupon'	: '',	
						},
					'products': [itemsArray]
				}
			  }
			});

			// GTM   step 4 capture products on thank you
			dataLayer.push({
				'event': 'Checkout_Purchase',
				'ecommerce': {
					'checkout': {
						'purchase': {
							'actionField': {
								'step': 4,
								'list'		: 'On-Demand Classes',
								'id'		: '<?php echo $order_id; ?>',
								'revenue'	: '<?php echo $order_total; ?>',
								'coupon'	: '',
								},
							'products': [itemsArray]	
						}						
					}
				}
			});

		}


	jQuery(document).ready(function(){
		
		// check if cookie is set, as we have set in checkout page load 
		isCookieSet = readCookie("purchased_click");

		// if cookie then run the GTM and enhance ecommerce otherwise means page is access directly or refresh
		if(isCookieSet){

			GTMthankyouPageStep();
		}
		
		eraseCookie("purchased_click");
	});	



	
	
<?php } ?>
</script>

<!-- ----------- GTM work end   -----------  -->


<!-- ------- Mailchimp work start   -------  -->

<script type="text/javascript">

 // ecommerce mailchip work starts here
 
 // mailchip work starts here

//jQuery(document).ready(function(){
	jQuery(window).load(function() {
		setTimeout(function() {
		<?php
	
	
		if (isset($_GET['mc_cid'])){
			$campaignID = $_GET['mc_cid'];
	?>
			var data = {
				'action': 'store_campaign_id',
				'campaignID': '<?php echo $campaignID;?>',			
			};
			var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
			jQuery.post(ajaxurl, data, function (response) {
				//console.log(response);
			});

	<?php
		}
	
	?>
	
         
    }, 3000);
	});
    <?php
	
	

    if(is_page(1851)){
		global $current_user;
		
        if (isset($_SESSION['mc_cid'])){
			
			$user_id = (string)$current_user->ID;
			$email_address = (string) $current_user->user_email;
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
			//jQuery(document).ready(function(){
			jQuery(window).load(function() {
				
				var transection_id 		= 	jQuery('#transection_id').text();
				var transection_amount 	= 	parseInt(jQuery('#transection_amount').text().trim()).toFixed(2);
				
				var discount_code = "";
				discount_code 		= 	jQuery('#discount_code').text();
				
				var data1 = {
					'action': 'mailchimp_add_store_customer',
					'email_address': '<?php echo $email_address;?>',
					'user_id': '<?php echo $user_id;?>',
				};
				
				var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data1,
					// async:false
				}).done(function(res_user_id) {
                
				//alert(user_id);
				var data = {
					'action': 'orders_mailchimp',
					'user_id': res_user_id,
					'email_address': '<?php echo $email_address;?>',
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
jQuery(document).ready(function($) { 
var delay = 100; setTimeout(function() { 
$('.elementor-tab-title').removeClass('elementor-active');
 $('.elementor-tab-content').css('display', 'none'); }, delay); 
}); 
</script>


<!-- ----------- Mailchimp work and other previous code end   -----------  -->


<?php
/* *** Woocommerce gifting customization ***** */
	
	
	if(is_cart() || is_checkout()){
		?> 
		
		<script>
			jQuery(document).ready(function($){
				
				// on change click unclick gift checkbox
				$(document).on( 'change', '.woocommerce_subscription_gifting_checkbox[type="checkbox"]',function( e, eventContext ) {
					if ($(this).is(':checked')) {
						
						// make email field required
						$(this).closest( 'fieldset' ).find( '.recipient_email' ).prop('required',true);
					} else {
						$(this).closest( 'fieldset' ).find( '.recipient_email' ).prop('required',false);

						var recipient_email_element = $(this).closest( 'fieldset' ).find( '.recipient_email' );
						var recipient_name_element = $(this).closest( 'fieldset' ).find( '.recipient_name' );
						var recipient_message_element = $(this).closest( 'fieldset' ).find( '.recipient_message' );
						
						// on uncheck gift checkbox clear all fields
						recipient_email_element.val('');
						recipient_name_element.val('');
						recipient_message_element.val('');
		
						// trigger validation for disabled checkbox in case user already subscribed		
						setTimeout(function(){
							doCartAjax();
						}, 1000);
						
					}
				});
			});
		</script>

		<!-- Subscription gifting validation, if user already subscribed to same product then restrict user to only gift trasaction -->
		<script>
				
			(function(){
				// during page load imddediatlly disable gift checkboxes till all related functionlity setup  
				jQuery('.woocommerce_subscription_gifting_checkbox[type="checkbox"]').prop('disabled', true);
			})();

			jQuery( document ).ready(function() {
				
				// on cart page load disable update cart button by default 
				jQuery("button[name = 'update_cart']").attr( 'disabled', true );
				
				// trigger validation for disabled checkbox in case user already subscribed
				setTimeout(function(){
					doCartAjax();
				}, 1000);

			});
		
			// cart page when click on update button
			jQuery('body').on("click", "button[name = 'update_cart']", function(e){
				
				
				// condition applied due to multiple quantity issue on cart page
				if(e.which) {
					//Actually clicked
					// re-trigger update to get actual quantity price
					setTimeout(function(){
						jQuery("button[name = 'update_cart']").attr( 'disabled', false );
						jQuery("button[name = 'update_cart']").trigger('click');
					}, 4000);
				}
				else {
					//Triggered by code
				}
				setTimeout(function(){
					doCartAjax();
				}, 1000);
			});
			
			
			jQuery('body').on('change', '.recipient_email', function(){
				console.log("recipient_email changed");
				jQuery("button[name = 'update_cart']").trigger('click');
				
				setTimeout(function(){
					doCartAjax();
				}, 1000);	
			});

			jQuery('body').on('change', '.recipient_name', function(){
				console.log("recipient_name changed");
				jQuery("button[name = 'update_cart']").trigger('click');
				setTimeout(function(){
					doCartAjax();
				}, 1000);
			});

			jQuery('body').on('change', '.recipient_message', function(){
				console.log("recipient_message changed");
				jQuery("button[name = 'update_cart']").trigger('click');
				setTimeout(function(){
					doCartAjax();
				}, 1000);
			});	
			
		</script>

		
		<script>
			// Method use to validate if current user has active subscriptions, if so then restrict that product just as a gift
			function doCartAjax(){
				
				// disable gift checkboxes till ajax complete
				jQuery('.woocommerce_subscription_gifting_checkbox[type="checkbox"]').prop('disabled', true);
				var data = {
					'action': 'cart_page_restrict_user_to_gift_only',
				};
				var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
				jQuery.post(ajaxurl, data, function (response) {
					
					// enable gift checkboxes that disabled for processing
					jQuery('.woocommerce_subscription_gifting_checkbox[type="checkbox"]').prop('disabled', false);
					
					if(response){
						
						// get the ids of product which user has already subscribed
						producsData = JSON.parse(response);

						for (let i = 0; i < producsData.length; i++){
							
							// force gift checkbox checked because user already has subscription to this product		
							if(!jQuery('#gifting_'+producsData[i].product_key+'_option').is(':checked'))
							
							// subscribed product validation starts from product detail page but in-case its not checked yet then do it now 
							jQuery('#gifting_'+producsData[i].product_key+'_option').trigger('click');
					
							// diabled checkbox so user can not un-check and process will go with gift option only for this products
							document.getElementById('gifting_'+producsData[i].product_key+'_option').disabled = true;
							
							// make email field required
							jQuery('#recipient_email\\['+producsData[i].product_key+'\\]').prop('required',true);
							//sconsole.log(jQuery('#recipient_email\\['+producsData[i].product_key+'\\]').val());

						}
					}
					

				});
			}
		</script>
		
		
		<script>
		
			jQuery(document).on('input', function() { 
				if (jQuery('.woocommerce-error')[0]) {
					jQuery('ul.woocommerce-error').remove();
				}
			});
			
			// function for email validation
			function isEmail(email) {
				var regex = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
				return regex.test(email);
			}
			
			//Validation for if gift checkbox is checked and recipient email is empty or invalid, used in checkout page
			
			// Checkout page on click order button
			jQuery(document).on('click','#place_order', function () {
				
				// check if there is any error on page 
				if (jQuery('.woocommerce-error')[0]) {
					alert('Please resolve all errors before submit!');
					return false;
				}
				
				// get all checkboxes
				var customChekbox = document.getElementsByName('gift_checkboxes[]');
				for (var i = 0; i < customChekbox.length; i++) {
					if (customChekbox[i].checked) {
						var checkbox_id = customChekbox[i].id;
						
						// checkbox_id is like gifting_f1e5284674fd1e360873c29337ebe2d7_option
						var newId = checkbox_id.slice(8,-7);
						
						// now newId is like f1e5284674fd1e360873c29337ebe2d7
						var giftEmail = jQuery('#recipient_email\\['+newId+'\\]').val();
						
						if(giftEmail){
								
							var isValidMail = isEmail(giftEmail);
							if(!isValidMail){
								alert('Please type a valid recipient email!');
								return false;
							}
						}else{
							alert('Please add recipient email!');
							return false;
						}
						
					}
				}
			});
		</script>

		
			
		<?php
	}

	

/* *** Woocommerce gifting customization ***** */

// hide my-classes link from menu if user is not login
if(!is_user_logged_in()){
	?>
	<style>li.c-my-class{display: none !important;}</style>
	<?php
}

?>

<!-- Fix for browser back button press issue -->
<?php if (is_product() || is_cart()) { ?>
	<script>
	
		if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
			location.reload();
		}
		
	</script>
<?php } ?>
<script>
	
	
// 	jQuery(document).ready(function($) { 
// 	if ($(window).width() < 767) {
// 		$( window ).load(function() {
//  				//$('.elementor-tab-content').removeClass('hideme');
//  				$('.elementor-tab-mobile-title').removeClass('elementor-tab-title');
//  				$('.elementor-tab-mobile-title, .elementor-tab-content').removeAttr('data-tab');
// 			});
// 	}
	
	
// });

jQuery(document).ready(function($) { 
	$('.elementor-accordion').on('click', '.elementor-tab-title', function(e){
  e.preventDefault(); //prevent default action of a button 
  $(this).next('.elementor-tab-content').animate(':animated'); 
});

	
	if ($(window).width() < 767) {
// 		$( window ).load(function() {
			
// 						if( $('#vNavTabsPizza').length )         // use this if you are using id to check
// 					{


//  				//$('.elementor-tab-content').removeClass('hideme');
//  				$('.elementor-tab-mobile-title').removeClass('elementor-tab-title');
//  				$('.elementor-tab-mobile-title, .elementor-tab-content').removeAttr('data-tab');
// 						}
// 			});
	
	}
	
	$('.elementor-tab-mobile-title').click(function() {

	  if ($(this).hasClass('active')) {    
	    $(this).removeClass('active').next().css({"display": "none"});
	  } else {
		  $('.elementor-tab-content').css({"display": "none"});
		   $('.elementor-tab-mobile-title').removeClass('active');
	    $(this).addClass('active').next().css({"display": "block"});
	  }
	});

	});
	

	



	
	


		</script>
</body>
</html>
