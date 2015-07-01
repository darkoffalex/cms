<?php
/**
 * Class ContentItemFieldEx
 * @property ContentTypeEx $contentType
 * @property ContentItemFieldTrl $trl
 * @property ContentItemFieldValueEx[] $contentItemFieldValues
 */
class ContentItemFieldEx extends ContentItemField
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
     * Returns value object for specified content item
     * @param $item_id
     * @return ContentItemFieldValueEx
     */
    public function getValueFor($item_id)
    {
        $values = $this->contentItemFieldValues;

        foreach ($values as $valueObj) {
            if($valueObj->content_item_id == $item_id){
                return $valueObj;
            }
        }

        $valueObj = new ContentItemFieldValueEx();
        $valueObj->content_item_id = $item_id;
        $valueObj->field_id = $this->id;
        return $valueObj;
    }

    /**
     * Finds or creates Trl of this item
     * @param $lng_id
     * @param bool $save
     * @return ContentItemFieldTrl
     */
    public function getOrCreateTrl($lng_id, $save = false)
    {
        $trl = ContentItemFieldTrl::model()->findByAttributes(array('field_id' => $this->id,'lng_id' => $lng_id));

        if(empty($trl)){
            $trl = new ContentItemFieldTrl();
            $trl -> lng_id = $lng_id;
            $trl -> field_id = $this->id;

            if($save){
                $trl->save();
            }
        }

        return $trl;
    }

    /**
     * Append some new rules
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = array('label, field_name','required');
        return $rules;
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
        $relations['trl'] = array(self::HAS_ONE, 'ContentItemFieldTrl', 'field_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}