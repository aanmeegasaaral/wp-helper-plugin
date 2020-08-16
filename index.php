<?php
/**
 * Plugin Name: Custom Helper Plugin.
 */

define( 'AANMEEGASAARAL_NAME', 'Aanmeegasaaral' );
define( 'AANMEEGASAARAL_SLUG', 'aanmeegasaaral' );
define( 'AANMEEGASAARAL_FILE', __FILE__ );
define( 'AANMEEGASAARAL_VERSION', '1.0' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

if ( function_exists( 'vsp_maybe_load' ) ) {
	vsp_maybe_load( 'aanmeegasaaral_init', __DIR__ . '/vendor/varunsridharan' );
}

if ( function_exists( 'wponion_load' ) ) {
	wponion_load( __DIR__ . '/vendor/wponion/wponion' );
}

if ( ! function_exists( 'aanmeegasaaral_init' ) ) {
	/**
	 * Inits SKU Shortlinks Plugin Once VSP_Framework Inits.
	 *
	 * @return bool|\Aanmeegasaaral
	 */
	function aanmeegasaaral_init() {
		require_once __DIR__ . '/includes/functions.php';
		require_once __DIR__ . '/bootstrap.php';
		return aanmeegasaaral();
	}
}

if ( ! function_exists( 'aanmeegasaaral' ) ) {
	/**
	 * Returns Plugin's Instance.
	 *
	 * @return \Aanmeegasaaral
	 */
	function aanmeegasaaral() {
		return Aanmeegasaaral::instance();
	}
}