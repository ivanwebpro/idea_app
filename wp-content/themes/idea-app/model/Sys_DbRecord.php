<?php

abstract class Sys_DbRecord
{
  protected static $tbl; // non-prefixed
  protected static $fld_id = 'ID';
  protected static $can_cache = false;
	public $db_data = array();
	public $real_data = array();
	protected $id;

  public static function myDump($data)
	{
		if (is_scalar($data))
      var_dump($data);
		elseif (!is_array($data))
			var_dump($data->real_data);
		else
		{
    	foreach($data as $obj)
			{
				var_dump($obj->real_data);
				print "\r\n";
			}
		}

	}

	public function __debugInfo()
	{
    return $this->real_data;
  }

	public function findAll()
	{
		return $this->findAllByAttributes();
	}

	public function findAllByAttributes($attrs = array())
	{
		$attrs = $this->getDbDataFromRealData($attrs);
		$els = Sys_Db::getAllRowsByAttrs(static::$tbl, $attrs);

		$res = array();

		foreach($els as $el)
		{
    	$obj = new static();
			$obj->prepareFromDbData($el);
			$res[] = $obj;
		}

		return $res;
	}


	public function validate(&$flds_errors, &$general_errors)
	{
  	return true;
	}

	public function beforeSave()
	{
  	return true;
	}

	function afterSave()
	{
	}


	public function findByPk($id)
	{
		$res = Sys_Db::getRowByCol(static::$tbl, static::$fld_id, $id);

		if ($res != null)
		{
			$this->db_data = $res;
			$this->real_data = $this->getRealDataFromDbData($this->db_data);
			return true;
		}

		return false;
	}


	public function loadFromDb()
	{
		$res = $this->findByPk($this->id);

		if (!$res)
    	throw new Exception("Object #{$this->id} not found in ".static::$tbl);
	}

	public static function getTbl()
	{
 		return static::$tbl;
	}

	public static function getFldId()
	{
 		return static::$fld_id;
	}


  public function __set($name, $value)
  {
  	$this->real_data[$name] = $value;
  	$this->db_data = $this->getDbDataFromRealData($this->real_data);
	}

  public function __isset($name)
  {
   	return isset($this->real_data[$name]);
	}

  public function __unset($name)
  {
		unset($this->real_data[$name]);
		$this->db_data = $this->getDbDataFromRealData($this->real_data);
  }

	public function prepareFromDbData($db_data)
	{
		$this->db_data = $db_data;
		$this->id = $this->db_data[static::$fld_id];
    $this->real_data = $this->getRealDataFromDbData($this->db_data);
	}

	public function __get($name)
	{

		if ('id' == $name)
			$name = static::$fld_id;

		if (!isset($this->db_data))
			throw new Exception("No data set");
		if (!is_array($this->real_data))
			throw new Exception("Bad data type (non-array)");

		if (array_key_exists($name, $this->real_data))
			return $this->real_data[$name];
		else
		{
			throw new Exception("Wrong attribute '$name'
												for class '".get_called_class()."' with ID #$this->id");
		}
	}


	public static function model()
	{
  	return new static();
	}

	public function __construct()
	{
	}

	abstract function getDbDataFromRealData($data);
	abstract function getRealDataFromDbData($data);

	public function save()
	{
		if (!$this->beforeSave())
		{
    	throw new Exception("Cannot save (beforeSave returned false)");
		}

		if ($this->id)
		{
			$key = array(static::$fld_id => $this->id);
			Sys_Db::update(static::$tbl, $this->db_data, $key);
		}
		else
		{
			$this->id = Sys_Db::insert(static::$tbl, $this->db_data);
		}

		$this->afterSave();

		return $this->id;
	}

	public function delete()
	{
		Sys_Db::deleteByCol(static::$tbl, static::$fld_id, $id);
	}

}