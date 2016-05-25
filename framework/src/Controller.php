<?php

namespace Litp\Aurora;

class Controller
{
    protected $request;
    protected $application;

    public function __construct($application, $request)
    {
        $this->request = $request;
        $this->application = $application;
    }
}