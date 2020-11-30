<?php

namespace app\core;
use app\core\exception\NotExistException;

/**
 * Class Router
 *
 * @author Mohamed Agoumi <agoumihunter@gmail.com>
 * @package app\core
 */
class Router
{
	public Request $request;
	public Response $response;
	protected array $routes = [];
	
	/**
	 * Router constructor.
	 * @param Request $request
	 * @param Response $response
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response= $response;
	}
	
	
	public function get($path, $callback)
	{
		$this->routes['get'][$path] = $callback;
	}
	
	public function post($path, $callback)
	{
		$this->routes['post'][$path] = $callback;
	}
	
	public function resolver()
	{
		$path       = $this->request->getPath();
		$method     = $this->request->method();
		$callback   = $this->routes[$method][$path] ?? false;
		if ($callback === false){
			throw new NotExistException();
		}
		if (is_string($callback)){
			return Application::$app->view->renderView($callback);
		}
		if (is_array($callback)){
			/** @var \app\core\controller $controller */
			$controller = new $callback[0]();
			Application::$app->controller = $controller;
			$controller->action = $callback[1];
			$callback[0] = $controller;
			foreach ($controller->getMiddlewares() as $middleware) {
				$middleware->execute();
			}
		}
		return call_user_func($callback, $this->request, $this->response);
	}
}