<?php
/**
 * Class ContentItemFieldValueEx
 * @property ContentItemEx $contentItem
 * @property ContentItemFieldEx $field
 * @property ContentItemFieldValueTrl $trl
 * @property FileOfValueEx[] $fileOfValues
 * @property ImageOfValueEx[] $imageOfValues
 */
class ContentItemFieldValueEx extends ContentItemFieldValue
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
        $relations['trl'] = array(self::HAS_ONE, 'ContentItemFieldValueTrl', 'value_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}