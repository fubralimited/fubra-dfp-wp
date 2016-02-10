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
function dfp( $ad, $type, $map ) {
  global $DoubleClick, $sizeMap;

  $map = array();

  if (isset($type)) {

    $type = strtolower($type);
    $type = str_replace(' ', '', $type);
    $map =$sizeMap[$type];

  } else {
    $err  = '<h1 style="color:white,background:red,padding:10px,font-size:25px;">';
    $err .= 'DFP AD ERROR - <a href="https://github.com/fubralimited/fubra-dfp-wp">Check Documentation</a>';
    $err .= '</h1>';
    return $err;
  }

  return $DoubleClick->place_ad( $ad, $map );
}

// Shortcode function
add_shortcode('dfp', function($args){
  return dfp( $args['ad'], $args['type'], $args['map'] );
});
