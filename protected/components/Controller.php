<?php

class Controller extends CController
{
	public $layout='//layouts/main';

    public $title = "";
    public $keywords = "";
    public $description = "";

    public $themeName = "";

    /**
     * @var GlobalSettingsEx
     */
    public $global_settings = null;

    /**
     * Perform before every action
     * @param CAction $action
     * @return bool
     */
    protected function beforeAction($action)
    {
        //get global settings
        $this->global_settings = GlobalSettingsEx::model()->find();

        //get theme
        Yii::app()->theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;

        //get theme name
        $this->themeName = !empty(Yii::app()->theme->name) ? Yii::app()->theme->name : '';

        //initialize dynamic widgets
        DynamicWidget::getInstance()->initialize($this,$this->themeName);

        //handle filtration requests
        $this->preSetFiltration();

        //before action - parent call
        return parent::beforeAction($action);
    }

    /**
     * Constructor override
     * @param string $id
     * @param null $module
     */
    public function __construct($id,$module=null)
    {
        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');

        //get from URL request or use default
        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);

        parent::__construct($id,$module);
    }

    /**
     * Setup the language
     * @param $lng
     */
    public function setLanguage($lng)
    {
        $objUser = Yii::app()->user;
        $request = Yii::app()->request;

        Yii::app()->language = $lng;
        $objUser->setState('language', $lng);
        $request->cookies['language'] = new CHttpCookie('lng', $lng);

        if ($objUser->hasState('language')) {
            Yii::app()->language = $objUser->getState('language');
        }
        elseif (isset($request->cookies['language'])) {
            Yii::app()->language = $request->cookies['language']->value;
        }
    }

    /**
     * If got filtration request from form - set it to session
     */
    public function preSetFiltration()
    {
        $params = Yii::app()->getRequest()->getParam(ContentItemFieldEx::FILTER_FIELDS_GROUP);

        if(!empty($params)){

            Yii::app()->session['filtration'] = $params;

            if(isset($params['clean'])){
                unset(Yii::app()->session['filtration']);
            }
        }
    }
}