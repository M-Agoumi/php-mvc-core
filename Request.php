<?php

namespace magoumi\phpmvc;
/**
 * @author  magoumi <agoumihunter@gmail.com>
 * @package magoumi\phpmvc
 */
class Request
{
	public function getPath()
	{
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');
		if ($position === FALSE)
			return $path;
		return substr($path, 0, $position);
	}
	
	public function method()
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}
	
	public function isGet()
	{
		return $this->method() === 'get';
	}
	
	public function isPost()
	{
		return $this->method() === 'post';
	}
	
	public function getBody()
	{
		$body = []; // TODO: something is wrong with this i guess fix it you asshole
		if ($this->method() === 'get') {
			foreach ($_GET as $key => $value) {
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		if ($this->method() === 'post') {
			foreach ($_POST as $key => $value) {
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $body;
	}
}