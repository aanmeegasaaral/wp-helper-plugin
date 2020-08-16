<?php

namespace Aanmeegasaaral;

defined( 'ABSPATH' ) || exit;

class Register_Post_Type extends \VSP\Base {
	public function __construct() {
		$this->narayaneeyam_post_type();

	}

	protected function narayaneeyam_post_type() {
		$this->_instance( '\Aanmeegasaaral\Narayaneeyam\Post_Type' );
		$this->_instance( '\Aanmeegasaaral\Narayaneeyam\Metabox' );
	}
}