<?php

class TemplateHelper
{

    /**
     * Returns meta-vars defined in file comments (stolen from "WordPress")
     * @param $file
     * @param $default_headers
     * @return array
     */
    public static function getFileData($file, $default_headers)
    {
        //to avoid errors if file not exist
        if(!file_exists($file)){
            return array();
        }

        $fp = fopen($file, 'r');

        // Pull only the first 4kiB of the file in.
        $file_data = fread($fp, 4096);

        // PHP will close file handle, but we are good citizens.
        fclose($fp);

        // Make sure we catch CR-only line endings.
        $file_data = str_replace( "\r", "\n", $file_data );

        $all_headers = $default_headers;

        foreach($all_headers as $field => $regex){
            if (preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
                $all_headers[ $field ] =  $match[1];
            else
                $all_headers[ $field ] = '';
        }

        return $all_headers;
    }


    /**
     * List all templates in specified directory (default - pages)
     * @param $themeName
     * @param string $type
     * @param string $directory
     * @return array
     */
    public static function getStandardTemplates($themeName, $type = 'Page', $directory = 'pages')
    {
        $keys = array('type' => 'TemplateType','name' => 'TemplateName');
        $templates = array('' => __a('None'));

        //get theme by name
        $theme = Yii::app()->getThemeManager()->getTheme($themeName);

        //if theme is correct
        if(!empty($themeName) && !empty($theme)){
            //get template directory in theme
            $dir = Yii::app()->themeManager->basePath.DS.$themeName.DS.'views'.DS.$directory;
        }else{
            //get template directory in application 'protected' folder
            $dir = Yii::app()->basePath.DS.'views'.DS.$directory;
        }

        //if directory exist
        if(is_dir($dir)){

            //get list of all files
            $files = scandir($dir);


            foreach($files as $filename){
                if($filename != '..' && $filename != '.'){

                    //get full path to template
                    $path = $dir.DS.$filename;

                    //if file exist
                    if(file_exists($path)){

                        //get info
                        $info = self::getFileData($path,$keys);

                        //if has correct type
                        if(!empty($info['type']) && $info['type'] == $type){
                            //store in array filename without extension
                            $name_w_extension = str_replace('.php','',$filename);
                            $templates[$name_w_extension] = !empty($info['name']) ? $info['name'] : $filename;
                        }
                    }
                }
            }

        }

        return $templates;
    }

    /**
     * Returns array of themes
     * @param bool $appendNone
     * @param string $defaultName
     * @return array
     */
    public static function getThemesForListing($appendNone = false, $defaultName = 'None')
    {
        $themeNames = Yii::app()->getThemeManager()->getThemeNames();
        $themeList = array();

        if($appendNone){
            $themeList[''] = $defaultName;
        }

        foreach($themeNames as $index => $name){

            //TODO: perform theme validation
            $themeList[$name] = $name;
        }

        return $themeList;
    }
}