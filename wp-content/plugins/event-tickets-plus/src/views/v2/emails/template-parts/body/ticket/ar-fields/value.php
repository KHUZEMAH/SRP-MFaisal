<?php
/**
 * Event Tickets Emails: Main template > Body > Ticket > Attendee Registration Field Value.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets-plus/v2/emails/template-parts/body/ticket/ar-fields/value.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/tickets-emails-tpl Help article for Tickets Emails template files.
 *
 * @since 5.6.10
 *
 * @version 5.6.10
 */

if ( empty( $value ) ) {
	return;
}

?>
<div class="tec-tickets__email-table-content-ticket-attendee-registration-fields-value">
	<?php esc_html_e( $value ); ?>
</div>
