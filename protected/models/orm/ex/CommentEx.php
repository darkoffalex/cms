<?php
/**
 * Class CommentEx
 * @property UserEx $user
 * @property ContentItemEx $contentItem
 */
class CommentEx extends Comment
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
     * Finds all comments and filters it if needed
     * @param null $user_id
     * @param null $commentator_ip
     * @param null $content_item_id
     * @return CommentEx[]
     */
    public function findAllFiltered($user_id = null, $commentator_ip = null, $content_item_id = null)
    {
        /* @var $result self[] */

        $result = self::model()->findAll();

        //if specified user id - filter by it
        if(!empty($user_id)){
            foreach($result as $index => $comment){
                if($comment->user_id != $user_id){
                    unset($result[$index]);
                }
            }
        }

        //if specified commentator ip - filter by it
        if(!empty($commentator_ip)){
            foreach($result as $index => $comment){
                if($comment->user_ip != $commentator_ip){
                    unset($result[$index]);
                }
            }
        }

        //if specified content item id - filter by it
        if(!empty($commentator_ip)){
            foreach($result as $index => $comment){
                if($comment->content_item_id != $content_item_id){
                    unset($result[$index]);
                }
            }
        }

        return $result;
    }

    /**
     * Returns commentator username
     * @return string
     */
    public function getCommentatorUsername()
    {
        return !empty($this->user) ? $this->user->login : __a('Guest');
    }

    /**
     * Returns permission level of commentator
     * @return int
     */
    public function permissionLevel()
    {
        return !empty($this->user) ? $this->user->role->permission_level : PHP_INT_MAX;
    }

    /**
     * Finds all comments and filters it if needed (another implementation)
     * @param null $user_id
     * @param null $commentator_ip
     * @param null $content_item_id
     * @return CommentEx[]
     */
    public function findAllFilteredEx($user_id = null, $commentator_ip = null, $content_item_id = null)
    {
        $conditions = array();
        if(!empty($user_id)){
            $conditions['user_id'] = $user_id;
        }

        if(!empty($commentator_ip)){
            $conditions['user_ip'] = $commentator_ip;
        }

        if(!empty($content_item_id)){
            $conditions['content_item_id'] = $content_item_id;
        }

        $result = !empty($conditions) ? self::model()->findAllByAttributes($conditions,array('order' => 'created_time ASC')) : self::model()->findAll(array('order' => 'created_time ASC'));

        return $result;
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

        //return modified relations
        return $relations;
    }
}