<?php
/**
 * @author ofanebob
 * @copyright 2014
 * Class Crud_Service
 * @since v.1.0
 * Adalah kelas untuk mengatasi permintaan database dari user pada server dalam bentuk universal
 * Didefinisikan sesuai standar MySQL Statment dalam transaksi data yaitu:
 * Create, Read, Update & Delete
 * Ditambahkan beberapa fungsi dari masing2 statment yang terintegrasi dengan Class DB_Class
 */

class Crud_Service {
	/**
     * @since v.1.0
	 * Mendefinisikan parameter ke Variable konstruksi Class dalam bentuk protected
	 */
	protected $_dataset;
	protected $_type;
    protected $_conected;

    /**
     * Nilai Parameter dimasukan kedalam fungsi __construct
     * Dengan maksud membuat fungsi protected tetap private dari fungsi static AJAX
     */
	function __construct($data,$type){
		if(!is_array($data) && !$type) exit(0);
        $db = new DB_Class();
        $this->_conected = $db->connect();
		$this->_dataset = $data;
		$this->_type = $type;
	}

	/**
     * @since v.1.0
	 * Mendefinisikan database dalam fungsi publik
	 * Ini adalah fungsi yang akan di akses oleh fungsi dari method lain diluar class Crud_Service
	 * Didalamnya mencakup pemanggilan member fungsi dari Class induk yg bersifat protected
     * Sehingga proses AJAX/Direct akan mendapat response langsung berupa nilai integer I/O /
     * \tanpa perlu mengakses fungsi protected
	 */
	public function _DefineDB_Process(){
		$type_query = $this->_type;
		switch($type_query){
			case 'read':
				return $this->_ReadDB();
			break;

			case 'create':
				return $this->_CreateDB();
			break;

			case 'update':
				return $this->_UpdateDB();
			break;

			case 'delete':
				return $this->_DeleteDB();
			break;

            case 'upload':
                return $this->_Upload();
            break;

			default:
                // Return 0 (false/null) menjadi integer default jika type tidak didefinisikan
				return 0;
			break;
		}
	}


    /**
     * @since v.1.0
     * _CreateDB()
     * Memuat statement INSERT database MySQL
     */
	protected function _CreateDB(){
		$datasets = $this->_dataset;

		$table = $datasets['tbl'];
		$params = $datasets['prm'];

        if(!$table && !is_array($params)) exit(0);

        /* 
         * DATA ARRAY DEFAULT RECEIVED:
         * array('tbl'=>'strings','prm'=>array('cols'=>'vals','cols'=>'vals'))
         *
         * Ilustrasi Column
         * ---------------------------------|-------------------------------------------|-----------------------------------|
         * PARAMETER INDEX ARRAY 			| PARAMETER DATA ARAY 						| PARAMETER FOREACH 				|
         * ---------------------------------|-------------------------------------------|-----------------------------------|
         * $datasets['prm']['nama_kolom']	| 'prm'=>array('nama_kolom'=>'isi_kolom')	| foreach($params as $col => $val)	|
         * $datasets['prm']['isi_kolom']	|											|									|
         * ---------------------------------|-------------------------------------------|-----------------------------------|
         */
        $column = '';
        $value = '';
        foreach($params as $col => $val){
        	if(is_string($val)){
        		$val = "'$val'";
        	}
        	elseif(is_numeric($val) OR is_integer($val)){
        		$val = "$val";
        	}
        	else{
        		$val = $val;
        	}
        	
            $column[] = $col;
            $value[] = $val;
        }
        $column = join($column,',');
        $value = join($value,',');

        $sql = "INSERT INTO $table ($column) VALUES ($value)";
        $result = $this->_conected->query($sql);

        return $result;
	}


    /**
     * @since v.1.0
     * _ReadDB()
     * Memuat statement SELECT database MySQL
     */
	protected function _ReadDB(){
		$datasets = $this->_dataset;

		$from = $datasets['from'];
        
        if(empty($from)) exit(0);

        $table = isset($datasets['tbl']) ? $datasets['tbl'] : '*';
		$params = isset($datasets['prm']) ? $datasets['prm'] : '';

        
        $sql = "SELECT $table FROM $from $params";
        $result = $this->_conected->query($sql);

        return $result;
	}


    /**
     * @since v.1.0
     * _UpdateDB()
     * Memuat statement UPDATE database MySQL
     */
	protected function _UpdateDB(){
		$datasets = $this->_dataset;

		$table = $datasets['tbl'];
		$params = $datasets['prm'];

        if(!$table && !$params && !is_array($params)) exit(0);
        
        $condition = isset($datasets['con']) ? $datasets['con']  : '';

        $coval = '';
        foreach($params as $cols => $val){
        	if(is_string($val)){
        		$val = "'$val'";
        	}
        	elseif(is_numeric($val) OR is_integer($val)){
        		$val = "$val";
        	}
        	else{
        		$val = $val;
        	}

            $coval[] = "$cols=$val";
        }

        $coval = join($coval,',');

        $sql = "UPDATE $table SET $coval $condition";
        $result = $this->_conected->query($sql);

        return $result;
	}


    /**
     * @since v.1.0
     * _DeleteDB()
     * Memuat statement DELETE database MySQL
     */
	protected function _DeleteDB(){
		$datasets = $this->_dataset;

		$table = $datasets['tbl'];
		$condition = isset($datasets['con']) ? $datasets['con'] : '';

        if(!$table) exit('Data table, kolom dan nilainnya harus di definisikan');

        $sql = "DELETE FROM $table WHERE $condition";
        $result = $this->_conected->query($sql);

        return $result;
	}
}

/**
 * @since v.1.0
 * Fungsi publik dalam method independen tanpa class
 * Access_Crud
 * Berisi baris perintah untuk mengakses class Crud_Service
 * Dengan parameter $data (dalam bentuk array) dan $type (untuk CRUD dalam bentuk string)
 * Data akan di return kedalam angka/integer antara 1 atau 0
 */
function Access_CRUD($data,$type){
	if(!$data AND !$type) exit(0);
	$Crud_Service = new Crud_Service($data,$type);
	return $Crud_Service->_DefineDB_Process();
}

function auto_fetch_db($data,$mode='read'){
    if($data){
        $sql = Access_CRUD($data,$mode);
        $fetch = $sql->fetch_assoc();
        return $fetch;
    }
    else{
        return false;
    }
}

function array_fetch_db($data,$mode='read'){
    if($data){
        $sql = Access_CRUD($data,$mode);
        $fetch = $sql->fetch_array();
        return $fetch;
    }
    else{
        return false;
    }
}
?>