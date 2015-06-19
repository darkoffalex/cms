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
     * Finds or creates Trl of this item
     * @param $lng_id
     * @param bool $save
     * @return ContentItemFieldValueTrl
     */
    public function getOrCreateTrl($lng_id, $save = false)
    {
        if(!$this->isNewRecord)
        {
            $trl = ContentItemFieldValueTrl::model()->findByAttributes(array('value_id' => $this->id,'lng_id' => $lng_id));

            if(empty($trl)){
                $trl = new ContentItemFieldValueTrl();
                $trl -> lng_id = $lng_id;
                $trl -> value_id = $this->id;

                if($save){
                    $trl->save();
                }
            }

            return $trl;
        }

        return new ContentItemFieldValueTrl();
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