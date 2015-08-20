<?php
/**
 * Class ContentTypeEx
 * @property ContentItemFieldEx[] $contentItemFields
 * @property WidgetEx[] $widgets
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
     * @param string $emptyElement
     * @return array
     */
    public function listAllItemsForForms($emptyElement = null)
    {
        $result = array();
        $all = self::model()->findAll();

        if(!empty($emptyElement)){
            $result[''] = $emptyElement;
        }

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
     * Returns filterable fields (which can be used in filter conditions)
     * @param bool|false $extended
     * @return ContentItemFieldEx[]
     */
    public function getFilterableFields($extended = false)
    {
        $result = array();

        $filterableFieldTypes = array(
            Constants::FIELD_TYPE_BOOLEAN,
            Constants::FIELD_TYPE_PRICE,
            Constants::FIELD_TYPE_DATE,
            Constants::FIELD_TYPE_NUMERIC,
        );

        if($extended){
            $filterableFieldTypes[] = Constants::FIELD_TYPE_TEXT;
            $filterableFieldTypes[] = Constants::FIELD_TYPE_SELECTABLE;
            $filterableFieldTypes[] = Constants::FIELD_TYPE_MULTIPLE_CHECKBOX;
        }

        if(!empty($this->contentItemFields)){
            foreach($this->contentItemFields as $field){

                if(in_array($field->field_type_id,$filterableFieldTypes)){
                    $result[] = $field;
                }
            }
        }

        return $result;
    }

    /**
     * Returns types that can be configured for front filtration
     * @return ContentItemFieldEx[]
     */
    public function getFilterConfigurableFields()
    {
        $result = array();

        $availableTypes = array(
            Constants::FIELD_TYPE_NUMERIC,
            Constants::FIELD_TYPE_PRICE,
            Constants::FIELD_TYPE_TEXT,
            Constants::FIELD_TYPE_DATE
        );

        if(!empty($this->contentItemFields)){
            foreach($this->contentItemFields as $field){

                if(in_array($field->field_type_id,$availableTypes)){
                    $result[] = $field;
                }
            }
        }

        return $result;
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