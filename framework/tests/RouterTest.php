<?php

class RouterTest extends PHPUnit_Framework_TestCase
{
    protected $request;
    protected $router;
    protected $routerTable = array(
            '/test' => array('TestController', 'test')
        );


    public function testEscapeRouterTable()
    {
        $this->router = new Router($this->routerTable);

        $testTable = array(
            '/test' => 'test'    
        );

        $escaped = $this->router->escapeRouterTable($testTable);

        $this->assertArrayHasKey("/\/test/", $escaped);
    }

    public function testGetQueryPath()
    {
        $this->router = new Router($this->routerTable);

        $this->request = new Request(
            'GET',              //method
            '/index.php/test',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
                )             
            );

        $result = $this->router->getQueryPath($this->request);

        $this->assertEquals('/test', $result);
    }

    public function testDispatchWithNoParameter()
    {
        $this->routerTable = array(
            '/test' => array('TestController', 'test')
        );

        $this->request = new Request(
            'GET',              //method
            '/index.php/test',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
                )             
            );
        $this->router = new Router($this->routerTable);

        $this->router->dispatch($this->request);
    }
    
    public function testDispatchWithOneArgument()
    {
        $this->routerTable = array(
            '/test' => array('TestController', 'test')
        );

        $this->request = new Request(
            'GET',              //method
            '/index.php/test/p1',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
            )
        );

        $this->router = new Router($this->routerTable);

        $this->router->dispatch($this->request);
        
        //$this->expectOutputString();
    }
    
    public function testDispatchWithMultiParameters()
    {
        $this->routerTable = array(
            '/test' => array('TestController', 'test')
        );

        $this->request = new Request(
            'GET',              //method
            '/index.php/test/p1/p2',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
            )
        );

        $this->router = new Router($this->routerTable);

        $this->router->dispatch($this->request);
    }
}
