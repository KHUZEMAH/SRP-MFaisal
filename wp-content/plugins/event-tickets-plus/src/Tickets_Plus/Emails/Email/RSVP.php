<?php
/**
 * Class RSVP.
 *
 * @since   5.6.10
 *
 * @package TEC\Tickets_Plus\Emails
 */

namespace TEC\Tickets_Plus\Emails\Email;

use TEC\Tickets\Emails\Email\RSVP as RSVP_Email;
use TEC\Tickets\Emails\Email\Ticket as Ticket_Email;

/**
 * Class Ticket.
 *
 * @since   5.6.10
 *
 * @package TEC\Tickets_Plus\Emails
 */
class RSVP {
	/**
	 * The option key for the QR codes.
	 *
	 * @since 5.6.10
	 *
	 * @var string
	 */
	public static $option_ticket_include_qr_codes = 'tec-tickets-emails-rsvp-include-qr-codes';

	/**
	 * The option key for the attendee registration fields.
	 *
	 * @since 5.6.10
	 *
	 * @var string
	 */
	public static $option_ticket_include_ar_fields = 'tec-tickets-emails-rsvp-include-ar-fields';

	/**
	 * Add settings to Tickets Emails Ticket template settings page.
	 *
	 * @since 5.6.10
	 *
	 * @param array $fields Array of settings fields from Tickets Emails.
	 *
	 * @return array $fields Modified array of settings fields.
	 */
	public function filter_tec_tickets_emails_rsvp_settings( $fields ): array {

		$ticket_label_plural_lower                       = esc_html( tribe_get_ticket_label_plural_lowercase( 'check_in_app' ) );
		$fields[ self::$option_ticket_include_qr_codes ] = [
			'type'            => 'toggle',
			'label'           => esc_html__( 'Include QR Codes', 'event-tickets-plus' ),
			'tooltip'         => esc_html(
				sprintf(
					// Translators: %1$s: 'tickets' label (plural, lowercase).
					__( 'Include QR codes in %1$s emails (required for Event Tickets Plus App)', 'event-tickets-plus' ),
					$ticket_label_plural_lower
				)
			),
			'default'         => true,
			'validation_type' => 'boolean',
		];

		$fields[ self::$option_ticket_include_ar_fields ] = [
			'type'            => 'toggle',
			'label'           => esc_html__( 'Include Attendee Registration Fields', 'event-tickets-plus' ),
			'tooltip'         => esc_html(
				sprintf(
					// Translators: %1$s: 'tickets' label (plural, lowercase).
					__( 'Include Attendee Registration fields in your %1$s emails', 'event-tickets-plus' ),
					$ticket_label_plural_lower
				)
			),
			'default'         => true,
			'validation_type' => 'boolean',
		];

		return $fields;
	}

	/**
	 * Maybe include Attendee Registration Fields.
	 *
	 * @since 5.6.10
	 *
	 * @param \Tribe__Template $et_template Event Tickets template object.
	 * @return void
	 */
	public function maybe_include_ar_fields( $et_template ) {

		if ( ! $this->is_ar_fields_active( $et_template ) ) {
			return;
		}

		$args = $et_template->get_local_values();

		/** @var \Tribe__Tickets_Plus__Template $template */
		$template = tribe( 'tickets-plus.template' );

		/** @var \Tribe__Tickets_Plus__Meta $meta */
		$meta          = tribe( 'tickets-plus.meta' );
		$attendee_id   = $args['ticket']['attendee_id'];
		$ticket_id     = $args['ticket']['product_id'];
		$attendee_meta = $meta->get_attendee_meta_values( $ticket_id, $attendee_id );

		$args['ticket']['attendee_meta'] = ! empty( $attendee_meta ) ? $attendee_meta : [];

		$template->template( 'v2/emails/template-parts/body/ticket/ar-fields', $args, true );
	}

	/**
	 * Maybe include Attendee Registration Fields Styles.
	 *
	 * @since 5.6.10
	 *
	 * @param \Tribe__Template $et_template Event Tickets template object.
	 *
	 * @return void
	 */
	public function maybe_include_ar_fields_styles( $et_template ) {
		if ( ! $this->is_ar_fields_active( $et_template ) ) {
			return;
		}

		$args = $et_template->get_local_values();

		/** @var \Tribe__Tickets_Plus__Template $template */
		$template = tribe( 'tickets-plus.template' );

		$template->template( 'v2/emails/template-parts/header/head/ar-styles', $args, true );
	}

	/**
	 * Determines if Attendee Registrations Fields for Emails is Active.
	 *
	 * @since 5.6.10
	 *
	 * @param \Tribe__Template $et_template Event Tickets template object.
	 *
	 * return boolean
	 */
	public function is_ar_fields_active( $et_template ) {
		$rsvp_class = $email_class = tribe( RSVP_Email::class );
		if ( tribe_is_truthy( tribe_get_option( $email_class->get_option_key( 'use-ticket-email' ), true ) ) ) {
			$email_class = tribe( Ticket_Email::class );
		}

		// Bail early if the email class is not enabled.
		if ( ! $email_class->is_enabled() ) {
			return false;
		}

		if ( ! tribe_is_truthy( tribe_get_option( self::$option_ticket_include_ar_fields, true ) ) ) {
			return false;
		}

		$args = $et_template->get_local_values();
		if ( ! empty( $args['is_preview'] ) && tribe_is_truthy( $args['is_preview'] ) ) {
			return false;
		}

		if (
			! empty( $args['email'] )
			&& $args['email']->get_id() !== $rsvp_class->get_id()
		) {
			return false;
		}

		return true;
	}

}
