<?php
/**
 * Handles the interaction w/ Webex API.
 *
 * @since 1.9.0
 *
 * @package Tribe\Events\Virtual\Meetings\Webex
 */

namespace Tribe\Events\Virtual\Meetings\Webex;

use Tribe\Events\Virtual\Encryption;
use Tribe\Events\Virtual\Template_Modifications;

/**
 * Class Api
 *
 * @since 1.9.0
 *
 * @package Tribe\Events\Virtual\Meetings\Webex
 */
class Api extends Account_API {

	/**
	 * {@inheritDoc}
	 */
	public static $api_name = 'Webex';

	/**
	 * {@inheritDoc}
	 */
	public static $api_id = 'webex';

	/**
	 * The base URL of the Webex REST API, v1.
	 *
	 * @since 1.9.0
	 *
	 * @var string
	 */
	public static $api_base = 'https://webexapis.com/v1/';

	/**
	 * Api constructor.
	 *
	 * @since 1.9.0
	 *
	 * @param Encryption $encryption An instance of the Encryption handler.
	 */
	public function __construct( Encryption $encryption, Template_Modifications $template_modifications ) {
		$this->encryption             = ( ! empty( $encryption ) ? $encryption : tribe( Encryption::class ) );
		$this->template_modifications = $template_modifications;

		// Attempt to load an account.
		$this->load_account();
	}

	/**
	 * Checks whether the current Webex API integration is authorized or not.
	 *
	 * The check is made on the existence of the refresh token, with it the token can be fetched on demand when
	 * required.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Whether the current Webex API integration is authorized or not.
	 */
	public function is_authorized() {
		return ! empty( $this->refresh_token );
	}

	/**
	 * {@inheritDoc}
	 */
	public function refresh_access_token( $id, $refresh_token ) {
		$refreshed = false;

		$this->post(
			Url::$token_request_url,
			[
				'body'    => [
					'grant_type'    => 'refresh_token',
					'refresh_token' => $refresh_token,
				],
			],
			200
		)->then(
			function ( array $response ) use ( &$id, &$refreshed ) {

				if (
					! (
						isset( $response['body'] )
						&& false !== ( $body = json_decode( $response['body'], true ) )
						&& isset( $body['access_token'], $body['refresh_token'], $body['expires_in'] )
					)
				) {
					do_action( 'tribe_log', 'error', __CLASS__, [
						'action'   => __METHOD__,
						'message'  => 'Webex API access token refresh response is malformed.',
						'response' => $body,
					] );

					return false;
				}

				$refreshed = $this->save_access_and_expiration( $id, $response );

				return $refreshed;
			}
		);

		return $refreshed;
	}

	/**
	 * Get the Meeting by ID from Webex and Return the Data.
	 *
	 * @since 1.9.0
	 *
	 * @param string $web_link The web link to the meeting.
	 *
	 * @return array An array of data from the Webex API.
	 */
	public function fetch_meeting_data( $web_link ) {
		if ( ! $this->get_token_authorization_header() ) {
			return [];
		}

		$data = [];
		$api_endpoint = Meetings::$api_endpoint;

		$this->get(
			self::$api_base . "{$api_endpoint}/?webLink={$web_link}",
			[
				'headers' => [
					'Authorization' => $this->get_token_authorization_header(),
					'Content-Type'  => 'application/json; charset=utf-8',
				],
				'body'    => null,
			],
			200
		)->then(
			function ( array $response ) use ( &$data ) {

				if (
					! (
						isset( $response['body'] )
						&& false !== ( $body = json_decode( $response['body'], true ) )
						&& isset( $body['items'] )
					)
				) {
					do_action( 'tribe_log', 'error', __CLASS__, [
						'action'   => __METHOD__,
						'message'  => 'Webex API meetings is response is malformed.',
						'response' => $body,
					] );

					return [];
				}

				$first_meeting = reset( $body['items'] );

				if ( ! ( isset( $first_meeting['webLink'] ) ) ) {
					do_action( 'tribe_log', 'error', __CLASS__, [
						'action'   => __METHOD__,
						'message'  => 'Webex API meetings returned no entries.',
						'response' => $body,
					] );

					return [];
				}
				$data = $first_meeting;
			}
		)->or_catch(
			function ( \WP_Error $error ) {
				do_action( 'tribe_log', 'error', __CLASS__, [
					'action'  => __METHOD__,
					'code'    => $error->get_error_code(),
					'message' => $error->get_error_message(),
				] );
			}
		);

		return $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function fetch_user( $user_id = 'me', $settings = false, $access_token = '' ) {
		if ( ! $this->get_token_authorization_header( $access_token ) ) {
			return [];
		}

		// If both user id and settings, add settings to detect webinar support.
		if ( $user_id && $settings ) {
			$user_id = $user_id . '/settings';
		}

		$this->get(
			self::$api_base . 'people/' . $user_id,
			[
				'headers' => [
					'Authorization' => $this->get_token_authorization_header( $access_token ),
					'Content-Type'  => 'application/json; charset=utf-8',
				],
				'body'    => null,
			],
			200
		)->then(
			static function ( array $response ) use ( &$data ) {

				$body = json_decode( $response['body'] );

				if (
					! isset( $response['body'] )
					|| false === ( $body = json_decode( $response['body'], true ) )
				) {
					do_action( 'tribe_log', 'error', __CLASS__, [
						'action'   => __METHOD__,
						'message'  => 'Webex API user response is malformed.',
						'response' => $body,
					] );

					return [];
				}
				$data = $body;
			}
		)->or_catch(
			static function ( \WP_Error $error ) {
				do_action( 'tribe_log', 'error', __CLASS__, [
					'action'  => __METHOD__,
					'code'    => $error->get_error_code(),
					'message' => $error->get_error_message(),
				] );
			}
		);

		return $data;
	}

	/**
	 * Get the List of all Users
	 *
	 * @since 1.9.0
	 *
	 * @return array An array of users from the Webex API.
	 */
	public function fetch_users() {
		if ( ! $this->get_token_authorization_header() ) {
			return [];
		}

		$args = [
			'max' => 500,
		];

		/**
		 * Filters the arguments for fetching users.
		 *
		 * @since 1.9.0
		 *
		 * @param array<string|string> $args The default arguments to fetch users.
		 */
		$args = (array) apply_filters( 'tec_events_virtual_webex_get_users_arguments', $args );

		// Get the initial page of users.
		$users = $this->fetch_users_with_args( $args );

		return $users;
	}

	/**
	 * Get the List of Users by arguments.
	 *
	 * @since 1.9.0
	 *
	 * @return array An array of data from the Webex API.
	 */
	public function fetch_users_with_args( $args ) {
		if ( ! $this->get_token_authorization_header() ) {
			return [];
		}

		$data = '';

		$this->get(
			self::$api_base . "people?email={$this->email}",
			[
				'headers' => [
					'Authorization' => $this->get_token_authorization_header(),
					'Content-Type'  => 'application/json; charset=utf-8',
				],
				'body'    => ! empty( $args ) ? $args : null,
			],
			200
		)->then(
			static function ( array $response ) use ( &$data ) {
				$body = json_decode( $response['body'] );

				if (
					! isset( $response['body'] )
					|| false === ( $body = json_decode( $response['body'], true ) )
					|| ! isset( $body['items'] )
				) {
					do_action( 'tribe_log', 'error', __CLASS__, [
						'action'   => __METHOD__,
						'message'  => 'Webex API users response is malformed.',
						'response' => $body,
					] );

					return [];
				}
				$data = $body;
			}
		)->or_catch(
			static function ( \WP_Error $error ) {
				do_action( 'tribe_log', 'error', __CLASS__, [
					'action'  => __METHOD__,
					'code'    => $error->get_error_code(),
					'message' => $error->get_error_message(),
				] );
			}
		);

		return $data;
	}

	/**
	 * Get the no Webex account found message.
	 *
	 * @since 1.9.0
	 *
	 * @return string The message returned when no account found.
	 */
	public function get_no_account_message() {
		return sprintf(
			'%1$s <a href="%2$s" target="_blank">%3$s</a>',
			esc_html_x(
				'No Webex account found. ',
			'The start of the message for smart url/autodetect when there is no Webex account found.',
			'events-virtual'
			),
			Settings::admin_url(),
			esc_html_x(
				'Please check your account connection.',
			'The link in of the message for smart url/autodetect when no Webex account is found.',
			'events-virtual'
			)
		);
	}
}