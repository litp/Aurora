<?php
class Router
{
    protected $directRouterTable = array();
    protected $rootDirectory = '';  //unused yet!!
    protected $controllerInstance;
    
    public function __construct($routerTable = array())
    {
        $this->directRouterTable = $this->escapeRouterTable($routerTable);
    }

    public function escapeRouterTable($routerTable)
    {
        $escapedRouterTable = array();

        foreach ($routerTable as $regex => $function) {
            $escapedRouterTable['/' . addcslashes($regex, "\'\"\\\/") . '/'] = $function;
        }

        return $escapedRouterTable;
    }

    // return query path starting with '/' and without the last '/'
    public function getQueryPath($request)
    {
        if (isset($request) && 
            isset($request->serverInfo->scriptName) &&
            isset($request->requestUri)) {
            
            $queryPath = str_replace($request->serverInfo->scriptName, '', $request->requestUri);

            return empty($queryPath) ? '/' : $queryPath;

        } else {
            return '/';
        }
    }

    public function dispatch($request = null)
    {
        $queryPath = $this->getQueryPath($request);

        foreach ($this->directRouterTable as $uri => $function) {
            if (preg_match($uri, $queryPath, $matches)) {
                $parameterPath = str_replace($matches[0],'',$queryPath);
                if ($parameterPath == '') {
                    $parameters = null;
                } else {
                    $parameters = explode('/',rtrim($parameterPath, '/'));
                    array_shift($parameters);
                }

                return call_user_func($function,$parameters);
            }
        }
    }
}
