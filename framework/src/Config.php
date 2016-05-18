<?php

class Config extends Collection
{
	public static function loadConfig($file = '')
	{
		if (!empty($file)) {
			$config = require $file;
		} else {
			$config = require 'default_config.php';
		}

		return new Collection($config);
	}
}