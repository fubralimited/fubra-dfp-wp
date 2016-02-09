<?php
/*
Plugin Name: 	Fubra DoubleClick for WordPress
Description: 	Responsive DoubleClick ads in WordPress. Modified copy of https://wordpress.org/plugins/doubleclick-for-wp/
Version: 		0.1.1
*/

global $DoubleClick;

include('dfw-init.php');


// Define breakpoints
$DoubleClick->register_breakpoint('small', array('minWidth'=> 0,'maxWidth'=>511));
$DoubleClick->register_breakpoint('medium', array('minWidth'=>512,'maxWidth'=>1199));
$DoubleClick->register_breakpoint('large', array('minWidth'=>1200,'maxWidth'=>99999));


$sizeMap = array(

  'leaderboard' => array( 'small' => '320x50', 'medium' => '468x60', 'large' => '728x90' ),
  'skyscraper' => array( 'small' => '160x600', 'medium' => '160x600','large' => '160x600' )

);

// Template function
function dfp( $ad, $size ) {
  global $DoubleClick, $sizeMap;
  $size = isset($size) ? $sizeMap[$size] : array();
  return $DoubleClick->place_ad( $ad, $size );
}

// Shortcode function
add_shortcode('dfp', function($args){
  return dfp($args['ad'], $args['size']);
});
