<?php
class DynamicWidget
{
    /**
     * @var self
     */
    protected static $_instance = null;
    /**
     * @var Controller
     */
    public $controller;
    /**
     * @var string
     */
    public $themeName;

    /**
     * Getting an instance
     * @return DynamicWidget
     */
    public static function getInstance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Default constructor
     */
    private function __construct()
    {

    }

    /**
     * Disable cloning
     */
    private function __clone()
    {

    }

    /**
     * Initialisation
     * @param $controller
     * @param $themeName
     */
    public function initialize(&$controller,$themeName)
    {
        $this->controller = $controller;
        $this->themeName = $themeName;
    }


    /**
     * Rendering content
     * @param $positionName
     * @param bool $return
     * @return string
     */
    public function render($positionName, $return = false)
    {
        /* @var $position WidgetPositionEx */
        /* @var $content string */

        $content = '';
        $position = WidgetPositionEx::model()->findByAttributes(array('position_name' => $positionName));

        if(!empty($position->widgetRegistrations)){

            foreach($position->widgetRegistrations as $registered)
            {
                $widget = $registered->widget;
                $data = $this->getContent($widget);
                $html = '';
                if(!empty($this->controller) && !empty($widget->template_name)){
                    try{
                        $html = $this->controller->renderPartial('//widgets/'.$widget->template_name,array('widget' => $widget, 'content' => $data),true);
                    }catch (Exception $ex){
                        $html = $ex->getMessage();
                    }

                }elseif(!empty($this->controller)){
                    $html = debugvar($data,true);
                }

                $content .= $html;
            }
        }

        if($return){
            return $content;
        }else{
            echo $content;
        }

        return null;
    }

    private function getContent($widget)
    {
        /* @var $widget WidgetEx */
        $content = array();

        if(!empty($widget)){

            switch($widget->type_id)
            {
                //if widget has type 'menu'
                case Constants::WIDGET_TYPE_MENU:
                    //get all subcategories of selected category
                    $content = $widget->tree->children;
                    break;

                //if widget has type 'blocks'
                case Constants::WIDGET_TYPE_BLOCKS:
                    //get all blocks of selected category
                    $items = $widget->tree->getContentBlocks($widget->include_from_nested);
                    $filterConditions = $widget->getFiltrationArr();
                    $itemsFiltered = Filtration::dynamicFiltrate($items,$widget->filtration_by_type_id,$filterConditions);

                    //limit array if needed (if limit was set)
                    if(!empty($widget->block_limit) && $widget->block_limit <= count($items)){
                        $content = array_splice($itemsFiltered,0,$widget->block_limit);
                    }else{
                        $content = $itemsFiltered;
                    }
                    break;

                //if widget has type 'breadcrumbs'
                case Constants::WIDGET_TYPE_BREADCRUMBS:

                    /* @var $item ContentITemEx */

                    $controllerId = Yii::app()->controller->id;
                    $actionId = Yii::app()->controller->action->id;

                    $id = Yii::app()->request->getParam('id',null);
                    $categoryId = null;
                    $item = null;

                    //if we in 'pages' controller
                    if($controllerId == 'pages'){

                        //if we showing single item (not listing items in a category, but showing inner page of one)
                        if($actionId == 'show'){
                            //find an item which currently rendering
                            $item = ContentItemEx::model()->findByPk((int)$id);
                            //if item found
                            if(!empty($item)){
                                //obtain a current category id
                                $categoryId = $item->tree_id;
                            }
                        }
                        //if we rendering a list (items of specified category)
                        elseif($actionId == 'list'){
                            $categoryId = $id;
                        }

                        //find current category
                        $category = TreeEx::model()->findByPk((int)$categoryId);
                        $result = array();

                        //if category not empty - build branch-path array
                        if(!empty($category)){
                            $categories = $category->findBranchEx();
                            $rootLvl = !empty($widget->breadcrumbs_root_level) ? $widget->breadcrumbs_root_level : 0;

                            foreach($categories as $index => $branchCat){
                                if($index >= $rootLvl){
                                    $crumb = array(
                                        'title' => !empty($branchCat->trl->name) ? $branchCat->trl->name : $branchCat->label,
                                        'url' => Yii::app()->createUrl('pages/list',array('id' => $branchCat->id, 'title' => 'undefined')) //TODO: implement title slug
                                    );
                                    $result[] = $crumb;
                                }
                            }
                        }

                        //if has item - append it's info as final path's part
                        if(!empty($item)){
                            $result[] = array(
                                'title' => !empty($item->trl->name) ? $item->trl->name : $item->label,
                                'url' => Yii::app()->createUrl('pages/show',array('id' => $item->id, 'title' => 'undefined'))
                            );
                        }

                        $content = $result;
                    }
                    break;

                //if widget has type 'filter'
                case Constants::WIDGET_TYPE_FILTER:
                    //TODO: implement here filter stuff
                    break;

                //if widget has type 'text'
                case Constants::WIDGET_TYPE_TEXT:
                    $content = array(
                        'title' => !empty($widget->trl->title) ? $widget->trl->title : '',
                        'text' => !empty($widget->trl->custom_content) ? $widget->trl->custom_content : ''
                    );
                    break;
            }

        }

        return $content;
    }
}