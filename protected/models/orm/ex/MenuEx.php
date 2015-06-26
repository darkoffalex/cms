<?php
/**
 * Class MenuEx
 * @property TreeEx $tree
 * @property MenuTrl $trl
 * @property WidgetRegistrationEx[] $widgetRegistrations
 */
class MenuEx extends Menu
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
     * @return MenuTrl
     */
    public function getOrCreateTrl($lng_id, $save = false)
    {
        $trl = MenuTrl::model()->findByAttributes(array('menu_id' => $this->id,'lng_id' => $lng_id));

        if(empty($trl)){
            $trl = new MenuTrl();
            $trl -> lng_id = $lng_id;
            $trl -> menu_id = $this->id;

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
        $relations['trl'] = array(self::HAS_ONE, 'MenuTrl', 'menu_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}