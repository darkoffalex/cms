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

    /**
     * Returns main menu
     * @return array
     */
    public static function menu()
    {
        return array(

            array(
                'url' => Yii::app()->createUrl('admin/statistics/index'),
                'icon' => '',
                'html_class' => 'icon dashboard',
                'title' => 'Statistics',
            ),

            array(
                'url' => Yii::app()->createUrl('admin/categories/index'),
                'icon' => '',
                'html_class' => 'icon pages',
                'title' => 'Content',

                'sub' => array(
                    array('title' => 'Categories', 'url' => Yii::app()->createUrl('admin/categories/index')),
                    array('title' => 'Blocks', 'url' => Yii::app()->createUrl('admin/blocks/list')),
                    array('title' => 'Types', 'url' => Yii::app()->createUrl('admin/types/list')),
                ),
            ),

            array(
                'url' => Yii::app()->createUrl('admin/widgets/index'),
                'icon' => '',
                'html_class' => 'icon edit-menu',
                'title' => 'Widgets',

                'sub' => array(
                    array('title' => 'Widgets', 'url' => Yii::app()->createUrl('admin/widgets/index')),
                    array('title' => 'Positions', 'url' => Yii::app()->createUrl('admin/widgets/positions')),
                    array('title' => 'Registration', 'url' => Yii::app()->createUrl('admin/widgets/registration'))
                ),
            ),

            array(
                'url' => Yii::app()->createUrl('admin/languages/index'),
                'icon' => '',
                'html_class' => 'icon translate',
                'title' => 'Languages',

                'sub' => array(
                    array('title' => 'Language list', 'url' => Yii::app()->createUrl('admin/languages/index')),
                    array('title' => 'Translations', 'url' => Yii::app()->createUrl('admin/translations/index')),
                ),
            ),

            array(
                'url' => Yii::app()->createUrl('admin/store/orders'),
                'icon' => '',
                'html_class' => 'icon products',
                'title' => 'Store',

                'sub' => array(
                    array('title' => 'Orders', 'url' => Yii::app()->createUrl('admin/store/orders')),
                    array('title' => 'Settings', 'url' => Yii::app()->createUrl('admin/store/settings'))
                ),
            ),

            array(
                'url' => Yii::app()->createUrl('admin/users/index'),
                'icon' => '',
                'html_class' => 'icon user',
                'title' => 'Users area',

                'sub' => array(
                    array('title' => 'User list', 'url' => Yii::app()->createUrl('admin/users/list')),
                    array('title' => 'Roles', 'url' => Yii::app()->createUrl('admin/users/roles')),
                    array('title' => 'Comments', 'url' => Yii::app()->createUrl('admin/users/comments')),
                    array('title' => 'Subscription', 'url' => Yii::app()->createUrl('admin/users/subscription'))
                ),
            ),

            array(
                'url' => Yii::app()->createUrl('admin/settings/index'),
                'icon' => '',
                'html_class' => 'icon settings',
                'title' => 'Settings',
            ),

        );
    }

    /**
     * Returns language menu
     * @return array
     */
    public static function languages()
    {
        $currentUrl = Yii::app()->request->url;
        $lng = Yii::app()->language;

        $menu = array(
            'en' => array(
                'title' => 'EN',
                'class' => '',
                'icon' => '',
                'url' => '#'
            ),

            'ru' => array(
                'title' => 'РУ',
                'class' => '',
                'icon' => '',
                'url' => '#'
            )
        );

        foreach($menu as $prefix => $arr)
        {
            $resultUrl = str_replace('/'.$lng.'/','/'.$prefix.'/',$currentUrl);
            $menu[$prefix]['url'] = $resultUrl;
        }

        return $menu;
    }

}
