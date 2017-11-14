<?php

/////////////////////////////////////////////////////////////////////////////
// Title.......: wazee_iresource.php
// Developed By: Rock River Ltd.
//
// Description.:
/////////////////////////////////////////////////////////////////////////////

interface t3_IResource {	
	public function find($id);
	public function find_all($opts);
//	public function find_all($keywords, $page);
	public function from_simple_xml($element,$deep=false);
	public function from_simple_json_all($element,$deep=false);
	public function from_simple_json_one($element,$deep=false);
}


?>