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
		wponion_admin_columns( 'narayaneeyam_lyrics', __( 'Part 1 Details', 'aanmeegasaaral' ), array(
			&$this,
			'render_parts_column',
		) );
		wponion_admin_columns( 'narayaneeyam_lyrics', __( 'Shortcodes', 'aanmeegasaaral' ), array(
			&$this,
			'render_shortcodes_column',
		) );

		add_filter( 'user_can_richedit', array( &$this, 'disable_wysiwyg_for_CPT' ) );

		wponion_register_post_type( 'narayaneeyam_lyrics', __( 'Narayaneeyam Lyrics', 'aanmeegasaaral' ) )
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

	protected function render_part_details( $post_id, $part = 1, $type = 'shortcode' ) {
		$data = wpo_post_meta( '_narayaneeyam_part' . $part, $post_id );

		if ( 'shortcode' === $type ) {
			return <<<HTML
<span >[narayaneeyam_lyrics id="${post_id}" from="{$data->get( 'from' )}" to="{$data->get( 'to' )}"]</span>
HTML;
		}

		return <<<HTML
<span> {$data->get( 'from' )} - {$data->get( 'to' )} => <a href="{$data->get( 'video_link' )}">{$data->get( 'video_link' )}</a></span>
HTML;

	}

	public function render_parts_column( $post_id ) {
		return $this->render_part_details( $post_id, 1, 'data' ) . '<br/>' . $this->render_part_details( $post_id, 2, 'data' );
	}

	public function render_shortcodes_column( $post_id ) {
		return $this->render_part_details( $post_id, 1 ) . '<br/>' . $this->render_part_details( $post_id, 2 );
	}
}