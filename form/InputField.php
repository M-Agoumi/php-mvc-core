<?php
/**
 * Field.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/24/2020
 * Time : 12:25
 */


namespace app\core\form;


use app\core\Model;

class InputField extends BaseField
{
	public const TYPE_TEXT = 'text';
	public const TYPE_PASSWORD = 'password';
	public const TYPE_EMAIL = 'email';
	public string $type;

	public function __construct(Model $model, string  $attribute)
	{
		$this->type = self::TYPE_TEXT;
		parent::__construct($model, $attribute);
	}
	
	public function passwordField()
	{
		$this->type = self::TYPE_PASSWORD;
		return $this;
	}
	
	public function emailField()
	{
		$this->type = self::TYPE_EMAIL;
		return $this;
	}
	
	public function renderInput(): string
	{
		return sprintf('<input type="%s" name="%s" value="%s" class="form-control %s">',
			$this->type,
			$this->attribute,
			$this->model->{$this->attribute},
			$this->model->hasError($this->attribute) ? ' is-invalid' : '',
		);
	}
}