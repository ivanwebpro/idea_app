<?php

/*

Attributes:
id (integer)
name (string)

Methods:
save()
delete()
findByPk($id)
findAll()
findAllByAttributes(array(‘attr’=>’value’, …))

*/

class Tag extends Sys_DbRecord
{
  protected static $tbl = 'terms'; // non-prefixed
  protected static $fld_id = 'term_id';

	function getDbDataFromRealData($data)
	{
		$db_data = [];
		$db_data[static::$fld_id] = $data['id'];
		$db_data['name'] = $data['name'];
		return $db_data;
	}

	function beforeSave()
	{
  	if (!parent::beforeSave())
			return false;

		if (isset($data['name']))
			$db_data['slug'] = sanitize_title($data['name']);

		return true;
	}

	function getRealDataFromDbData($data)
	{
		$real_data = [];

		$map = array(
				static::$fld_id => 'id',
				'name' => 'name',
				);

		foreach($map as $df => $rf)
			$real_data[$rf] = $this->db_data[$df];

		return $real_data;
	}
}


