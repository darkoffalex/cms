<?php
/**
 * Class OrderItemEx
 * @property OrderEx[] $orders
 * @property OrderDeliveryTrl $trl
 */
class OrderDeliveryEx extends OrderDelivery
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
     * Sets an array with weight-price dependencies from form table-fields
     * @param $array
     */
    public function setWeightDependencies($array)
    {
        $result = array();

        $keys = array_keys($array);

        $weights = !empty($array[$keys[0]]) ? $array[$keys[0]] : array();
        $prices = !empty($array[$keys[1]]) ? $array[$keys[1]] : array();

        foreach($weights as $index => $weight){
            if(priceToCents($weight) > 0 && !empty($prices[$index]) && priceToCents($prices[$index]) > 0){
                $result[priceToCents($weight)] = priceToCents($prices[$index]);
            }
        }

        $this->dependency_array = serialize($result);
    }

    /**
     * Returns stored dependency array
     * @return mixed
     */
    public function getWeightDependencies()
    {
        return is_serialized($this->dependency_array) ? unserialize($this->dependency_array) : array();
    }

    /**
     * Returns or creates trl object
     * @param $lng_id
     * @param bool $save
     * @return OrderDeliveryTrl|static
     */
    public function getOrCreateTrl($lng_id, $save = false)
    {
        $trl = OrderDeliveryTrl::model()->findByAttributes(array('delivery_id' => $this->id,'lng_id' => $lng_id));

        if(empty($trl)){
            $trl = new OrderDeliveryTrl();
            $trl -> lng_id = $lng_id;
            $trl -> delivery_id = $this->id;

            if($save){
                $trl->save();
            }
        }

        return $trl;
    }

    /**
     * Override for validation
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        foreach($rules as $index => $ruleArr){
            if(!empty($ruleArr['integerOnly'])){
                $rules[$index]['integerOnly'] = false;
            }
        }

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

        //relate with translation
        $lng = Yii::app()->language;
        $relations['trl'] = array(self::HAS_ONE, 'OrderDeliveryTrl', 'delivery_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}