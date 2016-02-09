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

// Get json file with size configurations
$sizeMap = json_decode( file_get_contents( dirname(__FILE__) . '/sizemap.json' ), TRUE );

// Template function
function dfp( $ad, $size ) {
  global $DoubleClick, $sizeMap;

  $map = array();

  // Format size string if set
  if (isset($size)) {
    $size = strtolower($size);
    $size = str_replace(' ', '', $size);
    $map =$sizeMap[$size];
  }

  return $DoubleClick->place_ad( $ad, $map );
}

// Shortcode function
add_shortcode('dfp', function($args){
  return dfp($args['ad'], $args['size']);
});
