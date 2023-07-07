<?php
/**
 * Event Tickets Emails: Main template > Body > Ticket > Attendee Registration Field Key.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets-plus/emails/template-parts/body/ticket/ar-fields/key.php
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
<div style="font-size: 16px; font-weight: 400;">
	<?php esc_html_e( $key ); ?>
</div>
