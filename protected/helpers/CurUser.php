<?php
/**
 * Class CurUser
 * @property UserEx $userDB
 */
class CurUser
{
    protected static $_instance;
    private $userDB = null;

    private function __clone(){}

    private function __construct()
    {
        $this->userDB = UserEx::model()->findByPk((int)Yii::app()->getUser()->id);
    }

    /**
     * Returns instance
     * @return CurUser
     */
    public static function get()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Current role ID
     * @return int|null
     */
    public function roleId()
    {
        return !empty($this->userDB) ? $this->userDB->role_id : null;
    }

    /**
     * Current permission level (lower - stronger)
     * @return int|null
     */
    public function permissionLvl()
    {
        return !empty($this->userDB->role) ? (int)$this->userDB->role->permission_level : null;
    }

    /**
     * Current's user object from db
     * @return null|UserEx
     */
    public function userObj()
    {
        return !empty($this->userDB) ? $this->userDB : null;
    }
}