<?php
use \Tribe\Tickets\Admin\Settings as ET_Settings;

/**
 * Adds settings relating directly to handling of ticket QR codes to the
 * Events ‣ Settings ‣ Tickets admin screen.
 *
 * @since 4.7.5
 */
class Tribe__Tickets_Plus__QR__Settings {

	/**
	 * Hook into Event Tickets/Event Tickets Plus.
	 *
	 * @since 4.7.5
	 */
	public function hook() {
		add_filter( 'tec_tickets_plus_integrations_tab_fields', [ $this, 'add_settings' ], 15 );
		add_action( 'wp_ajax_tribe_tickets_plus_generate_api_key', [ $this, 'generate_key' ] );
		add_action( 'admin_init', [ $this, 'maybe_display_qr_dependency_notice' ] );
	}

	/**
	 * Append global Event Tickets Plus settings section to tickets settings tab
	 *
	 * @since 4.7.5
	 *
	 * @param array $settings_fields
	 *
	 * @return array
	 */
	public function add_settings( array $settings_fields ) {
		$extra_settings = $this->additional_settings();

		return Tribe__Main::array_insert_before_key( 'tribe-form-content-end', $settings_fields, $extra_settings );
	}

	/**
	 * Adds the general ticket QR code settings to the Events ‣ Settings ‣ Tickets screen.
	 *
	 * @since 4.7.5
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function additional_settings( array $settings = [] ) {
		$ticket_label_plural_lower = esc_html( tribe_get_ticket_label_plural_lowercase( 'check_in_app' ) );

		$qr_settings = [
			'tickets-plus-qr-options-title'            => [
				'type' => 'html',
				'html' => '<h3>' . esc_html__( 'Event Tickets Plus App', 'event-tickets-plus' ) . '</h3>',
			],
			'tickets-plus-qr-options-intro'            => [
				'type' => 'html',
				'html' => $this->get_intro_html(),
			],
			'tickets-plus-qr-options-app-banner'       => [
				'type' => 'html',
				'html' => $this->get_app_banner(),
			],
			'tickets-enable-qr-codes'                  => [
				'type'            => 'toggle',
				'label'           => esc_html__( 'Use QR Codes', 'event-tickets-plus' ),
				'tooltip'         => esc_html(
					sprintf(
						// Translators: %s: 'tickets' label (plural, lowercase).
						__( 'Include QR codes in %s emails (required for Event Tickets Plus App)', 'event-tickets-plus' ),
						$ticket_label_plural_lower
					)
				),
				'default'         => true,
				'validation_type' => 'boolean',
			],
		];

		if ( tec_tickets_tec_events_is_active() ) {
			$enabled_post_types          = (array) tribe_get_option( 'ticket-enabled-post-types', [] );
			$events_label_singular_lower = tribe_get_event_label_singular_lowercase( 'check_in_app' );
			if ( in_array( Tribe__Events__Main::POSTTYPE, $enabled_post_types ) ) {
				$qr_settings['tickets-plus-qr-check-in-events-happening-now'] = [
					'type'            => 'toggle',
					'label'           => esc_html__( 'Restrict Check-In', 'event-tickets-plus' ),
					'tooltip'         => esc_html(
						sprintf(
							// Translators: %1$s: 'tickets' label (plural, lowercase). %2$s: 'event' label (singular, lowercase).
							__( 'Only allow check-in of QR %1$s during the date and time of the %2$s, including the check-in window below.', 'event-tickets-plus' ),
							$ticket_label_plural_lower,
							$events_label_singular_lower
						)
					),
					'default'         => false,
					'validation_type' => 'boolean',
				];

				$qr_settings['tickets-plus-qr-check-in-events-happening-now-time-buffer'] = [
					'type'            => 'text',
					'label'           => esc_html__( 'Check-in Window', 'event-tickets-plus' ),
					'tooltip'         => esc_html(
						sprintf(
							// Translators: %1$s: 'event' label (singular, lowercase).
							__( 'minutes before the %1$s', 'event-tickets-plus' ),
							$events_label_singular_lower
						)
					),
					'validation_type' => 'int',
					'size'            => 'small',
					'default'         => '0',
					'can_be_empty'    => true,
				];
			}
		}

		return Tribe__Main::array_insert_before_key(
			'tribe-form-content-end',
			$settings,
			$qr_settings
		);
	}

	/**
	 * Generate QR API Key
	 *
	 * @since 4.7.5
	 *
	 */
	public function generate_key() {

		$confirm = tribe_get_request_var( 'confirm', false );

		if ( ! $confirm || ! wp_verify_nonce( $confirm, 'generate_qr_nonce' ) ) {
			wp_send_json_error( __( 'Permission Error', 'event-tickets-plus' ) );
		}

		$api_key = $this->generate_new_api_key();

		if ( empty( $api_key ) ) {
			wp_send_json_error( __( 'The QR API key was not generated, please try again.', 'event-tickets-plus' ) );
		}

		$qr_src = $this->get_connection_qr_src( $api_key );

		if ( empty( $qr_src ) || is_wp_error( $qr_src ) ) {
			wp_send_json_error( __( 'The QR API key was generated, but generating the connection QR Code image failed.', 'event-tickets-plus' ) );
		}

		Tribe__Settings_Manager::set_option( 'tickets-plus-qr-options-api-key', $api_key );

		$data = [
			'msg'    => __( 'QR API Key Generated', 'event-tickets-plus' ),
			'key'    => $api_key,
			'qr_src' => $qr_src,
		];

		wp_send_json_success( $data );

	}

	/**
	 * Generate a random number for the QR API Key
	 *
	 * @since 4.7.5
	 *
	 * @return int $random a random number
	 */
	protected function generate_random_int() {
		$random = base_convert( mt_rand( 0, mt_getrandmax() ), 10, 32 );

		/**
		 * Filters the random number generated for QR API key
		 *
		 * @since 4.7.5
		 *
		 * @param int $random a random number
		 */
		return apply_filters( 'tribe_tickets_plus_qr_api_random_int', $random );
	}

	/**
	 * Generate a hash key for QR API.
	 *
	 * @since 4.7.5
	 *
	 * @param int $random The random number.
	 *
	 * @return string The QR API key.
	 */
	protected function generate_qr_api_hash( $random ) {
		$api_key = substr( md5( $random ), 0, 8 );

		/**
		 * Filters the generated hash key for QR API.
		 *
		 * @since 4.7.5
		 *
		 * @param string $api_key a API key string.
		 */
		return apply_filters( 'tribe_tickets_plus_qr_api_hash', $api_key );
	}

	/**
	 * Generate a random API key.
	 *
	 * @since 5.2.5
	 *
	 * @return string The QR API key.
	 */
	public function generate_new_api_key() {
		$random  = $this->generate_random_int();
		return $this->generate_qr_api_hash( $random );
	}

	/**
	 * Add an dismissible admin notice if required QR dependencies are missing.
	 *
	 * @since 5.6.2
	 *
	 * @return void
	 */
	public function maybe_display_qr_dependency_notice() : void {
		$enabled = tribe_get_option( 'tickets-enable-qr-codes', true );

		if ( ! $enabled || $this->dependencies_available() ) {
			return;
		}

		tribe_notice(
			'tec-tickets-plus-qr-dependency-notice',
			[ $this, 'get_dependency_notice' ],
			[
				'type'     => 'warning',
				'dismiss'  => 1,
				'wrap'     => 'p',
			],
			[ $this, 'should_display_notice' ]
		);
	}

	/**
	 * Return the dependency notice content.
	 *
	 * @since 5.6.2
	 *
	 * @return string
	 */
	public function get_dependency_notice() : string {
		$html  = '<h2>' . esc_html__( 'QR codes for tickets not available.', '' ) . '</h2>';
		$html .= esc_html__( 'In order to have QR codes for your tickets you will need to have both the `php_gd2` and `gzuncompress` PHP extensions installed on your server. Please contact your hosting provider.', 'event-tickets-plus' );
		$html .= ' <a target="_blank" href="https://evnt.is/XXXX">' . esc_html__( 'Learn more.', 'event-tickets-plus' ) . '</a>';

		return $html;
	}

	/**
	 * Determines the pages where the dependency notice should be visible.
	 *
	 * @since 5.6.2
	 *
	 * @return bool
	 */
	public function should_display_notice() : bool {

		$active_page = tribe_get_request_var( 'page' );

		if ( $active_page ) {
			$valid_pages = [
				'tickets-attendees',
				'tickets-commerce-orders',
				'edd-orders',
				'tickets-orders',
				'tec-tickets',
				'tec-tickets-help',
				'tec-tickets-troubleshooting',
				'tec-tickets-settings',
			];

			if ( in_array( $active_page, $valid_pages, true ) ) {
				return true;
			}
		}

		if ( 'ticket-meta-fieldset' === tribe_get_request_var( 'post_type' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get the QR setting intro html content.
	 *
	 * @since 5.6.2
	 *
	 * @return string
	 */
	public function get_intro_html() : string {

		if ( $this->dependencies_available() ) {
			$app_store     = sprintf( '<a href="https://evnt.is/etp-app-apple-store" target="_blank" rel="noopener noreferrer">%s</a>', esc_html__( 'App Store', 'event-tickets-plus' ) );
			$play_store    = sprintf( '<a href="https://evnt.is/etp-app-google-play" target="_blank" rel="noopener noreferrer">%s</a>', esc_html__( 'Google Play Store', 'event-tickets-plus' ) );
			$knowledgebase = sprintf( '<a href="https://evnt.is/event-tickets-qr-support" target="_blank" rel="noopener noreferrer">%s</a>', esc_html__( 'Knowledgebase', 'event-tickets-plus' ) );
			return '<p>'
			       . sprintf(
				         esc_html__(
					         'Our Event Tickets Plus app makes on-site ticket validation and attendee management a breeze. Available for mobile devices through the iOS %1$s and %2$s
store. Learn more about the app in our %3$s.', 'event-tickets-plus'
				         ),
						$app_store,
						$play_store,
						$knowledgebase
			         )
			       . '</p>';
		}

		return '<div id="modern-tribe-info" style="border-left: 3px solid #d63638;">' . $this->get_dependency_notice() . '</div>';
	}

	/**
	 * Check if all required dependencies are available.
	 *
	 * @since 5.6.2
	 *
	 * @return bool
	 */
	public function dependencies_available() : bool {
		return function_exists( 'gzuncompress' ) && function_exists( 'ImageCreate' );
	}

	/**
	 * Get the saved API key string.
	 *
	 * @since 5.6.2
	 *
	 * @return string
	 */
	public function get_api_key() : string {
		$api_key = tribe_get_option( 'tickets-plus-qr-options-api-key', '' );

		if ( empty( $api_key ) ) {
			$api_key = $this->generate_new_api_key();
			tribe_update_option( 'tickets-plus-qr-options-api-key', $api_key );
		}

		return $api_key;
	}

	/**
	 * Get the Event Tickets Plus App connection details banner.
	 *
	 * @since 5.6.2
	 *
	 * @return false|string Settings banner html.
	 */
	private function get_app_banner() : string {
		$api_key = $this->get_api_key();
		$qr_src  = $this->get_connection_qr_src( $api_key );

		if ( is_wp_error( $qr_src ) ) {
			return false;
		}

		$context = [
			'site_url' => site_url(),
			'api_key'  => $api_key,
			'qr_src'   => $qr_src,
		];

		/** @var Tribe__Tickets__Admin__Views $admin_views */
		$admin_views = tribe( 'tickets.admin.views' );
		return $admin_views->template( 'settings/etp-app-banner', $context, false );
	}

	/**
	 * Get the connection QR code image data src.
	 *
	 * @since 5.6.2
	 *
	 * @param string $api_key The API key value.
	 *
	 * @return string|WP_Error The data url to the QR code image or WP_Error.
	 */
	private function get_connection_qr_src( string $api_key ) {

		if ( ! $this->dependencies_available() ) {
			return new WP_Error( 'tec-tickets-plus-qr-code-dependency-missing', __( 'Missing required dependencies for generating QR codes' ), [ $api_key ] );
		}

		if ( ! class_exists( 'QRencode' ) ) {
			include_once( EVENT_TICKETS_PLUS_DIR . '/vendor/phpqrcode/qrlib.php' );
		}

		$data = json_encode( [
			'url'     => site_url(),
			'api_key' => $api_key,
			'tec'     => tec_tickets_tec_events_is_active(),
		] );

		ob_start();
		QRcode::png( $data );
		$src = base64_encode( ob_get_clean() );

		return "data:image/png;base64," . $src;
	}
}
