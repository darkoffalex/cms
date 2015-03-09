<?php

class AdminTranslation
{
    protected static $_instance; //instance
    public $translations = array(); //translations loaded from xml
    public $languages = array('en','ru'); //languages

    private $xml_path = '/../translations/messages.xml'; //path to file

    /**
     * Returns instance of this class
     * @return AdminTranslation
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
     * Init object - get all translations
     */
    private function __construct()
    {
        $this->translations = $this->getAllFromXml();
    }

    /**
     * Singleton realization
     */
    private function __clone()
    {

    }

    /**
     * Returns all translations
     * @return array
     */
    public function getAllFromXml()
    {
        //final result array
        $translations_array = array();

        //translation-xml filename
        $xml_fnm = dirname(__FILE__).$this->xml_path;

        //if file exist
        if(file_exists($xml_fnm))
        {
            //read xml
            $xml = simplexml_load_file($xml_fnm);

            //foreach all 'block' element
            foreach($xml->block as $block)
            {
                //source-word
                $source = $block->source->__toString();
                //translations array
                $lng = array();
                //for every language in list
                foreach($this->languages as $lngName)
                {
                    //if isset this lng in xml-block - add to translation array
                    if(isset($block->$lngName)){$lng[$lngName] = $block->$lngName->__toString();}

                    //add to result-array
                    $translations_array[$source] = $lng;
                }
            }
        }

        return $translations_array;
    }

    /**
     * Translate
     * @param $source
     * @return mixed
     */
    public function translate($source)
    {
        //if isset in array that source-word
        if(isset($this->translations[$source]))
        {
            //get translation for it
            $translation = $this->translations[$source];
        }
        //if not
        else
        {
            //return source word
            return $source;
        }

        //if not exist translation for this language - return source
        if(!isset($translation[AdminLanguage::getInstance()->lng])){return $source;}

        //return translation
        return $translation[AdminLanguage::getInstance()->lng];
    }
}