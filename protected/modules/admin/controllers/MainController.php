<?php

class MainController extends ControllerAdmin
{
	public function actionIndex()
	{
        $this->renderText('index');
	}

    /**
     * Login action
     */
    public function actionLogin()
    {
        if(!Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->urlManager->createUrl('/admin/main/index'));
        }

        $form = new LoginForm();

        if($_POST['LoginForm'])
        {
            $form->attributes = $_POST['LoginForm'];

            if($form->validate() && $form->login())
            {
                $this->redirect(Yii::app()->urlManager->createUrl('/admin/main/index'));
            }
        }

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