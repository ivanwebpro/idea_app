<?php

/*


Attributes:
id (integer)
name (string)

Methods:
static getCurrentUserId()
findByPk($id)

*/

class User extends Sys_DbRecord
{
  protected static $tbl = 'users'; // non-prefixed
  protected static $fld_id = 'ID';

	public static function getCurrentUserId()
	{
  	return get_current_user_id();
	}

	function getDbDataFromRealData($data)
	{
    $db_data = [];
		$db_data[static::$fld_id] = $data['id'];
		$db_data['user_nicename'] = $data['name'];
		return $db_data;
	}

	function getRealDataFromDbData($data)
	{
		$real_data = [];

		$map = array(
				static::$fld_id => 'id',
				'user_nicename' => 'name',
				);

		foreach($map as $df => $rf)
			$real_data[$rf] = $data[$df];

		return $real_data;
	}
}


