<?php
/**
 * Class WidgetPositionEx
 * @property WidgetRegistrationEx[] $widgetRegistrations
 */
class WidgetPositionEx extends WidgetPosition
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

        //modify relation - add ascending sorting
        $relations['widgetRegistrations'] = array(self::HAS_MANY, 'WidgetRegistrationEx', 'position_id','order' => 'priority ASC');

        //return modified relations
        return $relations;
    }
}