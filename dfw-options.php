<?php


global $DoubleClick;

/**
 * Register option page.
 *
 * @since v0.1
 */
function dfw_plugin_menu() {
	add_options_page(
		'DoubleClick for WordPress', 	// $page_title title of the page.
		'DoubleClick', 	                // $menu_title the text to be used for the menu.
		'manage_options', 				// $capability required capability for display.
		'doubleclick-for-wordpress', 	// $menu_slug unique slug for menu.
		'dfw_option_page_html' 			// $function callback.
		);
}
add_action( 'admin_menu', 'dfw_plugin_menu' );

/**
 * Output the HTML for the option page.
 *
 * @since v0.1
 */
function dfw_option_page_html() {

	// Nice try.
	if ( !current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

	echo '<div class="wrap">';
	echo '<h2>Fubra DoubleClick for WordPress Options</h2>';
	echo '<form method="post" action="options.php">';

	settings_fields( 'doubleclick-for-wordpress' );
	do_settings_sections( 'doubleclick-for-wordpress' );
	submit_button();

	echo '</form>';
	echo '</div>'; // div.wrap

}

/**
 * Registers options for the plugin.
 *
 * @since v0.1
 */
function dfw_register_options() {

	// Add a section for network option
	add_settings_section(
		'dfw_network_options',
		'Network Settings',
		'dfw_settings_section_intro',
		'doubleclick-for-wordpress'
	); // ($id, $title, $callback, $page)

	// Network Code
	add_settings_field(
		'dfw_network_code',
		'DoubleClick Network Code',
		'dfw_network_code_input',
		'doubleclick-for-wordpress',
		'dfw_network_options'
	); // ($id, $title, $callback, $page, $section, $args)


	register_setting( 'doubleclick-for-wordpress', 'dfw_network_code' );
	register_setting( 'doubleclick-for-wordpress', 'dfw_breakpoints', 'dfw_breakpoints_save' );

}
add_action('admin_init', 'dfw_register_options');

function dfw_settings_section_intro() {
	echo "Enter a DoubleClick for Publisher's Network Code ( <a href='https://developers.google.com/doubleclick-publishers/docs/start#signup' target='_blank'>?</a> )";
}

function dfw_network_code_input() {

	global $DoubleClick;

	if( isset($DoubleClick->networkCode) )
		echo '<input value="' . $DoubleClick->networkCode . ' (set in theme)" type="text" class="regular-text" disabled/>';
	else {
		echo '<input name="dfw_network_code" id="dfw_network_code" type="text" value="' . get_option('dfw_network_code') . '" class="regular-text" />';
	}
}
