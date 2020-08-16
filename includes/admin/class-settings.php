<?php

namespace Aanmeegasaaral\Admin;

defined( 'ABSPATH' ) || exit;

use Aanmeegasaaral\Admin\Settings\General;
use Aanmeegasaaral\Admin\Settings\Narayaneeyam;
use VSP\Core\Abstracts\Plugin_Settings;

/**
 * Class Settings
 *
 * @package WC_Product_Subtitle\Admin
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Settings extends Plugin_Settings {
	use General;
	use Narayaneeyam;

	/**
	 * Generates Basic Settings Fields.
	 * Inits Settings.
	 */
	public function fields() {
		$this->general();
		$general = $this->builder->container( 'templates', __( 'Templates' ) );
		$this->narayaneeyam($general);
	}

}