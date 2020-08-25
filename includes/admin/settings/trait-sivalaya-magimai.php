<?php

namespace Aanmeegasaaral\Admin\Settings;

defined( 'ABSPATH' ) || exit;

trait Sivalaya_Magimai {
	/**
	 * @param \WPO\Container $templates
	 *
	 * @since {NEWVERSION}
	 */
	protected function sivalaya_magimai( $templates ) {
		/**
		 * @var \WPO\Container $general
		 */
		$general = $templates->container( 'sivalaya_magimai', __( 'Sivalaya Magimai' ) );

		$general->text( 'sivalaya_magimai_post_title', __( 'Post Title' ) )->desc_field( array(
			'`[number]` To Get The Number',
		) )->style( 'width:50%;' );

		$select            = $general->select( 'sivalaya_magimai_category', __( 'Sivalaya Magimai Category' ) )
			->select_framework( 'select2' )
			->multiple( true )
			->style( 'width:50%;' );
		$select['options'] = 'category';

		$general->wp_editor( 'sivalaya_magimai_post_pre_txt', __( 'Post Before' ) );
		$general->wp_editor( 'sivalaya_magimai_post_post_txt', __( 'Post After' ) );
	}
}