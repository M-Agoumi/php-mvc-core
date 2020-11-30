<?php
/**
 * Response.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/23/2020
 * Time : 14:59
 */


namespace magoumi\phpmvc;


class Response
{
	public function setStatusCode(int $code)
	{
		http_response_code($code);
	}
	
	public function redirect(string $url)
	{
		header('Location: '.$url);
	}
}