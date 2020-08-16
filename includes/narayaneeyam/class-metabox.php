<?php

namespace Aanmeegasaaral\Narayaneeyam;

use VSP\Base;

defined( 'ABSPATH' ) || exit;

/**
 * Class Metabox
 *
 * @package Aanmeegasaaral\Narayaneeyam
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 * @since {NEWVERSION}
 */
class Metabox extends Base {

	/**
	 * Post_Type constructor.
	 */
	public function __construct() {
		wponion_metabox( array(
			'option_name'   => '_narayaneeyam',
			'metabox_title' => __( 'Narayaneeyam lyrics Information' ),
			'metabox_id'    => 'narayaneeyam_lyrics_information',
			'screens'       => array( 'narayaneeyam_lyrics' ),
			'ajax'          => true,
			'save_type'     => 'field',
			'theme'         => 'wp_modern',
		), array( $this, 'fields' ) );

		wponion_metabox( array(
			'option_name'   => '_narayaneeyam_dummy',
			'metabox_title' => __( 'Narayaneeyam lyrics' ),
			'metabox_id'    => 'narayaneeyam_lyrics',
			'screens'       => array( 'narayaneeyam_lyrics' ),
			'ajax'          => false,
			'save_type'     => false,
			'theme'         => 'wp_modern',
		), array( $this, 'content' ) );
	}

	public function parts_field( $builder, $part ) {
		$field = $builder->fieldset( 'part' . $part );
		$field->heading( __( 'Part' ) . ' - ' . $part );
		$field->text( 'from', 'From Slokas' )
			->attribute( 'type', 'number' )
			->attribute( 'min', '0' )
			->attribute( 'max', '20' );
		$field->text( 'to', 'To Slokas' )
			->attribute( 'type', 'number' )
			->attribute( 'min', '0' )
			->attribute( 'max', '20' );

		$field->oembed( 'video_link', 'Youtube Video' );
	}

	public function fields() {
		$builder = wpo_builder();

		$builder->text( 'dasakam_number', __( 'Dasakam Number' ) )
			->attribute( 'type', 'number' )
			->attribute( 'min', '0' )
			->attribute( 'max', '99999' );

		$builder->text( 'title', __( 'Dasakam Title' ) );
		$this->parts_field( $builder, 1 );
		$this->parts_field( $builder, 2 );
		return $builder;
	}

	public function content() {
		global $post;
		$builder = wpo_builder();
		$tab     = $builder->tab( 'maintab' )->tab_style( 'style2' );
		$types   = array( array( 1, 5 ), array( 6, 10 ), array( 1, 6 ), array( 7, 12 ) );

		foreach ( $types as $type ) {
			$sec = $tab->section( $type[0] . '_' . $type[1], $type[0] . ' - ' . $type[1] );
			$c   = Handler::content( $post->ID, $type[0], $type[1] );
			$c   = wpautop( implode( PHP_EOL . PHP_EOL, $c ) );
			$sec->content( $c );
		}
		return $builder;

	}
}