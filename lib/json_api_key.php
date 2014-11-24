<?php
/**
 * ToJson Class
 * Handling updata & create New API on database from user request
 *
 * @since v1.0
 * @author Ofan Ebob
 */
class ToJson {
	protected $_id;
    protected $_usn;
    protected $_pass;
    protected $_email;
    protected $_domain;
    protected $_nextyear;

	public function __construct($args){
		$this->_id = isset($args['id']) ? $args['id'] : false;
		$this->_usn = isset($args['usn']) ? $args['usn'] : false;
		$this->_pass = isset($args['pass']) ? $args['pass'] : false;
		$this->_valid = isset($args['valid']) ? $args['valid'] : false;
		$this->_email = isset($args['email']) ? $args['email'] : false;
		$this->_domain = isset($args['domain']) ? $args['domain'] : false;
		$this->_client = isset($args['client']) ? $args['client'] : false;
		$this->_nextyear = date('Y-m-d H:i:s', strtotime('+1 years'));
	}

	/**
	 * process_new_key() public function
	 * Handling external request function to Class ToJson
	 *
	 * @since v1.0
	 * @author Ofan Ebob
	 */
	public function process_new_key(){
		$username = $this->_usn;
		$password = $this->_pass;
		$email = $this->_email;
		$domain = $this->_domain;

		if(empty($username) && empty($password) && empty($email) && empty($domain)){
			return redirError( array('msg'=>304,'uri'=>site_url('users?register')) );
		}
		else{
			$create_api = $this->_CreateAPI();

			if($create_api == true){
				return redir(site_url('users'));
			}
			else{
				return redirError( array('uri'=>site_url('users?register'),'msg'=>422) );
			}
		}
	}

	/**
	 * _CreateAPI() protected function
	 * pre-action before Add new API Data to Database on _GenerateNewAPI()
	 * this access from process_new_key public function
	 *
	 * @since v1.0
	 * @author Ofan Ebob
	 */
	protected function _CreateAPI(){
		$username = $this->_usn;
		$password = $this->_pass;
		$email = $this->_email;
		//$check_user = $this->_CheckUserName();
		
		if($this->_CheckUserName() !== null){
			return false;
		}
		else{
			$UserService = new User_Service($username,
											$password,
											array('email'=>$email,
												  'fname'=>ucfirst($username),
												  'lname'=>'')
											);

			//$GenerateNewUser = $UserService->generate_user();

			if($UserService->generate_user() == true){

				//$checkDomain = $this->_checkDomainRegis();
				
				if($this->_checkDomainRegis() == false){

					//$generateAPI = $this->_GenerateAPI();

					if($this->_GenerateAPI() == 1){
						return true;
					}
					else{
						return false;
					}

				}
				else{
					return false;
				}

			}
			else{
				return false;
			}
		}
	}

	/**
	 * _GenerateAPI() protected function
	 * Post action add new API Data to database after _CreateAPI() protected function
	 *
	 * @since v1.0
	 * @author Ofan Ebob
	 */
	protected function _GenerateAPI(){
		global $Users;

		$username = $this->_usn;
		$domain = $this->_domain;
		$client = $this->_client;
		$nextyear = $this->_nextyear;
		$api_id = rand(100,999).time();
		$user_id = $Users->get_user_id_by_username($username);

		if($user_id !== null){
		    $data = array( 'tbl'=>'api_data',
		                   'prm'=>array('api_user'=>$user_id,
		                   				'api_id'=>$api_id,
		                   				'api_value'=>'none',
		                   				'api_domain'=>$domain,
		                   				'api_client'=>$client,
		                   				'api_valid'=>$nextyear,
		                   				'api_status'=>'N'
		                   				)
		                  );

		    $sql = Access_CRUD($data,'create');
		    return $sql;
		}
		else{
			return null;
		}
	}

	/**
	 * _CheckUserName() protected function
	 * Bridge user exist check to access User_Service->check_user_exist()
	 *
	 * @since v1.0
	 * @author Ofan Ebob
	 */
	protected function _CheckUserName(){
        $usn = $this->_usn;

        $credential = new User_Service($usn,'',array());

        $user = $credential->check_username();
        
        return $user;
	}

	protected function _CheckUser(){
        $usn = $this->_usn;
        $pas = md5($this->_pas);

        $credential = new User_Service($usn,$pas,array());

        $user = $credential->check_user_exist();
        
        return $user;
	}

	protected function _checkDomainRegis(){
		$domain = $this->_domain;

		$data = array('tbl'=>'*',
					  'from'=>'api_data',
					  'prm'=>"WHERE api_domain='{$domain}'"
					  );

		$sql = Access_CRUD($data,'read');

		if($sql->num_rows == 0){
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * update_api_data() public function
	 * Handling external request access to parent Class ToJson
	 * pre-action _UpdateAPIValue() protected function
	 *
	 * @since v1.0
	 * @author Ofan Ebob
	 */
	public function update_api_data(){
		$credential = check_api_id_exist($this->_id,false);

		if($credential AND $credential==1){
			
			$UpdateAPI = $this->_UpdateApiValue();

			if($UpdateAPI AND $UpdateAPI==1){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}

	}

	/**
	 * _UpdateAPIValue() protected function
	 * post-action to update API Data database from current user with ID define
	 *
	 * @since v1.0
	 * @author Ofan Ebob
	 */
	protected function _UpdateApiValue(){
        $id = $this->_id;
        $valid = $this->_valid;
        $api_value = base64_encode(get_masterdata_format().'|'.$id.'|'.strtotime($valid));
        $data = array( 'tbl'=>'api_data',
                       'prm'=>array('api_value'=>$api_value),
                       'con'=>"WHERE api_id=$id"
                    );

        $sql = Access_CRUD($data,'update');
        return $sql;
	}
}


/**
 * response_default function
 * Handle json response (error/undifined) results
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return array()
 */
function response_default($args=false){
	return $args['code'] ? status_array($args['code'],$args['lang']) : array('status'=>400,'value'=>'No Response from server');
}


/**
 * get_author_master_data() function
 * Handling spesific master data index value requests
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return get_split_master() with index array()
 */
function get_author_master_data($index=''){
	if($index!=''){
		return get_meta_tag_value($index);
	}
}

/**
 * get_user_api_data_merge_db() function
 * Handling database request from users & api_data table
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return array()
 */
function get_user_api_data_merge_db($userid){
	$data = array( 'tbl'=>'api_data.*, users.*',
	               'from'=>'api_data JOIN users ON api_data.api_user=users.user_id',
	               'prm'=>"WHERE api_data.api_user={$userid} AND api_data.status='Y' AND users.user_status='Y'"
	              );
     return $data;
}

/**
 * get_api_data_db() function
 * Handling api_data databse request
 * @since v1.0
 * @author Ofan Ebob
 * @return array()
 */
function get_api_data_db($args=false){
	$select = isset($args['select']) ? $args['select'] : '*';
	$where = isset($args['where']) ? 'WHERE '.$args['where'] : '';
	$order = isset($args['order']) ? 'ORDER BY '.$args['order'] : '';
	$data = array( 'tbl'=>$select,
	               'from'=>'api_data',
	               'prm'=>"$where $order"
	              );
    return $data;
}

/**
 * check_api_id_exist function
 * Check API exist from database api_data with api_user identifier
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return Access_CRUD() pra-action for CRUD class before access DB Class
 */
function check_api_id_exist($id,$active=false){
	$status = is_string($active) ? "AND api_status='$active'":"";
	$data = get_api_data_db( array('where'=>"api_id=$id {$status}") );
	$sql = Access_CRUD($data,'read');
	return $sql->num_rows;
}

/**
 * get_api_data_db() function
 * Get API datatabase with identifier api_user (ID) before get_api_data_db()
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return get_api_data_db() read Access_CRUD() with num_rows
 */
function get_api_data_db_by_user($userid,$active=false){
	$status = is_string($active) ? "AND api_status='$active'":"";
	$data = get_api_data_db( array('where'=>"api_user=$userid {$status}") );
    return $data;	
}
function get_api_data_by_user($userid,$active=false){
	$data = get_api_data_db_by_user($userid);
	$sql = array_fetch_db($data,'read');
    return $sql;	
}

/**
 * get_api_data_db_by_id() function
 * Get API datatabase with identifier api_id (ID) before get_api_data_db()
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return get_api_data_db() read Access_CRUD() with num_rows
 */
function get_api_data_db_by_id($api_id,$active=false){
	$status = is_string($active) ? "AND api_status='$active'":"";
	$data = get_api_data_db( array('where'=>"api_id=$api_id {$status}") );
    return $data;	
}
function get_api_data_by_id($userid,$active=false){
	$data = get_api_data_db_by_id($userid);
	$sql = array_fetch_db($data,'read');
    return $sql;	
}

/**
 * get_api_status function
 * Get API Status (Y/N) and convert it to (active/inactive) strings
 * Return html render with tag & class or just String variable
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return $result (string)
 */
function get_api_status($datauser,$convert=false,$html_render=false){
	/* Send to database process if $datauser is numeric */
	if(is_numeric($datauser)){
		$data = get_api_data_db_by_user($datauser,false);
		$sql = auto_fetch_db($data,'read');
		/* Retrive value ENUM (Y/N) from api_status column */
		$api_status = $sql['api_status'];
	}
	else{
		/* Define $datauser string (Y/N) to $api_status variable */
		$api_status = $datauser;
	}
    
    $result = $convert == true ? ($api_status=='Y'?'active':'inactive') : $api_status;
    return ($html_render == true ? '<span class="label '.($api_status=='Y'?'label-danger':'label-default').'">'.$result.'</span>':$result);
}

/**
 * formatting_json_request() function 
 * Handling request api_data with JSON Parse to get json format
 * pre-action json_api_key function
 *
 * @since v1.0
 * @author Ofan Ebob
 * @return array()
 */
function formatting_json_request($args=session_start){
	//false();

	if($args['id']==0){
		/* Response code 304 jika $data kosong */
		return response_default(array('code'=>304,'lang'=>$args['lang']));
	}
	else{
		/* Define HTTP Auth username & password from cURL request */
		$auth_usn = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : null;
		$auth_pas = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : null;

		/* Check credentials user exist */
		$UserService = new User_Service($auth_usn,$auth_pas,0);
		$check_user_exist = $UserService->check_user_exist();

		/* Set conditional if user exist return true or user have login session */
		if($check_user_exist==true || is_login()!=false){

			/* Cek API ID exist on database */
			$check_api_id_exist = check_api_id_exist($args['id'],'Y');
			
			/* Set condition if api_id is exist on database */
			if($check_api_id_exist!=0){
				
				/* Defined $user_credentials from database with call User_Service Class & method */
				$user_credentials = $UserService->get_user_database_read();

				/* Set data variable from json_api_key() function */
				$data = json_api_key(
							array(	'ids'=>$args['id'],
									'date_request'=>date('Y-m-d H:i:s'),
									'lang'=>$args['lang'],
									'credential'=>$user_credentials
								)
						);
			}
			else{
				/* Response code 410 jika $data tidak ada di database */
				$data = response_default(array('code'=>410,'lang'=>$args['lang']));
			}		
			return $data;
		}
		else{
			/* Response code 401 jika otentikasi gagal */
			return response_default(array('code'=>401,'lang'=>$args['lang']));
		}

	}
}

function json_api_key($args=false){
	global $Users;
	if(is_array($args)){
		if(($args['ids'] || $args['ids']!=0) && ($args['date_request'] || $args['date_request']!=0)){
			
			/* Defined api_id from formatting_json function (base on URL parameter) */
			$id = $args['ids'];
			
			/* Set credential user_id by username if API Access from logging user */
			$is_login = is_login();
			$decode_log_username = $is_login!=false ? $Users->get_decode_log_username($is_login[1]) : null;
			$get_user_id_by_username = $Users->get_user_id_by_username($decode_log_username);

			/* Defined $credentials variable if API access from cURL */
			$credentials = isset($args['credential']) ? $args['credential'] : null;

			/* Get API Data fetch array for retrive data API from database */
			$user_api_db = get_api_data_by_id($id);

			if($user_api_db['api_user']==$get_user_id_by_username || $user_api_db['api_user']==$credentials['user_id']){

				$api_encode = base64_encode(get_masterdata_format().'|'.$user_api_db['api_id'].'|'.strtotime($user_api_db['api_valid']));

				$arr = array('status'=>200,
							 'message'=>statusCode(200,$args['lang']),
							 'key'=>array('id'=>(float)$id,
							 			  'value'=>$api_encode
							 			  ),
							 //'id'=>$user_credentials['user_id'],
							 //'id_user'=>$get_user_id_by_username,
							 //'username'=>$decode_log_username,
							 //'u-agent'=>(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false),
							 //'referer'=>(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false),
							 //'username'=>(isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : false),
							 //'password'=>(isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : false)
							);

				$folder_storing = 'requests/';
				$file_storing = 'auth_key_'.$id.'.json';
				$file_data = $folder_storing.$file_storing;

				if(!file_exists($file_data))
					file_put_contents($file_data, json_encode($arr));

				if(file_exists($file_data)){

					if($user_api_db['api_value'] == $api_encode){
						return $arr;
					}
					else{
						$ToJson = new ToJson(array('id'=>$id,'valid'=>$user_api_db['api_valid']));
						$update_api_data = $ToJson->update_api_data();

						if($update_api_data AND $update_api_data==true){
							return $arr;
						}
						else{
							return false;
						}
					}
				}
				else{
					return false;
				}
			}
			else{
			/* Response code 406 jika api_user (ID) tidak sama dengan user_id login */
			return response_default(array('code'=>406,'lang'=>$args['lang']));
			}

		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}
?>