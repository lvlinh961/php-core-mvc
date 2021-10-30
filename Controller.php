<?php
namespace app\core;

class Controller
{
	public $layout = 'main';
	public $action = '';

	/**
	 * @var \lvl\phpcoremvc\middlewares\BaseMiddleware[]
	*/
	protected $middlewares = [];

	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	public function render($view, $params=[])
	{
		return Application::$app->view->renderView($view, $params);
	}

	public function registerMiddleware($middleware)
	{
		$this->middlewares[] = $middleware;
	}

	public function getMiddlewares()
	{
		return $this->middlewares;
	}
}