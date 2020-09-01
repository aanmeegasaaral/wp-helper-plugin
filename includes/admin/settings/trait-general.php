<?php

namespace Aanmeegasaaral\Admin\Settings;

defined( 'ABSPATH' ) || exit;

trait General {
	protected function general() {

		/**
		 * @var \WPO\Container $general
		 */
		$general           = $this->builder->container( 'general', __( 'General', 'aanmeegasaaral' ) );
		$select            = $general->select( 'default_author', __( 'Default Author', 'aanmeegasaaral' ) )
			->options( 'users' );
		$select['options'] = 'users';
		$general->wp_editor( 'signature', __( 'Global Signature', 'aanmeegasaaral' ) )
			->desc_field( __( 'Can Be Called As `[global-signature]` ', 'aanmeegasaaral' ) );
	}
}