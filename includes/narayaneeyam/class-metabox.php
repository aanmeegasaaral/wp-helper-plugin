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
			'metabox_title' => __( 'Narayaneeyam lyrics Information', 'aanmeegasaaral' ),
			'metabox_id'    => 'narayaneeyam_lyrics_information',
			'screens'       => array( 'narayaneeyam_lyrics' ),
			'ajax'          => true,
			'save_type'     => 'field',
			'theme'         => 'wp_modern',
		), array( $this, 'fields' ) );

		wponion_metabox( array(
			'option_name'   => '_narayaneeyam_dummy',
			'metabox_title' => __( 'Narayaneeyam lyrics', 'aanmeegasaaral' ),
			'metabox_id'    => 'narayaneeyam_lyrics',
			'screens'       => array( 'narayaneeyam_lyrics' ),
			'ajax'          => false,
			'save_type'     => false,
			'theme'         => 'wp_modern',
		), array( $this, 'content' ) );

		wponion_metabox( array(
			'context'       => 'side',
			'option_name'   => '_narayaneeyam_dummy2',
			'metabox_title' => __( 'Narayaneeyam Shortcodes', 'aanmeegasaaral' ),
			'metabox_id'    => 'narayaneeyam_shortcodes',
			'screens'       => array( 'narayaneeyam_lyrics' ),
			'ajax'          => false,
			'save_type'     => false,
			'theme'         => 'wp_modern',
		), array( $this, 'shortcodes' ) );
	}

	/**
	 * @param \WPO\Builder $builder
	 * @param              $part
	 *
	 * @since {NEWVERSION}
	 */
	public function parts_field( $builder, $part ) {
		$field = $builder->fieldset( 'part' . $part )->only_field( true );
		$field->heading( __( 'Part', 'aanmeegasaaral' ) . ' - ' . $part );
		$field->text( 'from', 'From Slokas' )
			->horizontal( true )
			->attribute( 'type', 'number' )
			->attribute( 'min', '0' )
			->attribute( 'max', '20' );
		$field->text( 'to', 'To Slokas' )
			->horizontal( true )
			->attribute( 'type', 'number' )
			->attribute( 'min', '0' )
			->attribute( 'max', '20' );

		$field->oembed( 'video_link', 'Youtube Video' )
			->horizontal( true );
	}

	public function fields() {
		$builder = wpo_builder();

		$builder->text( 'dasakam_number', __( 'Dasakam Number', 'aanmeegasaaral' ) )
			->attribute( 'type', 'number' )
			->attribute( 'min', '0' )
			->attribute( 'max', '99999' )
			->horizontal( true );

		$builder->text( 'title', __( 'Dasakam Title', 'aanmeegasaaral' ) )
			->horizontal( true );
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

	public function shortcodes() {
		$pid     = get_the_ID();
		$parts   = array(
			'part1' => __( 'Part 1', 'aanmeegasaaral' ),
			'part2' => __( 'Part 2', 'aanmeegasaaral' ),
		);
		$builder = wpo_builder();
		foreach ( $parts as $id => $part ) {
			$builder->subheading( $part );
			$meta    = wpo_post_meta( '_narayaneeyam_' . $id );
			$video   = $meta->get( 'video_link' );
			$from    = $meta->get( 'from' );
			$to      = $meta->get( 'to' );
			$content = <<<HTML
&lsqb;youtube-video id="${video}"&rsqb;
<br/>
<br/>
&lsqb;narayaneeyam_lyrics id="${pid}" from="$from" to="$to"&rsqb;
HTML;

			$builder->content( $content );
		}
		return $builder;
	}
}