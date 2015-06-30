<?php
/**
 * Class WidgetEx
 * @property TreeEx $tree
 * @property WidgetRegistrationEx[] $widgetRegistrations
 * @property ContentTypeEx $filtrationByType
 * @property WidgetTrl $trl
 */
class WidgetEx extends Widget
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
     * Filtration settings - returns key value
     * @param $id
     * @return null
     */
    public function filtrationValFor($id)
    {
        $arrayStr = $this->filtration_array_json;
        $array = !empty($arrayStr) ? json_decode($arrayStr,true) : array();

        return !empty($array[$id][0]) ? $array[$id][0] : null;
    }

    /**
     * Filtration settings - returns condition
     * @param $id
     * @return int
     */
    public function filtrationConFor($id)
    {
        $arrayStr = $this->filtration_array_json;
        $array = !empty($arrayStr) ? json_decode($arrayStr,true) : array();

        return !empty($array[$id][1]) ? $array[$id][1] : Constants::FILTER_CONDITION_IGNORE;
    }

    public function getFilteredItems()
    {
        /* @var $items ContentItemEx[] */
        /* @var $itemsTmp ContentItemEx[] */

        $items = array();
        $itemsTmp = $this->tree->getContentBlocks($this->include_from_nested);

        if(!empty($this->filtrationByType)){

            //first phase of filtration
            foreach($itemsTmp as $item)
            {
                if($item->content_type_id == $this->filtration_by_type_id){
                    $items[] = $item;
                }
            }

            $itemsTmp = $items;

            //get filterable fields
            $fields = $this->filtrationByType->getFilterableFields();

            foreach($fields as $filterable){
                if($this->filtrationConFor($filterable->id) != Constants::FILTER_CONDITION_IGNORE)
                {
                    foreach($itemsTmp as $item)
                    {
                        $value = $item->getDynamicFieldValueById($filterable->id);
                        $condition = $this->filtrationConFor($filterable->id);
                        $conditionValue = $this->filtrationValFor($filterable->id);

                        //TODO: the truth is out there...
                    }
                }
            }


        }else{
            $items = $itemsTmp;
        }
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