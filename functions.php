<?php



function register_my_menus() {

  register_nav_menus(
    array(
      'main-nav' => __( 'Main  Navigation' )
    )
  );

    register_nav_menus(
    array(
      'footer_1' => __( 'footer 1' )
    )
  );

  register_nav_menus(
    array(
      'footer_2' => __( 'footer 2' )
    )
  );

  register_nav_menus(
    array(
      'footer_3' => __( 'footer 3' )
    )
  );

  register_nav_menus(
    array(
      'footer_4' => __( 'footer 4' )
    )
  );

  register_nav_menus(
    array(
      'footer_5' => __( 'footer 5' )
    )
  );
  
   register_nav_menus(
    array(
      'footer_6' => __( 'footer 6' )
    )
  );
  register_nav_menus(
    array(
      'mid_countries' => __( 'countries' )
    )
  );

  register_nav_menus(
    array(
      'mid_artDesign' => __( 'Art Design' )
    )
  );

  register_nav_menus(
    array(
      'mid_religion' => __( 'Religion' )
    )
  );

  register_nav_menus(
    array(
      'mid_landscape' => __( 'Landscape' )
    )
  );

  register_nav_menus(
    array(
      'mid_society' => __( 'Society' )
    )
  );

  register_nav_menus(
    array(
      'mid_currentafairs' => __( 'Current afairs' )
    )
  );

  
   
  
}
add_action( 'init', 'register_my_menus' );

/*WAZEE API STUFF*/

//Wazee Theme Options
global $wazee_options;
$wazee_settings = get_option( 'wazee_options', $wazee_options );

// REMOVE WP header info & Login errors
remove_action('wp_head', 'wp_generator');

//initiate wazee stuff
require_once(get_stylesheet_directory() . '/init_wazee_parent.php');

if(is_admin()) // Load only if we are viewing an admin page
{
	require_once(get_stylesheet_directory() . "/wazee-options.php");
}

//TRI-ARC Theme Options
global $triarc_options;
$triarc_settings = get_option( 'triarc_options', $triarc_options );

//initiate wazee stuff
require_once(get_stylesheet_directory() . "/init_wazee.php");

if(is_admin()) // Load only if we are viewing an admin page
{
	require_once(get_stylesheet_directory() . "/triarc-theme-options.php");
}

//Meta Boxes for various Custom Fields Required
include(get_stylesheet_directory() . "/meta-boxes.php");

add_theme_support( 'post-thumbnails', array( 'post', 'page', 'collection', 'documentary' ) );

//Collection Custom Content Type
function create_collection_post_type() {
	register_post_type( 'collection',
		array(
			'labels' => array(
				'name' => __( 'Collections' ),
				'all_items' => __( 'All Collections' ),
				'singular_name' => __( 'collection' ),
				'add_new' => __( 'Add New Collection' ),
				'add_new_item' => __( 'Add New Collection' ),
				'edit_item' => __( 'Edit Collection' ),
				'new_item' => __( 'Add New Collection' ),
				'view_item' => __( 'View Collection' ),
				'search_items' => __( 'Search Collection' ),
				'not_found' => __( 'No collections found' ),
				'not_found_in_trash' => __( 'No collections found in trash' )
			),
			'description' => 'Custom Collection of Assets',
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'capability_type' => 'collection',
			'rewrite' => array("slug" => "collections"), // Permalinks format
			'menu_position' => 5,
			'menu_icon' => 'dashicons-format-gallery',
			'taxonomies' => array('portfolio'),
			'map_meta_cap' => true
		)
	);
}
add_action( 'init', 'create_collection_post_type' );

//Documentary Custom Content Type
function create_documentary_post_type() {
	register_post_type( 'documentary',
		array(
			'labels' => array(
				'name' => __( 'Documentaries' ),
				'all_items' => __( 'All Documentaries' ),
				'singular_name' => __( 'documentary' ),
				'add_new' => __( 'Add New Documentary' ),
				'add_new_item' => __( 'Add New Documentary' ),
				'edit_item' => __( 'Edit Documentary' ),
				'new_item' => __( 'Add New Documentary' ),
				'view_item' => __( 'View Documentary' ),
				'search_items' => __( 'Search Documentary' ),
				'not_found' => __( 'No documentaries found' ),
				'not_found_in_trash' => __( 'No documentaries found in trash' )
			),
			'description' => 'Custom Documentary Post Type',
			'public' => true,
			'has_archive' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			'capability_type' => 'documentary',
			'rewrite' => array("slug" => "documentaries"), // Permalinks format
			'menu_position' => 5,
			'menu_icon' => 'dashicons-format-gallery',
			'taxonomies' => array('portfolio'),
			'map_meta_cap' => true
		)
	);
}
add_action( 'init', 'create_documentary_post_type' );

//Custom Taxonomy for Collection of Collections Grouping, AKA - Portfolio
function create_portfolio_taxonomy() {
	// create a new taxonomy
	register_taxonomy(
		'portfolio',
		array('collection', 'documentary'),
		array(
			'labels' => array(
				'name'              => _x( 'Portfolios', 'taxonomy general name' ),
				'singular_name'     => _x( 'Portfolio', 'taxonomy singular name' ),
				'search_items'      => __( 'Search Portfolios' ),
				'all_items'         => __( 'All Portfolios' ),
				'parent_item'       => __( 'Parent Portfolio' ),
				'parent_item_colon' => __( 'Parent Portfolio:' ),
				'edit_item'         => __( 'Edit Portfolio' ),
				'update_item'       => __( 'Update Portfolio' ),
				'add_new_item'      => __( 'Add New Portfolio' ),
				'new_item_name'     => __( 'New Portfolio Name' ),
				'menu_name'         => __( 'Portfolios' ),
				'not_found'			=> __( 'No portfolios found' )
			),
			'rewrite' => array( 'slug' => 'portfolio' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'create_portfolio_taxonomy' );

function additional_scripts_with_the_lot()
{
    // Register the script like this for a theme:
	wp_register_script( 'spin-script', get_stylesheet_directory_uri() . '/js/spin.min.js', array(), '20171010', true );
	wp_register_script( 'lazy-script', get_stylesheet_directory_uri() . '/js/jquery.lazyload.min.js', array( 'jquery' ), '20171010', true );
	wp_register_script( 'videojs-script', 'http://vjs.zencdn.net/5.7.1/video.js', array(), '20171010', true );
	//wp_register_script( 'bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '20171015', true );
	//wp_register_script( 'videojs-marker-script', get_stylesheet_directory_uri() . '/js/videojs-markers.min.js', array(), '20151117', true );
 
    // For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'spin-script' );
	wp_enqueue_script( 'lazy-script' );
	wp_enqueue_script( 'videojs-script' );
	//wp_enqueue_script( 'bootstrap-script' );
	//wp_enqueue_script( 'videojs-marker-script' );
}
add_action( 'wp_enqueue_scripts', 'additional_scripts_with_the_lot' );

function additional_styles_with_the_lot()
{
	wp_register_style( 'videojs-style', 'http://vjs.zencdn.net/5.7.1/video-js.css', array(), '20171010', 'all' );
	wp_enqueue_style( 'videojs-style' );
}
add_action( 'wp_enqueue_scripts', 'additional_styles_with_the_lot' );

/*AJAX CALLS*/

//This preloads infinite search items for collections (single-collection.php)
function preload_infinite_collections_ajax() 
{
	if(isset($_POST['q']))
	{
		/*$q = isset($_REQUEST['q']) ? strip_tags($_REQUEST['q']) : '';
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
		$isfirst = isset($_REQUEST['isfirst']) ? true : false;
		$page_size = isset($_REQUEST['page_size']) ? $_REQUEST['page_size'] : WAZEE_SEARCH_RESULT_INFINITE_PRELOAD_NUMBER;
		
		$t3_Clip_obj = new t3_Clip(WAZEE_USER_NAME, WAZEE_PASSWORD, WAZEE_API_KEY);
		$clip_data = $t3_Clip_obj->find_all(array('keywords' => $q, 'page' => $page, 'page_size' => $page_size, 'sort' => "-date"), "deep");
		*/
		//Prepare the Wazee Query parameters and variables
		$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
		$page_size = isset($_REQUEST['page_size']) ? $_REQUEST['page_size'] : WAZEE_SEARCH_RESULT_INFINITE_PRELOAD_NUMBER;
		
		$isfirst = isset($_REQUEST['isfirst']) ? true : false;

		//Initialize the keywords submission variable for Wazee
		$full_q = $q;

		$full_q = stripslashes($full_q);
					
		//sort_date
		$sort = "-date";

		$t3_Clip_obj = new t3_Clip(WAZEE_USER_NAME, WAZEE_PASSWORD, WAZEE_API_KEY);
		$clip_data = $t3_Clip_obj->find_all(array('keywords' => $full_q, 'page' => $page, 'page_size' => $page_size, 'sort' => $sort), "deep");
		
		//$results .= "<li>Page_size " . $page_size . "</li>";
		
		if (($page <= $clip_data->resultTotalPageCount) && !empty($clip_data))
		{
			$clip_count = 0;
			foreach ($clip_data->clips as $clip) 
			{
				if($isfirst && ($clip_count < WAZEE_SEARCH_RESULT_CLIPS_PER_PAGE))
				{
					$clip_count++;
					//$results .= "<li>Skipping " . $clip_count . "</li>";
				}
				else
				{
						//Thumbnail
						$thumbnail_url = $clip->thumbnail_https_url;//$clip->smallThumbnail->url;
						if(empty($thumbnail_url)){ $thumbnail_url = $clip->largeThumbnail->url; }
						
						$asset_description = str_replace('\n', " ", (empty($clip->description) ? "Not Available" : $clip->description)); //Replaces \n with spaces for these short descriptions
						$short_description_length = 100; //truncate length
						$short_asset_description = $asset_description;
						if(strlen($asset_description) > $short_description_length)
						{
							$short_asset_description =  substr($asset_description, 0, strpos($asset_description, ' ', $short_description_length)) . " ...";//truncated
						}
						$results .= '<li class="asset-thumb"><div class="ratio-wrapper"><div class="ratio"></div>';
							$results .= '<a class="img" href="' . get_permalink(WAZEE_SITE_TEMPLATE_ASSET_DETAIL) . '?id=' . $clip->id . '">';
								$results .= '<img class="lazy" src="' . $thumbnail_url . '">';
							$results .= '</a></div>';
							$results .= '<h4><span> ' . $clip->name . '&nbsp;</span>';
								$results .= '<a href="' . get_permalink(WAZEE_SITE_TEMPLATE_ASSET_DETAIL) . '?id=' . $clip->id . '"><img src="' . get_stylesheet_directory_uri() . '/img/cart_11.jpg"></a>';
								//$results .= '<a href="#"><img src="' . get_stylesheet_directory_uri() . '/img/cart_09.jpg"></a>';
								//$results .= '<a href="#"><img src="' . get_stylesheet_directory_uri() . '/img/cart_07.jpg"></a>';
							$results .= '</h4>';
							$results .= '<p>' . $clip->title . '</p>';
						$results .= '</li>';
					
				}
			}
		}
		
		echo $results;
		die();
	} //end if
}
add_action('wp_ajax_preload_infinite_collections_ajax_call', 'preload_infinite_collections_ajax');
add_action('wp_ajax_nopriv_preload_infinite_collections_ajax_call', 'preload_infinite_collections_ajax');//for users that are not logged in.

//This preloads infinite search items
function preload_infinite_results_ajax() 
{
	if(isset($_POST['q']))
	{
		//Prepare the Wazee Query parameters and variables
		$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
		$page_size = isset($_REQUEST['page_size']) ? $_REQUEST['page_size'] : WAZEE_SEARCH_RESULT_INFINITE_PRELOAD_NUMBER;
		
		$isfirst = isset($_REQUEST['isfirst']) ? true : false;

		//Initialize the keywords submission variable for Wazee
		$full_q = $q;

		$full_q = stripslashes($full_q);
					
		//sort_date
		$sort = "relevance";
		if($sort_date){$sort = "-date";}

		$t3_Clip_obj = new t3_Clip(WAZEE_USER_NAME, WAZEE_PASSWORD, WAZEE_API_KEY);
		$clip_data = $t3_Clip_obj->find_all(array('keywords' => $full_q, 'page' => $page, 'page_size' => $page_size, 'sort' => $sort), "deep");
		
		//$results .= "<li>Page_size " . $page_size . "</li>";
		
		if (($page <= $clip_data->resultTotalPageCount) && !empty($clip_data))
		{
			$clip_count = 0;
			foreach ($clip_data->clips as $clip) 
			{
				if($isfirst && ($clip_count < WAZEE_SEARCH_RESULT_CLIPS_PER_PAGE))
				{
					$clip_count++;
					//$results .= "<li>Skipping " . $clip_count . "</li>";
				}
				else
				{
					//Thumbnail
					$thumbnail_url = $clip->thumbnail_https_url;//$clip->smallThumbnail->url;
					if(empty($thumbnail_url)){ $thumbnail_url = $clip->largeThumbnail->url; }
					
					$asset_description = str_replace('\n', " ", (empty($clip->description) ? "Not Available" : $clip->description)); //Replaces \n with spaces for these short descriptions
					$short_description_length = 100; //truncate length
					$short_asset_description = $asset_description;
					if(strlen($asset_description) > $short_description_length)
					{
						$short_asset_description =  substr($asset_description, 0, strpos($asset_description, ' ', $short_description_length)) . " ...";//truncated
					}
					$results .= '<li class="asset-thumb"><div class="ratio-wrapper"><div class="ratio"></div>';
						$results .= '<a class="img" href="' . get_permalink(WAZEE_SITE_TEMPLATE_ASSET_DETAIL) . '?id=' . $clip->id . '">';
							$results .= '<img class="lazy" src="' . $thumbnail_url . '">';
						$results .= '</a></div>';
						$results .= '<h4><span> ' . $clip->name . '&nbsp;</span>';
							$results .= '<a href="' . get_permalink(WAZEE_SITE_TEMPLATE_ASSET_DETAIL) . '?id=' . $clip->id . '"><img src="' . get_stylesheet_directory_uri() . '/img/cart_11.jpg"></a>';
							//print('<a href="#"><img src="' . get_stylesheet_directory_uri() . '/img/cart_09.jpg"></a>');
							//print('<a href="#"><img src="' . get_stylesheet_directory_uri() . '/img/cart_07.jpg"></a>');
						$results .= '</h4>';
						$results .= '<p>' . $clip->title . '</p>';
					$results .= '</li>';
				}
			}
		}

		echo $results;
		die();
	} //end if
}
add_action('wp_ajax_preload_infinite_results_ajax_call', 'preload_infinite_results_ajax');
add_action('wp_ajax_nopriv_preload_infinite_results_ajax_call', 'preload_infinite_results_ajax');//for users that are not logged in.
	
