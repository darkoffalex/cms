<?php
/**
 * Class WidgetEx
 * @property TreeEx $tree
 * @property WidgetRegistrationEx[] $widgetRegistrations
 * @property ContentTypeEx $filtrationByType
 * @property ContentItemFieldEx[]|array $preparedFilterableFields
 * @property WidgetTrl $trl
 * @property FeedbackEx[] $feedbacks
 */
class WidgetEx extends Widget
{
    /**
     * @var array
     */
    public $preparedFilterableFields = array();

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns filtration field - field object from already prepared/initialised array
     * @param $fieldName
     * @return ContentItemFieldEx|null
     */
    public function getFilterField($fieldName)
    {
        if(!empty($this->preparedFilterableFields)){
            foreach($this->preparedFilterableFields as $field){
                if($field->field_name == $fieldName){
                    return $field;
                }
            }
        }

        return null;
    }

    /**
     * Returns array of conditions for item filtration
     * @return array|mixed
     */
    public function getFiltrationArr()
    {
        $filtrationStr = $this->filtration_array_json;
        if(!empty($filtrationStr) && isJson($filtrationStr)){
            return json_decode($this->filtration_array_json,true);
        }
        return array();
    }

    /**
     * Returns all filtration variants for specified field
     * @param $field_id
     * @return array
     */
    public function getVariantsForField($field_id)
    {
        $array = $this->getFiltrationArr();
        return !empty($array[$field_id]['variants']) ? $array[$field_id]['variants'] : array();
    }

    /**
     * Returns all filtration variants-intervals for specified field
     * @param $field_id
     * @return array
     */
    public function getIntervalsForField($field_id)
    {
        $array = $this->getFiltrationArr();
        return !empty($array[$field_id]['intervals']) ? $array[$field_id]['intervals'] : array();
    }

    /**
     * Used for widget of filter type - returns filtration type
     * @param $field_id
     * @return null|int
     */
    public function filterTypeFor($field_id)
    {
        $array = $this->getFiltrationArr();
        return !empty($array[$field_id]['type']) ? $array[$field_id]['type'] : null;
    }

    /**
     * Used for widget of filter type - checks if field filtrated by specified type
     * @param $field_id
     * @param $type
     * @return bool
     */
    public function filterTypeForIs($field_id,$type)
    {
        return $this->filterTypeFor($field_id) == $type;
    }

    /**
     * Filtration settings - returns key value
     * @param $field_id
     * @return null
     */
    public function filtrationValFor($field_id)
    {
        $array = $this->getFiltrationArr();
        return !empty($array[$field_id][0]) ? $array[$field_id][0] : null;
    }

    /**
     * Filtration settings - returns condition
     * @param $field_id
     * @return int
     */
    public function filtrationConFor($field_id)
    {
        $array = $this->getFiltrationArr();
        return !empty($array[$field_id][1]) ? $array[$field_id][1] : Constants::FILTER_CONDITION_IGNORE;
    }

    /**
     * Finds or creates Trl of this item
     * @param $lng_id
     * @param bool $save
     * @return WidgetTrl
     */
    public function getOrCreateTrl($lng_id, $save = false)
    {
        $trl = WidgetTrl::model()->findByAttributes(array('widget_id' => $this->id,'lng_id' => $lng_id));

        if(empty($trl)){
            $trl = new WidgetTrl();
            $trl -> lng_id = $lng_id;
            $trl -> widget_id = $this->id;

            if($save){
                $trl->save();
            }
        }

        return $trl;
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
        $relations['trl'] = array(self::HAS_ONE, 'WidgetTrl', 'widget_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}