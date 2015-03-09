<?php

/**
 * Debug variable
 * @param $var
 * @param string $title
 */
function debug($var, $title = '')
{
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
        if( $title )
            echo "$title\n";
        print_r($var);
        $out = ob_get_clean();
        echo "<pre>";
        echo htmlentities($out);
        echo "</pre>";
    }
}

/**
 * Short equivalent of translation function
 * @param $label
 * @return mixed
 */
function __($label)
{
    return Translation::getInstance()->translate($label);
}

/**
 * Short equivalent of admin-translation function
 * @param $label
 * @return mixed
 */
function __a($label)
{
    return AdminTranslation::getInstance()->translate($label);
}

/**
 * Returns current language
 * @return string
 */
function __lng()
{
    return Yii::app()->language;
}