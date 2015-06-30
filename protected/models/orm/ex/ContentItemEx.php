<?php
/**
 * Class ContentItemEx
 * @property TreeEx $tree
 * @property ContentItemFieldValueEx[] $contentItemFieldValues
 * @property ContentTypeEx $contentType
 * @property ContentItemTrl $trl
 */
class ContentItemEx extends ContentItem
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
     * @return ContentItemTrl
     */
    public function getOrCreateTrl($lng_id, $save = false)
    {
        $trl = ContentItemTrl::model()->findByAttributes(array('item_id' => $this->id,'lng_id' => $lng_id));

        if(empty($trl)){
            $trl = new ContentItemTrl();
            $trl -> lng_id = $lng_id;
            $trl -> item_id = $this->id;

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
        $rules[] = array('label, tree_id','required');
        return $rules;
    }

    /**
     * Returns value of block's dynamic field (by id)
     * @param $fieldId
     * @return FileOfValueEx[]|ImageOfValueEx[]|int|null|string
     */
    public function getDynamicFieldValueById($fieldId)
    {
        $value = null;

        if(!empty($this->contentType->contentItemFields))
        {
            foreach($this->contentType->contentItemFields as $field)
            {
                if($field->id == $fieldId){
                    $valueObj = $field->getValueFor($this->id);

                    switch($field->field_type_id){
                        case Constants::FIELD_TYPE_TEXT:
                            $value = $valueObj->text_value;
                            break;
                        case Constants::FIELD_TYPE_BOOLEAN:
                        case Constants::FIELD_TYPE_NUMERIC:
                        case Constants::FIELD_TYPE_PRICE:
                        case Constants::FIELD_TYPE_DATE:
                            $value = $valueObj->numeric_value;
                            break;
                        case Constants::FIELD_TYPE_TEXT_TRL:
                            $value = !empty($valueObj->trl->text) ? $valueObj->trl->text : '';
                            break;
                        case Constants::FIELD_TYPE_IMAGE:
                            $value = $valueObj->imageOfValues;
                            break;
                        case Constants::FIELD_TYPE_FILE:
                            $value = $valueObj->fileOfValues;
                            break;
                    }
                }
            }
        }

        return $value;
    }

    /**
     * Returns value of block's dynamic field (by field name)
     * @param $fieldName
     * @return FileOfValueEx[]|ImageOfValueEx[]|int|null|string
     */
    public function getDynamicFieldValue($fieldName)
    {
        $value = null;

        if(!empty($this->contentType->contentItemFields))
        {
            foreach($this->contentType->contentItemFields as $field)
            {
                if($field->field_name == $fieldName){
                    $valueObj = $field->getValueFor($this->id);

                    switch($field->field_type_id){
                        case Constants::FIELD_TYPE_TEXT:
                            $value = $valueObj->text_value;
                            break;
                        case Constants::FIELD_TYPE_BOOLEAN:
                        case Constants::FIELD_TYPE_NUMERIC:
                        case Constants::FIELD_TYPE_PRICE:
                        case Constants::FIELD_TYPE_DATE:
                            $value = $valueObj->numeric_value;
                            break;
                        case Constants::FIELD_TYPE_TEXT_TRL:
                            $value = !empty($valueObj->trl->text) ? $valueObj->trl->text : '';
                            break;
                        case Constants::FIELD_TYPE_IMAGE:
                            $value = $valueObj->imageOfValues;
                            break;
                        case Constants::FIELD_TYPE_FILE:
                            $value = $valueObj->fileOfValues;
                            break;
                    }
                }
            }
        }

        return $value;
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
        $relations['trl'] = array(self::HAS_ONE, 'ContentItemTrl', 'item_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}