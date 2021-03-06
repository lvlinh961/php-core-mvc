<?php
namespace lvl\phpcoremvc\form;

use lvl\phpcoremvc\Model;


abstract class BaseField
{
	public $model;
	public $attribute;

	public function __construct(Model $model, string $attribute)
	{
		$this->model = $model;
		$this->attribute = $attribute;
	}

	abstract public function renderInput();

	public function __toString()
	{
		return sprintf(
			'
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