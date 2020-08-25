<?php
defined( 'ABSPATH' ) || exit;

/**
 * @param bool $key
 * @param bool $default
 *
 * @return array|bool|\WPOnion\DB\Option
 * @since {NEWVERSION}
 */
function aanmeegasaaral_option( $key = false, $default = false ) {
	return wpo_settings( '_aanmeegasaaral_options', $key, $default );
}