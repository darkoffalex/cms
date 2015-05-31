<?php

const DS = DIRECTORY_SEPARATOR;

/**
 * Debug variable
 * @param $var
 * @param string $title
 */
function debugvar($var, $title = '')
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

/**
 * Returns expression value - if it's not empty, or returns default value
 * @param $expression
 * @param null $default
 * @return null
 */
function getif($expression, $default = null)
{
    return !empty($expression) ? $expression : $default;
}