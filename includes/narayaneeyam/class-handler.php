<?php

namespace Aanmeegasaaral\Narayaneeyam;
//https://regex101.com/r/xuP4rH/1/
class Handler {
	public static function content( $post_id, $from, $to ) {
		$contents = get_post_field( 'post_content', $post_id );
		#$regex = new \VerbalExpressions\PHPVerbalExpressions\VerbalExpressions();
		#$regex->startOfLine()->anything()->lineBreak()->anything()->lineBreak()->lineBreak()->anything()->lineBreak()->anything()->endOfLine();
		preg_match_all( '/^(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)$/m', $contents, $matches, PREG_PATTERN_ORDER, 0 );
		$contents = $matches[0];
		$return   = array();

		$from = ( 1 == $from ) ? 0 : ( $from - 1 );
		$to   = ( $to - 1 );

		foreach ( $contents as $id => $content ) {
			if ( $from === $id ) {
				$return[] = $content;
			} elseif ( $id >= $from && $id <= $to ) {
				$return[] = $content;
			}
		}
		return $return;
	}
}
