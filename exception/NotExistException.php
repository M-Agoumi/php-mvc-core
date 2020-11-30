<?php
/**
 * NotExistException.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/26/2020
 * Time : 18:50
 */


namespace magoumi\phpmvc\exception;


class NotExistException extends \Exception
{
	protected $message = 'This link is broken, either it got deleted or restricted, if you think this is an Error in our side please contact <a href="/contact">Us</a>';
	protected $code = 404;
}