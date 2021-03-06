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
add_action('admin_init', function() {

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

	// Add a section for network option
	add_settings_section(
		'dfw_breakpoint_options',
		'Breakpoints',
		'dfw_breakpoints_section_intro',
		'doubleclick-for-wordpress'
	); // ($id, $title, $callback, $page)

	// Breakpoints
	add_settings_field(
		'dfw_breakpoints',
		'Breakpoints',
		'dfw_breakpoints_input',
		'doubleclick-for-wordpress',
		'dfw_breakpoint_options'
	); // ($id, $title, $callback, $page, $section, $args)

	register_setting( 'doubleclick-for-wordpress', 'dfw_network_code' );
	register_setting( 'doubleclick-for-wordpress', 'dfw_breakpoints', 'dfw_breakpoints_save' );
});

function dfw_network_code_input() {

	global $DoubleClick;

	if( isset($DoubleClick->networkCode) )
		echo '<input value="' . $DoubleClick->networkCode . ' (set in theme)" type="text" class="regular-text" disabled/>';
	else {
		echo '<input name="dfw_network_code" id="dfw_network_code" type="text" value="' . get_option('dfw_network_code') . '" class="regular-text" />';
	}
}

function dfw_settings_section_intro() {
	echo "Enter a DoubleClick for Publisher's Network Code ( <a href='https://developers.google.com/doubleclick-publishers/docs/start#signup' target='_blank'>?</a> )";
}


function dfw_breakpoints_section_intro() {
	echo "Enter breakpoints below<br />";
	echo "<em>Example: phone: 0 to 480, tablet 480 to 768, desktop 768 to 9999.</em>";
}

function dfw_breakpoints_input() {
	global $DoubleClick;

	if(count($DoubleClick->breakpoints)) {
		foreach ( $DoubleClick->breakpoints as $b ) {
			if ( !$b->option ) {
				echo '<input value="' . $b->identifier . '" type="text" class="medium-text" disabled />';
				echo '<label> min-width</label> <input value="' . $b->minWidth . '" type="number" class="medium-text" disabled />';
				echo '<label> max-width</label> <input value="' . $b->maxWidth . '" type="number" class="medium-text" disabled /> (default)<br/>';
			}
		}
		echo '<hr>';
	}

	$breakpoints = maybe_unserialize( get_option('dfw_breakpoints') );

	$i = 0;
	while ( $i < 5 ) {
		$identifier = ( isset( $breakpoints[$i]['identifier'] ) )? $breakpoints[$i]['identifier'] : '';
		$min_width = ( isset( $breakpoints[$i]['min-width'] ) )? $breakpoints[$i]['min-width'] : '';
		$max_width = ( isset( $breakpoints[$i]['max-width'] ) )? $breakpoints[$i]['max-width'] : ''; ?>
		<input value="<?php echo $identifier; ?>"
				placeholder="Name"
				name="dfw_breakpoints[<?php echo $i ?>][identifier]"
				type="text"
				class="medium-text" />
		<label> min-width
			<input
				value="<?php echo $min_width; ?>"
				placeholder="0"
				name="dfw_breakpoints[<?php echo $i ?>][min-width]"
				type="number"
				class="medium-text" />
		</label>
		<label> max-width
			<input
				value="<?php echo $max_width; ?>"
				placeholder="9999"
				name="dfw_breakpoints[<?php echo $i ?>][max-width]"
				type="number"
				class="medium-text" />
		</label><br/><?php
		$i++;
	}
	echo '<br><strong><i>*Ensure these breakpoints match sizemap.json in the plugin directory.</i></strong>';
}

function dfw_breakpoints_save($values) {
	$breakpoints = array();
	foreach ($values as $breakpoint) {
		if ( isset( $breakpoint['identifier'] ) && $breakpoint['identifier'] ) {
			$breakpoints[] = array(
				'identifier' => $breakpoint['identifier'],
				'min-width' => $breakpoint['min-width'],
				'max-width' => $breakpoint['max-width']
			);
		}
	}

	return $breakpoints;
}
