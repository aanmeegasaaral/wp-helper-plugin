<?php

namespace Aanmeegasaaral\Narayaneeyam;

use VSP\Base;

defined( 'ABSPATH' ) || exit;

/**
 * Class Post_Type
 *
 * @package Aanmeegasaaral\Narayaneeyam
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Post_Type extends Base {

	/**
	 * Post_Type constructor.
	 */
	public function __construct() {
		wponion_admin_columns( 'narayaneeyam_lyrics', __( 'Shortcode' ), array( &$this, 'render_column' ) );
		add_filter( 'user_can_richedit', array( &$this, 'disable_wysiwyg_for_CPT' ) );
		wponion_register_post_type( 'narayaneeyam_lyrics', __( 'Narayaneeyam Lyrics' ) )
			->publicly_queryable( false )
			->has_archive( false )
			->show_ui( true )
			->supports( 'title' )
			->supports( 'editor' )
			->show_in_menu( AANMEEGASAARAL_SLUG )
			->exclude_from_search( true );

	}

	/**
	 * Removes Visual Editor.
	 *
	 * @param $default
	 *
	 * @return bool
	 * @since {NEWVERSION}
	 */
	public function disable_wysiwyg_for_CPT( $default ) {
		global $post;
		if ( 'narayaneeyam_lyrics' == get_post_type( $post ) ) {
			return false;
		}
		return $default;
	}

	/**
	 * Renders Admin Column.
	 *
	 * @param $post_id
	 *
	 * @return string
	 * @since {NEWVERSION}
	 */
	public function render_column( $post_id ) {
		return <<<HTML
<strong> 1-5 : </strong> <br/> <code>[narayaneeyam_lyrics id="${post_id}" from="1" to="5"]</code> <br/>
<strong> 6-10 : </strong> <br/> <code>[narayaneeyam_lyrics id="${post_id}" from="6" to="10"]</code> <br/>
HTML;

	}
}