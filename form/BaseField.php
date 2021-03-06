<?php
/**
 * BaseField.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/30/2020
 * Time : 09:19
 */


namespace magoumi\phpmvc\form;


use magoumi\phpmvc\Model;

abstract class BaseField
{
	public const TYPE_TEXT = 'text';
	public const TYPE_PASSWORD = 'password';
	public const TYPE_EMAIL = 'email';
	public string $type;
	public Model $model;
	public string $attribute;
	
	public function __construct(Model $model, string  $attribute)
	{
		$this->model = $model;
		$this->attribute = $attribute;
	}
	
	
	abstract public function renderInput() : string;
	
	
	
	public function __toString()
	{
		return sprintf('
			<div class="form-group">
				<label>%s</label>
				%s
				<div class="invalid-feedback">
					%s
				</div>
			</div>
			',
			$this->model->getLabel($this->attribute),
			$this->renderInput(),
			$this->model->getFirstError($this->attribute)
		);
	}
}