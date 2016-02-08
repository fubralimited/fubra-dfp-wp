<?php
/*
Plugin Name: 	Fubra DoubleClick for WordPress
Description: 	Responsive DoubleClick ads in WordPress. Modified copy of https://wordpress.org/plugins/doubleclick-for-wp/
Version: 		0.1.1
*/

include('dfw-init.php');

$sizeMap = array(

  'leaderboard' => array( 'small' => '320x50', 'medium' => '468x60', 'large' => '728x90' ),
  'skyscraper' => array( 'small' => '160x600', 'medium' => '160x600','large' => '160x600' )

);

add_shortcode('dfp', function($args){
  global $DoubleClick;
  $size = isset($args['size']) ? $sizeMap[$args['size']] : array();
  return $DoubleClick->place_ad( $args['ad'], $size );
});
