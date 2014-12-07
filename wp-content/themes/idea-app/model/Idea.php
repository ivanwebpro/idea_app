<?php

/*

Attributes:
id (integer)
user_id (integer)
name (string)
body (string)
rating (float, 1…5)
categories_ids (array(cat_id1, cat_id2, …))
tags_ids (array(tag_id1, tag_id2, …))

Methods:
save()
delete()
findByPk($id)
findAll()
findAllByAttributes(array(‘attr’=>’value’, …)) - not use for categories/tags
findByTagId($tag_id)
findByCategoriesIds(array(cat1_id, cat2_id, ...))
findByNameLike($text) // WHERE name LIKE ‘%text%’


*/

class Idea extends Sys_DbRecord
{
  protected static $tbl = 'posts'; // non-prefixed
  protected static $fld_id = 'ID';

	public function __construct()
	{
		parent::__construct();
		$this->user_id = User::getCurrentUserId();
	}

	public function findByTagId($tag_id)
	{
		$objs = $this->findAll();
		$res = [];

		foreach($objs as $obj)
			if (in_array($tag_id, $obj->tags_ids))
				$res[] = $obj;

		return $res;
	}

	public function findByCategoriesIds($cat_ids)
	{
		$objs = $this->findAll();
		$res = [];

		foreach($objs as $obj)
		{
			foreach($cat_ids as $cat_id)
			{
				if (in_array($cat_id, $obj->categories_ids))
				{
					$res[] = $obj;
					break;
				}
			}
		}

		return $res;
	}

	public function findByNameLike($text)
	{
		$objs = $this->findAll();
		$res = [];

		foreach($objs as $obj)
			if (strstr($obj->name, $text))
				$res[] = $obj;

		return $res;

	}

	function getDbRealFieldsMap()
	{
		$map = array(
				static::$fld_id => 'id',
				'post_author' => 'user_id',
				'post_title' => 'name',
				'post_content' => 'body',
				);
  	return $map;
	}

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

	function beforeSave()
	{
  	if (!parent::beforeSave())
			return false;

		return true;
	}

	function afterSave()
	{
		$rd = $this->real_data;
		$id = $this->id;

		$kc = 'categories_ids';
		if (isset($rd[$kc]) && is_array($rd[$kc]))
		{
			$post_ID = $id;
			$post_categories = $rd[$kc];
			$append = false;
    	wp_set_post_categories($post_ID, $post_categories, $append);
		}

		$kt = 'tags_ids';
		if (isset($rd[$kt]) && is_array($rd[$kt]))
		{
			$post_ID = $id;
			$tags = $rd[$kt];
			$append = false;
    	wp_set_post_tags($post_ID, $tags, $append);
		}

	}


	function getRealDataFromDbData($data)
	{
		$real_data = [];

		$map = $this->getDbRealFieldsMap();
		foreach($map as $df => $rf)
		{
			if (isset($data[$df]))
				$real_data[$rf] = $data[$df];
		}

		if (isset($real_data['id']))
		{
			$id = $real_data['id'];

			// TODO - setup plugin for rating
			$real_data['rating'] = 0;

			$real_data['categories_ids'] = array();
			$cats = wp_get_post_categories($id);
			foreach($cats as $cat)
				$real_data['categories_ids'][] = $cat;

			$real_data['tags_ids'] = array();
			$tags = wp_get_post_tags($id);
			foreach($tags as $tag)
				$real_data['tags_ids'][] = $tag->term_id;
		}

		return $real_data;
	}

}