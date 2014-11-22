<?php

/**
 * @author ofanebob
 * @copyright 2014
 * Fungsi untuk User
 */

global $apiuserlog_session;

class User_Service {
    protected $_username;
    protected $_password;
    protected $_autologin;
    protected $_args;
    protected $_user;

    public function __construct($usr, $psw, $args){
        $this->_username = $usr;
        $this->_password = $psw;
        $this->_args = $args;
        $this->_autologin = is_array($args) ? (isset($args['autolog']) ? $args['autolog'] : 0) : $args;
    }

    public function process_user(){
        $sql = $this->_checkCredentials();

        if($sql->num_rows != 0){
            $this->_user = $sql;
            return $this->_GenerateSession(); /* Return integer 200 */
        }
        else{
            return 406;
        }
    }

    public function generate_user(){
        $response = $this->_GenerateNewUser();
        if($response AND $response==1){
            return true;
        }
        else{
            return false;
        }
    }

    protected function _GenerateNewUser(){
        $usn = $this->_username;
        $pas = md5($this->_password);
        $argum = $this->_args;
        $data = array( 'tbl'=>'users',
                       'prm'=>array('user_name'=>$usn,
                                    'user_email'=>$argum['email'],
                                    'user_pass'=>$pas,
                                    'user_firstname'=>$argum['fname'],
                                    'user_lastname'=>$argum['lname'],
                                    'user_status'=>'N'
                                    )
                      );

        return Access_CRUD($data,'create');
    }

    protected function _GenerateSession(){
        global $Users;
        //session_start();

        $userSQL = $this->_user;
        $userData = $userSQL->fetch_assoc();

        session_regenerate_id(true);

        $useridlog = $userData['user_id'];
        $usernamelog = $userData['user_name'];

        $_SESSION['apiuserlog'] = $Users->encodecode(array( array('a'=>$useridlog,'b'=>$usernamelog) ),'encode');
        return 200;
    }

    public function check_user_exist(){
        $sql = $this->_checkCredentials();

        if($sql->num_rows == 0){
            return false;
        }
        else{
            return true;
        }
    }

    protected function _checkCredentials(){
        $usn = $this->_username;
        $pas = md5($this->_password);

        $data = array( 'tbl'=>'*',
                       'from'=>'users',
                       'prm'=>"WHERE user_name='{$usn}' AND user_pass='{$pas}' AND user_status='Y'"
                      );

        $sql = Access_CRUD($data,'read');
        
        return $sql;
    }
    
    public function check_username(){
        $sql = $this->_CheckUserName();

        if($sql->num_rows == 0){
            return false;
        }
        else{
            return true;
        }
    }

    protected function _CheckUserName(){
        $usn = $this->_username;

        $data = array( 'tbl'=>'*',
                       'from'=>'users',
                       'prm'=>"WHERE user_name='{$usn}'"
                      );

        $sql = Access_CRUD($data,'read');
        
        return $sql;
    }

    public function get_user_database_read(){
        return $this->_checkUserDatabaseRead();
    }

    protected function _checkUserDatabaseRead(){
        $usn = $this->_username;
        $pas = md5($this->_password);

        $data = array( 'tbl'=>'*',
                       'from'=>'users',
                       'prm'=>"WHERE user_name='{$usn}' AND user_pass='{$pas}' AND user_status='Y'"
                      );
        
        return array_fetch_db($data,'read');
    }

    protected function _setAutologin(){        
        if($this->_autologin == 1){
            autologin_header();
        }
    }

    public function getUserData(){
        return $this->_user;
    }
}

class Users {
    public static function encodecode($data,$type='encode'){
        switch ($type) {
            case 'encode':
                if(is_array($data)){
                    return base64_encode($data[0]['a'].'|'.$data[0]['b']);
                }
                else{
                    return base64_encode($data);
                }
            break;
            case 'decode':
                $decode = base64_decode($data);
                $decodes = explode('|', $decode);
                return array( array('a'=>$decodes[0],'b'=>$decodes[1]) );
            break;
            default:
                return 0;
            break;
        }
    }

    public static function process_user_method_ajax($credential){
        if($credential==200){
            $data = statusCode($credential);
        }
        else{
            $data = ajaxError('login',$credential,1,'warning',false,false);
        }
        return array('status'=>$credential,'data'=>$data);
    }

    public static function process_user_method_direct($credential){
        if($credential==200){
            return redir(site_url('users'));
        }
        else{
            return redirError( array('uri'=>site_url('users'),'msg'=>$credential) );
        }
    }

    public static function logout($userlog){
        //session_start();
        if($userlog == $_SESSION['apiuserlog']){
            session_destroy();
            return 200;
        }
        else{
            return 401;
        }
    }

    public static function login($usn,$pas,$autolog,$type='ajax'){
        $credential = new User_Service($usn,$pas,$autolog);
        $process_user = $credential->process_user();

        if($type=='ajax'){
            return self::process_user_method_ajax($process_user);
        }
        else{
            return self::process_user_method_direct($process_user);
        }
    }

    public static function get_decode_log_id($data){
        $result = self::encodecode($data,'decode');
        return $result[0]['a'];
    }

    public static function get_decode_log_username($data){
        $result = self::encodecode($data,'decode');
        return $result[0]['b'];
    }

    public static function get_log_user_name($data_id){
        $result = self::get_user_database_by_id($data_id);
        return $result['user_name'];
    }

    public static function update_user_db($args=false){
        $id = $args['id'];
        $data = array(  'tbl'=>'users',
                        'prm'=>$args['prm'],
                        'con'=>"WHERE user_id=$id"
                    );

        $sql = Access_CRUD($data,'update');
        return $sql;
    }

    public static function edit_user_data($args=false){
        $prm = array('user_pass'=>$args['pass'],
                     'user_email'=>$args['mail'],
                     'user_firstname'=>$args['fname'],
                     'user_lastname'=>$args['lname']
                    );

        if(isset($args['usn'])){
            array_merge($prm,array('user_name'=>$args['usn']));
        }

        $data_array = array('id'=>$args['id'], 'prm'=>$prm);

        $data = self::update_user_db($data_array);

        if($data){
            return self::process_user_method_direct(200);
        }
        else{
            return self::process_user_method_direct(422);
        }
    }

    protected static function get_user_database_by_id($data_id){
        if(empty($data_id) && !is_numeric($data_id) && !is_string($data_id)){
            $data_id = $_SESSION['apiuserlog'];
            $userid = self::get_decode_log_id($data_id);
        }
        elseif(is_numeric($data_id)){
            $userid = intval($data_id);
        }
        else{
            $userid = self::get_decode_log_id($data_id);
        }

        $data = self::get_user_db(array('where'=>"user_id=$userid"));

        $user_sql = auto_fetch_db($data,'read');

        if($user_sql!=0 && !is_array($userid)){
            return $user_sql;
        }
        else{
            return 0;
        }
    }

    public static function get_user_id_by_username($usn){
        $data = self::get_user_db(array('where'=>"user_name='{$usn}'"));

        $result = Access_CRUD($data,'read');
        if($result->num_rows != 0){
            $user = $result->fetch_assoc();
            return $user['user_id'];
        }
        else{
            return null;
        }
    }

    protected static function get_user_db($args=false){
        $where = isset($args['where']) ? 'WHERE '.$args['where'] : '';
        $order = isset($args['order']) ? 'ORDER BY '.$args['order'] : '';
        $data = array( 'tbl'=>'*',
                       'from'=>'users',
                       'prm'=>"$where $order"
                      );
        return $data;
    }

    public static function get_user_db_array($args=false){
        $data = self::get_user_db($args);
        $sql = array_fetch_db($data,'read');
        return $sql;
    }

    public static function get_userlog_full_name($userlog){
        $userid = self::get_decode_log_id($userlog);
        return self::fullname_user_db_id($userid);
    }

    public static function get_user_full_name($userid){
        return self::fullname_user_db_id($userid);
    }

    public static function fullname_user_db_id($userid){
        $user = self::get_user_database_by_id($userid);
        return $user['user_firstname'].' '.$user['user_lastname'];
    }

    public static function get_log_user_email($userid){
        $user = self::get_user_database_by_id($userid);
        return $user['user_email'];
    }
}
$Users = new Users();

if(isset($_SESSION['apiuserlog'])){
    $userid_session = $Users->get_decode_log_id($_SESSION['apiuserlog']);
}
?>