<?php

/////////////////////////////////////////////////////////////////////////////
// Title.......: wazee_resource
// Developed By: Rock River ltd.
//
// Description.:
/////////////////////////////////////////////////////////////////////////////

abstract class t3_Resource implements t3_IResource {

	var $t3_user_name;
	var $t3_password;
	var $t3_api_key;
	var $view = 'deep';
	//var $host = 'http://api.thoughtequity.com/video/services'; //old
	//var $host = 'https://api.wzplatform.com/video/services';
	//var $host = 'https://kma9q4aat7.execute-api.us-west-2.amazonaws.com/corev1';
	//var $host = 'https://crxextapi.wzplatform.com/assets-api/v1/';
	var $host = WAZEE_ENDPOINT;
	var $resource_path;
	var $method;
	var $errors = array();
	
	// Getter and setter methods for resource
	public function __set( $key, $val ) {
		$this->$key = $val; 
	}

	public function __get( $key ) {
		return $this->$key; 
	}
	
	// Constructor
	function __construct($t3_user_name, $t3_password, $t3_api_key) {
		$this->t3_user_name = $t3_user_name;
		$this->t3_password = $t3_password;
		$this->t3_api_key = $t3_api_key;
	}

	// Find resource by ID
	public function find($id) {return '';}
	
	// Find/lookup all resources
	public function find_all($opts) {return '';}

	public function from_simple_xml($element,$deep=false) {return '';}
	
	public function from_simple_json_all($element,$deep=false) {return '';}
	
	public function from_simple_json_one($element,$deep=false) {return '';}

	private function t3_hash_token() {
		return md5("{$this->t3_password}:{$this->method}:{$this->resource_path}");
	}

	private function t3_auth($hash) {
		return "auth={$this->t3_user_name}:{$this->t3_api_key}:$hash";
	}

	public function resource_url() {
		//$hash = $this->t3_hash_token();
		//$auth = $this->t3_auth($hash);
		//$url = "{$this->host}{$this->resource_path}?$auth&view={$this->view}";
		$url = "{$this->host}{$this->resource_path}?view={$this->view}";
		return $url;
	}

	public function hmsf($milliseconds, $fps = 29.97) {
		$seconds = floor($milliseconds / 1000);
		$mils = ($milliseconds - ($seconds * 1000)) / 1000;
		$frames = round($fps * $mils, 0);
		$hours = floor($seconds / (60 * 60));
		$seconds = $seconds - ($hours * 60 * 60);
		$minutes = floor($seconds / 60);
		$seconds = $seconds - ($minutes * 60);
		return sprintf("%02d:%02d:%02d:%02d", $hours, $minutes, $seconds, $frames);
	}

}

?>
