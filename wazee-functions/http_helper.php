<?php

class HttpResult {
	var $error_code;
	var $error;
	var $http_code;
	var $raw_headers;
	var $headers;
	var $body;
	var $location;
	
	//getter and setter methods for resource
	public function __set( $key, $val ) { $this->$key = $val; }
	public function __get( $key ) { return $this->$key; }
	
	function isSuccess() {
		if (!isset($this->http_code)) return false;		
		$success_codes = array( 200, 201 );		
		if (in_array( $this->http_code, $success_codes )) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function errorMessages() {
		$errors = array();			
		if (isset($this->http_code) && strpos($this->body, "<error>") > 0) {
			//parse error XML from body and return array of error messages
			$xml = new SimpleXMLElement( $this->body );
			if (isset($xml->{'error'}))
				foreach($xml->{'error'} as $error)
					array_push($errors, (string)$error);
		}
		return $errors;
	}
}

class HttpHelper {
		
	public static function doRequest($url, $method, $params = array(), $credentials = array()) {
		$access_log = dirname(__FILE__).'/../log/t3_access.log';
	
//		if ($url == 'http://api.t3platform.com/video/services/clip/?auth=apiwpnatgeo:wpng-st9BeMEd:65982ea87cdfe9cd6d3e41c6ef857c6c&view=deep')
//			die('Blank URL!!!');

		$result = new HttpResult();

		if (!extension_loaded('curl'))
 			throw new ClientException('cURL extension not loaded.');

//		if (!isset($credentials) || !isset($credentials['username']) || !isset($credentials['password']))
//			throw new ClientException("Missing API credentials.");

		$ch = curl_init ();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_MAXREDIRS, 0);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_VERBOSE, 0);
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 60); //was 5
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60); //was 15

		// HTTP basic authentication
//		curl_setopt ($ch, CURLOPT_USERPWD, $credentials['username'] . ":" . $credentials['password']);
//		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Length: " . strlen(is_array($params) ? http_build_query($params) : $params)));

		$wazee_digital_key = "Authorization: Bearer " . WAZEE_DIGITAL_KEY;
		$wazee_gateway_key = "x-api-key: " . WAZEE_GATEWAY_KEY;

		curl_setopt ($ch, CURLOPT_HTTPHEADER, array($wazee_digital_key, $wazee_gateway_key));

		switch ($method) {
			case 'POST':
				curl_setopt ($ch, CURLOPT_POST, 1);
				curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
				break;

			case 'DELETE':
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;

			case 'PUT':
				curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
				break;

			case 'GET':
			default:
				break;
		}

		$now = time();
		$res = curl_exec ($ch);
		$run_time = time() - $now;
		t3_log($access_log, date('Y-m-d H:i:s').' - '.$run_time.' secs - '.$url);

		// get HTTP response code
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($http_code == 0) {
			$log_file = dirname(__FILE__).'/../log/t3_timeout.log';
			t3_log($log_file, date('Y-m-d H:i:s', $now).' - '.$url);
			echo "Error: Timeout!!!\n\n".date('Y-m-d H:i:s', $now)."\n\n$url\n\n";
			var_dump($ch);
			die();
		}

		// check response code for denied access		
		if ($http_code == 401) {
			$result->http_code = $http_code;
			$result->error = "HTTP Basic: Access denied.";
			curl_close ($ch);
			return $result;
		}


		if (!$res) {
			$result->error_code = curl_errno($ch);
			$result->error = curl_error($ch);
			curl_close ($ch);
			$log_file = dirname(__FILE__).'/../log/t3_error.log';
			t3_log($log_file, date('Y-m-d H:i:s', $now).' - '.$url.' - CURL Error:'.$result->error_code.': '.$result->error);
			return $result;
		}
		
		curl_close ($ch);		
		
		list($raw_headers, $res) = explode("\r\n\r\n", $res, 2);
		$parsed_headers = array();
		foreach (explode("\n", $raw_headers) as $header) {
			@list($header_name, $header_value) = explode(':', trim($header), 2);
			//skip header variables that don't have a value
			if (!isset($header_value)) continue;
			$header_value = ltrim($header_value);
			if (isset($parsed_headers[$header_name])) {
				//if header name already exist in header variable array, create array for multiple values
				$parsed_headers[$header_name] = array($parsed_headers[$header_name]);
				array_push($parsed_headers[$header_name], $header_value);
			}
			else {
				$parsed_headers[$header_name] = $header_value;
			}
		}

		if (isset($parsed_headers['Location'])) $result->location = $parsed_headers['Location'];
		$result->raw_headers = $raw_headers;
		$result->headers = $parsed_headers;
		$result->body = $res;		
		$result->http_code = $http_code;
		
		if (!$res) {
			return $result;
		}
		elseif ($res == ' ') {
			$result->error = 'Empty response';
			return $result;
		}
		
		return $result;
	}
	
}

?>