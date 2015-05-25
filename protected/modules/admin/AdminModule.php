<?php

class AdminModule extends CWebModule
{

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
            'admin.helpers.*',
            'admin.models.forms.*',
			'admin.components.*',
            'admin.helpers.*',
            'admin.widgets.*'
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

    public $menu = array(

        array(
            'url' => '#',
            'icon' => '',
            'html_class' => 'dashboard',
            'title' => 'Dashboard',
        ),

        array(
            'url' => '#',
            'icon' => '',
            'html_class' => 'dashboard',
            'title' => 'Site tree',
        ),

        array(
            'url' => '#',
            'icon' => '',
            'html_class' => 'widgets',
            'title' => 'Widgets',

            'sub' => array(
                array('controller' => 'menu', 'action' => 'list', 'title' => 'Menus', 'roles' => array(1), 'url' => '#'),
                array('controller' => 'widgets', 'action' => 'list', 'title' => 'Widgets', 'roles' =>  array(1), 'url' => '#')
            ),
        ),

    );
}
