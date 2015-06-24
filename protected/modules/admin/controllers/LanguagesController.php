<?php

class LanguagesController extends ControllerAdmin
{
    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/languages/list'));
    }

    /**
     * Render list of languages
     */
    public function actionList()
    {
        $languages = Language::model()->findAll(array('order' => 'priority ASC'));
        $this->render('list',array('items' => $languages));
    }

    /**
     * Change language's order
     * @param $id
     * @param $dir
     * @throws CHttpException
     */
    public function actionMove($id, $dir)
    {
        //get language
        $language = Language::model()->findByPk((int)$id);

        //if not found or wrong params
        if(empty($language) || empty($dir)){
            throw new CHttpException(404);
        }

        //move
        Sort::Move($language,$dir,'Language');

        //back to list
        $this->redirect(Yii::app()->createUrl('admin/languages/list'));
    }

    /**
     * Add new language
     */
    public function actionAdd()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //new language model
        $language = new Language();
        $form = Yii::app()->request->getPost('Language', null);
        $statuses = Constants::statusList();

        if(!empty($form)){
            $language->attributes = $form;

            if($language->validate()){
                $language->priority = Sort::GetNextPriority('Language');
                $language->save();

                $this->redirect(Yii::app()->createUrl('admin/languages/list'));
            }
        }

        $this->render('edit',array('model' => $language, 'statuses' => $statuses));
    }

    /**
     * Edit language's info
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //get language
        $language = Language::model()->findByPk((int)$id);
        $form = Yii::app()->request->getPost('Language', null);
        $statuses = Constants::statusList();

        //if not found or wrong params
        if(empty($language)){
            throw new CHttpException(404);
        }

        if(!empty($form)){
            $language->attributes = $form;

            if($language->validate()){
                $language->update();

                //success message
                Yii::app()->user->setFlash('success',__a('Success: All data saved'));
            }
        }

        $this->render('edit',array('model' => $language, 'statuses' => $statuses));
    }

    /**
     * Delete language
     * @param $id
     */
    public function actionDelete($id)
    {
        //delete by id
        Language::model()->deleteByPk((int)$id);

        //back to list
        $this->redirect(Yii::app()->createUrl('admin/languages/list'));
    }
}