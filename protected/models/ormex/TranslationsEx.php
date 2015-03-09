<?php

class TranslationsEx extends Translations
{


    /**
     * @param string $className
     * @return TranslationsEx
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns all translated labels by language
     * @param $language
     * @return array
     */
    public function getLabelsByLng($language)
    {
        $sql = "SELECT translations.label, translations_lng.value FROM translations JOIN translations_lng,
        languages WHERE translations_lng.translation_id = translations.id AND
        translations_lng.language_id = languages.id AND
        languages.prefix = '".$language."'";

        $connection = $this->getDbConnection();
        $data = $connection->createCommand($sql)->queryAll(true);

        return $data;
    }

    /**
     * Returns translation
     * @param $label
     * @param $language
     * @return mixed
     */
    public static function getFor($label,$language = null)
    {
        $return_val = $label;

        if($language == null)
        {
            $language = Yii::app()->language;
        }

        $connection = Yii::app()->getDb();

        $sql = "SELECT value FROM translations JOIN translations_lng, languages
        WHERE translations_lng.translation_id = translations.id AND
        translations_lng.language_id = languages.id AND languages.prefix = '".$language."'
        AND translations.label = '".$label."'";

        $data = $connection->createCommand($sql)->queryRow(true);

        if(!empty($data)){$return_val = $data['value'];}

        return $return_val;
    }

    /**
     * Returns translation for specified language
     * @param int $id
     * @return string
     */
    public function getByLngId($id)
    {
        $sql = "SELECT value FROM translations_lng WHERE translation_id = ".$this->id." AND language_id = ".$id;
        $connection = Yii::app()->getDb();
        $data = $connection->createCommand($sql)->queryRow(true);

        $return_val = "";

        if(!empty($data)){$return_val = $data['value'];}

        return $return_val;
    }

    /**
     * Deletes translations of all language-variants
     */
    public function deleteTranslations()
    {
        $sql = "DELETE FROM translations_lng WHERE translations_lng.translation_id = ".$this->id;
        $db = Yii::app()->getDb();
        $db -> createCommand($sql)->queryAll();
    }
}