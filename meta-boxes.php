<?php
/*
This file is for setting up the Meta Boxes used by the Meta Box plugin.  These appear in the WP backend and facilitate backend content creation.
*/

add_filter( 'rwmb_meta_boxes', 'wazee_register_meta_boxes' );

function wazee_register_meta_boxes( $meta_boxes )
{
	$prefix = 'wazee_';
	
	//Collection Content Type Meta Box
	$meta_boxes[] = array(
		'title'      => __( 'Collection Asset Details', 'meta-box' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'collection', 'documentary' ),
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		// List of meta fields
		'fields'     => array(
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'Wazee Search String', 'meta-box' ),
				// Field ID, i.e. the meta key
				'id'    => "wazee_collection_search_string",
				// Field description (optional)
				'desc'  => __( 'This is the search string/filter provided to the Wazee search.', 'meta-box' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => __( sanitize_text_field($_REQUEST['search_string']), 'meta-box' ),
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => false,
			),
			//TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'Wazee Bin ID', 'meta-box' ),
				// Field ID, i.e. the meta key
				'id'    => "wazee_collection_bin_id",
				// Field description (optional)
				'desc'  => __( 'This is a specific Wazee Bin ID to be added to this collection. eg. 32286143', 'meta-box' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => __( '', 'meta-box' ),
				// Number of rows
				'rows'    => 1,
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => false,
			),
			//TEXT
			array(
				// Field name - Will be used as label
				'name'  => __( 'Wazee Asset ID(s)', 'meta-box' ),
				// Field ID, i.e. the meta key
				'id'    => "wazee_collection_asset_ids",
				// Field description (optional)
				'desc'  => __( 'This is a specific Wazee Asset ID to be added to this collection. eg. 37780812', 'meta-box' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => __( '', 'meta-box' ),
				// Number of rows
				'rows'    => 1,
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => true,
			),
		)
	);
	
	return $meta_boxes;
}


?>