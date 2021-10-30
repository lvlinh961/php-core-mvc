<?php
namespace lvl\phpcoremvc;

class Response
{
	public function setStatusCode($code)
	{
		http_response_code($code);
	}

	public function redirect($string)
	{
		header('Location: ' . $string);
	}
}