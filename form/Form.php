<?php
/**
 * Form.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/24/2020
 * Time : 12:25
 */


namespace app\core\form;


use app\core\Model;

class Form
{
	public static function begin($action = '', $method = 'POST')
	{
		echo "<form action='{$action}' method='{$method}'>";
		return new Form();
	}
	
	public static function end()
	{
		echo "</form>";
	}
	
	public function field(Model $model, $attribute)
	{
		return new InputField($model, $attribute);
	}
}