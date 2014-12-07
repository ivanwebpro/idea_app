<?php

require 'test_include.php';

$tests = array();

$t = array();
$t['func'] = "getTbls()";
$tests[] = $t;

foreach($tests as $t)
{
	$f = "return Sys_Db::".$t['func'].";";
	$val = eval($f);
	print "<hr>$f:<br>res:<br><pre>";
	var_dump($val);
	print "</pre><hr>";
}