<?php

/*

Attributes:
id (integer)
idea_id (integer)
user_id (integer)
parent_id (integer)
body (string)

Methods:
save()
delete()
findByPk($id)
findAll()
findAllByAttributes(array(‘attr’=>’value’, …))


*/

class Comment extends Sys_DbRecord
{
  protected static $tbl = 'comments'; // non-prefixed
  protected static $fld_id = 'comment_ID';

	function getDbDataFromRealData($data)
	{
    $db_data = [];

		$map = $this->getDbRealFieldsMap();
		foreach($map as $df => $rf)
		{
			if (isset($data[$rf]))
				$db_data[$df] = $data[$rf];
		}

		return $db_data;
	}

	function getDbRealFieldsMap()
	{
		$map = array(
				static::$fld_id => 'id',
				'user_id' => 'user_id',
				'comment_post_ID' => 'idea_id',
				'comment_content' => 'body',
				'comment_parent' => 'parent_id',
				);
  	return $map;
	}

	function getRealDataFromDbData($data)
	{
		$real_data = [];

		$map = $this->getDbRealFieldsMap();

		foreach($map as $df => $rf)
			$real_data[$rf] = $data[$df];

		return $real_data;
	}
}


