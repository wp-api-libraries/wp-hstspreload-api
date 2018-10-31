<?php
/**
 * WP-HSTS-Preload-API
 *
 * @link hstspreload.org API Docs
 * @package WP-API-Libraries\WP-HSTS-Preload-API
 */

/*
* Plugin Name: WP HSTS Preload API
* Plugin URI: https://github.com/wp-api-libraries/wp-hstspreload-api
* Description: Perform API requests to HSTS Preload in WordPress.
* Author: WP API Libraries
* Version: 1.0.0
* Author URI: https://wp-api-libraries.com
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-hstspreload-api
* GitHub Branch: master
*/

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	exit; }


/* Check if class exists. */
if ( ! class_exists( 'HSTS_PreloadAPI' ) ) {

	/**
	 * HSTS_PreloadAPI Class.
	 *
	 * @link hstspreload.org API Docs
	 */
	class HSTS_PreloadAPI {


		/**
		 * BaseAPI Endpoint
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://hstspreload.org/api/v2/';

		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request, array( 'timeout' => 20 ) );
			$code     = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'wp-hstspreload-api' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}

		/**
		 * Get Domain Status
		 *
		 * @access public
		 * @param mixed $domain Domain.
		 * @return void
		 */
		function get_domain_status( $domain ) {

			$request = $this->base_uri . 'status?domain=' . $domain;

			return $this->fetch( $request );

		}

		/**
		 * IS Domain Preloadable?
		 *
		 * @access public
		 * @param mixed $domain Domain.
		 * @return void
		 */
		function get_domain_preloadable( $domain ) {

			$request = $this->base_uri . 'preloadable?domain=' . $domain;

			return $this->fetch( $request );

		}


	}
}
