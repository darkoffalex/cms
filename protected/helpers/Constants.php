<?php
class Constants
{
    //files
    const UPLOAD_IMAGE_FILE_SIZE = 4000000;
    const UPLOAD_COMMON_FILE_SIZE =  9000000;
    const UPLOAD_VALIDATE_IMAGE_TYPES = 'jpg, gif, png';
    const UPLOAD_VALIDATE_COMMON_TYPES = 'swf, pdf, txt, zip, mp3, jpg, gif, png, pdf, wav, avi, doc, xls';

    //admin panel pagination stuff
    const PER_PAGE = 10;
    const IMAGE_LIMIT = 5;

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
    const FIELD_TYPE_LINKED_BLOCK = 9;

    //widget types
    const WIDGET_TYPE_MENU = 1;
    const WIDGET_TYPE_BREADCRUMBS = 2;
    const WIDGET_TYPE_BLOCKS = 4;
    const WIDGET_TYPE_FILTER = 5;
    const WIDGET_TYPE_TEXT = 6;

    //filter conditions
    const FILTER_CONDITION_IGNORE = 0;
    const FILTER_CONDITION_SET = 1;
    const FILTER_CONDITION_UNSET = 2;
    const FILTER_CONDITION_MORE = 3;
    const FILTER_CONDITION_LESS = 4;
    const FILTER_CONDITION_EQUAL = 5;
    const FILTER_CONDITION_BETWEEN = 6;

    //client types
    const SHOP_CLIENT_PHYSICAL = 1;
    const SHOP_CLIENT_JURIDICAL = 2;


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
     * Returns list of statuses for users
     * @return array
     */
    public static function statusListForUsers()
    {
        return array(
            self::STATUS_VISIBLE => __a('Active'),
            self::STATUS_HIDDEN => __a('Inactive'),
            self::STATUS_SUSPENDED => __a('Suspended'),
        );
    }

    /**
     * Client types
     * @return array
     */
    public static function shopCliTypes()
    {
        return array(
            self::SHOP_CLIENT_PHYSICAL => __a('Physical'),
            self::SHOP_CLIENT_JURIDICAL => __a('Juridical')
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
            self::FIELD_TYPE_LINKED_BLOCK => __a('Linked block')
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


    /**
     * Admin-Panel action maps - used to build permission array for roles. In role you can manage access to every action
     * @return array
     */
    public static function adminActionMap()
    {
        $map = array(

            'statistics' => array(
                'Statistics',
                array(
                    'index' => 'See'
                )
            ),

            'categories' => array(
                'Categories',
                array(
                    'list' => 'See',
                    'edit' => 'Edit',
                    'delete' => 'Delete',
                    'add' => 'Add'
                )
            ),

            'blocks' => array(
                'Content',
                array(
                    'list' => 'See',
                    'add' => 'Add',
                    'edit' => 'Edit',
                    'delete' => 'Delete',
                )
            ),

            'types' => array(
                'Content types',
                array(
                    'list' => 'See types',
                    'edittype' => 'Edit types',
                    'deletetype' => 'Delete types',
                    'addtype' => 'Add types',
                    'fields' => 'See fields',
                    'addfield' => 'Add fields',
                    'editfield' => 'Edit fields',
                    'deletefield' => 'Delete fields',
                )
            ),

            'widgets' => array(
                'Widgets',
                array(
                    'list' => 'See widgets',
                    'edit' => 'Edit widgets',
                    'delete' => 'Delete widgets',
                    'add' => 'Add widgets',
                    'positions' => 'See positions',
                    'positionedit' => 'Edit positions',
                    'positiondelete' => 'Delete positions',
                    'positionadd' => 'Add positions',
                    'registration' => 'See registrations',
                    'register' => 'Register widgets',
                    'unregister' => 'Unregister widgets',
                    'moveregistered' => 'Ordering in positions'
                )
            ),

            'languages' => array(
                'Languages',
                array(
                    'list' => 'See languages',
                    'add' => 'Add languages',
                    'edit' => 'Edit languages',
                    'delete' => 'Delete languages',
                    'move' => 'Ordering languages'
                )
            ),

            'translations' => array(
                'Translations',
                array(
                    'list' => 'See translations',
                    'add' => 'Add translations',
                    'delete' => 'Delete translations',
                    'update' => 'Update translations',
                )
            ),

            'users' => array(
                'Users',
                array(
                    'list' => 'See users',
                    'edit' => 'Edit users',
                    'delete' => 'Delete users',
                    'add' => 'Add users',
                    'roles' => 'See roles',
                    'addrole' => 'Add roles',
                    'editrole' => 'Edit roles',
                    'deleterole' => 'Delete roles',
                )
            ),

            'settings' => array(
                'Settings',
                array(
                    'edit' => 'Manage settings'
                )
            ),

        );

        return $map;
    }
}