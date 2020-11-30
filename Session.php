<?php
/**
 * Session.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/24/2020
 * Time : 20:49
 */


namespace magoumi\phpmvc;


class Session
{
	protected const FLASH_KEY = 'flash_messages';
	
	public function __construct()
	{
		session_start();
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMessages as $key => &$flashMessage) {
			// mark to be removed
			$flashMessage['remove'] = true;
		}
		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}
	
	public function setFlash($key, $message)
	{
		$_SESSION[self::FLASH_KEY][$key] = [
			'remove' => false,
			'value' => $message
		];
	}
	
	public function getFlash($key)
	{
		return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
	}
	
	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	public function get($key)
	{
		return $_SESSION[$key] ?? false;
	}
	
	public function remove($key)
	{
		unset($_SESSION[$key]);
	}
	
	public function __destruct()
	{
		// Iterate over marked to be removed
		$flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
		foreach ($flashMessages as $key => &$flashMessage) {
			// mark to be removed
			if ($flashMessage['remove']) {
				unset($flashMessages[$key]);
			}
		}
		$_SESSION[self::FLASH_KEY] = $flashMessages;
	}
}