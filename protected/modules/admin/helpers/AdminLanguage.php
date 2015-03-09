<?php

class AdminLanguage
{
    protected static $_instance; //instance
    public $lng; //language prefix

    /**
     * Singleton - get instance
     * @return AdminLanguage
     */
    public static function getInstance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Sets admin language (also to cookies ad user's state)
     * @param $language
     */
    public function set($language)
    {
        $objUser = Yii::app()->user;
        $request = Yii::app()->request;

        $this->lng = $language;
        $objUser->setState('admin_language', $language);
        $request->cookies['admin_language'] = new CHttpCookie('a_lng', $language);
        $this->lng = $language;
    }

    /**
     * Init object - set admin language
     */
    private function __construct()
    {
        //set language by default
        $this->lng = Yii::app()->params['defaultAdminLanguage'];

        $objUser = Yii::app()->user;
        $request = Yii::app()->request;

        //if set in state
        if ($objUser->hasState('admin_language')) {
            $this->lng = $objUser->getState('admin_language');
        }

        //if set in cookies
        elseif (isset($request->cookies['admin_language'])) {
            $this->lng = $request->cookies['admin_language']->value;
        }
    }


}