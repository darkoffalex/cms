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
        return array(
            array('label', 'required'),
            array('status_id, created_by_id, updated_by_id, created_time, updated_time', 'numerical', 'integerOnly'=>true),
            array('id, label, price, status_id, created_by_id, updated_by_id, created_time, updated_time', 'safe', 'on'=>'search'),
            array('price','numerical','integerOnly' => false)
        );
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