<?php
namespace lvl\phpcoremvc\exception;

class NotFoundException extends \Exception
{
	protected $message = 'Not Found!';
	protected $code = 404;
}