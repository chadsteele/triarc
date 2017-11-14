<?php

// Default options values
$triarc_options = array(
	'social_facebook_url' => '#',
	'social_twitter_url' => '#',
	'social_instagram_url' => '#',
	'social_pinterist_url' => '#',
	'search_full_entity_json' => '#',
	'search_competition_json' => '#',
	'search_season_json' => '#',
	'search_round_json' => '#',
	'search_game_json' => '#',
	'search_team_json' => '#',
	'search_venue_json' => '#',
	'search_player_json' => '#'
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function load_wp_media_files() 
{
	wp_enqueue_script('media-upload'); //Provides all the functions needed to upload, validate and give format to files.
	wp_enqueue_script('thickbox'); //Responsible for managing the modal window.
	wp_enqueue_style('thickbox'); //Provides the styles needed for this window.
}
add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );

wp_register_script( 'theme_options_media_uploader-script', get_stylesheet_directory_uri() . '/js/theme_options_media_uploader.js', array(), '20151117', true );
wp_enqueue_script( 'theme_options_media_uploader-script' );

function triarc_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'triarc_theme_options', 'triarc_options', 'triarc_validate_options' );
}

add_action( 'admin_init', 'triarc_register_settings' );

function triarc_theme_options() {
	// Add theme options page to the addmin menu
	add_theme_page( 'TRIARC Theme Options', 'TRIARC Theme Options', 'edit_theme_options', 'triarc_theme_options', 'triarc_theme_options_page' );
}

add_action( 'admin_menu', 'triarc_theme_options' );

// Function to generate options page
function triarc_theme_options_page() {
	global $triarc_options, $wazee_categories, $wazee_layouts;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<?php echo "<h2>TRIARC Theme Options</h2>"; ?>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>

	<?php
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'site';
	?>
	
	<h2 class="nav-tab-wrapper">
		<a href="?page=triarc_theme_options&tab=site" class="nav-tab <?php echo $active_tab == 'site' ? 'nav-tab-active' : ''; ?>">Site Templates</a>
		<a href="?page=triarc_theme_options&tab=home" class="nav-tab <?php echo $active_tab == 'home' ? 'nav-tab-active' : ''; ?>">Homepage Settings</a>
		<a href="?page=triarc_theme_options&tab=social" class="nav-tab <?php echo $active_tab == 'social' ? 'nav-tab-active' : ''; ?>">Social Settings</a>
		<a href="?page=triarc_theme_options&tab=search" class="nav-tab <?php echo $active_tab == 'search' ? 'nav-tab-active' : ''; ?>">Search Settings</a>
	</h2>
	
	
	<form method="post" action="options.php">
	
	<?php $settings = get_option( 'triarc_options', $triarc_options ); ?>
	
	<?php //print_r($settings); ?>
	
	<?php settings_fields( 'triarc_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>
	
	<?php if( $active_tab == 'site' ) { ?>
	
	<h3>Site Templates</h3>
		<?php
			//Getting array of Pages for use in this form
			$page_array = array();
			$type = 'page';
			$args=array(
			  'post_type' => $type,
			  'post_status' => 'publish',
			  'posts_per_page' => -1,
			  'caller_get_posts'=> 1);
			$page_query = null;
			$page_query = new WP_Query($args);
			if( $page_query->have_posts() ) 
			{
				while ($page_query->have_posts()) : $page_query->the_post();
					$id = get_the_ID();
					$title = get_the_title();
					$page_array[$id] = $title;
				endwhile;
			}
		wp_reset_query(); // Restore global post data stomped by the_post().  
			
		?>
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<!--Account Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_account">Account Page</label></th>
		<td>
		<select id="wazee_site_template_account" name="triarc_options[wazee_site_template_account]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_account'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Advanced Search Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_adv_search">Advanced Search Page</label></th>
		<td>
		<select id="wazee_site_template_adv_search" name="triarc_options[wazee_site_template_adv_search]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_adv_search'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Asset Detail Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_asset_detail">Asset Detail Page</label></th>
		<td>
		<select id="wazee_site_template_asset_detail" name="triarc_options[wazee_site_template_asset_detail]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_asset_detail'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Collections Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_collections">Collections Page</label></th>
		<td>
		<select id="wazee_site_template_collections" name="triarc_options[wazee_site_template_collections]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_collections'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Contact Us Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_contact">Contact Us Page</label></th>
		<td>
		<select id="wazee_site_template_contact" name="triarc_options[wazee_site_template_contact]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_contact'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Lightbox Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_lightbox">Lightbox Page</label></th>
		<td>
		<select id="wazee_site_template_lightbox" name="triarc_options[wazee_site_template_lightbox]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_lightbox'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Privacy Policy Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_privacy_policy">Privacy Policy Page</label></th>
		<td>
		<select id="wazee_site_template_privacy_policy" name="triarc_options[wazee_site_template_privacy_policy]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_privacy_policy'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Registration Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_registration">Registration Page</label></th>
		<td>
		<select id="wazee_site_template_registration" name="triarc_options[wazee_site_template_registration]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_registration'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Search Results Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_search_results">Search Results Page</label></th>
		<td>
		<select id="wazee_site_template_search_results" name="triarc_options[wazee_site_template_search_results]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_search_results'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--Terms of Use Page Template Designation-->
		<tr valign="top"><th scope="row"><label for="wazee_site_template_terms">Terms of Use Page</label></th>
		<td>
		<select id="wazee_site_template_terms" name="triarc_options[wazee_site_template_terms]">
	<?php	
		foreach($page_array as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_site_template_terms'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		</table>
		
		<h3>Default Content</h3>

		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<!--Default Thumbnail Image URL-->
		<tr valign="top"><th scope="row"><label for="triarc_default_thumbnail_url">Default Thumbnail URL</label></th>
			<td>
				<input id="triarc_default_thumbnail_url" name="triarc_options[triarc_default_thumbnail_url]" type="text" value="<?php  esc_attr_e($settings['triarc_default_thumbnail_url']); ?>" />
				<input id="triarc_default_thumbnail_url_button" class="button" name="triarc_default_thumbnail_url_button" type="text" value="Upload" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<img id="triarc_default_thumbnail_preview" src="<?php esc_attr_e($settings['triarc_default_thumbnail_url']); ?>" style="height: 100px;" />
			</th>
		</tr>
		
		</table>
		
		
	<?php } //End Site Templates Tab?>
	
	<?php if( $active_tab == 'home' ) { ?>
	
		<h3>Featured Collections</h3>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
	<?php
		//Getting array of Collection Content Types for use in form
		$collections = array();

		$type = 'collection';
		$args=array(
		  'post_type' => $type,
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'orderby' => 'title',
		  'order' => 'ASC',
		  'caller_get_posts'=> 1);
		
		$collections_query = null;
		$collections_query = new WP_Query($args);
		if( $collections_query->have_posts() ) 
		{
			while ($collections_query->have_posts()) : $collections_query->the_post();
				$id = get_the_ID();
				$title = get_the_title();
				$collections[$id] = $title;
			endwhile;
		}
		wp_reset_query(); // Restore global post data stomped by the_post().
	?>
		  
		<!--1 First Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_1">Featured Collection 1</label></th>
		<td>
		<select id="wazee_home_featured_1" name="triarc_options[wazee_home_featured_1]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_1'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--2 Second Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_2">Featured Collection 2</label></th>
		<td>
		<select id="wazee_home_featured_2" name="triarc_options[wazee_home_featured_2]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_2'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--3 Third Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_3">Featured Collection 3</label></th>
		<td>
		<select id="wazee_home_featured_3" name="triarc_options[wazee_home_featured_3]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_3'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--4 Forth Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_4">Featured Collection 4</label></th>
		<td>
		<select id="wazee_home_featured_4" name="triarc_options[wazee_home_featured_4]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_4'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--5 Fifth Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_5">Featured Collection 5</label></th>
		<td>
		<select id="wazee_home_featured_5" name="triarc_options[wazee_home_featured_5]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_5'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--6 Sixth Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_6">Featured Collection 6</label></th>
		<td>
		<select id="wazee_home_featured_6" name="triarc_options[wazee_home_featured_6]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_6'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--8 Seventh Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_7">Featured Collection 7</label></th>
		<td>
		<select id="wazee_home_featured_7" name="triarc_options[wazee_home_featured_7]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_7'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--8 Eighth Featured Collection-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_8">Featured Collection 8</label></th>
		<td>
		<select id="wazee_home_featured_8" name="triarc_options[wazee_home_featured_8]">
	<?php	
		foreach($collections as $id => $title)
		{
			$select_text = "";
			if($settings['wazee_home_featured_8'] == $id){ $select_text = "selected"; }
			print('<option value="' . $id . '" ' . $select_text . '>' . $title . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
	
		</table>
		
		<h3>Featured Portfolios</h3>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
	
	<?php
		//Getting array of Portfolios Content Types for use in form
		$portfolios = array();

		$taxonomy = 'portfolio';
		$tax_terms = get_terms($taxonomy);
		
		foreach ($tax_terms as $tax_term) 
		{
			$portfolios[] = $tax_term->name;
		}
	?>
		<!--1 First Featured portfolio-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_portfolio_1">Featured Portfolio 1</label></th>
		<td>
		<select id="wazee_home_featured_portfolio_1" name="triarc_options[wazee_home_featured_portfolio_1]">
	<?php	
		foreach($portfolios as $name)
		{
			$select_text = "";
			if($settings['wazee_home_featured_portfolio_1'] == $name){ $select_text = "selected"; }
			print('<option value="' . $name . '" ' . $select_text . '>' . $name . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--2 Second Featured portfolio-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_portfolio_2">Featured Portfolio 2</label></th>
		<td>
		<select id="wazee_home_featured_portfolio_2" name="triarc_options[wazee_home_featured_portfolio_2]">
	<?php	
		foreach($portfolios as $name)
		{
			$select_text = "";
			if($settings['wazee_home_featured_portfolio_2'] == $name){ $select_text = "selected"; }
			print('<option value="' . $name . '" ' . $select_text . '>' . $name . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--3 Third Featured portfolio-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_portfolio_3">Featured Portfolio 3</label></th>
		<td>
		<select id="wazee_home_featured_portfolio_3" name="triarc_options[wazee_home_featured_portfolio_3]">
	<?php	
		foreach($portfolios as $name)
		{
			$select_text = "";
			if($settings['wazee_home_featured_portfolio_3'] == $name){ $select_text = "selected"; }
			print('<option value="' . $name . '" ' . $select_text . '>' . $name . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--4 Fourth Featured portfolio-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_portfolio_4">Featured Portfolio 4</label></th>
		<td>
		<select id="wazee_home_featured_portfolio_4" name="triarc_options[wazee_home_featured_portfolio_4]">
	<?php	
		foreach($portfolios as $name)
		{
			$select_text = "";
			if($settings['wazee_home_featured_portfolio_4'] == $name){ $select_text = "selected"; }
			print('<option value="' . $name . '" ' . $select_text . '>' . $name . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		<!--5 Fifth Featured portfolio-->
		<tr valign="top"><th scope="row"><label for="wazee_home_featured_portfolio_5">Featured Portfolio 5</label></th>
		<td>
		<select id="wazee_home_featured_portfolio_5" name="triarc_options[wazee_home_featured_portfolio_5]">
	<?php	
		foreach($portfolios as $name)
		{
			$select_text = "";
			if($settings['wazee_home_featured_portfolio_5'] == $name){ $select_text = "selected"; }
			print('<option value="' . $name . '" ' . $select_text . '>' . $name . '</option>');
		}
	?>
		</select>
		</td>
		</tr>
		
		</table>
		
		<h3>Featured Videos</h3>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_youtube_1">Feature Video 1 YouTube ID</label></th>
			<td>
				<input id="iof_home_featured_video_youtube_1" name="triarc_options[iof_home_featured_video_youtube_1]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_youtube_1']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_title_1">Feature Video 1 Title</label></th>
			<td>
				<input id="iof_home_featured_video_title_1" name="triarc_options[iof_home_featured_video_title_1]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_title_1']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_description_1">Feature Video 1 Description</label></th>
			<td>
				<input id="iof_home_featured_video_description_1" name="triarc_options[iof_home_featured_video_description_1]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_description_1']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_id_1">Feature Video 1 ID</label></th>
			<td>
				<input id="iof_home_featured_video_id_1" name="triarc_options[iof_home_featured_video_id_1]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_id_1']); ?>" />
			</td>
		</tr>
	
		</table>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_youtube_2">Feature Video 2 YouTube ID</label></th>
			<td>
				<input id="iof_home_featured_video_youtube_12" name="triarc_options[iof_home_featured_video_youtube_2]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_youtube_2']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_title_2">Feature Video 2 Title</label></th>
			<td>
				<input id="iof_home_featured_video_title_2" name="triarc_options[iof_home_featured_video_title_2]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_title_2']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_description_2">Feature Video 2 Description</label></th>
			<td>
				<input id="iof_home_featured_video_description_2" name="triarc_options[iof_home_featured_video_description_2]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_description_2']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_id_2">Feature Video 2 ID</label></th>
			<td>
				<input id="iof_home_featured_video_id_2" name="triarc_options[iof_home_featured_video_id_2]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_id_2']); ?>" />
			</td>
		</tr>
	
		</table>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_youtube_3">Feature Video 3 YouTube ID</label></th>
			<td>
				<input id="iof_home_featured_video_youtube_3" name="triarc_options[iof_home_featured_video_youtube_3]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_youtube_3']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_title_3">Feature Video 3 Title</label></th>
			<td>
				<input id="iof_home_featured_video_title_3" name="triarc_options[iof_home_featured_video_title_3]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_title_3']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_description_3">Feature Video 3 Description</label></th>
			<td>
				<input id="iof_home_featured_video_description_3" name="triarc_options[iof_home_featured_video_description_3]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_description_3']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_id_3">Feature Video 3 ID</label></th>
			<td>
				<input id="iof_home_featured_video_id_3" name="triarc_options[iof_home_featured_video_id_3]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_id_3']); ?>" />
			</td>
		</tr>
	
		</table>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_youtube_4">Feature Video 4 YouTube ID</label></th>
			<td>
				<input id="iof_home_featured_video_youtube_4" name="triarc_options[iof_home_featured_video_youtube_4]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_youtube_4']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_title_4">Feature Video 4 Title</label></th>
			<td>
				<input id="iof_home_featured_video_title_4" name="triarc_options[iof_home_featured_video_title_4]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_title_4']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_description_4">Feature Video 4 Description</label></th>
			<td>
				<input id="iof_home_featured_video_description_4" name="triarc_options[iof_home_featured_video_description_4]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_description_4']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_id_4">Feature Video 4 ID</label></th>
			<td>
				<input id="iof_home_featured_video_id_4" name="triarc_options[iof_home_featured_video_id_4]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_id_4']); ?>" />
			</td>
		</tr>
	
		</table>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_youtube_5">Feature Video 5 YouTube ID</label></th>
			<td>
				<input id="iof_home_featured_video_youtube_5" name="triarc_options[iof_home_featured_video_youtube_5]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_youtube_5']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_title_5">Feature Video 5 Title</label></th>
			<td>
				<input id="iof_home_featured_video_title_5" name="triarc_options[iof_home_featured_video_title_5]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_title_5']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_description_5">Feature Video 5 Description</label></th>
			<td>
				<input id="iof_home_featured_video_description_5" name="triarc_options[iof_home_featured_video_description_5]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_description_5']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_id_5">Feature Video 5 ID</label></th>
			<td>
				<input id="iof_home_featured_video_id_5" name="triarc_options[iof_home_featured_video_id_5]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_id_5']); ?>" />
			</td>
		</tr>
	
		</table>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_youtube_6">Feature Video 6 YouTube ID</label></th>
			<td>
				<input id="iof_home_featured_video_youtube_6" name="triarc_options[iof_home_featured_video_youtube_6]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_youtube_6']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_title_6">Feature Video 6 Title</label></th>
			<td>
				<input id="iof_home_featured_video_title_6" name="triarc_options[iof_home_featured_video_title_6]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_title_6']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_description_6">Feature Video 6 Description</label></th>
			<td>
				<input id="iof_home_featured_video_description_6" name="triarc_options[iof_home_featured_video_description_6]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_description_6']); ?>" />
			</td>
		</tr>
		<tr valign="top"><th scope="row"><label for="iof_home_featured_video_id_6">Feature Video 6 ID</label></th>
			<td>
				<input id="iof_home_featured_video_id_6" name="triarc_options[iof_home_featured_video_id_6]" type="text" value="<?php  esc_attr_e($settings['iof_home_featured_video_id_6']); ?>" />
			</td>
		</tr>
	
		</table>
	
	<?php } //End Home Tab?>
	
	<?php if( $active_tab == 'social' ) { ?>
	
	<h3>Social Settings</h3>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="social_facebook_url">Facebook URL</label></th>
			<td>
				<input id="social_facebook_url" name="triarc_options[social_facebook_url]" type="text" value="<?php  esc_attr_e($settings['social_facebook_url']); ?>" />
			</td>
		</tr>
		
		<tr valign="top"><th scope="row"><label for="social_instagram_url">Instagram URL</label></th>
			<td>
				<input id="social_instagram_url" name="triarc_options[social_instagram_url]" type="text" value="<?php  esc_attr_e($settings['social_instagram_url']); ?>" />
			</td>
		</tr>
		
		<tr valign="top"><th scope="row"><label for="social_twitter_url">Twitter URL</label></th>
			<td>
				<input id="social_twitter_url" name="triarc_options[social_twitter_url]" type="text" value="<?php  esc_attr_e($settings['social_twitter_url']); ?>" />
			</td>
		</tr>
		
		<tr valign="top"><th scope="row"><label for="social_pinterest_url">Pinterest URL</label></th>
			<td>
				<input id="social_pinterest_url" name="triarc_options[social_pinterest_url]" type="text" value="<?php  esc_attr_e($settings['social_pinterest_url']); ?>" />
			</td>
		</tr>
	
		</table>
	
	<?php } //End Social Tab?>
	
	<?php if( $active_tab == 'search' ) { ?>
	
	<h3>Search Settings</h3>
		
		<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
		
		<tr valign="top"><th scope="row"><label for="wazee_search_result_clips_per_page">Search Results per Page</label></th>
			<td>
				<input id="wazee_search_result_clips_per_page" name="triarc_options[wazee_search_result_clips_per_page]" type="text" value="<?php  esc_attr_e($settings['wazee_search_result_clips_per_page']); ?>" />
			</td>
		</tr>
	
		<tr valign="top"><th scope="row"><label for="wazee_search_result_infinite_preload_number">Infinite Pre-load Number</label></th>
			<td>
				<input id="wazee_search_result_infinite_preload_number" name="triarc_options[wazee_search_result_infinite_preload_number]" type="text" value="<?php  esc_attr_e($settings['wazee_search_result_infinite_preload_number']); ?>" />
				<i>The number of assets to preload in the background.</i>
			</td>
		</tr>
		
		<tr valign="top"><th scope="row"><label for="wazee_search_result_infinite_preload_threshold">Infinite Pre-load Threshold</label></th>
			<td>
				<input id="wazee_search_result_infinite_preload_threshold" name="triarc_options[wazee_search_result_infinite_preload_threshold]" type="text" value="<?php  esc_attr_e($settings['wazee_search_result_infinite_preload_threshold']); ?>" />
				<i>px.  This is the distance from the bottom of the page on scroll which will trigger a preload in the background.</i>
			</td>
		</tr>
		
		<tr valign="top"><th scope="row"><label for="wazee_search_result_lazy_threshold">Infinite Lazy-Load Threshold</label></th>
			<td>
				<input id="wazee_search_result_lazy_threshold" name="triarc_options[wazee_search_result_lazy_threshold]" type="text" value="<?php  esc_attr_e($settings['wazee_search_result_lazy_threshold']); ?>" />
				<i>px.  This is the distance from the individual thumnbnail to trigger the img to load.</i>
			</td>
		</tr>
	
		<!--<tr valign="top"><th scope="row"><label for="wazee_search_result_bins_per_page">Search results (bins) per page</label></th>
			<td>
				<input id="wazee_search_result_bins_per_page" name="triarc_options[wazee_search_result_bins_per_page]" type="text" value="<?php  //esc_attr_e($settings['wazee_search_result_bins_per_page']); ?>" />
			</td>
		</tr>-->
	
		</table>
	
	<?php } //End Search Tab?>
	
	<?php if( $active_tab == 'wazee' ) { ?>

	<h3>Wazee Core Integration</h3>
	
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

		<tr valign="top"><th scope="row"><label for="wazee_user_name">Wazee User Name</label></th>
			<td>
				<input id="wazee_user_name" name="triarc_options[wazee_user_name]" type="text" value="<?php  esc_attr_e($settings['wazee_user_name']); ?>" />
			</td>
		</tr>
		
		<tr valign="top"><th scope="row"><label for="wazee_password">Wazee Password</label></th>
			<td>
				<input id="wazee_password" name="triarc_options[wazee_password]" type="text" value="<?php  esc_attr_e($settings['wazee_password']); ?>" />
			</td>
		</tr>
		
		<tr valign="top"><th scope="row"><label for="wazee_api_key">Wazee API Key</label></th>
			<td>
				<input id="wazee_api_key" name="triarc_options[wazee_api_key]" type="text" value="<?php  esc_attr_e($settings['wazee_api_key']); ?>" />
			</td>
		</tr>
	
	</table>

	<?php } //End Wazee Tab?>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
	<input type="hidden" value="<?php echo $active_tab; ?>" name="triarc_options[tab]" />
	
	</form>
	
	</div>

	<?php
}

function triarc_validate_options( $input ) {
	global $triarc_options, $wazee_categories, $wazee_layouts;

	$settings = get_option( 'triarc_options', $triarc_options );
	
	//print_r($input); //debug
	
	//Wazee Integration Tab
	if($input['tab'] == "wazee")
	{
		// We strip all tags from the text field, to avoid vulnerablilties like XSS
		$input['wazee_user_name'] = wp_filter_post_kses( $input['wazee_user_name'] );
		
		// We strip all tags from the text field, to avoid vulnerablilties like XSS
		$input['wazee_password'] = wp_filter_nohtml_kses( $input['wazee_password'] );
		
		// We strip all tags from the text field, to avoid vulnerablilties like XSS
		$input['wazee_api_key'] = wp_filter_nohtml_kses( $input['wazee_api_key'] );
	}
	else
	{
		$input['wazee_user_name'] = $settings['wazee_user_name'];
		$input['wazee_password'] = $settings['wazee_password'];
		$input['wazee_api_key'] = $settings['wazee_api_key'];
	}
	
	//Site Template Tab
	if($input['tab'] == "site")
	{
		$input['wazee_site_template_account'] = wp_filter_nohtml_kses( $input['wazee_site_template_account'] );
		$input['wazee_site_template_adv_search'] = wp_filter_nohtml_kses( $input['wazee_site_template_adv_search'] );
		$input['wazee_site_template_asset_detail'] = wp_filter_nohtml_kses( $input['wazee_site_template_asset_detail'] );
		$input['wazee_site_template_lightbox'] = wp_filter_nohtml_kses( $input['wazee_site_template_lightbox'] );
		$input['wazee_site_template_search_results'] = wp_filter_nohtml_kses( $input['wazee_site_template_search_results'] );
		$input['wazee_site_template_registration'] = wp_filter_nohtml_kses( $input['wazee_site_template_registration'] );
		$input['wazee_site_template_contact'] = wp_filter_nohtml_kses( $input['wazee_site_template_contact'] );
		$input['wazee_site_template_collections'] = wp_filter_nohtml_kses( $input['wazee_site_template_collections'] );
		$input['wazee_site_template_privacy_policy'] = wp_filter_nohtml_kses( $input['wazee_site_template_privacy_policy'] );
		$input['wazee_site_template_terms'] = wp_filter_nohtml_kses( $input['wazee_site_template_terms'] );
		$input['triarc_default_thumbnail_url'] = wp_filter_nohtml_kses( $input['triarc_default_thumbnail_url'] );
	}
	else
	{
		$input['wazee_site_template_account'] = $settings['wazee_site_template_account'];
		$input['wazee_site_template_adv_search'] = $settings['wazee_site_template_adv_search'];
		$input['wazee_site_template_asset_detail'] = $settings['wazee_site_template_asset_detail'];
		$input['wazee_site_template_lightbox'] = $settings['wazee_site_template_lightbox'];
		$input['wazee_site_template_search_results'] = $settings['wazee_site_template_search_results'];
		$input['wazee_site_template_registration'] = $settings['wazee_site_template_registration'];
		$input['wazee_site_template_contact'] = $settings['wazee_site_template_contact'];
		$input['wazee_site_template_collections'] = $settings['wazee_site_template_collections'];
		$input['wazee_site_template_privacy_policy'] = $settings['wazee_site_template_privacy_policy'];
		$input['wazee_site_template_terms'] = $settings['wazee_site_template_terms'];
		$input['triarc_default_thumbnail_url'] = $settings['triarc_default_thumbnail_url'];
	}
	
	//Home Page Settings
	if($input['tab'] == "home")
	{
		// We strip all tags from the text field, to avoid vulnerablilties like XSS
		$input['wazee_home_featured_1'] = wp_filter_nohtml_kses( $input['wazee_home_featured_1'] );
		$input['wazee_home_featured_2'] = wp_filter_nohtml_kses( $input['wazee_home_featured_2'] );
		$input['wazee_home_featured_3'] = wp_filter_nohtml_kses( $input['wazee_home_featured_3'] );
		$input['wazee_home_featured_4'] = wp_filter_nohtml_kses( $input['wazee_home_featured_4'] );
		$input['wazee_home_featured_5'] = wp_filter_nohtml_kses( $input['wazee_home_featured_5'] );
		$input['wazee_home_featured_6'] = wp_filter_nohtml_kses( $input['wazee_home_featured_6'] );
		$input['wazee_home_featured_7'] = wp_filter_nohtml_kses( $input['wazee_home_featured_7'] );
		$input['wazee_home_featured_8'] = wp_filter_nohtml_kses( $input['wazee_home_featured_8'] );
		$input['wazee_home_featured_portfolio_1'] = wp_filter_nohtml_kses( $input['wazee_home_featured_portfolio_1'] );
		$input['wazee_home_featured_portfolio_2'] = wp_filter_nohtml_kses( $input['wazee_home_featured_portfolio_2'] );
		$input['wazee_home_featured_portfolio_3'] = wp_filter_nohtml_kses( $input['wazee_home_featured_portfolio_3'] );
		$input['wazee_home_featured_portfolio_4'] = wp_filter_nohtml_kses( $input['wazee_home_featured_portfolio_4'] );
		$input['wazee_home_featured_portfolio_5'] = wp_filter_nohtml_kses( $input['wazee_home_featured_portfolio_5'] );
		$input['iof_home_featured_video_youtube_1'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_youtube_1'] );
		$input['iof_home_featured_video_title_1'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_title_1'] );
		$input['iof_home_featured_video_description_1'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_description_1'] );
		$input['iof_home_featured_video_id_1'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_id_1'] );
		$input['iof_home_featured_video_youtube_2'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_youtube_2'] );
		$input['iof_home_featured_video_title_2'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_title_2'] );
		$input['iof_home_featured_video_description_2'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_description_2'] );
		$input['iof_home_featured_video_id_2'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_id_2'] );
		$input['iof_home_featured_video_youtube_3'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_youtube_3'] );
		$input['iof_home_featured_video_title_3'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_title_3'] );
		$input['iof_home_featured_video_description_3'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_description_3'] );
		$input['iof_home_featured_video_id_3'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_id_3'] );
		$input['iof_home_featured_video_youtube_4'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_youtube_4'] );
		$input['iof_home_featured_video_title_4'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_title_4'] );
		$input['iof_home_featured_video_description_4'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_description_4'] );
		$input['iof_home_featured_video_id_4'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_id_4'] );
		$input['iof_home_featured_video_youtube_5'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_youtube_5'] );
		$input['iof_home_featured_video_title_5'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_title_5'] );
		$input['iof_home_featured_video_description_5'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_description_5'] );
		$input['iof_home_featured_video_id_5'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_id_5'] );
		$input['iof_home_featured_video_youtube_6'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_youtube_6'] );
		$input['iof_home_featured_video_title_6'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_title_6'] );
		$input['iof_home_featured_video_description_6'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_description_6'] );
		$input['iof_home_featured_video_id_6'] = wp_filter_nohtml_kses( $input['iof_home_featured_video_id_6'] );
	}
	else
	{
		$input['wazee_home_featured_1'] = $settings['wazee_home_featured_1'];
		$input['wazee_home_featured_2'] = $settings['wazee_home_featured_2'];
		$input['wazee_home_featured_3'] = $settings['wazee_home_featured_3'];
		$input['wazee_home_featured_4'] = $settings['wazee_home_featured_4'];
		$input['wazee_home_featured_5'] = $settings['wazee_home_featured_5'];
		$input['wazee_home_featured_6'] = $settings['wazee_home_featured_6'];
		$input['wazee_home_featured_7'] = $settings['wazee_home_featured_7'];
		$input['wazee_home_featured_8'] = $settings['wazee_home_featured_8'];
		$input['wazee_home_featured_portfolio_1'] = $settings['wazee_home_featured_portfolio_1'];
		$input['wazee_home_featured_portfolio_2'] = $settings['wazee_home_featured_portfolio_2'];
		$input['wazee_home_featured_portfolio_3'] = $settings['wazee_home_featured_portfolio_3'];
		$input['wazee_home_featured_portfolio_4'] = $settings['wazee_home_featured_portfolio_4'];
		$input['wazee_home_featured_portfolio_5'] = $settings['wazee_home_featured_portfolio_5'];
		$input['iof_home_featured_video_youtube_1'] = $settings['iof_home_featured_video_youtube_1'];
		$input['iof_home_featured_video_title_1'] = $settings['iof_home_featured_video_title_1'];
		$input['iof_home_featured_video_description_1'] = $settings['iof_home_featured_video_description_1'];
		$input['iof_home_featured_video_id_1'] = $settings['iof_home_featured_video_id_1'];
		$input['iof_home_featured_video_youtube_2'] = $settings['iof_home_featured_video_youtube_2'];
		$input['iof_home_featured_video_title_2'] = $settings['iof_home_featured_video_title_2'];
		$input['iof_home_featured_video_description_2'] = $settings['iof_home_featured_video_description_2'];
		$input['iof_home_featured_video_id_2'] = $settings['iof_home_featured_video_id_2'];
		$input['iof_home_featured_video_youtube_3'] = $settings['iof_home_featured_video_youtube_3'];
		$input['iof_home_featured_video_title_3'] = $settings['iof_home_featured_video_title_3'];
		$input['iof_home_featured_video_description_3'] = $settings['iof_home_featured_video_description_3'];
		$input['iof_home_featured_video_id_3'] = $settings['iof_home_featured_video_id_3'];
		$input['iof_home_featured_video_youtube_4'] = $settings['iof_home_featured_video_youtube_4'];
		$input['iof_home_featured_video_title_4'] = $settings['iof_home_featured_video_title_4'];
		$input['iof_home_featured_video_description_4'] = $settings['iof_home_featured_video_description_4'];
		$input['iof_home_featured_video_id_4'] = $settings['iof_home_featured_video_id_4'];
		$input['iof_home_featured_video_youtube_5'] = $settings['iof_home_featured_video_youtube_5'];
		$input['iof_home_featured_video_title_5'] = $settings['iof_home_featured_video_title_5'];
		$input['iof_home_featured_video_description_5'] = $settings['iof_home_featured_video_description_5'];
		$input['iof_home_featured_video_id_5'] = $settings['iof_home_featured_video_id_5'];
		$input['iof_home_featured_video_youtube_6'] = $settings['iof_home_featured_video_youtube_6'];
		$input['iof_home_featured_video_title_6'] = $settings['iof_home_featured_video_title_6'];
		$input['iof_home_featured_video_description_6'] = $settings['iof_home_featured_video_description_6'];
		$input['iof_home_featured_video_id_6'] = $settings['iof_home_featured_video_id_6'];
	}
	
	//Social Settings
	if($input['tab'] == "social")
	{
		$input['social_facebook_url'] = wp_filter_nohtml_kses( $input['social_facebook_url'] );
		$input['social_twitter_url'] = wp_filter_nohtml_kses( $input['social_twitter_url'] );
		$input['social_instagram_url'] = wp_filter_nohtml_kses( $input['social_instagram_url'] );
		$input['social_pinterest_url'] = wp_filter_nohtml_kses( $input['social_pinterest_url'] );
	}
	else
	{
		$input['social_facebook_url'] = $settings['social_facebook_url'];
		$input['social_instagram_url'] = $settings['social_instagram_url'];
		$input['social_twitter_url'] = $settings['social_twitter_url'];
		$input['social_pinterest_url'] = $settings['social_pinterest_url'];
	}
	
	//Search Settings
	if($input['tab'] == "search")
	{
		// We strip all tags from the text field, to avoid vulnerablilties like XSS
		$input['wazee_search_result_clips_per_page'] = wp_filter_nohtml_kses( $input['wazee_search_result_clips_per_page'] );
		$input['wazee_search_result_infinite_preload_number'] = wp_filter_nohtml_kses( $input['wazee_search_result_infinite_preload_number'] );
		$input['wazee_search_result_infinite_preload_threshold'] = wp_filter_nohtml_kses( $input['wazee_search_result_infinite_preload_threshold'] );
		$input['wazee_search_result_lazy_threshold'] = wp_filter_nohtml_kses( $input['wazee_search_result_lazy_threshold'] );
	}
	else
	{
		$input['wazee_search_result_clips_per_page'] = $settings['wazee_search_result_clips_per_page'];
		$input['wazee_search_result_infinite_preload_number'] = $settings['wazee_search_result_infinite_preload_number'];
		$input['wazee_search_result_infinite_preload_threshold'] = $settings['wazee_search_result_infinite_preload_threshold'];
		$input['wazee_search_result_lazy_threshold'] = $settings['wazee_search_result_lazy_threshold'];
	}
	
	return $input;
}

endif;  // EndIf is_admin()

?>