<?php
/**
 * Class ContentTypeEx
 * @property ContentItemFieldEx[] $contentItemFields
 */
class ContentTypeEx extends ContentType
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
     * Array for drop-downs
     * @return array
     */
    public function listAllItemsForForms()
    {
        $result = array();
        $all = self::model()->findAll();

        foreach ($all as $type) {
            $result[$type->id] = $type->label;
        }

        return $result;
    }

    /**
     * Check if type contains translatable fields
     * @return bool
     */
    public function hasTranslatableFields()
    {
        foreach($this->contentItemFields as $field){
            if($field->field_type_id == Constants::FIELD_TYPE_TEXT_TRL){
                return true;
            }
        }

        return false;
    }

    /**
     * Append some new rules
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = array('label','required');
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

        //return modified relations
        return $relations;
    }
}