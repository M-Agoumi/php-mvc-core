<?php

namespace magoumi\phpmvc;

use magoumi\phpmvc\db\Database;
use magoumi\phpmvc\db\DbModel;

class Application
{
	const EVEN_BEFORE_REQUEST = 'beforeRequest';
	const EVEN_AFTER_REQUEST = 'afterRequest';
	
	protected array $eventListners = [];
	
	public static Application $app;
	public static string $ROOT_DIR;
	public string $userClass;
	public string $layout = 'main';
	public Router $router;
	public Request $request;
	public Response $response;
	public Session $session;
	public Database $db;
	public ?UserModel $user;
	public View $view;
	
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
			$this->user = NULL;
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
		$this->user = NULL;
		$this->session->remove('user');
	}
	
	public static function isGuest()
	{
		return !self::$app->user;
	}
	
	public function on($eventName, $callback)
	{
		$this->eventListners[$eventName][] = $callback;
	}
	
	public function triggerEvent($eventName)
	{
		$callbacks = $this->eventListners[$eventName] ?? [];
		foreach ($callbacks as $callback) {
			call_user_func($callback);
		}
	}
	
	public function run()
	{
		$this->triggerEvent(self::EVEN_BEFORE_REQUEST);
		try {
			echo $this->router->resolver();
		} catch (\Exception $e) {
			$this->response->setStatusCode($e->getCode());
			echo $this->view->renderView('_error', [
				'exception' => $e
			]);
		}
	}
}