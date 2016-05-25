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

	public function testPsr4Autoloader()
    {
        $testClass = new \Litp\Aurora\Collection();
        $testClass2 = new \Litp\Aurora\Http\Headers();

        $this->assertInstanceOf('\Litp\Aurora\Collection', $testClass);
        $this->assertInstanceOf('\Litp\Aurora\Http\Headers', $testClass2);
    }
}