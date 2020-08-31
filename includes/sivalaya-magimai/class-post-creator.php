<?php

namespace Aanmeegasaaral\Sivalaya_Magimai;

defined( 'ABSPATH' ) || exit;

class Post_Creator extends \VSP\Base {
	public function __construct() {
		wponion_admin_page( array(
			'menu_title' => __( 'Sivalaya Magimai' ),
			'page_title' => __( 'Sivalaya Magimai' ),
			'submenu'    => AANMEEGASAARAL_SLUG,
			'render'     => array( &$this, 'render' ),
			'on_load'    => array( &$this, 'onload' ),
		) );
	}

	public function onload() {
		if ( isset( $_REQUEST['aan_sivalaya_magimai_creator'] ) ) {
			$pre_txt   = aanmeegasaaral_option( 'sivalaya_magimai_post_pre_txt' );
			$post_txt  = aanmeegasaaral_option( 'sivalaya_magimai_post_post_txt' );
			$signature = aanmeegasaaral_option( 'signature' );
			$raw_title = aanmeegasaaral_option( 'sivalaya_magimai_post_title' );

			$video_link  = $_REQUEST['aan_sivalaya_magimai_creator']['video_link'];
			$temple_name = $_REQUEST['aan_sivalaya_magimai_creator']['temple_name'];
			$episode     = $_REQUEST['aan_sivalaya_magimai_creator']['episode'];
			$temple_info = $_REQUEST['aan_sivalaya_magimai_creator']['temple_info'];

			$this->status = array();
			$this->errors = array();

			$content = <<<TXT
$pre_txt

<h4><em>${temple_name}</em></h4>

[youtube-video id="${video_link}"]

<br/>

$temple_info

<br/>

$post_txt

<br/>
$signature 
TXT;

			$title  = str_replace( array( '[number]' ), array( $episode ), $raw_title );
			$args   = array(
				'post_author'  => aanmeegasaaral_option( 'default_author', false ),
				'post_content' => $content,
				'post_title'   => $title,
				'tax_input'    => array(
					'category' => aanmeegasaaral_option( 'sivalaya_magimai_category' ),
				),
			);
			$status = wp_insert_post( $args );
			if ( ! is_wp_error( $status ) ) {
				$this->status[ $status ] = $title;
			} else {
				$this->errors[] = $status;
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

		$builder->text( 'episode', __( 'Episode' ) )
			->style( 'width:10%;' )
			->js_validate( 'number' )
			->placeholder( '58' );

		$builder->text( 'temple_name', __( 'Temple Name' ) )
			->placeholder( 'அருள்மிகு அக்னீஸ்வரர் திருக்கோயில்(கஞ்சனூர்)' )
			->style( 'width:50%;' );

		$builder->text( 'video_link', __( 'Video Link' ) )
			->placeholder( 'https://youtu.be/NPFvumTkjlM' )
			->style( 'width:25%;' );

		$builder->wp_editor( 'temple_info', __( 'Temple Info' ) );

		/**
		 * @var \WPO\Field $field
		 */
		foreach ( $builder->fields() as $field ) {
			echo $field->render( null, 'aan_sivalaya_magimai_creator' );
		}
		echo '
</div>
<button type="submit" class="wpo-btn wpo-btn-success wpo-btn-sm" style="min-width:300px;">' . __( 'Create' ) . '</button>
</form>';
	}
}