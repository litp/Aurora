<?php

define('ROOT_DIR', dirname(__DIR__));

function autoloader($class)
{
	if (file_exists(ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class . '.php')) {
		require ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class . '.php';
	} else {
		foreach( glob(ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $directory) {
			if (file_exists($directory . DIRECTORY_SEPARATOR . $class . '.php')) {
				require $directory . DIRECTORY_SEPARATOR . $class . '.php';
				break;
			}
		}	
	}

}

spl_autoload_register('autoloader');