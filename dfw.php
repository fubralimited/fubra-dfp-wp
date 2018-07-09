<?php
/*
Plugin Name: 	Fubra DoubleClick for WordPress
Description: 	Responsive DoubleClick ads in WordPress. Modified copy of https://wordpress.org/plugins/doubleclick-for-wp/
Version: 		  1.0.0
*/

global $DoubleClick;

include('dfw-init.php');

// Get json file with size configurations
$sizeMap = json_decode( file_get_contents( dirname(__FILE__) . '/sizemap.json' ), TRUE );

// Internal helper function
function _str_clean($s) {
  $s = strtolower($s);
  $s = str_replace(' ', '', $s);
  return $s;
}

// Template function
function dfp( $ad, $type, $user_map = NULL ) {
  global $DoubleClick, $sizeMap;

  // Error html
  $err  = '<h1 style="color:white;background:red;padding:10px;font-size:25px;">';
  $err .= 'DFP AD ERROR - ';
  $err .= '<a style="color:white;text-decoration:underline;" target="_blank" href="https://github.com/fubralimited/fubra-dfp-wp">';
  $err .= 'Check Documentation</a></h1>';

  // Check ad code is set
  $ad = _str_clean($ad);
  if( !$ad ) return $err;

  // Start with empty size map
  $map = array();

  // Check if a custom map was defined
  if ( isset($user_map) ) {

    $user_map = _str_clean($user_map);
    $map = explode( ',', $user_map );
    $map = array_combine( array('small','medium','large'), $map );

  // Format size string if set
  } else if ( isset($type) ) {

    $type = _str_clean($type);
    $map = $sizeMap[$type];

  // Else return err
  } else { return $err; }

  // Return ad code
  return $DoubleClick->place_ad( $ad, $map );
}

// Shortcode function
add_shortcode('dfp', function($args){
  return dfp( $args['ad'], $args['type'], $args['map'] );
});
