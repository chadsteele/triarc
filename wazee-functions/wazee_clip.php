<?php

/////////////////////////////////////////////////////////////////////////////
// Title.......: wazee_clip
// Developed By: Rock River ltd.
//
// Description.:
/////////////////////////////////////////////////////////////////////////////

class t3_Clip extends t3_Resource 
{

	var $id;

	public function find($id, $view="deep") {
		if (!strlen($id)) return '';
		try {
			$this->resource_path = '/clip/'.$id;
			$this->method = 'GET';
			$this->view = $view;

			$url = WAZEE_ENDPOINT . '/clip/' . $id;
			//print "test " . $url;
			$http_helper = new HttpHelper();
			$result = $http_helper->doRequest($url, $this->method);
			//print_r($result->body);
			
			$raw_body = $result->body;
			
			//JSON results
			$raw_json = json_decode($raw_body);
			
			//$xml = simplexml_load_string($result->body);
			
			$ret->resultTotalClipCount = 1;
			$ret->resultTotalPageCount = 1;
			$ret->resultStartIndex = 1;
			$ret->resultPageNumber = 1;
			$ret->resultPageSize = 1;
			
			//JSON results
			$raw_json = json_decode($raw_body);
			//var_dump($raw_json);
			
			$ret->clipData = $this->from_simple_json_one($raw_json, false);
			
			
			//$ret->clips[] = $this->from_simple_xml($xml, true);
			//print_r($this->from_simple_xml($xml));
			
			// Collect the Syndication (preview) embed code.
			/*$this->resource_path = '/syndication/';
			$this->method = 'POST';
			$url = $this->resource_url();
			$url .= "&clip=/clip/$id";
			$ret->clips[0]->syndication_url = $url;
			$result = $http_helper->doRequest($url, $this->method);
			$xml = simplexml_load_string($result->body);
			//print "test: " . $result->body;
			$ret->clips[0]->syndication_code = html_entity_decode("{$xml->html}");
			*/
			
			//Now calls to get the preview url
			$url = WAZEE_ENDPOINT . '/clip/' . $id . '/clipDetail';
			$result = $http_helper->doRequest($url, $this->method);
			$raw_body = $result->body;
			$raw_json = json_decode($raw_body);
			//print_r($raw_json);
			$ret->clipData->clippreview = $raw_json->clipUrl;
			$ret->clipData->clipthumbnail = $raw_json->clipThumbnailUrl;
			
			return $ret;
		}
		catch (Exception $e) {
			$error_log = dirname(__FILE__).'/../log/t3_error.log';
			t3_log($error_file, date('Y-m-d H:i:s').' - '.$e->getMessage());
			die("An error was detected. Please review the error log.");
		}
		return '';
	}

	public function find_all($opts, $view="deep") {
		try {
			$this->resource_path = '/search/';
			$this->method = 'GET';
			$this->view = $view;

			$keywords = isset($opts['keywords']) ? $opts['keywords'] : '';
			$page = isset($opts['page']) ? $opts['page'] : 0;
			$sort = isset($opts['sort']) ? $opts['sort'] : "";
			$page_size = isset($opts['page_size']) ? $opts['page_size'] : WAZEE_SEARCH_RESULT_CLIPS_PER_PAGE;

			//$page_size = WAZEE_SEARCH_RESULT_CLIPS_PER_PAGE;
			$wazee_search_base = WAZEE_SEARCH_BASE;
			
			$keywords = urlencode(htmlentities($keywords, ENT_COMPAT, 'UTF-8', false));
			
			//This is the important part - rmmadden
			//print('(' . $keywords . '%20' . rawurlencode($wazee_search_base) . '%20)'); //debug
			
			//$url = $this->resource_url().'&keywords=(' . $keywords . '%20' . $wazee_search_base . '%20)&resultPageSize=' . $page_size . '&resultPageNumber=' . $page . (!empty($sort) ? "&search.sortBy=" . $sort : ""); 
			$url = $this->resource_url().'&q=(' . $keywords . '%20' . $wazee_search_base . '%20)&n=' . $page_size . '&i=' . $page . (!empty($sort) ? "&search.sortBy=" . $sort : ""); 
			//print "test " . $url;
			
			$http_helper = new HttpHelper();
			$result = $http_helper->doRequest($url, $this->method);
			//print_r($result->body);
			$raw_body = $result->body;
			
			//JSON results
			$raw_json = json_decode($raw_body);
			//var_dump($raw_json);
			//print_r($raw_json->items);
			$ret->resultTotalClipCount = $raw_json->totalCount;
			$ret->resultTotalPageCount = $raw_json->numberOfPages;
			//$ret->resultStartIndex = (int)$xml->resultStartIndex; //not needed
			$ret->resultPageNumber = $raw_json->currentPage;
			$ret->resultPageSize = $raw_json->pageSize;
			if ($ret->resultTotalClipCount == 0 || $page > $ret->resultPageNumber) return($ret);
			
			$clip_index = 0;
			foreach ($raw_json->items as $clip) {
				$ret->clips[] = $this->from_simple_json_all($clip, false);
			}
			return $ret;
			
			/*
			//XML Result
			$xml = simplexml_load_string($result->body);
			//print_r($xml); //debug
			$ret->resultTotalClipCount = (int)$xml->resultTotalClipCount;
			$ret->resultTotalPageCount = (int)$xml->resultTotalPageCount;
			$ret->resultStartIndex = (int)$xml->resultStartIndex;
			$ret->resultPageNumber = (int)$xml->resultPageNumber;
			$ret->resultPageSize = (int)$xml->resultPageSize;
			if ($ret->resultTotalClipCount == 0 || $page > $ret->resultPageNumber) return($ret);

			$clip_index = 0;
			foreach ($xml->clip as $clip) {
				$ret->clips[] = $this->from_simple_xml($clip, false);
			}
			return $ret;
			*/
		}
		catch (Exception $e) {
			$error_log = dirname(__FILE__).'/../log/t3_error.log';
			t3_log($error_file, date('Y-m-d H:i:s').' - '.$e->getMessage());
			die("An error was detected. Please review the error log.");
		}
	}
	
	public function from_simple_xml($clip, $deep=false) 
	{
		//print_r($clip);
		//print("<br/><br/>");
		
		$ret->id = "{$clip->id}";
		$ret->aspectRatio = "{$clip->aspectRatio}";
		$ret->clipClass = "{$clip->clipClass}";
		$ret->description = "{$clip->description}";
		$ret->digitalFormat = "{$clip->digitalFormat}";
		$ret->duration = "{$clip->duration}";
		$ret->length = $this->hmsf($ret->duration);
		$ret->rights = "{$clip->rights}";
		$ret->goLiveDate = "{$clip->goLiveDate}";
		$ret->lastModified = "{$clip->lastModified}";
		$ret->name = "{$clip->name}";
		
		$ret->OriginalName = "{$clip->metadata->{'Supplier.OriginalName'}}";
		//$ret->name = "{$clip->name}";
		//$ret->name = "{$clip->name}";

		$ret->smallPreview = null;
		$ret->largePreview = null;
		$ret->smallThumbnail = null;
		$ret->largeThumbnail = null;
		$ret->mediumProxy = null;
		$ret->metadata = null;
		$ret->renditions = null;

		// Collect renditions
		$inc = 0;
		foreach($clip->rendition as $rendition) 
		{
			if($deep)
			{
				//print_r($rendition);
				$ret->renditions->$inc = null;
				$rendition_purpose = "{$rendition->purpose}";
				$rendition_name = "{$rendition->name}";
				//$rendition_id = "{$rendition->id}";
				$rendition_fileSize = "{$rendition->fileSize}";
				$rendition_size = "{$rendition->size}";
				//$rendition_variant = "{$rendition->variant}";
				//$rendition_clip = "{$rendition->clip}";
				$rendition_format = "{$rendition->format}";
				$rendition_url = "{$rendition->url}";
				//print_r($rendition->internalUrls);
				if($rendition_purpose == "Preview")
				{
					foreach($rendition->internalUrls as $internalUrl) 
					{
						foreach($internalUrl as $urlKey)
						{
							if($urlKey->key == "https-Html5Preview")
							{
							
								$rendition_url ="{$urlKey->value}";
							}
						}
					}
				}
				//$rendition_scope = "{$rendition->scope}";
				$ret->renditions->$inc->name = $rendition_name;
				$ret->renditions->$inc->purpose = $rendition_purpose;
				$ret->renditions->$inc->fileSize = $rendition_fileSize;
				$ret->renditions->$inc->size = $rendition_size;
				//$ret->renditions->$inc->variant = $rendition_variant;
				//$ret->renditions->$inc->clip = $rendition_clip;
				$ret->renditions->$inc->format = $rendition_format;
				$ret->renditions->$inc->url = $rendition_url;
				//$ret->renditions->$inc->scope = $rendition_scope;
				$inc++;
			}
			//if (isset($_REQUEST['debug'])) var_dump($rendition);
			$purpose = "{$rendition->purpose}";
			$size = "{$rendition->size}";
			$variant = "{$rendition->variant}";
			if ($purpose == 'Preview' && $size == 'Small') {
				$ret->smallPreview->id = "{$rendition->id}";
				$ret->smallPreview->url = "{$rendition->url}";
				$ret->smallPreview->format = "{$rendition->format}";
				$ret->smallPreview->name = "{$rendition->name}";
				$ret->smallPreview->created = "{$rendition->created}";
			}
			if ($purpose == 'Preview' && $size == 'Large') {
				$ret->largePreview->id = "{$rendition->id}";
				$ret->largePreview->url = "{$rendition->url}";
				$ret->largePreview->format = "{$rendition->format}";
				$ret->largePreview->name = "{$rendition->name}";
				$ret->largePreview->created = "{$rendition->created}";
				$ret->largePreview->urlFlashPrivate = "{$rendition->urlFlashPrivate}";
			}
			if ($purpose == 'Thumbnail' && $size == 'Small') {
				$ret->smallThumbnail->id = "{$rendition->id}";
				$ret->smallThumbnail->url = "{$rendition->url}";
				$ret->smallThumbnail->format = "{$rendition->format}";
				$ret->smallThumbnail->name = "{$rendition->name}";
				$ret->smallThumbnail->created = "{$rendition->created}";
			}
			if ($purpose == 'Thumbnail' && $size == 'Large') {
				$ret->largeThumbnail->id = "{$rendition->id}";
				$ret->largeThumbnail->url = "{$rendition->url}";
				$ret->largeThumbnail->format = "{$rendition->format}";
				$ret->largeThumbnail->name = "{$rendition->name}";
				$ret->largeThumbnail->created = "{$rendition->created}";
			}
			if ($purpose == 'Proxy' && $size == 'Medium' && strpos($variant, ',wmte')) {
				$ret->mediumProxy->id = "{$rendition->id}";
				$ret->mediumProxy->url = "{$rendition->url}";
				$ret->mediumProxy->format = "{$rendition->format}";
				$ret->mediumProxy->name = "{$rendition->name}";
				$ret->mediumProxy->created = "{$rendition->created}";
			}
		}

		// Collect metadata
		foreach ($clip->metadata as $meta) $ret->metadata->{$meta->name} = "{$meta->value}";
		
		return $ret;
	}
	
	public function from_simple_json_all($clip, $deep=false) 
	{
		//print_r($clip);
		//print("<br/><br/>");
		
		$raw_metadata = $clip->metaData;
		$metadata = array();
		foreach($raw_metadata as $single_metadata)
		{
			$metadata[$single_metadata->name] = $single_metadata->value;
			//print("Name: " . $metadata->name . " Value: " . $metadata->value . "<br/>");
		}
		
		$ret->id = $clip->assetId;
		$ret->clipClass = $metadata['Resource.Class'];
		$ret->description = $metadata['Description'];
		$ret->digitalFormat = $metadata['TE.DigitalFormat'];
		$ret->duration = $metadata['Format.Duration'];
		$ret->title = $metadata['Title'];
		$ret->name = $clip->name;
		$ret->speed = $metadata['Description.Tempo'];
		$ret->aspectratio = $metadata['Format.AspectRatio'];
		$ret->framerate = $metadata['Format.FrameRate'];
		$ret->framesize = $metadata['Format.FrameSize'];
		$ret->broadcaststandard = $metadata['Format.BroadcastStandard'];
		$ret->videographer = $metadata['Creator.Videographer'];
		$ret->color = $metadata['Description.Color'];
		$ret->thumbnail_https_url = $clip->thumbnail->urls->https;
		
		
		return $ret;
	}
	
	public function from_simple_json_one($clip, $deep=false)
	{
		//print_r($clip);
		//print("<br/><br/>");
		
		$raw_metadata = $clip->clipData;
		//print_r($raw_metadata);
		$metadata = array();
		foreach($raw_metadata as $single_metadata)
		{
			$metadata[$single_metadata->name] = $single_metadata->value;
			//print("Name: " . $single_metadata->name . " Value: " . $single_metadata->value . "<br/>");
		}
		
		$ret->id = $clip->id;
		$ret->clipClass = $metadata['Resource.Class'];
		$ret->description = $metadata['Description'];
		$ret->digitalFormat = $metadata['TE.DigitalFormat'];
		$ret->duration = $metadata['Format.Duration'];
		$ret->title = $metadata['Title'];
		$ret->name = $clip->name;
		$ret->speed = $metadata['Description.Tempo'];
		$ret->aspectratio = $metadata['Format.AspectRatio'];
		$ret->framerate = $metadata['Format.FrameRate'];
		$ret->framesize = $metadata['Format.FrameSize'];
		$ret->broadcaststandard = $metadata['Format.BroadcastStandard'];
		$ret->videographer = $metadata['Creator.Videographer'];
		$ret->color = $metadata['Description.Color'];
		$ret->keywords = $metadata['Keywords'];
		
		return $ret;
	}
}

?>
