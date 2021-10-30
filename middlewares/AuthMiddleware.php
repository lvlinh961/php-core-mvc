<?php
namespace lvl\phpcoremvc\middlewares;

use lvl\phpcoremvc\Application;
use lvl\phpcoremvc\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
	public $actions = [];

	public function __construct($actions = [])
	{
		$this->actions = $actions;
	}

	public function execute()
	{
		if (Application::isGuest())
		{
			if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
				throw new ForbiddenException();
			}
		}
	}
}