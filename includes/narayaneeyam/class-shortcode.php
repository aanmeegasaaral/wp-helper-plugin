<?php

namespace Aanmeegasaaral\Narayaneeyam;

defined( 'ABSPATH' ) || exit;

class Shortcode extends \VSP\Modules\Shortcode {
	/**
	 * Shortcode Name
	 *
	 * @var string
	 */
	protected $name = 'narayaneeyam_lyrics';

	/**
	 * Generates Defaults.
	 *
	 * @return array|bool[]
	 * @since {NEWVERSION}
	 */
	protected function defaults() {
		return array(
			'id'   => false,
			'from' => false,
			'to'   => false,
		);
	}

	protected function output() {
		$c = Handler::content( $this->option( 'id' ), $this->option( 'from' ), $this->option( 'to' ) );
		$c = wpautop( implode( PHP_EOL . PHP_EOL, $c ) );
		return $c;
	}
}