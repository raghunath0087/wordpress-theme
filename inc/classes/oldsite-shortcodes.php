<?php
/*
 * Declare all old site shortcodes
 *
 * @since Virtual Employee 1.0
 *
 */
 
/** start row shortcode */
if(!function_exists('ve_raw_func')):
function ve_raw_func( $atts, $content = "" ) 
{
	return "$content";
}
endif;
add_shortcode( 'raw', 've_raw_func' );
/** end row shortcode */
