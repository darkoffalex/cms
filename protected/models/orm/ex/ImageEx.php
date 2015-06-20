<?php
/**
 * Class FileEx
 * @property ImageOfTreeEx[] $imageOfTrees
 * @property ImageOfValueEx[] $imageOfValues
 * @property ImageTrl $trl
 */
class ImageEx extends Image
{
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns URL to cached file (caches - if not already cached)
     * @param int $w
     * @param int $h
     * @param bool $fit
     * @return string
     */
    public function getCachedUrl($w = 0,$h = 0,$fit = false)
    {
        return ImageCache::getCachedUrl($this->filename,$w,$h,$fit);
    }

    /**
     * Returns path to cached file (caches - if not already cached)
     * @param int $w
     * @param int $h
     * @param bool $fit
     * @return string
     */
    public function getCachedPath($w = 0,$h = 0,$fit = false)
    {
        return ImageCache::getCachedPath($this->filename,$w,$h,$fit);
    }

    /**
     * Returns full path to image file
     * @return string
     */
    public function getLocalPath()
    {
        $path = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'images'.DS.$this->filename;
        return $path;
    }

    /**
     * Delete file
     * @return bool
     */
    public function deleteFile()
    {
        try
        {
            unlink($this->getLocalPath());
            return true;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    /**
     * Override, relate with extended models
     * @return array relational rules.
     */
    public function relations()
    {
        //get all relations from base class
        $relations = parent::relations();

        //pass through all
        foreach($relations as $name => $relation)
        {
            //if found extended file for this related class
            if(file_exists(dirname(__FILE__).DS.$relation[1].'Ex.php'))
            {
                $relations[$name][1] = $relation[1].'Ex';
            }
        }

        //relate with translation
        $lng = Yii::app()->language;
        $relations['trl'] = array(self::HAS_ONE, 'ImageTrl', 'image_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}