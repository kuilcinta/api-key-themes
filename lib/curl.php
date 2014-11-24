<?php
/**
 * cURLs CLASS
 * Handling request data from external url/site domain
 * With 2 type method: _checkDomainURL() and _ProcessDataCurl()
 *
 * @since v1.0
 * @author Ofan Ebob
 */
class cURLs {
	protected $_url;
	protected $_type;
	protected $_args;

	public function __construct($arr){
		$this->_url = isset($arr['url']) ? $arr['url'] : false;
		$this->_type = isset($arr['type']) ? $arr['type'] : false;
		$this->_args = isset($arr['args']) ? $arr['args'] : array();
	}

	/*
	 * access_curl public function
	 * Handling function call from other resource/function
	 */
	public function access_curl(){
		$type = $this->_type;

		if($type == false){
			return false;
		}
		else{
			switch($type) {
				case 'domain':
					return $this->_checkDomainCURL();
				break;
				case 'data':
					return $this->_ProcessDataCurl();
				break;
				case 'slice':
					return $this->_sliceCurlData();
				break;
				case 'favicon':
					return $this->_getFavicon();
				break;
				case 'loop-favicon':
					return $this->_loopFavicon();
				break;
				default:
					return $this->_ProcessDataCurl();
				break;
			}
		}
	}

	/*
	 * _chcekDOmainCURL()
	 * getting information for domain exist from url defined
	 * return true/false
	 */
	protected function _checkDomainCURL(){
		$url = $this->_url;
		$args = $this->_args;
		$timeout_con = isset($args['timeout_con']) ? $args['timeout_con'] : 5;
		$timeout_res = isset($args['timeout_res']) ? $args['timeout_res'] : 10;
		$max_redir = isset($args['max_redir']) ? $args['max_redir'] : 3;

		if($url == false){
			return false;
		}
		else{
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_TIMEOUT, $timeout_res);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout_con);
			curl_setopt($curl, CURLOPT_MAXREDIRS, $max_redir);
			curl_setopt($curl, CURLOPT_HEADER, true);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			if(isset($args['uAgent'])){
				curl_setopt($curl, CURLOPT_USERAGENT, $args['uAgent']); // who am i
			}
			
			$result = curl_exec($curl);

			if($result !== false){

				$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 

				if( in_array($statusCode, range(200,306)) ){
					return false;
				}
				else{
					return true;
				}
			}
			else{
				return false;
			}

			curl_close($curl);
		}
	}

	/*
	 * _ProcessDataCurl()
	 * grab data json/txt/html or basic text from url defition
	 * return $result (data) or null
	 */
	protected function _ProcessDataCurl(){
		$url = $this->_url;
		$args = $this->_args;
		$encod = isset($args['encod']) ? $args['encod'] : "gzip";
		$timeout_con = isset($args['timeout_con']) ? $args['timeout_con'] : 5;
		$timeout_res = isset($args['timeout_res']) ? $args['timeout_res'] : 10;
		$max_redir = isset($args['max_redir']) ? $args['max_redir'] : 3;

		if($url == false){
			return null;
		}
		else{
			$options = array(
				CURLOPT_RETURNTRANSFER => true, // return web page
				CURLOPT_HEADER => false, // don't return headers
				CURLOPT_FOLLOWLOCATION => true, // follow redirects
				CURLOPT_ENCODING => $encod, // handle all encodings
				CURLOPT_AUTOREFERER => true, // set referer on redirect
				CURLOPT_CONNECTTIMEOUT => $timeout_con, // timeout on connect
				CURLOPT_TIMEOUT => $timeout_res, // timeout on response
				CURLOPT_MAXREDIRS => $max_redir, // stop after 10 redirects
				CURLOPT_SSL_VERIFYHOST => 0, // disable SSL verification host
				CURLOPT_SSL_VERIFYPEER => false, // skip SSL verifier
			);

			$curl = curl_init();
			
			if(isset($args['uAgent'])){
				$options[CURLOPT_USERAGENT] = $args['uAgent']; // who am i
			}

			if(isset($args['refer'])){
				$options[CURLOPT_REFERER] = $args['refer']; // detect domain come from request
			}

			if(isset($args['auth'])){
				$options[CURLOPT_USERPWD] = $args['auth']; // detect domain come from request
				$options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC; // set HTTP authorization
			}

			$options[CURLOPT_URL] = $url;  
			curl_setopt_array($curl, $options);

			$result = curl_exec($curl);

			if($result !== false){

				$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 

				if( in_array($statusCode, range(200,306)) ){
					return $result;
				}
				else{
					return null;
				}
			}
			else{
				return null;
			}
			curl_close($curl);
		}
	}

	protected function _saveFavicon($url_icon){

		$url = $this->_url;
		$args = $this->_args;
		$file_path = isset($args['fp']) ? $args['fp'] : 'favicon/';
		$url_icon = $url_icon ? $url_icon : $url;
		$fixed_file = $this->_fixedFile($url_icon);
		$local_file = $file_path.$fixed_file;

		if(!is_dir($file_path)){
			mkdir($file_path,0777,true);
		}

		if(!file_exists($local_file)){

			$ch = curl_init($url_icon);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/21.0 (compatible; MSIE 8.01; Windows NT 5.0)');
			curl_setopt($ch, CURLOPT_TIMEOUT, 200);
			curl_setopt($ch, CURLOPT_AUTOREFERER, false);
			curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follows redirect responses
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			// gets the file content, trigger error if false
			$file = curl_exec($ch);
			if($file === false) trigger_error(curl_error($ch));

			curl_close ($ch);

			@file_put_contents($local_file, $file);

		}
	}

	protected function _loopFavicon(){}

	protected function _googleGetFavicon(){
		$url = $this->_url;
	    $ch = curl_init('http://www.google.com/s2/favicons?domain='.$url);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($ch);
	    curl_close($ch);
	 
	    return $data;
	}

	protected function _getFavicon(){
		$url = $this->_url;
		$args = $this->_args;

		$url = preg_match('/(htt(p|ps)|ft(p|ps))/', $url) ? $url : 'http://'.$url;
		$processDataCurl = $this->_ProcessDataCurl();

		if($processDataCurl !== null){
			$favicon = $this->_parseFavicon($processDataCurl);

			$pieces = parse_url($favicon);
			$domain = isset($pieces['host']) ? $pieces['host'] : '';
			
			if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain)) {
				$favicon = preg_match('/^\/\/(.*)/', $favicon) ? 'http:'.$favicon : $favicon;
				$result = $favicon;
			}
			else{
				$favicon = preg_match('/^\/(.*)/', $favicon) ? $favicon : '/'.$favicon;
				$result = $url.$favicon;
			}

			if(isset($args['save']) AND $args['save']==true){
				$this->_saveFavicon($result);
			}

			return $result;
		}
		else{
			return null;
		}
	}

	protected function _matchDomain(){
		$url = $this->_url;
	}

	protected function _sliceCurlData(){
		$args = $this->_args;
		$processDataCurl = $this->_ProcessDataCurl();

		if($processDataCurl !== null){
			$get_html = strstr($processDataCurl,$args['o_tag']);
			$get_html = strstr($get_html,$args['c_tag'],true);
			$get_html = substr($get_html,strlen($args['o_tag'])+1,-1);
			//$get_html = preg_replace('#<(script|style)(.*?)>(.*?)</(script|style)>#is','',$get_html);
			return $get_html;
		}
		else{
			return null;
		}
	}

	protected function _fixedFile($url_icon){
		$url = $this->_url;
		$url_icon = $url_icon ? $url_icon : $url;
		$path_info = pathinfo($url_icon);
		$ext = $path_info['extension'];
		$ext = preg_replace('/(\?)(.*)/','', $ext);
		$name_icon = preg_replace('/\./','_', $url);
		$name_icon = $name_icon.'.'.$ext;
		return $name_icon;
	}

	protected function _parseFavicon($html){
		/**
		 * _parseFavicon function
		 * Source: https://gist.github.com/jeremiahlee/785769
		 *
		 * Get the 'href' attribute value in a <link rel="icon" ... />
		 * Also works for IE style: <link rel="shortcut icon" href="http://www.example.com/myicon.ico" />
		 * And for iOS style: <link rel="apple-touch-icon" href="somepath/image.ico">
		 */

		$matches = array();

		/* Search for .. /><link rel="icon" type="image/png" href="http://example.com/icon.png" /> */
		preg_match('/><link.*?rel=("|\').*icon("|\').*?href=("|\')(.*?)("|\')/i', $html, $matches);
		if (count($matches) > 4)
			return trim($matches[4]);

		/* Search for <link type="image/ ..." type="image/png" href="http://example.com/icon.png" /> */
		preg_match('/<link.*?type=("|\')image.*("|\').*?href=("|\')(.*?)("|\')/i', $html, $matches);
		if (count($matches) > 4)
			return trim($matches[4]);

		/* 
		 * Order of attributes could be swapped around:
		 * <link href="http://example.com/icon.png" type="image/......" />
		 */
		preg_match('/<link.*?href=("|\')(.*?)("|\').*?type=("|\')image.*("|\')/i', $html, $matches);
		if (count($matches) > 2)
			return trim($matches[2]);

		/* 
		 * Order of attributes could be swapped around:
		 * <link type="image/......" href="http://example.com/icon.png" />
		 */
		preg_match('/<link.*?rel=("|\').*icon("|\').*?href=("|\')(.*?)("|\')/i', $html, $matches);
		if (count($matches) > 4)
			return trim($matches[4]);

		/* Order of attributes could be swapped around:
		 * <link href="http://example.com/icon.png" rel="icon" />
		 */
		preg_match('/<link.*?href=("|\')(.*?)("|\').*?rel=("|\').*icon("|\')/i', $html, $matches);
		if (count($matches) > 2)
			return trim($matches[2]);

		/* Order of attributes could be swapped around:
		 * <link rel="icon" href="http://example.com/icon.png" />
		 */
		preg_match('/<link.*?rel=("|\')icon("|\').*?href=("|\')(.*?)("|\')/i', $html, $match_todo);
		if (count($match_todo) > 3)
			return trim($match_todo[3]);

		/* No match */
		return null;
	}
}
?>
