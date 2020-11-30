<?php
/**
 * controller.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/23/2020
 * Time : 16:12
 */


namespace app\core;


use app\core\middlewares\BaseMiddleware;

class controller
{
	public string $layout = 'main';
	public string $action = '';
	
	/**
	 * @var BaseMiddleware[]
	 */
	protected array $middlewares = [];
	
	public function setLayout(string $layout)
	{
		$this->layout = $layout;
	}
	
	public function render($view, $param = [])
	{
		return Application::$app->view->renderView($view, $param);
	}
	
	public function registerMiddleware(BaseMiddleware $middleware)
	{
		$this->middlewares[] = $middleware;
	}
	
	/**
	 * @return BaseMiddleware[]
	 */
	public function getMiddlewares(): array
	{
		return $this->middlewares;
	}
}