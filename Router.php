<?php
namespace lvl\phpcoremvc;

use lvl\phpcoremvc\exception\NotFoundException;

class Router
{
	protected $routes = [];
	public $request;
	public $response;

	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback;
	}

	public function post($path, $callback)
	{
		$this->routes['post'][$path] = $callback;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->method();
		$callback = $this->routes[$method][$path] ?? false;

		if ($callback === false) {
			throw new NotFoundException();
		}

		if (is_string($callback)) {
			return Application::$app->view->renderView($callback);
		}

		if (is_array($callback)) {
			/** @var \lvl\phpcoremvc\Controller $controller */
			$controller = new $callback[0]();
			$controller->action = $callback[1];
			Application::$app->controller = $controller;

			foreach ($controller->getMiddlewares() as $middleware) {
				$middleware->execute();
			}

			$callback[0] = new $callback[0]();
		}

		echo call_user_func($callback, $this->request, $this->response);
	}
}