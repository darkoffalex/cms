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

        echo DynamicWidget::getInstance()->render('Banner',true);
        exit();

        $this->renderText("Hello world!");
    }
}