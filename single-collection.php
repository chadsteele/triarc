<?php
/*
Template for single Collection post type
*/


require_once 'init_wazee.php';

//Prepare the Wazee Core API Call
$q = $collection_search_base = str_replace('-', '%2D', get_post_meta(get_the_ID(), "wazee_collection_search_string", TRUE));
//Collection Bin
$wazee_collection_bin_id = get_post_meta(get_the_ID(), "wazee_collection_bin_id", TRUE);
$wazee_collection_bin_asset_list = array(); //initiate
if(!empty($wazee_collection_bin_id))
{
	$t3_Bin_obj = new t3_Bin(WAZEE_USER_NAME, WAZEE_PASSWORD, WAZEE_API_KEY);
	$bin_data = $t3_Bin_obj->find($wazee_collection_bin_id);
	//print_r($bin_data); //debug
	foreach($bin_data->bins as $bin)
	{
		foreach($bin->clip as $clip)
		{
			$wazee_collection_bin_asset_list[] = $clip->name;
		}
	}
	
	foreach($wazee_collection_bin_asset_list as &$asset_id)
	{
		$asset_id = 'name:' . $asset_id;
	}
}

//Asset List Meta
$wazee_collection_asset_list = get_post_meta(get_the_ID(), "wazee_collection_asset_ids", TRUE);
//print_r($wazee_collection_asset_list); //debug
//((Newcastle Knights) OR id%3A37780812 OR id%3A37780801) //example of what we are crafting here
if(!empty($wazee_collection_asset_list))
{	
	//here we need to create a comprehensive query - so we aren't making a million API calls
	foreach($wazee_collection_asset_list as &$asset_id)
	{
		$asset_id = 'id:' . $asset_id;
	}
}

//print_r($wazee_collection_asset_list); //debug
//merge arrays for meta asset list and bin asset list
$merged_asset_list = array_merge((array)$wazee_collection_asset_list, (array)$wazee_collection_bin_asset_list);

//print_r($merged_asset_list); //debug

//Now build query string
if(!empty($collection_search_base))
{
	$q = '((' . $collection_search_base . ')';
}
else
{
	$q = "(";
}
if(!empty($collection_search_base) && (!empty($merged_asset_list) && !empty($merged_asset_list[0])))
{
	$q .= ' OR ';
}

if(!empty($merged_asset_list))
{
	$q .= implode(' OR ', $merged_asset_list) . ')';
}
else
{
	$q .= ')';
}
	
//print($q); //debug

$page = (get_query_var('page')) ? get_query_var('page') : 0;
$current_page = $page;

$t3_Clip_obj = new t3_Clip(WAZEE_USER_NAME, WAZEE_PASSWORD, WAZEE_API_KEY);
$clip_data = $t3_Clip_obj->find_all(array('keywords' => $q, 'page' => $page, 'sort' => "-date"), "deep");
//print_r($clip_data); //debug

get_header(); 
require_once(get_stylesheet_directory() .'/search-bar.php');
?>

<div id="page-top" >
	<div class="container-fluid">
	<div class="row">
   
	<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
   
   <?php
	if(has_post_thumbnail())
	{
		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);
		print('<div class="collect-annotated" style="background-image: url(\'' . $thumb_url[0] . '\');">');
			print('<div class="text col-md-4 col-sm-6 col-xs-12 pull-left mx-5">');
				print('<h1>' . get_the_title() . '</h1>');
				print('<p>' . get_the_content() . '</p>');
			print('</div>');
		print('</div>');
	}
	else
	{
		print('<div class="collect-annotated">');
			print('<div class="text col-xs-12 col-lg-6 col-xl-4 pull-left mx-5">');
				print('<h1>' . get_the_title() . '</h1>');
				print('<p>' . get_the_content() . '</p>');
			print('</div>');
		print('</div>');
	}
   ?>
   <!--<div class="collect-annotated" style="background-image: url('<?php //the_post_thumbnail_url( 'full' ); ?>');">
      <div class="text">
        <h1 style="font-family:inherit; font-weight:100;"><?php //the_title(); ?></h1>
        <p><?php //the_content(); ?> </p>
      </div>
    </div>-->

	<?php endwhile; ?>
	<?php endif; ?>
	
    <section style="padding-top:0;">
    <div class="">      <!--was container-->    
      <div class="row">
        <div class="col-lg-12 px-5">
          <h5 class="clipsLine"><?php echo number_format($clip_data->resultTotalClipCount, 0, '.', ','); ?> Clips in this collection</h5>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 px-5">
        <ul class="UsedFilms">
<?php
		if($page <= $clip_data->resultTotalPageCount) 
		{
			foreach ($clip_data->clips as $clip) 
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
				print('<li class="asset-thumb"><div class="ratio-wrapper"><div class="ratio"></div>');
					print('<a class="img" href="' . get_permalink(WAZEE_SITE_TEMPLATE_ASSET_DETAIL) . '?id=' . $clip->id . '">');
						print('<img class="lazy" src="' . $thumbnail_url . '">');
					print('</a></div>');
					print('<h4><span> ' . $clip->name . '&nbsp;</span>');
						print('<a href="' . get_permalink(WAZEE_SITE_TEMPLATE_ASSET_DETAIL) . '?id=' . $clip->id . '"><img src="' . get_stylesheet_directory_uri() . '/img/cart_11.jpg"></a>');
						//print('<a href="#"><img src="' . get_stylesheet_directory_uri() . '/img/cart_09.jpg"></a>');
						//print('<a href="#"><img src="' . get_stylesheet_directory_uri() . '/img/cart_07.jpg"></a>');
					print('</h4>');
					print('<p>' . $clip->title . '</p>');
				print('</li>');
			}
		}
?>          
        </ul>
        </div>
      </div>
	  <div class="loading row">
        <div class="col-lg-12">
          <h5 class="clipsLine">Loading additional assets...</h5>
        </div>
      </div>
    </div>
    </section>

  </div> 
  </div>
  </div>  
  </div>
    <!-- id="page-top" ends -->

<?php get_footer(); ?>

<?php
//Spinner .js setup - for use to show system is busy with an ajax call
?>
<script>
	var opts = {
		  lines: 13 // The number of lines to draw
		, length: 28 // The length of each line
		, width: 14 // The line thickness
		, radius: 42 // The radius of the inner circle
		, scale: 1 // Scales overall size of the spinner
		, corners: 1 // Corner roundness (0..1)
		, color: '#000' // #rgb or #rrggbb or array of colors
		, opacity: 0.25 // Opacity of the lines
		, rotate: 0 // The rotation offset
		, direction: 1 // 1: clockwise, -1: counterclockwise
		, speed: 1 // Rounds per second
		, trail: 60 // Afterglow percentage
		, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
		, zIndex: 2e9 // The z-index (defaults to 2000000000)
		, className: 'spinner' // The CSS class to assign to the spinner
		, top: '30%' // Top position relative to parent
		, left: '50%' // Left position relative to parent
		, shadow: false // Whether to render a shadow
		, hwaccel: false // Whether to use hardware acceleration
		, position: 'absolute' // Element positioning
	};

	var spinner = new Spinner(opts);
</script>

<script>

	$(function() {
		$("img.lazy").lazyload({
			threshold: <?php echo WAZEE_SEARCH_RESULT_LAZY_THRESHOLD;?>,
			effect: "fadeIn",
			skip_invisible: false,
			load: function() {
				$(this).removeClass("lazy");
			}
		});
		var $infinite_page = 0;
		var $is_updating_infinite = true;
		$.ajax({
			url: "<?php echo bloginfo('url');?>/wp-admin/admin-ajax.php",
			type: 'POST',
			data: 'action=preload_infinite_collections_ajax_call&isfirst=1&page=' + $infinite_page + '&q=<?php echo $q; ?>',
			success: function(results) {
				$(results).insertAfter($(".asset-thumb").last());
				$infinite_page++;
				$is_updating_infinite = false;
				$(".loading").hide();
				refreshDOM();
			}
		});
		$(".loading").hide();
		$(window).scroll(function() {
			if ($(window).scrollTop() + $(window).height() > $(document).height() - <?php echo WAZEE_SEARCH_RESULT_INFINITE_PRELOAD_THRESHOLD; ?>) {
				if (!$is_updating_infinite && ($('.asset-thumb').length < <?php echo $clip_data->resultTotalClipCount; ?>)) {
					$(".loading").show();
					$is_updating_infinite = true;
					$.ajax({
						url: "<?php echo bloginfo('url');?>/wp-admin/admin-ajax.php",
						type: 'POST',
						data: 'action=preload_infinite_collections_ajax_call&page=' + $infinite_page + '&q=<?php echo $q; ?>',
						success: function(results) {
							$(results).insertAfter($(".asset-thumb").last());
							$infinite_page++;
							$is_updating_infinite = false;
							$(".loading").hide();
							refreshDOM();
						}
					});
					refreshDOM();
				}
			}
		});
		
		function refreshDOM() {
			$("img.lazy").lazyload({
				threshold: <?php echo WAZEE_SEARCH_RESULT_LAZY_THRESHOLD;?>,
				effect: "fadeIn",
				skip_invisible: false,
				load: function() {
					$(this).removeClass("lazy");
				}
			});
			//alert("numthumbs: " + $('.asset-thumb').length + " totalclips: " + <?php echo $clip_data->resultTotalClipCount; ?>);
		}
		
		function infinite_preload() {
			var $infinite_page = 1;
			$.ajax({
				url: "<?php echo bloginfo('url');?>/wp-admin/admin-ajax.php",
				type: 'POST',
				data: 'action=preload_infinite_collections_ajax_call&isfirst=1&page=' + $infinite_page + '&q=<?php echo $q; ?>',
				success: function(results) {
					$(results).insertAfter($(".asset-thumb").last());
					$infinite_page++;
					$is_updating_infinite = false;
					$(".loading").hide();
					refreshDOM();
				}
			});
		}
	});

</script>
