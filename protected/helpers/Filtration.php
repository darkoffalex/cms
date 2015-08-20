<?php

class Filtration
{

    /**
     * Filtrate all dynamic items by dynamic conditions
     * @param ContentItemEx[] $items
     * @param int|null $contentTypeId
     * @param array $conditions
     * @return ContentItemEx[]
     */
    public static function dynamicFiltrate($items,$contentTypeId = null, $conditions = array())
    {
        /* @var $result ContentItemEx[] */

        $result = $items;

        //by content type if needed
        if(!empty($contentTypeId)){

            //remove all items which are not of specified type
            foreach($result as $index => $item){
                if($item->content_type_id != $contentTypeId){
                    unset($result[$index]);
                }
            }
            
            //by conditions
            foreach($conditions as $fieldId => $params)
            {
                $conditionValue = !empty($params[0]) ? $params[0] : null;
                $conditionTerm = !empty($params[1]) ? $params[1] : Constants::FILTER_CONDITION_IGNORE;

                if($conditionTerm != Constants::FILTER_CONDITION_IGNORE)
                {
                    foreach($result as $index => $item)
                    {
                        $itemValue = $item->getDynamicFieldValueById($fieldId);

                        switch($conditionTerm){
                            case Constants::FILTER_CONDITION_EQUAL:
                                if($conditionValue != $itemValue){
                                    unset($result[$index]);
                                }
                                break;
                            case Constants::FILTER_CONDITION_MORE:
                                if($itemValue <= $conditionValue){
                                    unset($result[$index]);
                                }
                                break;
                            case Constants::FILTER_CONDITION_LESS:
                                if($itemValue >= $conditionValue){
                                    unset($result[$index]);
                                }
                                break;
                            case Constants::FILTER_CONDITION_SET:
                                if(empty($itemValue)){
                                    unset($result[$index]);
                                }
                                break;
                            case Constants::FILTER_CONDITION_UNSET:
                                if(!empty($itemValue)){
                                    unset($result[$index]);
                                }
                        }
                    }

                }
            }
        }

        return $result;
    }

    /**
     * Filter all items by specified dynamic fields
     * @param ContentItemEx[] $items
     * @param array $conditions
     * @return ContentItemEx[]
     */
    public static function complexDynamicFiltrate($items,$conditions)
    {
        /* @var $result ContentItemEx[] */
        /* @var $items  ContentItemEx[] */

        $result = $items;

        //pass through all items
        foreach($result as $index => $item)
        {
            //pass through all field-conditions
            foreach($conditions as $fieldId => $condition){

                //get field object
                $field = ContentItemFieldEx::model()->findByPk($fieldId);

                //get item's value for this field
                $itemValue = $item->getDynamicFieldValueById($fieldId);

                //get condition and value from condition array
                $conditionValue = !empty($condition['value']) ? $condition['value'] : '';
                $conditionCond = !empty($condition['condition']) ? $condition['condition'] : '';

                //if nothing missed
                if(!empty($conditionCond) && !empty($conditionValue) && !empty($field)){

                    //if price filtered - convert entered value to cents
                    if($field->field_type_id == Constants::FIELD_TYPE_PRICE){
                        $conditionValue = priceToCents($conditionValue);
                    //if date entered - convert to timestamp
                    }elseif($field->field_type_id == Constants::FIELD_TYPE_DATE){
                        $conditionValue = DateTime::createFromFormat('m/d/Y',$conditionValue)->getTimestamp();
                    }

                    //each type has own checking
                    switch($field->field_type_id)
                    {
                        //for all numeric types
                        case Constants::FIELD_TYPE_NUMERIC:
                        case Constants::FIELD_TYPE_PRICE:
                        case Constants::FIELD_TYPE_DATE:

                            if($conditionCond == Constants::FILTER_CONDITION_EQUAL){
                                if($itemValue != $conditionValue){
                                    unset($result[$index]);
                                }
                            }elseif($conditionCond == Constants::FILTER_CONDITION_MORE){
                                if($itemValue <= $conditionValue){
                                    unset($result[$index]);
                                }
                            }elseif($conditionCond == Constants::FILTER_CONDITION_LESS){
                                if($itemValue >= $conditionValue){
                                    unset($result[$index]);
                                }
                            }elseif($conditionCond == Constants::FILTER_CONDITION_BETWEEN){
                                $range = explode(':',$conditionValue);
                                $min = !empty($range[0]) ? $range[0] : 0;
                                $max = !empty($range[1]) ? $range[1] : 0;

                                if(!($itemValue >= $min && $itemValue <= $max)){
                                    unset($result[$index]);
                                }
                            }

                            break;

                        //for text type
                        case Constants::FIELD_TYPE_TEXT:

                            if($conditionCond == Constants::FILTER_CONDITION_EQUAL){
                                if($itemValue != $conditionValue){
                                    unset($result[$index]);
                                }
                            }elseif($conditionCond == Constants::FILTER_CONDITION_SIMILAR){
                                if(strpos($itemValue,$conditionValue) === false){
                                    unset($result[$index]);
                                }
                            }

                            break;

                        //for selectable
                        case Constants::FIELD_TYPE_SELECTABLE:

                            //if from filter received none array (single value)
                            if(!is_array($conditionValue))
                            {
                                //check as EQUAL condition
                                if($itemValue != $conditionValue){
                                    unset($result[$index]);
                                }
                            }
                            //if array given
                            else{
                                if(!in_array($itemValue,$conditionValue)){
                                    unset($result[$index]);
                                }
                            }


                            break;

                        //for multiple checkbox
                        case Constants::FIELD_TYPE_MULTIPLE_CHECKBOX:

                            //if from filter received none array (single value)
                            if(!is_array($conditionValue))
                            {
                                //we have just one array checking
                                if(!in_array($conditionValue,$itemValue)){
                                    unset($result[$index]);
                                }
                            //if we have two arrays
                            }else{
                                $collides = false;
                                foreach($conditionValue as $val)
                                {
                                    if(in_array($val,$itemValue)){
                                        $collides = true;
                                    }
                                }
                                if(!$collides){
                                    unset($result[$index]);
                                }
                            }

                            break;
                    }
                }
            }
        }

        return $result;
    }
}