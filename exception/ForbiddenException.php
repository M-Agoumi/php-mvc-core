<?php
/**
 * ForbiddenException.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/26/2020
 * Time : 18:24
 */


namespace magoumi\phpmvc\exception;


class ForbiddenException extends \Exception
{
	protected $message = 'You don\'t have permission to access this page';
	protected $code = 403;
}