<?php
/**
 * TextareaField.php
 * @author magoumi <agoumihunter@gmail.com>
 * Date : 11/30/2020
 * Time : 09:29
 */


namespace magoumi\phpmvc\form;


class TextareaField extends BaseField
{
	
	public function renderInput(): string
	{
		return sprintf('<textarea name="%s" class="form-control%s">%s</textarea>',
			$this->attribute,
			$this->model->hasError($this->attribute) ? ' is-invalid' : '',
			$this->model->{$this->attribute},
		);
	}
}