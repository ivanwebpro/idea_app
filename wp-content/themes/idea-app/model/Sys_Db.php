<?php

class Sys_Db
{

	public static function insert($tbl, $data)
	{
    global $wpdb;
		$ptbl = $wpdb->prefix.$tbl;
		$wpdb->insert($ptbl, $data);
		return $wpdb->insert_id;
	}

	public static function update($tbl, $data, $where)
	{
    global $wpdb;
		$ptbl = $wpdb->prefix.$tbl;
		$wpdb->update($ptbl, $data, $where);
	}

	public static function getTbls()
	{
		global $wpdb;
		$tbls = $wpdb->get_results("SHOW TABLES", ARRAY_N);

		$res = array();
		foreach($tbls as $t)
			$res[] = $t[0];
		return $res;
	}

	public static function getCols($tbl)
	{
		global $wpdb;
		$ptbl = $wpdb->prefix.$tbl;
		$cols = $wpdb->get_col( "DESC " . $ptbl, 0);
		return $cols;
	}

	public static function getPrefixedTbl($tbl)
	{
		global $wpdb;
		$ptbl = $wpdb->prefix.$tbl;
		$tbls = static::getTbls();

		if (!in_array($ptbl, $tbls))
    	throw new Exception("`$tbl` not exist in DB");

		return $ptbl;
	}

	public static function getRow($select, $tbl, $where)
	{
		global $wpdb;
		$ptbl = static::getPrefixedTbl($tbl);
		$res = $wpdb->get_row("SELECT $select FROM $ptbl WHERE $where");
		return $res;
	}

	public static function isExistByCol($tbl, $col, $val)
	{
		global $wpdb;
		$cols = static::getCols($tbl);
		$ptbl = static::getPrefixedTbl($tbl);

		if (!in_array($col, $cols))
			throw new Exception("$ptbl not have column $col");

		$q = $wpdb->prepare("SELECT COUNT(*)
				FROM `$ptbl` WHERE `$col` = '%s'", $val);

		$c = $wpdb->get_var($q);

		return ($c>0);
	}

	public static function getRowByCol($tbl, $col, $val)
	{
		global $wpdb;
		$cols = static::getCols($tbl);
		$ptbl = static::getPrefixedTbl($tbl);

		if (!in_array($col, $cols))
			throw new Exception("$ptbl not have column $col");

		$q = $wpdb->prepare("SELECT *
				FROM `$ptbl` WHERE `$col` = '%s'", $val);

		$r = $wpdb->get_row($q, ARRAY_A);

		return $r;
	}


	public static function deleteByCol($tbl, $col, $val)
	{
		global $wpdb;
		$cols = static::getCols($tbl);
		$ptbl = static::getPrefixedTbl($tbl);

		if (!in_array($col, $cols))
			throw new Exception("$ptbl not have column $col");

		$q = $wpdb->prepare("DELETE
				FROM `$ptbl` WHERE `$col` = '%s'", $val);

		$wpdb->query($q);
	}

	public static function getAllRowsByAttrs($tbl, $attrs = array())
	{
		global $wpdb;
		$cols = static::getCols($tbl);
		$ptbl = static::getPrefixedTbl($tbl);

		$where = ' 1 ';
		$pars = array();
		foreach($attrs as $col => $v)
		{
			if (!in_array($col, $cols))
				throw new Exception("$ptbl not have column $col");

			$where .= " AND `$col` = '%s' ";
			$pars[] = $v;
		}

    $sql = "SELECT * FROM `$ptbl` WHERE $where";

		if (count($pars) > 0)
			$sql = $wpdb->prepare($sql, $pars);

		//print "SQL: $sql<br>";

		$els = $wpdb->get_results($sql, ARRAY_A);
		return $els;
	}

}