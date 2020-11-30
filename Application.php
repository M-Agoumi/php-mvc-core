<?php

namespace magoumi\phpmvc;

use magoumi\phpmvc\db\Database;
use magoumi\phpmvc\db\DbModel;

class Application
{
	public static string $ROOT_DIR;
	
	public string $layout = 'main';
	public string $userClass;
	public Router $router;
	public Request $request;
	public Response $response;
	public Session $session;
	public Database $db;
	public ?UserModel $user;
	public View $view;
	
	public static Application $app;
	public ?Controller $controller = NULL;
	
	public function __construct($rootPath, array $config)
	{
		$this->userClass = $config['userClass'];
		self::$ROOT_DIR = $rootPath;
		self::$app = $this;
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->router = new Router($this->request, $this->response);
		$this->view = new View();
		
		$this->db = new Database($config['db']);
		
		$primaryValue = $this->session->get('user');
		if ($primaryValue) {
			$primaryKey = $this->userClass::primaryKey();
			$this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
		} else {
			$this->user = null;
		}
	}
	
	public function run()
	{
		try {
			echo $this->router->resolver();
		} catch (\Exception $e) {
			$this->response->setStatusCode($e->getCode());
			echo $this->view->renderView('_error', [
				'exception' => $e
			]);
		}
	}
	
	/**
	 * @return Controller
	 */
	public function getController(): Controller
	{
		return $this->controller;
	}
	
	/**
	 * @param Controller $controller
	 */
	public function setController(Controller $controller): void
	{
		$this->controller = $controller;
	}
	
	public function login(UserModel $user)
	{
		$this->user = $user;
		$primaryKey = $user->primaryKey();
		$primaryValue = $user->{$primaryKey};
		$this->session->set('user', $primaryValue);
		return TRUE;
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