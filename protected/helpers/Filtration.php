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
        /* @var $temp ContentItemEx[] */

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
}