<?php

class MainController extends Controller
{
    /**
     * Entry
     */
    public function actionIndex()
    {
        $this->title = "Site";
        $this->description = "Index";

        /* @var $items ContentItemEx[] */

        $items = ContentItemEx::model()->findAll();
        $conditions = !empty(Yii::app()->session['filtration']) ? Yii::app()->session['filtration'] : array();
        $result = Filtration::complexDynamicFiltrate($items,$conditions);

        __widgets('Filter');

        foreach($result as $item){
            debugvar($item->label);
        }

        $this->renderText("Hello world!");
    }
}