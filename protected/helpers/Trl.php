<?php
/**
 * Class Trl
 * @property TranslationTrl[] $translations
 */
class Trl
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
        $this->translations = TranslationEx::model()->getTranslationsForLanguage(Yii::app()->language);
    }


    private function __clone()
    {

    }

    /**
     * Translates label, uses stored array
     * @param $label
     * @param string $noLabelMark
     * @return string
     */
    public function translate($label,$noLabelMark = '')
    {
        foreach($this->translations as $trl)
        {
            if($trl->translation->label == $label)
            {
                return $trl->value;
            }
        }

        return $noLabelMark.$label;
    }

    /**
     * Translates label directly from DB
     * @param $labelIn
     * @param string $noLabelMark
     * @param string $noTransMark
     * @return string
     */
    public function translateEx($labelIn,$noLabelMark = '',$noTransMark = '')
    {
        $label = TranslationEx::model()->findByAttributes(array('label' => $labelIn));
        if(!empty($label))
        {
            if(!empty($label->trl))
            {
                return $label->trl->value;
            }

            return $noTransMark.$labelIn;
        }

        return $noLabelMark.$labelIn;
    }

}