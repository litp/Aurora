<?php

class Request
{
	protected $method;
	protected $requestUri;
	protected $httpVersion;

	protected $headers;
	protected $body;
	protected $cookies;

	protected $GET;
	protected $POST;

	protected $serverInfo;

	public function __construct($method, $requestUri, $httpVersion, $headers = null, $body = null, $cookies = null, $GET = null, $POST = null, $serverInfo = null)
	{
		$this->method = $method;
		$this->requestUri = $requestUri;
		$this->httpVersion = $httpVersion;

		$this->headers = $headers;
		$this->body = $body;
		$this->cookies = $cookies;
		$this->GET = $GET;
		$this->POST = $POST;
		$this->serverInfo = $serverInfo;
	}

	public static function createFromEnvironments()
	{
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		$httpVersion = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';

        // Construct headers from envs
        $headers['Accept'] = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT']) : '';
        $headers['Accept-Charset'] = isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? $_SERVER['HTTP_ACCEPT_CHARSET'] : '';
        $headers['Accept-Encoding'] = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : '';
        $headers['Accept-Language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
        $headers['Host'] = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $headers['Connection'] = isset($_SERVER['HTTP_CONNECTION']) ? $_SERVER['HTTP_CONNECTION'] : '';
        $headers['Referer'] = isset($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '';
        $headers['User-Agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        
		$headers = new Headers($headers); 
		$body = file_get_contents('php://input');
		$cookies = $_COOKIE; //TODO: create a Cookie class to encapsulate $_COOKIE
		$GET = $_GET;
		$POST = $_POST;

        // Construct server info
        $serverInfo['ScriptName'] = isset($_SERVER['SCRIPT_NAME') ? $_SERVER['SCRIPT_NAME'] : '';
        $serverInfo = new ServerInfo($serverInfo);

		return new Request($method, $requestUri, $httpVersion, $headers, $body, $cookies, $GET, $POST, $serverInfo);
	}

	
}
