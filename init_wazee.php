<?php
//include from parent theme
require_once(get_stylesheet_directory() .'/init_wazee_parent.php');

//Custom utlity functions for this child theme
require_once(dirname(__FILE__).'/wazee-functions/wazee_utility.php');

//Social Settings
define('SOCIAL_FACEBOOK_URL', $triarc_settings['social_facebook_url']);
define('SOCIAL_INSTAGRAM_URL', $triarc_settings['social_instagram_url']);
define('SOCIAL_TWITTER_URL', $triarc_settings['social_twitter_url']);
define('SOCIAL_PINTEREST_URL', $triarc_settings['social_pinterest_url']);
//Search Settings and Variables
define('WAZEE_SEARCH_RESULT_CLIPS_PER_PAGE', $triarc_settings['wazee_search_result_clips_per_page']);
define('WAZEE_SEARCH_RESULT_INFINITE_PRELOAD_NUMBER', $triarc_settings['wazee_search_result_infinite_preload_number']);
define('WAZEE_SEARCH_RESULT_INFINITE_PRELOAD_THRESHOLD', $triarc_settings['wazee_search_result_infinite_preload_threshold']);
define('WAZEE_SEARCH_RESULT_LAZY_THRESHOLD', $triarc_settings['wazee_search_result_lazy_threshold']);
//Home Page Variables
define('WAZEE_HOME_FEATURED_1', $triarc_settings['wazee_home_featured_1']);
define('WAZEE_HOME_FEATURED_2', $triarc_settings['wazee_home_featured_2']);
define('WAZEE_HOME_FEATURED_3', $triarc_settings['wazee_home_featured_3']);
define('WAZEE_HOME_FEATURED_4', $triarc_settings['wazee_home_featured_4']);
define('WAZEE_HOME_FEATURED_5', $triarc_settings['wazee_home_featured_5']);
define('WAZEE_HOME_FEATURED_6', $triarc_settings['wazee_home_featured_6']);
define('WAZEE_HOME_FEATURED_7', $triarc_settings['wazee_home_featured_7']);
define('WAZEE_HOME_FEATURED_8', $triarc_settings['wazee_home_featured_8']);
define('WAZEE_HOME_FEATURED_PORTFOLIO_1', $triarc_settings['wazee_home_featured_portfolio_1']);
define('WAZEE_HOME_FEATURED_PORTFOLIO_2', $triarc_settings['wazee_home_featured_portfolio_2']);
define('WAZEE_HOME_FEATURED_PORTFOLIO_3', $triarc_settings['wazee_home_featured_portfolio_3']);
define('WAZEE_HOME_FEATURED_PORTFOLIO_4', $triarc_settings['wazee_home_featured_portfolio_4']);
define('WAZEE_HOME_FEATURED_PORTFOLIO_5', $triarc_settings['wazee_home_featured_portfolio_5']);
define('TRIARC_HOME_FEATURED_VIDEO_YOUTUBE_1', $triarc_settings['triarc_home_featured_video_youtube_1']);
define('TRIARC_HOME_FEATURED_VIDEO_TITLE_1', $triarc_settings['triarc_home_featured_video_title_1']);
define('TRIARC_HOME_FEATURED_VIDEO_DESCRIPTION_1', $triarc_settings['triarc_home_featured_video_description_1']);
define('TRIARC_HOME_FEATURED_VIDEO_ID_1', $triarc_settings['triarc_home_featured_video_id_1']);
define('TRIARC_HOME_FEATURED_VIDEO_YOUTUBE_2', $triarc_settings['triarc_home_featured_video_youtube_2']);
define('TRIARC_HOME_FEATURED_VIDEO_TITLE_2', $triarc_settings['triarc_home_featured_video_title_2']);
define('TRIARC_HOME_FEATURED_VIDEO_DESCRIPTION_2', $triarc_settings['triarc_home_featured_video_description_2']);
define('TRIARC_HOME_FEATURED_VIDEO_ID_2', $triarc_settings['triarc_home_featured_video_id_2']);
define('TRIARC_HOME_FEATURED_VIDEO_YOUTUBE_3', $triarc_settings['triarc_home_featured_video_youtube_3']);
define('TRIARC_HOME_FEATURED_VIDEO_TITLE_3', $triarc_settings['triarc_home_featured_video_title_3']);
define('TRIARC_HOME_FEATURED_VIDEO_DESCRIPTION_3', $triarc_settings['triarc_home_featured_video_description_3']);
define('TRIARC_HOME_FEATURED_VIDEO_ID_3', $triarc_settings['triarc_home_featured_video_id_3']);
define('TRIARC_HOME_FEATURED_VIDEO_YOUTUBE_4', $triarc_settings['triarc_home_featured_video_youtube_4']);
define('TRIARC_HOME_FEATURED_VIDEO_TITLE_4', $triarc_settings['triarc_home_featured_video_title_4']);
define('TRIARC_HOME_FEATURED_VIDEO_DESCRIPTION_4', $triarc_settings['triarc_home_featured_video_description_4']);
define('TRIARC_HOME_FEATURED_VIDEO_ID_4', $triarc_settings['triarc_home_featured_video_id_4']);
define('TRIARC_HOME_FEATURED_VIDEO_YOUTUBE_5', $triarc_settings['triarc_home_featured_video_youtube_5']);
define('TRIARC_HOME_FEATURED_VIDEO_TITLE_5', $triarc_settings['triarc_home_featured_video_title_5']);
define('TRIARC_HOME_FEATURED_VIDEO_DESCRIPTION_5', $triarc_settings['triarc_home_featured_video_description_5']);
define('TRIARC_HOME_FEATURED_VIDEO_ID_5', $triarc_settings['triarc_home_featured_video_id_5']);
define('TRIARC_HOME_FEATURED_VIDEO_YOUTUBE_6', $triarc_settings['triarc_home_featured_video_youtube_6']);
define('TRIARC_HOME_FEATURED_VIDEO_TITLE_6', $triarc_settings['triarc_home_featured_video_title_6']);
define('TRIARC_HOME_FEATURED_VIDEO_DESCRIPTION_6', $triarc_settings['triarc_home_featured_video_description_6']);
define('TRIARC_HOME_FEATURED_VIDEO_ID_6', $triarc_settings['triarc_home_featured_video_id_6']);

//Site Template Variables
define('WAZEE_SITE_TEMPLATE_ACCOUNT', $triarc_settings['wazee_site_template_account']);
define('WAZEE_SITE_TEMPLATE_ADV_SEARCH', $triarc_settings['wazee_site_template_adv_search']);
define('WAZEE_SITE_TEMPLATE_ASSET_DETAIL', $triarc_settings['wazee_site_template_asset_detail']);
define('WAZEE_SITE_TEMPLATE_SEARCH_RESULTS', $triarc_settings['wazee_site_template_search_results']);
define('WAZEE_SITE_TEMPLATE_LIGHTBOX', $triarc_settings['wazee_site_template_lightbox']);
define('WAZEE_SITE_TEMPLATE_REGISTRATION', $triarc_settings['wazee_site_template_registration']);
define('WAZEE_SITE_TEMPLATE_CONTACT', $triarc_settings['wazee_site_template_contact']);
define('WAZEE_SITE_TEMPLATE_COLLECTIONS', $triarc_settings['wazee_site_template_collections']);
define('WAZEE_SITE_TEMPLATE_PRIVACY_POLICY', $triarc_settings['wazee_site_template_privacy_policy']);
define('WAZEE_SITE_TEMPLATE_TERMS', $triarc_settings['wazee_site_template_terms']);
//Default Content
define('TRIARC_DEFAULT_THUMBNAIL_URL', $triarc_settings['triarc_default_thumbnail_url']);
?>