<?php
/**
 * Class ATrl
 * @property array $translations
 */
class ATrl
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
        //path to file
        $filename = __DIR__.DS.'..'.DS.'translations'.DS.'trl.xml';

        //xml array
        $xml = json_decode(json_encode((array) simplexml_load_file($filename)), 1);

        //get all translation blocks
        $trlArray = $xml['block'];

        //current language
        $lng = Yii::app()->language;

        //pass through all blocks
        foreach($trlArray as $index => $arr)
        {
            //if there more than one block in array (if block is only one - info directly contained in 'block' array)
            if(is_numeric($index))
            {
                if(!empty($arr['source']) && !empty($arr[$lng])){
                    $this->translations[$arr['source']] = $arr[$lng];
                }
            }
            //if there only one translation
            else
            {
                if(!empty($trlArray['source']) && !empty($trlArray[$lng])){
                    $this->translations[$trlArray['source']] = $trlArray[$lng];
                }
            }
        }
    }


    private function __clone()
    {

    }

    /**
     * Translates label for admin panel, uses stored array
     * @param $label
     * @param string $noLabelMark
     * @return string
     */
    public function translate($label,$noLabelMark = '')
    {
        if(array_key_exists($label,$this->translations)){
            return $noLabelMark.$this->translations[$label];
        }

        return $noLabelMark.$label;
    }

}