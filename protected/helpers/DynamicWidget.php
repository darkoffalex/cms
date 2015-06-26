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
     */
    public function render($positionName)
    {
        /* @var $position WidgetPositionEx */
        /* @var $content string */

        $content = '';
        $position = WidgetPositionEx::model()->findByAttributes(array('position_name' => $positionName));

        if(!empty($position->widgetRegistrations)){

            foreach($position->widgetRegistrations as $registered)
            {
                $menu = $registered->menu;
                $widget = $registered->widget;

                //TODO: implement rendering for widgets and menus
            }

        }
    }
}