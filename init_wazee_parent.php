<?php
require_once(dirname(__FILE__).'/wazee-functions/http_helper.php');
require_once(dirname(__FILE__).'/wazee-functions/wazee_utility.php');
require_once(dirname(__FILE__).'/wazee-functions/wazee_iresource.php');
require_once(dirname(__FILE__).'/wazee-functions/wazee_resource.php');
require_once(dirname(__FILE__).'/wazee-functions/wazee_clip.php');
require_once(dirname(__FILE__).'/wazee-functions/wazee_bin.php');

global $wazee_options;
$wazee_settings = get_option( 'wazee_options', $wazee_options );

//Get variables from Wazee Options page
//define('WAZEE_USER_NAME', $wazee_settings['wazee_user_name']);
//define('WAZEE_PASSWORD', $wazee_settings['wazee_password']);
//define('WAZEE_API_KEY', $wazee_settings['wazee_api_key']);
define('WAZEE_SEARCH_BASE', $wazee_settings['wazee_search_base']);

define('WAZEE_DIGITAL_KEY', $wazee_settings['wazee_digital_key']);
define('WAZEE_GATEWAY_KEY', $wazee_settings['wazee_gateway_key']);
define('WAZEE_ENDPOINT', $wazee_settings['wazee_endpoint']);

//print ('test: ' . $wazee_settings['wazee_user_name']);
?>