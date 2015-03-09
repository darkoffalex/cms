<?php

class TranslationsLngEx extends  TranslationsLng
{

    /**
     * @param string $className
     * @return TranslationsLngEx
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Deletes language
     * @param $id
     */
    public function deleteByLanguageId($id)
    {
        $sql = "DELETE FROM translations_lng WHERE translations_lng.language_id = ".$id;
        $db = Yii::app()->getDb();
        $db -> createCommand($sql)->queryAll();
    }
}