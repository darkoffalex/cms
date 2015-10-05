<?php

/**
 * Class FeedbackEx
 * @property WidgetEx $widget
 */
class FeedbackEx extends Feedback
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

    /**
     * Returns entered by client information as array (field => value)
     * @return array|mixed
     */
    public function getFieldsInfo()
    {
        $array = !empty($this->incoming_data_json) && isJson($this->incoming_data_json) ? json_decode($this->incoming_data_json,true) : array();
        return $array;
    }
}