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

        __widgets('Filter');

        debugvar(Yii::app()->session['filtration']);

        $this->renderText("Hello world!");
    }
}