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

    public static function adminPermissionMap()
    {
        $map = [
            'statistics' => [
                'title' => __a('Statistics'),
                'access' => null,
                'actions' => [
                    'index' => ['title' => __a('See'), 'access' => null],
                ],
            ],

            'categories' => [
                'title' => __a('Categories'),
                'access' => null,
                'actions' => [
                    'list' => ['title' => __a('See'), 'access' => null],
                    'edit' => ['title' => __a('Edit'), 'access' => null],
                    'delete' => ['title' => __a('Delete'), 'access' => null],
                    'add' => ['title' => __a('Add'), 'access' => null]
                ],
            ],

            'blocks' => [
                'title' => __a('Content'),
                'access' => null,
                'actions' => [
                    'list' => ['title' => __a('See'), 'access' => null],
                    'add' => ['title' => __a('Add'), 'access' => null],
                    'edit' => ['title' => __a('Edit'), 'access' => null],
                    'delete' => ['title' => __a('Delete'), 'access'=> null]
                ],
            ],

            'types' => [
                'title' => __a('Content types'),
                'access' => null,
                'actions' => [
                    'list' => ['title' => __a('See'), 'access' => null],
                    'edittype' => ['title' => __a('Edit type'), 'access' => null],
                    'deletetype' => ['title' => __a('Delete type'), 'access' => null],
                    'addtype' => ['title' => __a('Add type'), 'access' => null],
                    'fields' => ['title' => __a('List fields'), 'access' => null],
                    'addfield' => ['title' => __a('Add fields'), 'access' => null],
                    'editfield' => ['title' => __a('Edit fields'), 'access' => null],
                    'deletefield' => ['title' => __a('Delete fields'), 'access' => null]
                ],
            ],

            'widgets' => [
                'title' => __a('Widgets'),
                'access' => null,
                'actions' => [
                    'list' => ['title' => __a('See'), 'access' => null],
                    'edit' => ['title' => __a('Edit'), 'access' => null],
                    'delete' => ['title' => __a('Delete'), 'access' => null],
                    'add' => ['title' => __a('Add'), 'access' => null],
                    'positions' => ['title' => __a('See positions'), 'access' => null],
                    'positionedit' => ['title' => __a('Edit positions'), 'access' => null],
                    'positiondelete' => ['title' => __a('Delete positions'), 'access' => null],
                    'positionadd' => ['title' => __a('Add positions'), 'access' => null],
                    'registration' => ['title' => __a('See registrations'), 'access' => null],
                    'register' => ['title' => __a('Register'), 'access' => null],
                    'unregister' => ['title' => __a('Unregister'), 'access' => null],
                    'moveregistered' => ['title' => __a('Ordering'), 'access' => null]
                ],
            ],

            'languages' => [
                'title' => __a('Languages'),
                'access' => null,
                'actions' => [
                    'list' => ['title' => __a('See'), 'access' => null],
                    'add' => ['title' => __a('Add'), 'access' => null],
                    'edit' => ['title' => __a('Edit'), 'access' => null],
                    'delete' => ['title' => __a('Delete'), 'access' => null],
                    'move' => ['title' => __a('Ordering'), 'access' => null]
                ],
            ],

            'translations' => [
                'title' => __a('Translations'),
                'access' => null,
                'actions' => [
                    'list' => ['title' => __a('See'), 'access' => null]
                ]
            ],

            'users' => [
                'title' => __a('Users'),
                'access' => null,
                'actions' => [
                    'list' => ['title' => __a('See'), 'access' => null],
                ]
            ],


            //TODO: continue build accessions map...
        ];
    }

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
}