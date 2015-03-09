<?php

class AdminControllersMenu extends CWidget {

    //current controller name
    public $current;

    /**
     * Widget entry point
     */
    public function run(){
        //render top menu widget
        $this->render('adminControllersMenu',array('current_controller' => $this->current, 'menu' => AdminModule::$menu));
    }

}