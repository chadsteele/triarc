<?php

function wazee_pagination($page, $num_rows, $results_per_page, $link_to, $links_to_pad = 0, $field_name = 'page') 
{
	$ret = '
	<div class="wazee-pagination-wrapper">
		<div class="wazee-pagination">';
	
	$total_pages = $num_rows ? ceil($num_rows / $results_per_page) : 1 ;
	$page = ((is_numeric($page)) and ($page >= 1) and ($page <= $total_pages)) ? (int)$page : 1 ;

	if ($page == 1) $ret .= '
		<img src="' . get_stylesheet_directory_uri() . '/images/left-arrow-light.png">';
	else $ret .= '
		<a href="'.$link_to.'&'.$field_name.'='.($page - 1).'"><img src="' . get_stylesheet_directory_uri() . '/images/left-arrow-dark.png"></a>';
	
	$min_page = (($page - $links_to_pad) < 1) ? 1 : ($page - $links_to_pad);
	$max_page = (($page + $links_to_pad) > $total_pages) ? $total_pages : ($page + $links_to_pad);

	$ret .= '
		' . $page . ' OF ' . $total_pages;

	if ($page < $total_pages) $ret .= '
		<a href="'.$link_to.'&'.$field_name.'='.($page + 1).'"><img src="' . get_stylesheet_directory_uri() . '/images/right-arrow-dark.png"></a>';
	else $ret .= '
		<img src="' . get_stylesheet_directory_uri() . '/images/right-arrow-light.png">';

	$ret .= '
		</div>
	</div>';
	
	return $ret;

}


function t3_log($log_file, $message) {
	$file = fopen($log_file, 'a');
	if ($file) {
		fwrite($file, "$message\n");
		fclose($file);
	}
}


function right($string, $length) {
	return substr($string, strlen($string) - $length);
}

function humanFileSize($size,$unit="") {
  if( (!$unit && $size >= 1<<30) || $unit == " GB")
    return number_format($size/(1<<30),2)." GB";
  if( (!$unit && $size >= 1<<20) || $unit == " MB")
    return number_format($size/(1<<20),2)." MB";
  if( (!$unit && $size >= 1<<10) || $unit == " KB")
    return number_format($size/(1<<10),2)." KB";
  return number_format($size)." bytes";
}

?>
