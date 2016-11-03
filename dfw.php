<?php
/*
Plugin Name: 	Fubra DoubleClick for WordPress
Description: 	Responsive DoubleClick ads in WordPress. Modified copy of https://wordpress.org/plugins/doubleclick-for-wp/
Author:    		Fubra Ltd.
Version: 		  1.0.0
*/

include('dfw-init.php');

function google_ads () {

    global  $wp_query,
            $google_ads_unit,
            $post,
            $DoubleClick,
            $listing_page,
            $blog;

    $google_ads_header = '';
    $google_ads_pub    = 'ca-pub-5419175785675578';
    $data              = new stdClass();

    if( class_exists( 'WAC_Search' ) && WAC_Search::is_search_page() ) {

        $data->sidebar = 'WAC_Searchresultspages_ATF_Skyscraper_A';
        $data->footer  = 'WAC_Searchresultspages_BTF_Footer_728x90_A';

    } elseif( $listing_page ) {

        $data->sidebar       = 'WAC_Alphabeticalpages_ATF_Skyscraper_A';
        $data->footer        = 'WAC_Alphabeticalpages_BTF_Footer_728x90_A';
        $data->leaderboard_1 = 'WAC_Alphabeticalpages_BTF_Leaderboard_A';
        $data->leaderboard_2 = 'WAC_Alphabeticalpages_BTF_Leaderboard_2_A';
        $data->leaderboard_3 = 'WAC_Alphabeticalpages_BTF_Leaderboard_3_A';

    } elseif( is_page_template('templates/directory-taxi.php') ) {

        $data->body    = 'WAC_TaxiPages_ATF_Leaderboard';
        $data->sidebar = 'WAC_TaxiPages_ATF_Right_160x600';
        $data->footer  = 'WAC_TaxiPages_BTF_Footer_728x90';

    } elseif( is_page_template('templates/directory-hotel.php') ) {

        $data->body    = 'WAC_HotelPages_ATF_Leaderboard';
        $data->sidebar = 'WAC_HotelPages_ATF_Right_160x600';
        $data->footer  = 'WAC_HotelPages_BTF_Footer_728x90';

    } elseif( is_page_template('templates/directory-parking.php') ) {

        $data->body    = 'WAC_ParkingPages_ATF_Leaderboard';
        $data->sidebar = 'WAC_ParkingPages_ATF_Right_160x600';
        $data->footer  = 'WAC_ParkingPages_BTF_Footer_728x90';

    } elseif( is_page_template('templates/directory-carhire.php') ) {

        $data->body    = 'WAC_CarHirePages_ATF_Leaderboard';
        $data->sidebar = 'WAC_CarHirePages_ATF_Right_160x600';
        $data->footer  = 'WAC_CarHirePages_BTF_Footer_728x90';

    }  elseif( is_page_template('templates/directory-currency.php') ) {

        $data->body    = 'WAC_CarHirePages_ATF_Leaderboard';
        $data->sidebar = 'WAC_CarHirePages_ATF_Right_160x600';
        $data->footer  = 'WAC_CarHirePages_BTF_Footer_728x90';

    } elseif( get_post_type() === 'airport' ) {

        // Top banner
        $data->top_leaderboard       = 'WAC_AirportResultsPage_ATF_Leaderboard';

        // Between the hotel and affiliates links and the destinations
        $data->affiliate_leaderboard = 'WAC_AirportResultsPage_BTF_Leaderboard';

        // Skyscraper
        $data->sidebar               = 'WAC_AirportResultsPage_ATF_Right_160x600';

        // Only on long pages, placed under gallery
        $data->gallery_leaderboard   = 'WAC_AirportResultsPage_BTF_Leaderboard_2';

        // Test Ads Sales - Dubai
        $data->DXB_leaderboard       = 'WAC_DXBairport_ATF_Leaderboard';



        foreach( $data as $key => $value ) {
            $data->{$key} = $value.'_B';
        }

        // Overide leaderboard on airport pages
        $data->IST_leaderboard   = 'WAC_ISTairport_ATF_Leaderboard';
        $data->IST_leaderboard   = 'WAC_ISTairport_ATF_Leaderboard';
    		$data->PEK_leaderboard   = 'WAC_PEKairport_ATF_Leaderboard';
    		$data->PVG_leaderboard   = 'WAC_PVGairport_ATF_Leaderboard';
        $data->HKG_leaderboard   = 'WAC_HKGairport_ATF_Leaderboard';
        $data->SIN_leaderboard   = 'WAC_SIN_airport_ATF_Leaderboard';
        $data->KUL_leaderboard   = 'WAC_KUL_airport_ATF_Leaderboard';
        $data->BKK_leaderboard   = 'WAC_BKK_airport_ATF_Leaderboard';
        $data->BNE_leaderboard   = 'WAC_BNE_airport_ATF_Leaderboard';
        $data->SHA_leaderboard   = 'WAC_SHA_airport_ATF_Leaderboard';
        $data->CGK_leaderboard   = 'WAC_CGK_airport_ATF_Leaderboard';
        $data->SGN_leaderboard   = 'WAC_SGN_airport_ATF_Leaderboard';


    } elseif( in_array(get_the_title(), array('World Top 30 Airports', 'US Top 40 Airports')) ) {

        $data->sidebar           = 'WAC_Contentpages_ATF_Skyscraper_C';
        $data->BTF_Leaderboard   = 'WAC_Contentpages_BTF_Leaderboard_C';
        $data->BTF_Leaderboard_2 = 'WAC_Contentpages_BTF_Leaderboard_2_C';
        $data->BTF_Leaderboard_3 = 'WAC_Contentpages_BTF_Leaderboard_3_C';
        $data->BTF_Footer_728x9  = 'WAC_Contentpages_BTF_Footer_728x9_C';

    } elseif( in_array(get_the_title(), array('UK Top 20 Airports')) ) {

        $data->sidebar           = 'WAC_UKTop20_ATF_WideSkyscraper';
        $data->BTF_Leaderboard   = 'WAC_UKTop20_BTF_Leaderboard';
        $data->BTF_Leaderboard_2 = 'WAC_Contentpages_BTF_Leaderboard_2_C';
        $data->BTF_Leaderboard_3 = 'WAC_Contentpages_BTF_Leaderboard_3_C';
        $data->BTF_Footer_728x9  = 'WAC_UKTop20_BTF_Footer_728x90';

    } elseif( $blog ) {

        $data->blog_atf = 'WAC_Blog_ATF_Leaderboard';
        $data->blog_btf = 'WAC_Blog_BTF_Footer';

    } else {

        $data->sidebar = 'WAC_HomepageAndContentPages_BTF_Right_300x250';
        $data->mpu = 'WAC_HomepageAndContentPages_BTF_Right_300x250';
        $data->blb = 'WAC_BTF_Footer_728x90'; // Leader board at the bottom

    }

    if( !isset($data->blb) || !isset($data->footer) ) {
        // Leader board at the bottom
        $data->blb = 'WAC_BTF_Footer_728x90';
    }

    if( !is_object( $google_ads_unit ) ) {
        $google_ads_unit = new stdClass;

    }

    foreach ( $data as $type => $value) {

        if($type !== 'sidebar') {
          $google_ads_unit->{$type} = $DoubleClick->place_ad( $value, array( 'small' => '320x50', 'medium' => '468x60', 'large' => '728x90' ) );
        } else {
          $google_ads_unit->{$type} = $DoubleClick->place_ad( $value, array( 'small' => '160x600', 'medium' => '160x600','large' => '160x600' ) );
        }
    }
}

add_shortcode('dfp_leaderboard', function($args){
  global $DoubleClick;
  return $DoubleClick->place_ad( $args['ad'], array( 'small' => '320x50', 'medium' => '468x60', 'large' => '728x90' ) );
});

add_shortcode('dfp_skyscraper', function($args){
  global $DoubleClick;
  return $DoubleClick->place_ad( $args['ad'], array( 'small' => '160x600', 'medium' => '160x600','large' => '160x600' ) );
});
