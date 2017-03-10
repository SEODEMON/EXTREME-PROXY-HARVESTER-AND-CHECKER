<?php

class Curl {

	protected $debugFile = 'curl.debug.txt';
	// If set $this->results is an an asoc. array [url] => [data]
	public $resAsoc = true;
	
	public $results;
	public $errors;
	
	protected $defaultOptions;
	protected $mh;
	protected $requests;
	protected $links;
	protected $mode;
	protected $activeConn;
	protected $mrc;
	
	
	protected $chunked = false;
	protected $chunks;
	
	
	
	public function __construct() {
	
		$this->results = array();
		$this->requests = array();
		$this->errors = array();

	/*
	* DEFAULT CURL OPTIONS
	* Can be overidden by $curlOptions in addRequest()
	*/
		$this->defaultOptions = array(  CURLOPT_RETURNTRANSFER => true,
						CURLOPT_HEADER => false,
						CURLOPT_AUTOREFERER => true,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_MAXREDIRS => 20,
						CURLOPT_CONNECTTIMEOUT => 200
						);
	/* END CURL OPTIONS */

	}


	public function addRequest($url, $curlOptions = '') {

		$this->requests[$url]= $curlOptions;
	}
	//public function removeRequest() { }
	

	public function chunk($chunkSize) {

		
		$k = count($this->requests);
		if($chunkSize > 0) {
		
			$this->chunked = true;
			
			$this->chunks = array_chunk($this->requests, $chunkSize, true);

		}
	}
	
	public function returnBad() {
	
		return $this->badUrls;
	}
	
	public function perform() {
		$k = count($this->requests);
		if($k > 0 ) {
		if($k == 1) 
		{
			$this->performSingle();
			
		} 
		else 
		{
			if(!$this->chunked) {
			
				$this->mh = curl_multi_init();
				$this->makeHandles();
				$this->performMulti();
			}
			else 
			{
				foreach($this->chunks as $i => $chunk) {

					$this->requests = $chunk;
					
					$this->mh = curl_multi_init();
					$this->makeHandles();
					$this->performMulti();
					
				}
			}
		}
		}
	
	}
	
	public function clear() {
			$this->results = array();
			$this->requests = array();
			$this->badUrls = array();	
	}
	
  /**********************************
  ** Protected functions
  **********************************/

	protected function makeHandles() {

		foreach ($this->requests as $url => $req) {

			$this->handles[$url] = curl_init($url);

			// Apply default options to all requests
			$this->setOptions($this->handles[$url], $this->defaultOptions);

			// Apply individual options if any
			if(is_array($req)) {
				$this->setOptions($this->handles[$url], $req);
			}
			


			curl_multi_add_handle ($this->mh,$this->handles[$url]);
		}
	}
	

	protected function performSingle() {

		$a = array_keys($this->requests);
		$url = $a[0];
		$this->mh = curl_init($url);
		
		// Apply default options to all requests
		$this->setOptions($this->mh, $this->defaultOptions);

		// Apply individual options if any
		if( is_array($this->requests[$url]) ) {
	
			$this->setOptions($this->mh, $this->requests[$url] );
		}
		
		if( $this->resAsoc ) { 
		 $this->results[$url] = curl_exec($this->mh);
		}else {
		 $this->results[] = curl_exec($this->mh);
		}
		if ($ern = curl_errno($this->mh)) {
			$err = curl_error($this->mh);
			$str = "Curl error $ern on handle $i: $err\n";
			$this->errors[$url]= array( 'num' => $ern, 'msg' => $err );
			$this->logError($str);
		}

		curl_close($this->mh);	
	}

	protected function performMulti() {

		// start performing the request
		do {
		  $this->mrc = curl_multi_exec($this->mh, $this->activeConn);
		} while ($this->mrc == CURLM_CALL_MULTI_PERFORM);

		while ($this->activeConn and $this->mrc == CURLM_OK) {
		  // wait for network
		  if (curl_multi_select($this->mh) != -1) {
		   // pull in any new data, or at least handle timeouts
		   do {
		     $this->mrc = curl_multi_exec($this->mh, $this->activeConn);
		   } while ($this->mrc == CURLM_CALL_MULTI_PERFORM);
		  }
		}

		if ($this->mrc != CURLM_OK) {
		
		   $this->logError("Curl multi read error $this->mrc\n");
		}

		$k = count($this->handles);

		// retrieve data
		foreach($this->requests as $url => $req) {

		  if ( ($err = curl_error($this->handles[$url])) == '' ) {
		  
		  	if( $this->resAsoc ) { 
		 	 $this->results[$url] = curl_multi_getcontent($this->handles[$url]);
		 	} else {
		 	 $this->results[] = curl_multi_getcontent($this->handles[$url]);
		 	}

		  } 
		  else {
		  	$err = curl_error($this->handles[$url]);
		  	$ern = curl_errno($this->handles[$url]);
			$this->logError("Curl error $ern on handle $url: $err\n");
			$this->errors[$url]= array( 'num' => $ern, 'msg' => $err );
		  }

		  curl_multi_remove_handle($this->mh, $this->handles[$url]);
		  curl_close($this->handles[$url]);
		}

		// Log failed urls
		//$this->logError( "Failed:".implode('||', $this->badUrls)."\n");

		curl_multi_close($this->mh);
	}

	protected function setOptions($ch, $curloptions) {

			curl_setopt_array($ch, $curloptions);
	}

	protected function logError($str) {
	
		file_put_contents( $this->debugFile, $str, FILE_APPEND);
	}
	
	protected function prepareVars( $arr ) {
		if( is_array($arr) ) {
		$str = '';
		foreach( $arr as $k => $v ) {
			$str .= $k.'='.urlencode($v).'&';
		}
		$str = substr($str, 0, -1);
		return $str;
		} else { return false;}
	}
}

?>