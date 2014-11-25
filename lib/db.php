<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * @author ofanebob
 * @copyright 2014
 * Perubahan method DB_Class dari pemanggilan database standar mysql
 * Dirubah menjadi method OOP mysqli
 * Berlaku untuk semua versi PHP kecuali di di atas 5.4.9 Depreceted
 */

class DB_Class {
    protected $_connecting;
    protected $_hosting;
    protected $_username;
    protected $_password;
    protected $_database;

    function __construct(){
        $this->_hosting = DB_HOST;
        $this->_username = DB_USERNAME;
        $this->_password = DB_PASSWORD;
        $this->_database = DB_NAME;
    }
 
    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        
        $this->_connecting = new mysqli($this->_hosting, $this->_username, $this->_password, $this->_database);
        
        if (mysqli_connect_errno()) {
            die("Koneksi MySQL gagal: " . mysqli_connect_error());
        }
        elseif($this->_connecting->connect_error) {
            $this->last_error = 'Database tidak tersambung. ' . $_connecting->connect_error;
            exit();
        }

        return $this->_connecting;
    }
}

?>