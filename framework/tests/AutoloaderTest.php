<?php

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
	public function testLoadFiles()
	{
		$router = new Collection();

		$this->assertInstanceOf('Collection', $router);
	}

	public function testLoadFileInsideSubdirectory()
	{
		$serverInfo = new ServerInfo(null);

		$this->assertInstanceOf('ServerInfo', $serverInfo);
	}
}