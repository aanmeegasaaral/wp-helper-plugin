<?php

namespace Aanmeegasaaral\Admin\Settings;

defined( 'ABSPATH' ) || exit;

trait Narayaneeyam {
	/**
	 * @param \WPO\Container $templates
	 *
	 * @since {NEWVERSION}
	 */
	protected function narayaneeyam( $templates ) {
		/**
		 * @var \WPO\Container $general
		 */
		$general = $templates->container( 'narayaneeyam', __( 'Narayaneeyam' ) );

		$general->text( 'narayaneeyam_post_title', __( 'Post Title' ) )->desc_field( array(
			'`[dasakam_number]` To Get The Number',
			'`[from]` To From Slokas Number',
			'`[to]` To Get Till Slokas Number',
		) )->style( 'width:50%;' );

		$select            = $general->select( 'narayaneeyam_category', __( 'Narayaneeyam Category' ) )
			->select_framework( 'select2' )
			->multiple( true )
			->style( 'width:50%;' );
		$select['options'] = 'category';

		$general->wp_editor( 'narayaneeyam_post_pre_txt', __( 'Post Before Slokas' ) );
		$general->wp_editor( 'narayaneeyam_post_post_txt', __( 'Post After Slokas' ) );
	}
}