<?php

namespace Aanmeegasaaral\Narayaneeyam;
//https://regex101.com/r/xuP4rH/1/
//https://regex101.com/r/mZvvqC/1
class Handler {
	public static function content( $post_id, $from, $to ) {
		$contents = get_post_field( 'post_content', $post_id );
		$regex    = new \VerbalExpressions\PHPVerbalExpressions\VerbalExpressions();

		/**
		 * 2set of sloka -- ^(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)$
		 * 4set of sloka -- ^(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)$
		 */

		/*$regex->startOfLine();
		$regex->anything()->lineBreak()->anything()->lineBreak();
		$regex->anything()->lineBreak()->anything()->lineBreak();
		$regex->lineBreak();
		$regex->anything()->lineBreak()->anything()->lineBreak();
		$regex->anything()->lineBreak()->anything();*/

		$regex->add( '^(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)$' );
		$regex->_or( '^(?:.*)(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:\n|(\r\n))(?:.*)(?:\n|(\r\n))(?:.*)$' );
		#$regex->endOfLine();
		preg_match_all( $regex, $contents, $matches, PREG_PATTERN_ORDER, 0 );

		$contents = $matches[0];
		$return   = array();

		$from = ( 1 == $from ) ? 0 : ( $from - 1 );
		$to   = ( $to - 1 );

		foreach ( $contents as $id => $content ) {
			if ( $from === $id ) {
				$return[] = trim( $content );
			} elseif ( $id >= $from && $id <= $to ) {
				$return[] = trim( $content );
			}
		}
#		var_dump( $return );
		return $return;
	}
}
