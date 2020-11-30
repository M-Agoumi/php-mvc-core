<?php
/**
 * BaseMiddleware.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/26/2020
 * Time : 18:11
 */


namespace magoumi\phpmvc\middlewares;


abstract class BaseMiddleware
{
	abstract public function execute();
}