<?php
class Constants
{
    //statuses
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN = 2;
    const STATUS_DELETED = 3;
    const STATUS_SUSPENDED = 4;

    //field types
    const FIELD_TYPE_NUMERIC = 1;
    const FIELD_TYPE_TEXT = 2;
    const FIELD_TYPE_TEXT_TRL = 3;
    const FIELD_TYPE_DATE = 4;
    const FIELD_TYPE_IMAGE = 5;
    const FIELD_TYPE_FILE = 6;
    const FIELD_TYPE_BOOLEAN = 7;
    const FIELD_TYPE_PRICE = 8;

    //widget types
    const WIDGET_TYPE_MENU = 1;
    const WIDGET_TYPE_BREADCRUMBS = 2;
    const WIDGET_TYPE_BLOCKS = 4;
    const WIDGET_TYPE_FILTER = 5;
    const WIDGET_TYPE_TEXT = 6;

    /**
     * Returns list of basic statuses
     * @return array
     */
    public static function statusList()
    {
        return array(
            self::STATUS_VISIBLE => __a('Visible'),
            self::STATUS_HIDDEN => __a('Hidden')
        );
    }

    /**
     * Returns list of all statuses
     * @return array
     */
    public static function statusListEx()
    {
        return array(
            self::STATUS_VISIBLE => __a('Visible'),
            self::STATUS_HIDDEN => __a('Hidden'),
            self::STATUS_DELETED => __a('Deleted'),
            self::STATUS_SUSPENDED => __a('Suspended'),
        );
    }

    /**
     * Returns all field types
     * @return array
     */
    public static function fieldTypeList()
    {
        return array(
            self::FIELD_TYPE_NUMERIC => __a('Numeric'),
            self::FIELD_TYPE_PRICE => __('Price'),
            self::FIELD_TYPE_TEXT => __a('Text'),
            self::FIELD_TYPE_TEXT_TRL  => __a('Translatable text'),
            self::FIELD_TYPE_DATE => __a('Date-Time'),
            self::FIELD_TYPE_IMAGE => __a('Image'),
            self::FIELD_TYPE_FILE => __a('File'),
            self::FIELD_TYPE_BOOLEAN  => __a('Checkbox'),
        );
    }

    /**
     * Returns all widget types
     * @return array
     */
    public static function widgetTypeList()
    {
        return array(
            self::WIDGET_TYPE_MENU  => __a('Menu'),
            self::WIDGET_TYPE_BREADCRUMBS => __('Breadcrumbs'),
            self::WIDGET_TYPE_BLOCKS  => __a('Blocks'),
            self::WIDGET_TYPE_FILTER => __a('Filter'),
            self::WIDGET_TYPE_TEXT => __a('Custom text'),
        );
    }

    /**
     * Template types for widgets
     * @param $type_id
     * @param $default
     * @return mixed
     */
    public static function widTplType($type_id, $default = 'Default')
    {
        $arr = array(
            self::WIDGET_TYPE_MENU  => 'Menu',
            self::WIDGET_TYPE_BREADCRUMBS => 'Breadcrumbs',
            self::WIDGET_TYPE_BLOCKS  => 'Blocks',
            self::WIDGET_TYPE_FILTER => 'Filter',
            self::WIDGET_TYPE_TEXT => 'CustomText'
        );

        return !empty($arr[$type_id]) ? $arr[$type_id] : $default;
    }


    /**
     * Returns name of filed type by ID
     * @param $type_id
     * @param string $default
     * @return null
     */
    public static function getTypeName($type_id,$default = 'Unknown')
    {
        $array = self::fieldTypeList();
        $name = !empty($array[$type_id]) ? $array[$type_id] : __a($default);
        return $name;
    }

    /**
     * Returns widget type name by ID
     * @param $type_id
     * @param string $default
     * @return string
     */
    public static function getWidgetTypeName($type_id, $default = 'Unknows')
    {
        $array = self::widgetTypeList();
        $name = !empty($array[$type_id]) ? $array[$type_id] : __a($default);
        return $name;
    }

    /**
     * Returns name of status by ID
     * @param $status_id
     * @param string $default
     * @return string
     */
    public static function getStatusName($status_id, $default = 'Unknown')
    {
        $array = self::statusListEx();
        $name = !empty($array[$status_id]) ? $array[$status_id] : __a($default);
        return $name;
    }
}