<?php

class MainController extends ControllerAdmin
{
    /**
     * Main entry point to admin panel
     */
    public function actionIndex()
	{
        //send user to statistics page
        $this->redirect(Yii::app()->createUrl('admin/statistics/index'));
	}

    /**
     * Login action
     */
    public function actionLogin()
    {
        //switch to login layout
        $this->layout = '/layouts/login';

        //if user logged in
        if(!Yii::app()->user->isGuest)
        {
            //not show login form to them - just redirect him to index
            $this->redirect(Yii::app()->urlManager->createUrl('/admin/main/index'));
        }

        //login form validation model
        $form = new LoginForm();

        //if got post from form
        if(!empty($_POST['LoginForm']))
        {
            //get attributes
            $form->attributes = $_POST['LoginForm'];

            //if data valid and logged in
            if($form->validate() && $form->login())
            {
                //send user to index
                $this->redirect(Yii::app()->urlManager->createUrl('/admin/main/index'));
            }
        }

        //render form
        $this->render('login',array('form_mdl' => $form));
    }

    /**
     * Logout action
     */
    public function actionLogout()
    {
        Yii::app()->user->logout(false);
        $this->redirect(Yii::app()->urlManager->createUrl('/admin/main/login'));
    }
}