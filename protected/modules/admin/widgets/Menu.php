<?php
class Menu extends CWidget {

    /**
     * Widget entry point
     */
    public function run(){
        $cur_controller = Yii::app()->controller->id;
        $cur_action = Yii::app()->controller->action->id;

        $this->render('menu',array('cur_controller' => $cur_controller, 'cur_action' => $cur_action, 'menu' => AdminModule::menu()));
    }

}