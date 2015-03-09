<?php

class AdminLanguage
{
    protected static $_instance; //instance
    private $lng; //language prefix

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
     * Returns current admin language (already set in cookies or user's state)
     * @return mixed|string
     */
    public function get()
    {
        $objUser = Yii::app()->user;
        $request = Yii::app()->request;

        //if set in state
        if ($objUser->hasState('admin_language')) {
            return $objUser->getState('admin_language');
        }

        //if set in cookies
        elseif (isset($request->cookies['admin_language'])) {
            return $request->cookies['admin_language']->value;
        }

        return $this->lng;
    }

    /**
     * Sets admin language to cookies ad user's state
     * @param $language
     */
    public function set($language)
    {
        $objUser = Yii::app()->user;
        $request = Yii::app()->request;

        $this->lng = $language;
        $objUser->setState('admin_language', $language);
        $request->cookies['admin_language'] = new CHttpCookie('a_lng', $language);

        if ($objUser->hasState('admin_language')) {
            $this->lng = $objUser->getState('admin_language');
        }
        elseif (isset($request->cookies['admin_language'])) {
            $this->lng = $request->cookies['admin_language']->value;
        }
    }

    /**
     * Init object - set admin language
     */
    private function __construct()
    {
        //set language by default
        $this->lng = Yii::app()->params['defaultAdminLanguage'];
    }


}