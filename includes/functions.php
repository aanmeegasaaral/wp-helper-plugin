<?php
defined( 'ABSPATH' ) || exit;

/**
 * @param bool $key
 * @param bool $default
 *
 * @return array|bool|\WPOnion\DB\Option
 * @since {NEWVERSION}
 */
function aanmeegasaaral_option( $key = false, $default = false ) {
	return wpo_settings( '_aanmeegasaaral_options', $key, $default );
}


add_shortcode( 'youtube-video', 'aanm_youtube_shortcode' );

function aanm_youtube_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'id' => false,
	), $atts, 'youtube-video' );
	$rurl = $atts['id'];
	$url  = $atts['id'];
	$urls = parse_url( $url );

	//Expect the URL to be http://youtu.be/abcd, where abcd is the video ID
	if ( $urls['host'] == 'youtu.be' ) :
		$imgPath = ltrim( $urls['path'], '/' );
	//Expect the URL to be http://www.youtube.com/embed/abcd
	elseif ( strpos( $urls['path'], 'embed' ) == 1 ) :
		$imgPath = end( explode( '/', $urls['path'] ) );
	//Expect the URL to be abcd only
	elseif ( strpos( $url, '/' ) === false ):
		$imgPath = $url;
	//Expect the URL to be http://www.youtube.com/watch?v=abcd
	else :
		parse_str( $urls['query'] );
		$imgPath = $v;
	endif;


	return <<<HTML
    
<p> 
    <a class="youtube-img-link" href="${url}" target="_blank" rel="noopener noreferrer">
        <img class="aligncenter size-large jetpack-lazy-image" src="https://img.youtube.com/vi/${imgPath}/maxresdefault.jpg" />
    </a>
</p>

HTML;

}