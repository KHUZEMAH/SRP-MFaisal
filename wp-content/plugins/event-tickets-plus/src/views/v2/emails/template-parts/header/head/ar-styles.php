<?php
/**
 * Event Tickets Emails: Main template > Header > Head > Attendee Registration Styles.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets-plus/v2/emails/template-parts/header/head/ar-styles.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/tickets-emails-tpl Help article for Tickets Emails template files.
 *
 * @version 5.6.10
 *
 * @since 5.6.10
 *
 * @var Tribe_Template  $this  Current template object.
 * @var string $header_bg_color   Hex value for the header background color.
 * @var string $header_text_color Hex value for the header text color
 * @var string $ticket_bg_color   Hex value for the ticket background color.
 * @var string $ticket_text_color Hex value for the ticket text color.
 */

?>
<style type="text/css">
	.tec-tickets__email-table-content-ticket-attendee-registration-fields-container,
	div.tec-tickets__email-table-content-ticket-attendee-registration-fields-container {
		clear: both;
		color: <?php echo esc_attr( $ticket_text_color ); ?>;
		display: block;
		padding: 15px 0 0 0;
	}

	.tec-tickets__email-table-content-ticket-attendee-registration-fields-table,
	table.tec-tickets__email-table-content-ticket-attendee-registration-fields-table {
		border-top: 1px solid <?php echo esc_attr( $ticket_text_color ); ?>;
	}

	.tec-tickets__email-table-content-ticket-attendee-registration-fields-table-data,
	td.tec-tickets__email-table-content-ticket-attendee-registration-fields-table-data {
		padding-top: 15px;
		width: 50%;
	}

	.tec-tickets__email-table-content-ticket-attendee-registration-fields-key,
	div.tec-tickets__email-table-content-ticket-attendee-registration-fields-key {
		font-size: 16px;
		font-weight: 400;
	}

	.tec-tickets__email-table-content-ticket-attendee-registration-fields-value,
	div.tec-tickets__email-table-content-ticket-attendee-registration-fields-value {
		font-size: 16px;
		font-weight: 700;
	}
</style>
