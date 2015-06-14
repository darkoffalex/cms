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
            self::FIELD_TYPE_TEXT => __a('Text'),
            self::FIELD_TYPE_TEXT_TRL  => __a('Translatable text'),
            self::FIELD_TYPE_DATE => __a('Date-Time'),
            self::FIELD_TYPE_IMAGE => __a('Image'),
            self::FIELD_TYPE_FILE => __a('File'),
            self::FIELD_TYPE_BOOLEAN  => __a('Checkbox'),
        );
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
        $name = getif($array[$type_id],__a($default));
        return $name;
    }
}