<?php

namespace Aanmeegasaaral\Narayaneeyam;

defined( 'ABSPATH' ) || exit;

class Post_Creator extends \VSP\Base {
	public function __construct() {
		wponion_admin_page( array(
			'menu_title' => __( 'Narayaneeyam Creator' ),
			'page_title' => __( 'Narayaneeyam Creator' ),
			'submenu'    => AANMEEGASAARAL_SLUG,
			'render'     => array( &$this, 'render' ),
			'on_load'    => array( &$this, 'onload' ),
		) );
	}

	public function onload() {
		if ( isset( $_REQUEST['aan_narayaneeyam_creator'] ) ) {
			$eol           = PHP_EOL . PHP_EOL;
			$id            = $_REQUEST['aan_narayaneeyam_creator']['narayaneeyam_lyrics'];
			$parts         = ( isset( $_REQUEST['aan_narayaneeyam_creator']['narayaneeyam_part'] ) ) ? $_REQUEST['aan_narayaneeyam_creator']['narayaneeyam_part'] : false;
			$parts         = ( empty( $parts ) ) ? array( 'part1', 'part2' ) : array( $parts );
			$dasakam_title = wpo_post_meta( '_narayaneeyam_title', $id );
			$number        = wpo_post_meta( '_narayaneeyam_dasakam_number', $id );
			$dasakam_title = ( wpo_is_option( $dasakam_title ) ) ? $dasakam_title->get() : '';
			$number        = ( wpo_is_option( $number ) ) ? $number->get() : '';
			$pre_txt       = aanmeegasaaral_option( 'narayaneeyam_post_pre_txt' );
			$post_txt      = aanmeegasaaral_option( 'narayaneeyam_post_post_txt' );
			$signature     = aanmeegasaaral_option( 'signature' );
			$raw_title     = aanmeegasaaral_option( 'narayaneeyam_post_title' );
			$this->status  = array();
			$this->errors  = array();
			foreach ( $parts as $part ) {

				$part_number = ( $number * 2 );

				if ( 'part1' === $part ) {
					$part_number = $part_number - 1;
				}

				$data    = wpo_post_meta( '_narayaneeyam_' . $part, $id );
				$content = <<<TXT
$pre_txt

[youtube-video id="{$data['video_link']}"]

[narayaneeyam_lyrics id="${id}" from="{$data['from']}" to="{$data['to']}"]

<br/>
<br/>

$post_txt

<br/>
<br/>

$signature 
TXT;
				$title   = str_replace( array( '[dasakam_number]', '[from]', '[to]' ), array(
					'#' . $number,
					$data['from'],
					$data['to'],
				), $raw_title );
				$args    = array(
					'post_author'  => aanmeegasaaral_option( 'default_author', false ),
					'post_content' => $content,
					'post_title'   => $title,
					'tax_input'    => array(
						'category' => aanmeegasaaral_option( 'narayaneeyam_category' ),
					),
					'post_name'    => 'நாராயணியம்-' . $part_number,
				);
				$status  = wp_insert_post( $args );
				if ( ! is_wp_error( $status ) ) {
					$this->status[ $status ] = $title;
				} else {
					$this->errors[] = $status;
				}
			}
		}
	}

	public function render() {

		$builder = wpo_builder();
		echo <<<HTML
<form method="post" class="wponion-form  ">
<div class="wponion-framework  wpo-text-left ">
HTML;
		if ( isset( $this->status ) ) {
			foreach ( $this->status as $id => $title ) {
				$title = sprintf( __( 'Post Created %s' ), '<a href="' . get_edit_post_link( $id ) . '">' . $title . '</a>' );
				echo wpo_field( 'notice_success', $title )->render();
				echo '<br/>';
			}
			echo '<hr/>';

			if ( isset( $this->errors ) && ! empty( $this->errors ) ) {
				echo '<pre>';
				print_r( $this->errors );
				echo '</pre>';
				echo '<hr/>';
			}
		}

		$select            = $builder->select( 'narayaneeyam_lyrics', __( 'Narayaneeyam Lyrics' ) )->query_args( array(
			'post_type'      => 'narayaneeyam_lyrics',
			'posts_per_page' => 10,
		) )->select_framework( 'select2' )->ajax( true )->style( 'width:25%;' );
		$select['options'] = 'post';
		$builder->select( 'narayaneeyam_part', __( 'Narayaneeyam Part' ) )
			->option( '', __( 'All' ) )
			->option( 'part1', __( 'Part 1' ) )
			->option( 'part2', __( 'Part 2' ) )
			->select_framework( 'select2' )
			->style( 'width:25%;' );

		/**
		 * @var \WPO\Field $field
		 */
		foreach ( $builder->fields() as $field ) {
			echo $field->render( null, 'aan_narayaneeyam_creator' );
		}
		echo '
</div>
<button type="submit" class="wpo-btn wpo-btn-success wpo-btn-sm" style="min-width:300px;">' . __( 'Create' ) . '</button>
</form>';
	}
}