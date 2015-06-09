<?php
/**
 * Class TreeEx
 * @property ContentItemEx[] $contentItems
 * @property ImageOfTreeEx[] $imageOfTrees
 * @property MenuEx[] $menus
 * @property TreeTrl $trl
 * @property TreeEx $parent
 * @property TreeEx[] $children
 * @property WidgetEx[] $widgets
 * @property CUploadedFile $image
 */
class TreeEx extends Tree
{

    //for image uploading
    public $image;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns true - if category has parents
     * @param int $ignore_parent
     * @return bool
     */
    public function hasParent($ignore_parent = 0)
    {
        $count = 0;
        if($this->parent_id != $ignore_parent){
            $count = self::model()->countByAttributes(array('id' => $this->parent_id));
        }
        return $count > 0;
    }

    /**
     * Recursively deletes all sub-categories and category itself
     */
    public function recursiveDelete()
    {
        if(count($this->children) > 0){
            foreach($this->children as $child){
                $child->recursiveDelete();
            }
        }

        $this->delete();
    }

    /**
     * Returns true if category has children
     * @return bool
     */
    public function hasChildren()
    {
        $count = self::model()->countByAttributes(array('parent_id' => $this->id));
        return $count > 0;
    }

    /**
     * Calculate nesting level
     */
    public function nestingLevel()
    {
        $level = 1;
        $currentItem = $this;

        while(!empty($currentItem->parent))
        {
            $level++;
            $currentItem = $currentItem->parent;
        }

        return $level;
    }

    /**
     * Returns branch-line of item
     * @param bool $asString
     * @return array|string
     */
    public function findBranch($asString = false)
    {
        //all id's of branch
        $branch = array();

        //current step's item
        $current = $this;

        //if this item is saved in db - branch will include id of this item, if not - append 'X' symbol
        if(!$this->isNewRecord){
            $branch[] = $this->id;
        }else{
            $branch[] = 'X';
        }

        //while current item has parent
        while(!empty($current->parent_id) && $current->parent_id !== 0){
            $branch[] = $current->parent_id; //add id of parent to branch
            $current = self::model()->findByPk($current->parent_id); //current item - parent item
        }

        //append zero
        $branch[] = 0;

        //reverse array
        $branch = array_reverse($branch);

        //branch as string
        $string = implode(':',$branch);

        //return array or string
        return $asString ? $string : $branch;
    }

    /**
     * Builds recursively-sorted array of tree items (not nested array)
     * @param int $parent_id
     * @param array $attributes
     * @param array $conditions
     * @return array|self[]
     */
    public function getChildrenRecursive($parent_id = 0, $attributes = array(), $conditions = array('order' => 'priority ASC'))
    {
        /* @var $all self[] */
        /* @var $tmp self[] */

        //array with recursively sorted items
        $result = array();

        //store attributes and conditions from arguments
        $_attributes = $attributes;
        $_conditions = $conditions;

        //modify attributes (parent id must be set separately in first param, and will be overwritten)
        $_attributes['parent_id'] = $parent_id;

        //get all elements by this conditions
        $all = self::findAllByAttributes($_attributes,$_conditions);

        //pass through all found elements
        foreach($all as $item)
        {
            //append to result
            $result[] = $item;

            //but if it has children
            if($item->hasChildren()){

                //get them all by this function (recursively)
                $tmp = $this->getChildrenRecursive($item->id,$attributes,$conditions);

                //and append them
                foreach($tmp as $innerItem)
                {
                    $result[] = $innerItem;
                }
            }
        }

        return $result;
    }

    /**
     * Builds recursively-sorted and grouped by roots array of tree items (not nested array)
     * @param int $parent_id
     * @param array $attributes
     * @param array $conditions
     * @return array
     */
    public function getChildrenRecursiveGrouped($parent_id = 0, $attributes = array(), $conditions = array('order' => 'priority ASC'))
    {
        /* @var $array self[] */

        $array = self::model()->getChildrenRecursive($parent_id,$attributes,$conditions);
        $currentIndex = 0;
        $result = array();

        foreach($array as $item)
        {
            if(!$item->hasParent($parent_id))
            {
                $currentIndex = $item->id;
            }

            $result[$currentIndex][] = $item;
        }

        return $result;
    }

    /**
     * Returns list-array for menu drop-downs
     * @param int $parent_id
     * @param string $nesting_symbol
     * @param bool $include_root
     * @param string $root_name
     * @return array
     */
    public function listAllItemsForForms($parent_id = 0, $nesting_symbol = '',$include_root = false, $root_name = '')
    {
        //result array
        $result = array();

        //get all items by recursion
        $all = $this->getChildrenRecursive($parent_id);

        //if we should show first-root element
        if($include_root){
            $result[0] = $root_name;
        }

        //fill array (id => label)
        foreach($all as $index => $item)
        {
            $nestingPaddingStr = '';

            for($i=0; $i<$item->nestingLevel(); $i++){
                $nestingPaddingStr .= $nesting_symbol;
            }

            $result[$item->id] = $nestingPaddingStr.$item->label;
        }

        return $result;
    }

    /**
     * Finds or creates Trl of this item
     * @param $lng_id
     * @param bool $save
     * @return TreeTrl
     */
    public function getOrCreateTrl($lng_id, $save = false)
    {
        $trl = TreeTrl::model()->findByAttributes(array('tree_id' => $this->id,'lng_id' => $lng_id));

        if(empty($trl)){
            $trl = new TreeTrl();
            $trl -> lng_id = $lng_id;
            $trl -> tree_id = $this->id;

            if($save){
                $trl->save();
            }
        }

        return $trl;
    }


    /**
     * Append some new rules
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = array('label','required');
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
        $relations['trl'] = array(self::HAS_ONE, 'TreeTrl', 'tree_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));
        $relations['parent'] = array(self::BELONGS_TO, 'TreeEx', 'parent_id');
        $relations['children'] = array(self::HAS_MANY, 'TreeEx', 'parent_id');

        //return modified relations
        return $relations;
    }
}