<?php
namespace app\core\form;

use app\core\Model;

class TextareaField extends BaseField
{
	public const TYPE_TEXT 			= 'text';
	public const TYPE_PASSWORD 		= 'password';
	public const TYPE_NUMBER 		= 'number';

	public $type;
	
	public function __construct(Model $model, string $attribute)
	{
		$this->type = self::TYPE_TEXT;
		parent::__construct($model, $attribute);
	}

	public function passwordField()
	{
		$this->type = self::TYPE_PASSWORD;
		return $this;
	}

	public function renderInput()
	{
		return sprintf(
			'<textarea name="%s" class="form-control%s">%s</textarea>',
			$this->attribute, 
			$this->model->hasError($this->attribute) ? ' is-invalid':'',
			$this->model->{$this->attribute}
		);
	}
}