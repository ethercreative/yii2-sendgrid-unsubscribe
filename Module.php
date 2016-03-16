<?php

namespace ethercreative\unsubscribe;

use Yii;

class Module extends \yii\base\Module
{
	public
		$default,
		$groups = [],
		$flashMessage,
		$flashGroup,
		$redirect,
		$key;

	public $defaultRoute = 'unsubscribe';
	
	public function init()
	{
		parent::init();

		$this->params['default'] = $this->default;
		$this->params['groups'] = $this->groups;
		$this->params['flashMessage'] = $this->flashMessage;
		$this->params['flashGroup'] = $this->flashGroup;
		$this->params['redirect'] = $this->redirect;
		$this->params['key'] = $this->key;
	}
}
