<?php
class Sort
{
    /**
     * Finds two item by PK, swaps priority and updates
     * @param $id1
     * @param $id2
     * @param $className
     * @param bool $update
     * @return  array | bool | Tree[] | TreeEx[] | ContentItemEx[] | ContentItem[] | CActiveRecord[]
     */
    public static function SwapById($id1,$id2,$className,$update = true)
    {
        /* @var $className CActiveRecord */
        /* @var $objItem1 Tree | TreeEx | ContentItem | ContentItemEx | CActiveRecord*/
        /* @var $objItem2 Tree | TreeEx | ContentItem | ContentItemEx | CActiveRecord*/

        $objItem1 = $className::model()->findByPk($id1);
        $objItem2 = $className::model()->findByPk($id2);

        if($objItem1 != null && $objItem2 != null)
        {
            $p1 = $objItem1->priority;
            $objItem1->priority = $objItem2->priority;
            $objItem2->priority = $p1;

            if($update)
            {
                $objItem1->update();
                $objItem2->update();
            }

            return array($objItem1,$objItem2);
        }

        return false;
    }


    /**
     * Swaps priority of two items
     * @param CActiveRecord $object1
     * @param CActiveRecord $object2
     * @param bool $update
     * @return array | bool | Tree[] | TreeEx[] | ContentItemEx[] | ContentItem[] | CActiveRecord[]
     */
    public  static function Swap($object1, $object2, $update = true)
    {
        /* @var $object1 Tree | TreeEx | ContentItem | ContentItemEx | CActiveRecord*/
        /* @var $object2 Tree | TreeEx | ContentItem | ContentItemEx | CActiveRecord*/

        //if objects not null
        if($object1 != null && $object2 != null)
        {
            //store first object's priority
            $pr1 = $object1->priority;
            //assign to first object priority pf second
            $object1->priority = $object2->priority;
            //assign to second object stored first object's priority
            $object2->priority = $pr1;

            if($update)
            {
                //update both
                $object1->update();
                $object2->update();
            }

            return array($object1,$object2);
        }

        return false;
    }


    /**
     * Reorders priorities (used for ajax drag-n-drop sequence changing)
     * @param string $className
     * @param array $oldOrder
     * @param array $newOrder
     * @param string $sortOrder
     */
    public static function ReorderItems($className,$oldOrder,$newOrder,$sortOrder = 'priority ASC')
    {
        if(!empty($oldOrder) && !empty($newOrder) && count($oldOrder) == count($newOrder))
        {
            /* @var $className TreeEx | ContentItemEx | CActiveRecord */
            /* @var $items TreeEx[] | ContentItemEx[] | CActiveRecord[] */
            /* @var $item TreeEx | ContentItemEx | CActiveRecord */

            //get all items by old order's ID's and sort them by priority
            $items = $className::model()->findAllByAttributes(array('id' => $oldOrder),array('order' => $sortOrder));

            if(!empty($items))
            {
                //get max and min priorities
                $minPriority = $items[0]->priority;
                $maxPriority = $items[count($items)-1]->priority;

                //current iteration priority
                $current_priority = $minPriority;

                //foreach ID in new order sequence
                foreach($newOrder as $id)
                {
                    //set current iteration priority
                    $item = $className::model()->findByPk($id);
                    $item->priority = $current_priority;
                    $item->update();

                    //increase if not reached max
                    if($current_priority < $maxPriority)
                    {
                        $current_priority++;
                    }
                }
            }

        }
    }

    /**
     * Returns next priority for some item (used in adding)
     * @param $className
     * @param array $condition
     * @param string $field
     * @return int
     */
    public static function GetNextPriority($className,$condition = array(),$field = 'priority')
    {
        /* @var $className CActiveRecord */
        /* @var $itemsAll TreeEx[] | ContentItemEx[] */

        if(!empty($condition))
        {
            $itemsAll = $className::model()->findAllByAttributes($condition);
        }
        else
        {
            $itemsAll = $className::model()->findAll();
        }

        $max = 0;
        foreach($itemsAll as $item)
        {
            if($item->$field > $max)
            {
                $max = $item->$field;
            }
        }

        return $max + 1;
    }


    /**
     * Moves item's priority higher or lower
     * @param $movingObject Tree | ContentItem | CActiveRecord
     * @param string $direction
     * @param string $className
     * @param array $condition
     * @param string $order_by
     */
    public static function Move($movingObject,$direction,$className,$condition = array(),$order_by = 'priority ASC')
    {
        /* @var $className CActiveRecord */
        if(!empty($condition))
        {
            $all = $className::model()->findAllByAttributes($condition,array('order' => $order_by));
        }
        else
        {
            $all = $className::model()->findAll(array('order' => $order_by));
        }

        foreach($all as $index => $obj)
        {
            if($obj == $movingObject)
            {
                if($direction == 'up' && isset($all[$index - 1]))
                {
                    self::Swap($all[$index-1],$obj);
                }

                if($direction == 'down' && isset($all[$index + 1]))
                {
                    self::Swap($all[$index+1],$obj);
                }
            }
        }
    }
}