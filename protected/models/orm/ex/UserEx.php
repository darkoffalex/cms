<?php
/**
 * Class UserEx
 * @property RoleEx $role
 * @property CUploadedFile $avatar
 * @property CUploadedFile $photo
 */
class UserEx extends User
{
    /*
     * Avatar and photo
     */
    public $avatar = null;
    public $photo = null;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Searches user's by query string
     * @param $search
     * @return UserEx[]
     */
    public function searchByString($search)
    {
        $sql = "SELECT * FROM ".$this->tableName()." WHERE login LIKE '%".$search."%' OR email LIKE '%".$search."%' OR name LIKE '%".$search."%' OR surname LIKE '%".$search."%' OR id = '".$search."'";
        $all = self::model()->findAllBySql($sql);
        return $all;
    }

    public function avatarUrl()
    {
        return Yii::app()->getHomeUrl().'uploads/avatars/'.$this->avatar_filename;
    }

    public function photoUrl()
    {
        return Yii::app()->getHomeUrl().'uploads/avatars/'.$this->photo_filename;
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
     * Override for file validation
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules[] = array('avatar', 'file', 'types'=>Constants::UPLOAD_VALIDATE_IMAGE_TYPES, 'allowEmpty' => true, 'maxSize' => 300000);
        $rules[] = array('photo', 'file', 'types'=>Constants::UPLOAD_VALIDATE_IMAGE_TYPES, 'allowEmpty' => true, 'maxSize' => 1500000);

        //email validation
        $rules[] = array('email', 'email');

        //login must be unique (ignoring this item while updating)
        $rules[] = array('login', 'unique', 'caseSensitive' => true);

        //if we create new user - password is necessary
        if($this->isNewRecord){
            $rules[] = array('password', 'required');
        }

        return $rules;
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

        //return modified relations
        return $relations;
    }
}