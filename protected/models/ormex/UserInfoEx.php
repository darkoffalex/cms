<?php
class UserInfoEx extends UserInfo
{
    /**
     * @param string $className
     * @return UserInfoEx
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}