<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');
/**
 * Favicon Class
 * Grab favicon URL to files from HTTP cURL
 *
 * @since v1.0
 * @author Ofan Ebob
 */

class Favicon {
	protected $_args;

	public function __construct($args){
		$this->_args = $args;
	}

	protected function _saveFavicon($url){

		$args = $this->_args;
		$url = $args['url'];
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
		$args = $this->_args;
		$url = $args['url'];
	    $ch = curl_init('http://www.google.com/s2/favicons?domain='.$url);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($ch);
	    curl_close($ch);
	 
	    return $data;
	}

	protected function _getFavicon(){
		$args = $this->_args;
		$url = $args['url'];

		$url = preg_match('/(htt(p|ps)|ft(p|ps))/', $url) ? $url : 'http://'.$url;

		$Curls = new cURLs( array('url'=>$url,'type'=>'data') );		
		$processDataCurl = $Curls->access_curl();

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