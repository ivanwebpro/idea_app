<?php

function idea_app_models_autoloader($class)
{
	$f = $class.'.php';
 	if (file_exists($f))
	{
		include $f;
		return;
	}
}

spl_autoload_register('idea_app_models_autoloader');