<?php
namespace app\core;

use lvl\phpcoremvc\db\Database;

class Application
{

	public static $ROOT_DIR;
	public static $app;

	public $layout = 'main';
	public $userClass;
	public $router;
	public $request;
	public $response;
	public $session;
	public $view;
	public $db;
	public $user;

	public $controller;

	public function __construct($rootPath, $config)
	{
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;

		$this->userClass = $config['userClass'];
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->view = new View();
		$this->db = new Database($config['db']);
		$this->router = new Router($this->request, $this->response);

		$primaryValue = $this->session->get('user');
		if ($primaryValue) {
			$primaryKey = $this->userClass::primaryKey();
			$this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
		}
		else {
			$this->user = null;
		}
	}

	public function run()
	{
		try {
			echo $this->router->resolve();
		}
		catch(\Exception $e) {
			$this->response->setStatusCode($e->getCode());
			echo $this->view->renderView('_error', [
				'exception'	=> $e
			]);
		}
	}

	public function getController()
	{
		return $this->controller;
	}

	public function setController($controller)
	{
		$this->controller = $controller;
	}

	public function login(UserModel $user)
	{
		$this->user = $user;
		$primaryKey = $user->primaryKey();
		$primaryValue = $user->{$primaryKey};

		$this->session->set('user', $primaryValue);
		return true;
	}

	public function logout()
	{
		$this->user = null;
		$this->session->remove('user');
	}

	public static function isGuest()
	{
		return !self::$app->user;
	}
}