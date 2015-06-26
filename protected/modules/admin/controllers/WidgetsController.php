<?php

class WidgetsController extends ControllerAdmin
{
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/widgets/menus'));
    }

    /**
     * List all menus
     */
    public function actionMenus()
    {
        $menu = MenuEx::model()->findAll();
        $this->render('menus_list',array('items' => $menu));
    }

    /**
     * Add new menu
     */
    public function actionMenuAdd()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $menu = new MenuEx();
        $languages = Language::model()->findAll(array('order' => 'priority ASC'));

        $theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;
        $templates = TemplateHelper::getStandardTemplates($theme,'Menu','widgets');
        $categories = TreeEx::model()->listAllItemsForForms(0,'-');

        $form = Yii::app()->request->getPost('MenuEx',null);

        //if form
        if(!empty($form)){

            $menu->attributes = $form;
            $nameTrl = !empty($form['name']) ? $form['name'] : array();
            $descriptionTrl = !empty($form['description']) ? $form['description'] : array();

            if($menu->validate()){

                $transaction = Yii::app()->db->beginTransaction();

                try
                {
                    $menu->created_by_id = Yii::app()->user->id;
                    $menu->updated_by_id = Yii::app()->user->id;
                    $menu->created_time = time();
                    $menu->updated_time = time();
                    $menu->readonly = 0;
                    $ok = $menu->save();

                    if($ok)
                    {
                        foreach($languages as $lng)
                        {
                            $name = !empty($nameTrl[$lng->id]) ? $nameTrl[$lng->id] : '';
                            $description =  !empty($descriptionTrl[$lng->id]) ? $descriptionTrl[$lng->id] : '';
                            $trl = $menu->getOrCreateTrl($lng->id);

                            $trl->name = $name;
                            $trl->description = $description;

                            $ok = $trl->isNewRecord ? $trl->save() : $trl->update();
                        }
                    }


                    $transaction->commit();

                    //redirect to list
                    $this->redirect(Yii::app()->createUrl('admin/widgets/menus'));
                }
                catch(Exception $ex)
                {
                    $transaction->rollback();
                    exit($ex->getMessage());
                }
            }
        }

        $this->render('menus_edit',array('model' => $menu, 'languages' => $languages, 'templates' => $templates, 'categories' => $categories));
    }

    /**
     * Edit menu
     * @param $id
     * @throws CHttpException
     */
    public function actionMenuEdit($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $menu = MenuEx::model()->findByPk((int)$id);

        if(empty($menu)){
            throw new CHttpException(404);
        }

        $languages = Language::model()->findAll(array('order' => 'priority ASC'));

        $theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;
        $templates = TemplateHelper::getStandardTemplates($theme,'Menu','widgets');
        $categories = TreeEx::model()->listAllItemsForForms(0,'-');

        $form = Yii::app()->request->getPost('MenuEx',null);

        //if form
        if(!empty($form)){

            $menu->attributes = $form;
            $nameTrl = !empty($form['name']) ? $form['name'] : array();
            $descriptionTrl = !empty($form['description']) ? $form['description'] : array();

            if($menu->validate()){

                $transaction = Yii::app()->db->beginTransaction();

                try
                {
                    $menu->updated_by_id = Yii::app()->user->id;
                    $menu->updated_time = time();
                    $menu->readonly = 0;
                    $ok = $menu->update();

                    if($ok)
                    {
                        foreach($languages as $lng)
                        {
                            $name = !empty($nameTrl[$lng->id]) ? $nameTrl[$lng->id] : '';
                            $description =  !empty($descriptionTrl[$lng->id]) ? $descriptionTrl[$lng->id] : '';
                            $trl = $menu->getOrCreateTrl($lng->id);

                            $trl->name = $name;
                            $trl->description = $description;

                            $ok = $trl->isNewRecord ? $trl->save() : $trl->update();
                        }
                    }

                    $transaction->commit();

                    //success message
                    Yii::app()->user->setFlash('success',__a('Success: All data saved'));
                }
                catch(Exception $ex)
                {
                    $transaction->rollback();
                    exit($ex->getMessage());
                }
            }else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }
        }

        $this->render('menus_edit',array('model' => $menu, 'languages' => $languages, 'templates' => $templates, 'categories' => $categories));
    }

    /**
     * Delete menu
     * @param $id
     */
    public function actionMenuDelete($id)
    {
        //delete by pk
        MenuEx::model()->deleteByPk($id);

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}