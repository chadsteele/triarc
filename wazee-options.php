<?php

// Default options values
$wazee_options = array(
	'wazee_user_name' => 'PLEASE CHANGE',
	'wazee_password' => 'PLEASE CHANGE',
	'wazee_api_key' => 'PLEASE CHANGE',
	'wazee_search_base' => 'PLEASE CHANGE'
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function wazee_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'wazee_theme_options', 'wazee_options', 'wazee_validate_options' );
}

add_action( 'admin_init', 'wazee_register_settings' );

function wazee_theme_options() {
	// Add theme options page to the addmin menu
	add_theme_page( 'Wazee Core Settings', 'Wazee Core Settings', 'edit_theme_options', 'wazee_core_settings', 'wazee_theme_options_page' );
}

add_action( 'admin_menu', 'wazee_theme_options' );

// Function to generate options page
function wazee_theme_options_page() {
	global $wazee_options, $wazee_categories, $wazee_layouts;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<?php echo "<h2>Wazee Parent Theme Options</h2>"; ?>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>
	
	<form method="post" action="options.php">
	
	<?php $settings = get_option( 'wazee_options', $wazee_options ); ?>
	
	<?php //print_r($settings); ?>
	
	<?php settings_fields( 'wazee_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>

	<h3>Wazee Core Integration</h3>
	
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

	<tr valign="top"><th scope="row"><label for="wazee_digital_key">Wazee Digital Key</label></th>
    <td>
    <input id="wazee_digital_key" name="wazee_options[wazee_digital_key]" style="width: 100%;" type="text" value="<?php  esc_attr_e($settings['wazee_digital_key']); ?>" />
    </td>
    </tr>
	
	<tr valign="top"><th scope="row"><label for="wazee_gateway_key">Gateway Key</label></th>
    <td>
    <input id="wazee_gateway_key" name="wazee_options[wazee_gateway_key]" style="width: 100%;" type="text" value="<?php  esc_attr_e($settings['wazee_gateway_key']); ?>" />
    </td>
    </tr>
	
	<tr valign="top"><th scope="row"><label for="wazee_endpoint">Wazee Endpoint URL</label></th>
    <td>
    <input id="wazee_endpoint" name="wazee_options[wazee_endpoint]" style="width: 100%;" type="text" value="<?php  esc_attr_e($settings['wazee_endpoint']); ?>" />
    </td>
    </tr>
	
	<!--<tr valign="top"><th scope="row"><label for="wazee_user_name">Wazee User Name</label></th>
    <td>
    <input id="wazee_user_name" name="wazee_options[wazee_user_name]" type="text" value="<?php  esc_attr_e($settings['wazee_user_name']); ?>" />
    </td>
    </tr>
	
	<tr valign="top"><th scope="row"><label for="wazee_password">Wazee Password</label></th>
    <td>
    <input id="wazee_password" name="wazee_options[wazee_password]" type="text" value="<?php  esc_attr_e($settings['wazee_password']); ?>" />
    </td>
    </tr>
	
	<tr valign="top"><th scope="row"><label for="wazee_api_key">Wazee API Key</label></th>
	<td>
	<input id="wazee_api_key" name="wazee_options[wazee_api_key]" type="text" value="<?php  esc_attr_e($settings['wazee_api_key']); ?>" />
    </td>
    </tr>-->
	
	<tr valign="top"><th scope="row"><label for="wazee_search_base">Wazee Search Base</label></th>
		<td>
			<input id="wazee_search_base" name="wazee_options[wazee_search_base]"  style="width: 100%;" type="text" value="<?php  esc_attr_e($settings['wazee_search_base']); ?>" />
		</td>
	</tr>
	
	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
	<input type="hidden" value="<?php echo $active_tab; ?>" name="wazee_options[tab]" />
	
	</form>
	
	</div>

	<?php
}

function wazee_validate_options( $input ) {
	global $wazee_options, $wazee_categories, $wazee_layouts;

	$settings = get_option( 'wazee_options', $wazee_options );
	
	//print_r($input); //debug
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['wazee_digital_key'] = wp_filter_post_kses( $input['wazee_digital_key'] );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['wazee_gateway_key'] = wp_filter_nohtml_kses( $input['wazee_gateway_key'] );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['wazee_endpoint'] = wp_filter_nohtml_kses( $input['wazee_endpoint'] );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	//$input['wazee_search_result_clips_per_page'] = wp_filter_nohtml_kses( $input['wazee_search_result_clips_per_page'] );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	//$input['wazee_search_result_bins_per_page'] = wp_filter_nohtml_kses( $input['wazee_search_result_bins_per_page'] );
	//$input['wazee_search_base'] = sanitize_text_field($input['wazee_search_base']);
	
	return $input;
}

endif;  // EndIf is_admin()