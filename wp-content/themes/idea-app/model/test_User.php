<?php

require 'test_include.php';

$tests = array();

$t = array();
$t['func'] = "findByPk(1)";
$tests[] = $t;

foreach($tests as $t)
{
	$f = "\$obj = new User(); \$obj->".$t['func']."; return \$obj->real_data;";
	$val = eval($f);
	print "<hr>$f:<br>res:<br><pre>";
	var_dump($val);
	print "</pre><hr>";
}