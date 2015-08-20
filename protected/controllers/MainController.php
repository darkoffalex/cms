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

        $this->renderText("Hello world!");
    }
}