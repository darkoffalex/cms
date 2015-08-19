<?php
/**
 * Class FilterableField
 * @property string $name
 * @property string $title
 * @property string $variants
 * @property int $condition_id
 * @property int $type_id
 * @property ContentItemFieldEx $field_object
 */
class FilterableField
{
    const FILTER_FIELDS_GROUP = 'FrontFiltration';
    const INTERVAL_DELIMITER = ' - ';

    public $name;
    public $title;
    public $variants;
    public $condition_id;
    public $type_id;
    public $field_object;
    private $id;

    public function __construct($field = null, $widget = null){

        /* @var $widget WidgetEx */
        /* @var $field ContentItemFieldEx */

        if(!empty($field) && !empty($widget)){
            $this->init($field,$widget);
        }
    }

    public function init($field = null, $widget = null)
    {
        /* @var $widget WidgetEx */
        /* @var $field ContentItemFieldEx */

        //set field id (it should be same as field's from db)
        $this->id = $field->id;
        $this->field_object = $field;

        //get all variants, intervals and filtration type from widget settings for this field
        $variants = $widget->getVariantsForField($this->id);
        $intervals = $widget->getIntervalsForField($this->id);
        $filtrationType = $widget->filterTypeFor($this->id);

        //set filtration condition
        $this->condition_id = $filtrationType;

        //obtain a variants as array of strings
        switch($this->condition_id){

            case Constants::FILTER_CONDITION_EQUAL:
            case Constants::FILTER_CONDITION_LESS:
            case Constants::FILTER_CONDITION_MORE:

                if(!empty($variants)){
                    foreach($variants as $variant){
                        $this->variants[] = $variant['variant'];
                    }
                }
                break;

            case Constants::FILTER_CONDITION_BETWEEN:
                if(!empty($intervals)){
                    foreach($intervals as $interval){
                        $this->variants[] = $interval['min'].self::INTERVAL_DELIMITER.$interval['max'];
                    }
                }
            break;
        }

        //set field's type
        $this->type_id = $field->field_type_id;
    }
}