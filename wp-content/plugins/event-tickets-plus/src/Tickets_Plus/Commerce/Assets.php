<?php
/**
 * Handles registering and setup for assets on Tickets Plus Commerce.
 *
 * @since   5.3.0
 *
 * @package TEC\Tickets_Plus\Commerce
 */

namespace TEC\Tickets_Plus\Commerce;

use \tad_DI52_ServiceProvider;

/**
 * Class Assets.
 *
 * @since   5.3.0
 *
 * @package TEC\Tickets_Plus\Commerce
 */
class Assets extends tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since 5.3.0
	 */
	public function register() {
		$plugin = tribe( 'tickets-plus.main' );

	}
}
