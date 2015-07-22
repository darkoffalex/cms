<?php
/**
 * Class SubscriptionEx
 */
class SubscriptionEx extends Subscription
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
        $labels['period_in_seconds'] = 'Period (days)';

        foreach($labels as $label => $value)
        {
            $labels[$label] = __a($value);
        }

        return $labels;
    }

    public function periodInDays()
    {
        return ($this->period_in_seconds / 86400);
    }

    /**
     * Override for validation
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        //email validation
        $rules[] = array('email', 'email');

        //email must be unique (ignoring this item while updating)
        $rules[] = array('email', 'unique', 'caseSensitive' => true);

        return $rules;
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