<?php
class Lang extends CWidget {

    /**
     * Widget entry point
     */
    public function run(){
        $lng = Yii::app()->language;
        $languages = AdminModule::languages();

        $current = getif($languages[$lng],array('title' => '--'));

        $this->render('lang',array('current' => $current, 'menu' => AdminModule::languages()));
    }

}