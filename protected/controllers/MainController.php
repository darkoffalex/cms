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

        $this->renderText("Hello world!");
    }
}