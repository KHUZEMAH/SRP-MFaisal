<?php
/**
 * Event Tickets Emails: Main template > Body > Ticket > Attendee Registration Field Key.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets-plus/v2/emails/template-parts/body/ticket/ar-fields/key.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/tickets-emails-tpl Help article for Tickets Emails template files.
 *
 * @since 5.6.10
 *
 * @version 5.6.10
 */

if ( empty( $key ) ) {
	return;
}

?>
<div class="tec-tickets__email-table-content-ticket-attendee-registration-fields-key">
	<?php esc_html_e( $key ); ?>
</div>
