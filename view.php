<?php
/**
 * view.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/30/2020
 * Time : 08:36
 */


namespace magoumi\phpmvc;


class View
{
	public string $title = 'Site name';
	
	
	public function renderView($view, $params = [])
	{
		$viewContent    = $this->renderOnlyView($view, $params);
		$layoutContent  = $this->layoutContent($view);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}
	public function renderContent($viewContent)
	{
		$layoutContent  = $this->layoutContent($viewContent);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}
	
	protected function layoutContent($view)
	{
		$layout = Application::$app->layout;
		if (Application::$app->controller)
			$layout = Application::$app->controller->layout;
		ob_start();
		include_once Application::$ROOT_DIR. "/views/layout/" . $layout . ".php";
		return ob_get_clean();
	}
	protected function renderOnlyView($view, $params = [])
	{
		foreach ($params as $key => $value){
			$$key = $value;
		}
		ob_start();
		include_once Application::$ROOT_DIR."/views/$view.php";
		return ob_get_clean();
	}
}