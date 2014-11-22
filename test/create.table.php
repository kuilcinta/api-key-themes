<?php

require_once(dirname(__FILE__).'/../config.php');

class Tests {
	protected $_a;
	protected $_b;
	protected $_c;
	function __construct($a,$b,$c){
		$this->_a = $a;
		$this->_b = $b;
		$this->_c = $c;
	}

	public function get_tests(){
		$proses = $this->_CreateSQL();
		if($proses AND $proses==1){
			return 200;
		}
		else{
			return 422;
		}
	}

	protected function _CreateSQL(){
		global $Testing;

		$name_test = $this->_a;
		$desc_test = $this->_b;
		$data = array('where'=>"name_test='{$name_test}'");
		$check_test = $Testing->check_test($data);

		if($check_test==false){
			$ce = $this->_c;
			$data = array('tbl'=>'test',
						  'prm'=>array(	'name_test'=>$name_test,
						  				'desc_test'=>$desc_test,
						  				'date_test'=>$ce['date'],
						  				'status_test'=>$ce['status']
						  				)
						  );

			$result = Access_CRUD($data,'create');
		}
		else{
			$result = null;
		}
		return $result;
	}

	public function test_echo(){
		return $this->_Echo();
	}

	protected function _Echo(){
		global $Testing;
		$a = $this->_a;
		$b = $this->_b;
		$c = $this->_c;
		$sc = implode(', ',$c);
		return $Testing->test_echo(array('v'=>"$a $b $sc")); 
	}
}

class Testing {
	public static function check_test($args=false){
		$where = isset($args['where']) ? $args['where'] : '';
		$check = self::_CheckTest(array('where'=>"WHERE $where"));
		if($check->num_rows == 0){
			return false;
		}
		else{
			return true;
		}
	}

	public static function _CheckTest($args=false){
		$where = isset($args['where']) ? $args['where'] : '';
		$order = isset($args['order']) ? $args['order'] : '';
		$data = array('tbl'=>'*',
					  'from'=>'test',
					  'prm'=>"$where $order"
					 );

		$sql = Access_CRUD($data,'read');
		return $sql;
	}

	public static function test_echo($a=false){
		return self::echos($a['v']);
	}

	private static function echos($a){
		echo $a.' is work';
	}
}
$Testing = new Testing();

$TestEcho = new Tests('syukur','alhamdulillah',array('a'=>'smile','b'=>'happy'));
//$TestEcho->test_echo();

if(isset($_GET['create']) AND $_GET['create'] == 'do'){
	$proses = new Tests($_POST['name'],$_POST['desc'],array('date'=>date('Y-m-d H:i:s'),'status'=>'N'));
	$sql = $proses->get_tests();

	echo $sql;
}
?>
<form action="<?= $_SERVER['PHP_SELF'] ?>?create=do" method="POST">
	<input name="name" type="text">
	<input name="desc" type="text">
	<input value="Kirim" type="submit">
</form>