<?php
class UsersEx extends Users
{
    /**
     * @param string $className
     * @return UsersEx
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}