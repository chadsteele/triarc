<?php

/////////////////////////////////////////////////////////////////////////////
// Title.......: wazee_bin
// Developed By: Rock River ltd.
//
// Description.:
/////////////////////////////////////////////////////////////////////////////

class t3_Bin extends t3_Resource {

	var $id;

	public function find($id) {
		try {
			$this->resource_path = '/bin/'.$id;
			$this->method = 'GET';
			$this->view = 'deep';

			$url = $this->resource_url();
			$http_helper = new HttpHelper();
			$result = $http_helper->doRequest($url, $this->method);

			$xml = simplexml_load_string($result->body);
			$ret->resultTotalBinCount = 1;
			$ret->resultTotalPageCount = 1;
			$ret->resultStartIndex = 1;
			$ret->resultPageNumber = 1;
			$ret->resultPageSize = 1;
			$ret->bins[] = $this->from_simple_xml($xml,false);
			return $ret;
		}
		catch (Exception $e) {
			$error_log = dirname(__FILE__).'/../log/t3_error.log';
			t3_log($error_file, date('Y-m-d H:i:s').' - '.$e->getMessage());
			die("An error was detected. Please review the error log.");
		}
		return '';
	}

	public function find_all($opts) {
		try {
			$this->resource_path = '/bin/';
			$this->method = 'GET';
			$this->view = 'shallow';

			$user_name = T3_USER_NAME;

			$page_size = T3_SEARCH_RESULT_BINS_PER_PAGE;
			$page = isset($opts['page']) ? $opts['page'] : 1;

			$url = $this->resource_url()."&member:$user_name";
	//		$url = $this->resource_url()."&owner:[$user_name]&resultPageSize=$page_size&resultPageNumber=$page";

			$http_helper = new HttpHelper();
			$result = $http_helper->doRequest($url, $this->method);
			$xml = simplexml_load_string($result->body);
			$ret->totalNumber = (int)$xml->attributes()->totalNumber;
			$ret->pageSize = (int)$xml->attributes()->pageSize;
			$ret->pageNumber = (int)$xml->attributes()->pageNumber;
			if ($ret->totalNumber == 0 || $page > ($ret->pageNumber + 1)) return($ret);

			foreach ($xml->bin as $bin) {
				$ret->bins[] = $this->from_simple_xml($bin,false);
			}
			return $ret;
		}
		catch (Exception $e) {
			$error_log = dirname(__FILE__).'/../log/t3_error.log';
			t3_log($error_file, date('Y-m-d H:i:s').' - '.$e->getMessage());
			die("An error was detected. Please review the error log.");
		}
	}

	public function from_simple_xml($bin,$deep=false) {
		$ret->id = "{$bin->id}";
		$ret->name = "{$bin->name}";
		$ret->path = "{$bin->path}";
		$ret->created = "{$bin->created}";
		$ret->modified = "{$bin->modified}";
		$ret->sortOrder = "{$bin->sortOrder}";
		$ret->defaultAccess = "{$bin->defaultAccess}";
		$ret->searchable = "{$bin->searchable}";
		$ret->binPath = "{$bin->binPath}";
		
		$m = 0;
		foreach ($bin->member as $member) {
			$ret->member[$m]->id = "{$member->id}";
			$ret->member[$m]->access = "{$member->access}";
			$ret->member[$m]->becameMember = "{$member->becameMember}";
			$m++;
			
		}
		
		$a = 0;
		foreach ($bin->asset as $asset) {
			if (isset($asset->{clip-asset})) {
				$ret->clip[$a]->id = "{$asset->{clip-asset}->id}";
				$ret->clip[$a]->name = "{$asset->{clip-asset}->name}";
				$a++;
			}
		}

		// Collect metadata
		foreach ($bin->metadata as $meta) $ret->metadata->{$meta->name} = "{$meta->value}";
		
		return $ret;
	}
	
	
}


?>
