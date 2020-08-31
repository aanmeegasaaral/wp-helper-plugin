<?php

use Aanmeegasaaral\Register_Post_Type;
use VSP\Framework;

defined( 'ABSPATH' ) || exit;

/**
 * Class Aanmeegasaaral
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
final class Aanmeegasaaral extends Framework {
	/**
	 * Aanmeegasaaral constructor.
	 *
	 * @throws \Exception
	 */
	public function __construct() {
		parent::__construct( array(
			'name'          => AANMEEGASAARAL_NAME,
			'file'          => AANMEEGASAARAL_FILE,
			'version'       => AANMEEGASAARAL_VERSION,
			'hook_slug'     => AANMEEGASAARAL_SLUG,
			'db_slug'       => AANMEEGASAARAL_SLUG,
			'slug'          => AANMEEGASAARAL_SLUG,
			'addons'        => false,
			'logging'       => false,
			'system_tools'  => false,
			'localizer'     => false,
			'autoloader'    => array(
				'namespace' => 'Aanmeegasaaral',
				'base_path' => $this->plugin_path( 'includes/', AANMEEGASAARAL_FILE ),
				'options'   => array(
					'classmap' => $this->plugin_path( 'classmaps.php', AANMEEGASAARAL_FILE ),
				),
			),
			'settings_page' => array(
				'option_name'    => '_aanmeegasaaral_options',
				'framework_desc' => sprintf( __( 'Custom %s Helper' ), AANMEEGASAARAL_NAME ),
				'theme'          => 'wp',
				'ajax'           => true,
				'search'         => false,
				'menu'           => array(
					'hook_priority'  => 999,
					'page_title' => __( 'Settings' ),
					'menu_title' => __( 'Settings' ),
					'menu_slug'  => 'settings',
					'submenu'    => AANMEEGASAARAL_SLUG,
				),
			),
		) );
	}

	public function plugin_init() {
		Register_Post_Type::instance();
		\Aanmeegasaaral\Narayaneeyam\Shortcode::instance();
		\Aanmeegasaaral\YouTube_Video_Shortcode::instance();
		if ( is_admin() ) {
			\Aanmeegasaaral\Narayaneeyam\Post_Creator::instance();
			\Aanmeegasaaral\Sivalaya_Magimai\Post_Creator::instance();
		}
	}

	/**
	 * Generates Settings.
	 *
	 * @since {NEWVERSION}
	 */
	public function settings_init_before() {
		wponion_admin_page( array(
			'menu_title' => AANMEEGASAARAL_NAME,
			'page_title' => AANMEEGASAARAL_NAME,
			'menu_slug'  => AANMEEGASAARAL_SLUG,
			'submenu'    => false,
			'render'     => array( $this, 'gen' ),
		) );
		$this->_instance( '\Aanmeegasaaral\Admin\Settings' );
	}

	public function admin_init() {
	}
}