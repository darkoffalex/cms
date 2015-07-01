<?php

class SettingsController extends ControllerAdmin
{
    /**
     * Main entry point
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/settings/edit'));
    }

    public function actionEdit()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');

        $categories = TreeEx::model()->listAllItemsForForms(0,'-',true,__a('None'));
        $settings = GlobalSettingsEx::model()->find();
        $themes = TemplateHelper::getThemesForListing(true,__a('Default'));

        if(empty($settings)){
            $settings = new GlobalSettingsEx();
        }

        $post = Yii::app()->request->getPost('GlobalSettingsEx',array());

        if(!empty($post)){
            $settings->attributes = $post;

            if($settings->validate()){
                $ok = $settings->isNewRecord ? $settings->save() : $settings->update();

                if($ok){
                    Yii::app()->user->setFlash('success',__a('Success: All data saved'));
                }else{
                    Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
                }
            }else{
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }
        }

        $this->render('edit', array('model' => $settings, 'categories' => $categories, 'themes' => $themes));
    }
}