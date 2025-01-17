<?php
/**
 * Virtual Event Link Button.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-virtual/components/link-button.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 1.1.2
 *
 * @var string $url   The URL of the link button.
 * @var string $label The label of the link button.
 * @var array  $attrs Associative array of attributes of the link button.
 */

?>
<div style="border: 1px solid #fff; padding: 0 1rem; border-radius: 5px;">
<h3 style="color: white; margin: 0; padding-top: 1.75rem; padding-bottom: 1rem; border-bottom: 1px solid; width: 100%;">Register Via ZOOM</h3>
<a
	href="<?php echo esc_url( $url ); ?>"
	class="tribe-events-virtual-link-button"
	<?php tribe_attributes( $attrs ); ?>
>
	<?php $this->template( 'v2/components/icons/play', [ 'classes' => [ 'tribe-events-virtual-link-button__icon' ] ] ); ?>
	<span class="tribe-events-virtual-link-button__label">
		<?php echo esc_html( $label ); ?>
	</span>
</a>
</div>
