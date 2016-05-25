<?php

use Litp\Aurora\Controller;

class TestController extends Controller
{
    public function test($parameter = 'default')
    {
        echo 'request ' . $this->request->requestUri . ' with arguments ' . $parameter . "\n";
    }
}