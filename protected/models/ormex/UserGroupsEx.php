<?php
class UserGroupsEx extends UserGroups
{
    /**
     * @param string $className
     * @return UserGroupsEx
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}