<?php

require 'test_include.php';

$tests = array();

$t = array();
$t['run'] = "\$obj = new Idea(); \$obj->findByPk(6); return \$obj;";
$tests[] = $t;

$t = array();
$t['run'] = "\$obj = new Idea(); \$els = \$obj->findAll(); return \$els;";
$tests[] = $t;

$t = array();
$t['run'] = "\$obj = new Idea(); \$els = \$obj->findByTagId(9); return \$els;";
$tests[] = $t;

$t = array();
$t['run'] = "\$obj = new Idea(); \$els = \$obj->findByCategoriesIds([5]); return \$els;";
$tests[] = $t;

$t = array();
$t['run'] = "\$obj = new Idea();
\$obj->categories_ids = [4];
\$obj->tags_ids = [6];
\$obj->name = 'TestIdea(".time().")';
return \$obj->save();";
$tests[] = $t;

foreach($tests as $t)
{
	$f = $t['run'];
	$val = eval($f);
	print "<hr>$f:<br>res:<br><pre>";
	//var_dump($val);
	if (isset($val))
		Sys_DbRecord::myDump($val);
	print "</pre><hr>";
}