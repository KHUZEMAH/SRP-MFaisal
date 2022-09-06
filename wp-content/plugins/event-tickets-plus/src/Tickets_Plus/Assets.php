<?php
/**
 * Handles registering and setup for assets on Tickets Plus.
 *
 * @since   5.3.0
 *
 * @package TEC\Tickets_Plus
 */

namespace TEC\Tickets_Plus;

use \tad_DI52_ServiceProvider;

/**
 * Class Assets.
 *
 * @since   5.3.0
 *
 * @package TEC\Tickets_Plus
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
