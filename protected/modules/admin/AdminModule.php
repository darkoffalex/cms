<?php

class AdminModule extends CWebModule
{
    /**
     * Structure of admin-menu
     * @var array
     */

    public $menu = array(

        'main' => array('title' => 'Main', 'actions' => array(
            'index' => array('title' => 'Information', 'html_id' => '', 'html_class' => '', 'html_style' => '', 'icon' => ''),
            'logout' => array('title' => 'Exit', 'html_id' => '', 'html_class' => '', 'html_style' => '', 'icon' => ''),
            'tree' => array('title' => 'Tree', 'html_id' => '', 'html_class' => '', 'html_style' => '', 'icon' => '')
        )),
    );

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
            'admin.models.forms.*',
            'admin.models.orm.*',
            'admin.models.ormex.*',
			'admin.components.*',
            'admin.helpers.*'
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
