<?php
/**
 * Class RoleEx
 * @property RoleTrl $trl
 * @property User[] $users
 */
class RoleEx extends Role
{
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    /**
     * List all items for form's drop-downs
     * @param bool $translate
     * @param bool $limit_permissions
     * @return array
     */
    public function listAllItemsForForms($translate = true, $limit_permissions = true)
    {
        $list = array();
        $all = self::model()->findAll();

        //if permissions should be limited
        if($limit_permissions){
            foreach($all as $role){
                //add roles for choosing only if they have weaker permission than current user's
                if($role->permission_level > CurUser::get()->permissionLvl()){
                    $list[$role->id] = $translate ? __a($role->label) : $role->label;
                }
            }
        }
        //if should show all roles
        else{
            foreach($all as $role){
                $list[$role->id] = $translate ? __a($role->label) : $role->label;
            }
        }

        return $list;
    }

    /**
     * Override to translate all labels
     * @return array
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        foreach($labels as $label => $value)
        {
            $labels[$label] = __a($value);
        }

        return $labels;
    }

    /**
     * Override, relate with extended models
     * @return array relational rules.
     */
    public function relations()
    {
        //get all relations from base class
        $relations = parent::relations();

        //pass through all
        foreach($relations as $name => $relation)
        {
            //if found extended file for this related class
            if(file_exists(dirname(__FILE__).DS.$relation[1].'Ex.php'))
            {
                $relations[$name][1] = $relation[1].'Ex';
            }
        }

        //relate with translation
        $lng = Yii::app()->language;
        $relations['trl'] = array(self::HAS_ONE, 'RoleTrl', 'role_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}