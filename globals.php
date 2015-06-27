<?php

const DS = DIRECTORY_SEPARATOR;

/**
 * Debug variable
 * @param $var
 * @param bool $return
 * @return string
 */
function debugvar($var, $return = false)
{
    $result = "";
    $arrIps = array(
        '127.0.0.1',
        '::1',
        '88.119.151.3'
    );

    //if current ip exist in available ips array
    if(in_array($_SERVER["REMOTE_ADDR"],$arrIps))
    {
        //debug
        ob_start();
        print_r($var);
        $out = ob_get_clean();

        if(!$return){
            echo "<pre>";
            echo htmlentities($out);
            echo "</pre>";
        }else{
            $result = "<pre>".htmlentities($out)."</pre>";
        }

    }

    return $result;
}


/**
 * Short equivalent of translation function
 * @param $label
 * @return mixed
 */
function __($label)
{
    return Trl::getInstance()->translate($label);
}

/**
 * Short equivalent of admin translation function
 * @param $label
 * @return string
 */
function __a($label)
{
    return ATrl::getInstance()->translate($label);
}

/**
 * Returns current language
 * @return string
 */
function __lng()
{
    return Yii::app()->language;
}


function centsToPrice($cents)
{
    return number_format(($cents / 100),2,'.','');
}

function PriceToCents($price)
{
    if(is_numeric($price))
    {
        $clean = floatval(str_replace(',','.',$price));

        return $clean * 100;
    }

    return 0;
}