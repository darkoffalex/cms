<?php
/**
 * Class ContentItemFieldEx
 * @property ContentTypeEx $contentType
 * @property ContentItemFieldTrl $trl
 * @property int|null $filter_condition_id
 * @property array|null $filter_variants
 * @property string|null $filter_field_name
 * @property string|null $filter_field_name_group
 * @property string|null $filter_condition_field_name
 * @property ContentItemFieldValueEx[] $contentItemFieldValues
 */
class ContentItemFieldEx extends ContentItemField
{
    //filtration field name group
    const FILTER_FIELDS_GROUP = 'FrontFiltration';
    const FILTER_LESS_SIGN = '<';
    const FILTER_MORE_SIGN = '>';

    public $filter_condition_id = null;
    public $filter_variants = null;
    public $filter_field_name = null;
    public $filter_field_name_group = null;
    public $filter_condition_field_name = null;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns array of variants
     * @param null $widget
     */
    public function initFiltrationParams($widget = null)
    {
        /* @var $widget WidgetEx */

        $result = array();

        switch($this->field_type_id)
        {
            case Constants::FIELD_TYPE_NUMERIC:
            case Constants::FIELD_TYPE_PRICE:
            case Constants::FIELD_TYPE_TEXT:
            case Constants::FIELD_TYPE_DATE:

                //if filtration widget (with filtration settings) set
                if(!empty($widget)){

                    //get all variants, intervals and filtration condition/type from widget settings for this field
                    $variants = $widget->getVariantsForField($this->id);
                    $intervals = $widget->getIntervalsForField($this->id);
                    $this->filter_condition_id = $widget->filterTypeFor($this->id);

                    //for "equal", "less", "more" - simple variants, for "between" - intervals
                    switch($this->filter_condition_id){
                        case Constants::FILTER_CONDITION_EQUAL:
                        case Constants::FILTER_CONDITION_LESS:
                        case Constants::FILTER_CONDITION_MORE:

                            if(!empty($variants)){
                                foreach($variants as $variant){

                                    $sign = "";
                                    if($this->filter_condition_id == Constants::FILTER_CONDITION_LESS){
                                        $sign = self::FILTER_LESS_SIGN;
                                    }elseif($this->filter_condition_id == Constants::FILTER_CONDITION_MORE){
                                        $sign = self::FILTER_MORE_SIGN;
                                    }

                                    $result[$variant['variant']] = $sign.$variant['variant'];
                                }
                            }
                            break;

                        case Constants::FILTER_CONDITION_BETWEEN:
                            if(!empty($intervals)){
                                foreach($intervals as $interval){
                                    $result[$interval['min'].':'.$interval['max']] = $interval['min'].' - '.$interval['max'];
                                }
                            }
                            break;
                    }
                }
                break;

            case Constants::FIELD_TYPE_MULTIPLE_CHECKBOX:
            case Constants::FIELD_TYPE_SELECTABLE:

                $selectable = $this->getSelectableVariants();
                $result = $selectable;

                break;
        }

        $this->filter_variants = $result;
        $this->filter_field_name = self::FILTER_FIELDS_GROUP.'['.$this->id.'][value]';
        $this->filter_field_name_group = self::FILTER_FIELDS_GROUP.'['.$this->id.'][value][]';
        $this->filter_condition_field_name = self::FILTER_FIELDS_GROUP.'['.$this->id.'][condition]';
    }

    /**
     * Returns array of variants
     * @param null $widget
     * @return array|mixed
     */
    public function getFilterVariants($widget = null)
    {
        $this->initFiltrationParams($widget);
        return $this->filter_variants;
    }

    /**
     * Adds special hidden input for filtration condition
     * @param bool|false $return
     * @return null|string
     */
    public function filterEssentials($return = false){

        $conditionId = !empty($this->filter_condition_id) ? $this->filter_condition_id : Constants::FILTER_CONDITION_EQUAL;

        $result = "<input type='hidden' value='".$conditionId."' name='".$this->filter_condition_field_name."'>";
        $result .= "<input type='hidden' value='' name='".$this->filter_field_name."'>";

        if($return){
            return $result;
        }

        echo $result;
        return null;
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
     * Sets an array with selectable variants from form table-fields
     * @param $array
     */
    public function setSelectableVariants($array)
    {
        $result = array();

        $keys = array_keys($array);

        $values = !empty($array[$keys[0]]) ? $array[$keys[0]] : array();
        $titles = !empty($array[$keys[1]]) ? $array[$keys[1]] : array();

        foreach($values as $index => $value){

            if(!empty($value)){
                $result[$value] = !empty($titles[$index]) ? $titles[$index] : '';
            }
        }

        $this->selecatble_variants = serialize($result);
    }

    /**
     * Returns all selectable variants for a table
     * @return array|mixed
     */
    public function getSelectableVariants()
    {
        return is_serialized($this->selecatble_variants) ? unserialize($this->selecatble_variants) : array();
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