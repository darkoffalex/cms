<?php

class ControllerAdmin extends CController
{

    /**
     * Access rules for every action in every controller for system groups (system groups - not editable, and can be
     * edited only by developer)
     * @var array
     */
    public $accessRulesForSysGroups = array(

        'main' => array(
            'index' => array(Constants::GROUP_ADMIN,Constants::GROUP_ROOT),
            'logout' => array(Constants::GROUP_ADMIN,Constants::GROUP_ROOT, Constants::GROUP_USER),
            'login' => array(Constants::GROUP_ADMIN,Constants::GROUP_ROOT, Constants::GROUP_USER)
        ),
    );

    public $title = "D.W.CMS";
    public $description = "Panel";
    public $version = "2.0";

    /**
     * Check if user allowed to admin's module controllers and actions
     * @param CWebUser $user
     * @param string $controller
     * @param string $action
     * @return bool
     */
    public function isUserAllowed($user,$controller,$action)
    {
        /* @var $user CWebUser */
        /* @var $dbUser UsersEx */

        if(!$user->isGuest)
        {
            //get user from db
            $dbUser = UsersEx::model()->findByPk($user->getState('id'));

            //if user's group - system group
            if($dbUser->group->system == 1)
            {
                //return true if user's group is allowed
                return in_array($dbUser->group_id,$this->accessRulesForSysGroups[$controller][$action]);
            }
            //if user's group - not system group (for example added through admin-panel)
            else
            {
                /*TODO : implement there access checking for dynamically managed groups */
                return false;
            }
        }

        return false;

    }

    /**
     * Override constructor
     * @param string $id
     * @param null $module
     */
    public function __construct($id,$module=null)
    {
        $this->layout = '/layouts/main';
        parent::__construct($id,$module);
    }

    /**
     * Override before action method
     * @param CAction $action
     * @return bool|void
     */
    protected function beforeAction($action) {

        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultAdminLanguage']);
        AdminLanguage::getInstance()->set($language);

        //if current action - not login
        if($action->id != 'login')
        {
            //if user not allowed to this controller and action
            if(!$this->isUserAllowed(Yii::app()->user,Yii::app()->controller->id,$action->id))
            {
                //redirect to login
                $this->redirect(Yii::app()->urlManager->createAdminUrl('/admin/main/login'));
            }
        }

        return parent::beforeAction($action);
    }
}