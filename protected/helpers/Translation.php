<?php

class Translation
{
    protected static $_instance;
    public $translations = array();

    public static function getInstance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
        $this->updateTranslationsFromDb();
    }

    public function updateTranslationsFromDb()
    {
        $translated = TranslationsEx::model()->getLabelsByLng(Yii::app()->language);
        foreach ($translated as $row) {
            $this->translations[$row['label']] = $row['value'];
        }
    }

    private function __clone()
    {

    }

    public function translate($label)
    {
        return isset($this->translations[$label]) ? $this->translations[$label] : $label;
    }

}