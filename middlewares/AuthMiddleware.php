<?php
/**
 * AuthMiddleware.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/26/2020
 * Time : 18:15
 */


namespace app\core\middlewares;


use app\core\Application;
use app\core\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
	public array $action;
	
	public function __construct(array $action = [])
	{
		$this->action = $action;
	}
	
	public function execute()
	{
		if (Application::isGuest()) {
			if (empty($this->action) || in_array(Application::$app->controller->action, $this->action)) {
				throw new ForbiddenException();
			}
		}
	}
}