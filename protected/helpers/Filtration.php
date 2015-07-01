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

        $result = array();
        $temp = array();

        //by content type if needed
        if(!empty($contentTypeId)){

            //pas through all items
            foreach($items as $item){
                //add just needed type item
                if($item ->content_type_id == $contentTypeId){
                    $temp[] = $item;
                }
            }

            //by conditions
            foreach($conditions as $fieldId => $params)
            {
                $conditionValue = !empty($params[0]) ? $params[0] : null;
                $conditionTerm = !empty($params[1]) ? $params[1] : Constants::FILTER_CONDITION_IGNORE;

                if($conditionTerm != Constants::FILTER_CONDITION_IGNORE)
                {
                    foreach($temp as $item)
                    {
                        $itemValue = $item->getDynamicFieldValueById($fieldId);

                        switch($conditionTerm){
                            case Constants::FILTER_CONDITION_EQUAL:
                                if($conditionValue == $itemValue){
                                    $result[] = $item;
                                }
                                break;
                            case Constants::FILTER_CONDITION_MORE:
                                if($itemValue > $conditionValue){
                                    $result[] = $item;
                                }
                                break;
                            case Constants::FILTER_CONDITION_LESS:
                                if($itemValue < $conditionValue){
                                    $result[] = $item;
                                }
                                break;
                            case Constants::FILTER_CONDITION_SET:
                                if(!empty($itemValue)){
                                    $result[] = $item;
                                }
                                break;
                            case Constants::FILTER_CONDITION_UNSET:
                                if(empty($itemValue)){
                                    $result[] = $item;
                                }
                        }
                    }

                    $temp = $result;
                    $result = array();
                }
            }

        //if not need - just add all items
        }else{
            $temp = $items;
        }

        $result = $temp;

        return $result;
    }
}