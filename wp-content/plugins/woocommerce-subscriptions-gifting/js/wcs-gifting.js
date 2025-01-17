jQuery(document).ready(function($){
	$(document).on( 'change', '.woocommerce_subscription_gifting_checkbox[type="checkbox"]',function( e, eventContext ) {
		if ($(this).is(':checked')) {
			$(this).closest( 'fieldset' ).find( '.wcsg_add_recipient_fields' ).slideDown( 250, function() {
				if ( 'undefined' === typeof( eventContext ) || 'pageload' != eventContext ) {
					$( this ).find( '.recipient_email' ).focus();
				}
			} );
			$(this).closest( 'fieldset' ).find( '.recipient_email' ).prop('required',true);

		} else {
			$(this).closest( 'fieldset' ).find( '.wcsg_add_recipient_fields' ).slideUp( 250 );
			$(this).closest( 'fieldset' ).find( '.recipient_email' ).prop('required',false);

			var recipient_email_element = $(this).closest( 'fieldset' ).find( '.recipient_email' );
			var recipient_name_element = $(this).closest( 'fieldset' ).find( '.recipient_name' );
			var recipient_message_element = $(this).closest( 'fieldset' ).find( '.recipient_message' );
			
			recipient_email_element.val('');
			recipient_name_element.val('');
			recipient_message_element.val('');

			if ( $( 'form.checkout' ).length !== 0 ) {
				// Trigger the event to update the checkout after the recipient field has been cleared
				setTimeout(function(){
					update_checkout();
				}, 0000);
			}
		}
	});

	/**
	 * Handles recipient e-mail inputs on the cart page.
	 */
	/*var cart = {
		init: function() {
			$( document ).on( 'submit', 'div.woocommerce > form', this.set_update_cart_as_clicked );

			// We need to make sure our callback is hooked before WC's.
			var handlers = $._data( document, "events" );
			if ( 'undefined' !== typeof handlers['submit'] ) {
				handlers['submit'].unshift( handlers['submit'].pop() );
			}
		},

		set_update_cart_as_clicked: function( evt ) {
			var $form = $( evt.target );
			var $submit = $( document.activeElement );

			// If we're not on the cart page exit.
			if ( 0 === $form.find( 'table.shop_table.cart' ).length ) {
				return;
			}

			// If the recipient email element is the active element, the clicked button is the update cart button.
			if ( $submit.is( 'input.recipient_email' ) ) {
				$( ':input[type="submit"][name="update_cart"]' ).attr( 'clicked', 'true' );
			}
		}
	};
	cart.init();*/

	/*******************************************
	 * Update checkout on input changed events *
	 *******************************************/
	var update_timer;

	$(document).on( 'change', '.recipient_email, .recipient_name, .recipient_message ', function() {

		if ( $( 'form.checkout' ).length === 0 ) {
			return;
		}

		// Update the checkout so recurring carts are updated
		if ( $( this ).hasClass( 'wcsg_needs_update' ) ) {
			setTimeout(function(){
					update_checkout();
			}, 0000);
		}
	});

	$(document).on( 'keyup', '.recipient_email, .recipient_name, .recipient_message ', function( e ) {
		var code = e.keyCode || e.which || 0;

		if ( $( 'form.checkout' ).length === 0 || code === 9 ) {
			return true;
		}

		var current_recipient  = $( this ).val();
		var original_recipient = $( this ).attr( 'data-recipient' );
		
		//var current_recipient_name  = $( this ).val();
		//var original_recipient_name = $( this ).attr( 'data-recipient' );
		
		//var current_recipient_message  = $( this ).val();
		//var original_recipient_message = $( this ).attr( 'data-recipient' );
		

		reset_checkout_update_timer();

		// If the recipient has changed since last load, mark the element as needing an update
		if ( current_recipient !== original_recipient ) {
			$( this ).addClass( 'wcsg_needs_update' );
			update_timer = setTimeout( update_checkout, '1500' );
		} else {
			$( this ).removeClass( 'wcsg_needs_update' );
		}
	});

	function update_checkout() {
		reset_checkout_update_timer();
		
		if ( $( '.recipient_email' ).hasClass( 'wcsg_needs_update' ) ) {
			$( '.recipient_email' ).removeClass( 'wcsg_needs_update' );
		}
	
		if ( $( '.recipient_name' ).hasClass( 'wcsg_needs_update' ) ) {
			$( '.recipient_name' ).removeClass( 'wcsg_needs_update' );
		}

		if ( $( '.recipient_message' ).hasClass( 'wcsg_needs_update' ) ) {
			$( '.recipient_message' ).removeClass( 'wcsg_needs_update' );
		}
		
		$( document.body ).trigger( 'update_checkout' );
	}

	function reset_checkout_update_timer() {
		clearTimeout( update_timer );
	}

	// Triggers
	$( '.woocommerce_subscription_gifting_checkbox[type="checkbox"]' ).trigger( 'change', 'pageload' );
});
