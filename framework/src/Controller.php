<?php

/**
 * Created by PhpStorm.
 * User: tianpeng
 * Date: 17/5/16
 * Time: 11:32 PM
 */
class Controller
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
}