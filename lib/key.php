<?php
/**
 * TheKey adalah class untuk akses
 */

class TheKey {
    protected $_k;
    protected $_def_k;
    
	function __construct($k){
		$this->_k = md5($k);
		$this->_def_k = get_author_master_data('key');
	}

	public function get_key(){
		return $this->create_session();
	}

	protected function create_session(){
		$process_key = $this->process_key();

		if($process_key==true){
			session_regenerate_id();
			$_SESSION['ofansession'] = base64_encode('has_login');
			return 200;
		}
		else{
			return 404;
		}
	}

	protected function process_key(){
		$the_k = $this->_k;
		$data = array('from'=>'site_opt',
					  'prm'=>"WHERE opt_name='key' AND opt_value='{$the_k}'",
					  'tbl'=>'*'
					 );
		$sql = Access_CRUD($data,'read');
		if($sql->num_rows != 0){
			return true;
		}
		else{
			if($this->_def_k == $this->_k){
				return true;
			}
			else{
				return false;
			}
		}
	}
}

class KeyLogging {
	public static function access($k){
		$the_k = new TheKey($k);
		$check_k = $the_k->get_key();

		if($check_k==200){
			return redir(site_url('ofan'));
		}
		else{
			return redirError( array('uri'=>site_url('ofan'),'msg'=>$the_k) );
		}
	}

	public static function exits($ses){
	    //session_start();
	    if($ses == $_SESSION['ofansession']){
	        session_destroy();
	        return 200;
	    }
	    else{
	        return 401;
	    }
	}
}

$KeyLogging = new KeyLogging();
?>