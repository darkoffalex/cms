<?php

class ControllerAdmin extends CController
{
    public $title = "Web Constructor";
    public $description = "";
    public $assets = "";

    /**
     * Override constructor
     * @param string $id
     * @param null $module
     */
    public function __construct($id,$module=null)
    {
        $this->layout = '/layouts/main';

        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');

        //get from URL request or use default
        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);

        parent::__construct($id,$module);
    }

    /**
     * Override before action method
     * @param CAction $action
     * @return bool|void
     */
    protected function beforeAction($action) {

        //publish assets
        $this->assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.design'));

        //enable foreign keys (for cascade operations in SQLITE)
        $con = Yii::app()->db->createCommand("PRAGMA foreign_keys = ON")->execute();

        //if current action - not login
        if($action->id != 'login' && Yii::app()->user->isGuest)
        {
            //redirect to login
            $this->redirect(Yii::app()->createUrl('/admin/main/login'));
        }

        return parent::beforeAction($action);
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
}