<?php if ( ! defined('BASEDIR')) header('Location:page=error&msg=404');

/**
 * Setting class
 * Menangani pengaturan website
 *
 * @author Ofan Ebob
 * @since v1.0
 */
class Setting
{
	protected $_args;
	protected $_type;

	public function __construct($args=false)
	{
		$this->_default_type = 'read';
		$this->_args = is_array($args) ? $args : null;
	}

	protected function _SettingDB()
	{
		$argum = $this->_args;

		if($argum !== null)
		{

			$is_type = $this->_type;

			$default_type = $this->_default_type;

			$array_type = array('create','read','update','delete');

			$type_db = in_array($is_type, $array_type) ? $is_type : $default_type;

			$data = array('tbl'=>'site_opt');

			if(isset($argum['row']))
			{
				$data['row'] = isset($argum['row']) ? $argum['row'] : '*';
			}
			
			if(isset($argum['prm']))
			{
				$data['prm'] = $argum['prm'];
			}

			if(isset($argum['con']))
			{
				$data['con'] = $argum['con'];
			}

			return Access_CRUD($data,$type_db);
		}
		else
		{
			return null;
		}
	}

	public function read_site_opt()
	{
		$this->_type = 'read';
		$sql = $this->_SettingDB();

		if($sql == null)
		{
			return null;
		}
		else
		{
			return $sql;
		}
	}

	public function update_site_opt()
	{
		$this->_type = 'update';
		$sql = $this->_SettingDB();

		if($sql == null OR $sql == 0)
		{
			return null;
		}
		else
		{
			return $sql;
		}
	}

	public function delete_site_opt()
	{
		$this->_type = 'delete';
		$sql = $this->_SettingDB();

		if($sql == null OR $sql == 0)
		{
			return null;
		}
		else
		{
			return $sql;
		}
	}
}
?>