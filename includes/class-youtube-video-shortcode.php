<?php

namespace Aanmeegasaaral;

defined( 'ABSPATH' ) || exit;

class YouTube_Video_Shortcode extends \VSP\Modules\Shortcode {
	/**
	 * Shortcode Name
	 *
	 * @var string
	 */
	protected $name = 'youtube-video';

	/**
	 * Generates Defaults.
	 *
	 * @return array|bool[]
	 * @since {NEWVERSION}
	 */
	protected function defaults() {
		return array(
			'id' => false,
		);
	}

	protected function get_video_info( $url ) {
		$post_id  = get_the_ID();
		$meta_key = '_ytb_video' . md5( $url );
		$meta     = get_post_meta( $post_id, $meta_key, true );

		if ( empty( $meta ) ) {
			$info_url = 'https://www.youtube.com/oembed?url=' . urlencode( $url ) . '&format=json';
			$request  = wp_remote_get( $info_url );
			if ( is_wp_error( $request ) ) {
				return array();
			}
			$meta = wp_remote_retrieve_body( $request );
			$meta = json_decode( $meta, true );

			if ( isset( $meta['type'] ) ) {
				update_post_meta( get_the_ID(), $meta_key, $meta );
			}
		}
		return $meta;
	}

	protected function output() {
		$url  = $this->option( 'id' );
		$urls = parse_url( $url );

		if ( 'youtu.be' === $urls['host'] ) {
			$imgpath = ltrim( $urls['path'], '/' );
		} elseif ( strpos( $urls['path'], 'embed' ) == 1 ) {
			$_url    = explode( '/', $urls['path'] );
			$imgpath = end( $_url );
		} elseif ( strpos( $url, '/' ) === false ) {
			$imgpath = $url;
		} else {
			parse_str( $urls['query'] );
			$imgpath = null;
		}
		$data  = $this->get_video_info( $url );
		$title = ( isset( $data['title'] ) ) ? $data['title'] : '';

		return <<<HTML
<style>
.youtube-img-container{
	transition: all 0.5s ease;
    position: relative;
}

.youtube-img-container::before {
	transition: all 0.5s ease;
    content: attr(data-video-title);
    background: #0000008c;
    color: transparent;
    width: 100%;
    display: block;
    position: absolute;
    top: 0;
    height:0;
    padding:0px 10px;
}

.youtube-img-container:hover::before{
    height:45px;
    z-index: 4;
    color: white;
   
}
 
.youtube-img-link{
	position: relative;
	display: inline-block;
	transition: all 0.5s ease;
}

.youtube-img-link::after {
	content: " ";
	width: 100%;
	height: 100%;
	position: absolute;
	background: #00000014;
	transition: all 0.5s ease;
	left: 0;
	bottom: 0;
}

.youtube-img-link::before {
	background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' height='100%25' version='1.1' viewBox='0 0 68 48' width='100%25'%3E%3Cpath class='ytp-large-play-button-bg' d='M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z' fill='%23212121' fill-opacity='0.8'%3E%3C/path%3E%3Cpath d='M 45,24 27,14 27,34' fill='%23fff'%3E%3C/path%3E%3C/svg%3E");
	background-repeat: no-repeat;
	background-position: center;
	background-size: 100px auto;
	content: " ";
	z-index:10;
	width: 100%;
	height: 100%;
	position: absolute;
	transition: all 0.5s ease;
	left: 0;
	bottom: 0;
}

.youtube-img-link:hover::before{
	background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' height='100%25' version='1.1' viewBox='0 0 68 48' width='100%25'%3E%3Cpath class='ytp-large-play-button-bg' d='M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z' fill='%23f00' fill-opacity='0.8'%3E%3C/path%3E%3Cpath d='M 45,24 27,14 27,34' fill='%23fff'%3E%3C/path%3E%3C/svg%3E");
}

.youtube-img-link:hover::after {
	content: " ";
	width: 100%;
	height: 100%;
	position: absolute;
	left: 0;
	bottom: 0;
}
</style>
    
<p class="youtube-img-container" data-video-title="${title}"> 
    <a class="youtube-img-link" href="${url}" target="_blank" rel="noopener noreferrer">
        <img class="aligncenter size-large jetpack-lazy-image" src="https://img.youtube.com/vi/${imgpath}/maxresdefault.jpg" />
    </a>
</p>

HTML;
	}
}