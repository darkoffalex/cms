<?php

class WidgetsController extends ControllerAdmin
{
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/widgets/list'));
    }

    /********************************************** W I D G E T S ******************************************************/

    /**
     * List & Add widgets
     */
    public function actionList()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.lightbox.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.labels.js',CClientScript::POS_END);
        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery.js' => false);

        $model = new WidgetEx();

        if(Yii::app()->request->isAjaxRequest){
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-form')
                {
                    echo CActiveForm::validate($model);
                }
                Yii::app()->end();
            }
        }else{
            //if have form
            if(isset($_POST['WidgetEx']))
            {
                $model->attributes = $_POST['WidgetEx'];

                if($model->validate())
                {
                    $model->created_by_id = Yii::app()->user->id;
                    $model->created_time = time();
                    $model->updated_by_id = Yii::app()->user->id;
                    $model->updated_time = time();
                    $model->readonly = 0;
                    $model->save();
                }
            }
        }

        $types = Constants::widgetTypeList();
        $widgets = WidgetEx::model()->findAll();
        $this->render('widget_list',array('items' => $widgets, 'types' => $types, 'model' => $model));
    }

    /**
     * Delete widget
     * @param int $id
     */
    public function actionDelete($id)
    {
        //delete by pk
        WidgetEx::model()->deleteByPk($id);

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }


    /**
     * Edit widget
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $item = WidgetEx::model()->findByPk((int)$id);

        if(empty($item)){
            throw new CHttpException(404);
        }

        $languages = Language::model()->findAll(array('order' => 'priority ASC'));

        $theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;
        $templates = TemplateHelper::getStandardTemplates($theme,Constants::widTplType($item->type_id),'widgets');

        $categories = TreeEx::model()->listAllItemsForForms(0,'-');
        $form = Yii::app()->request->getPost('WidgetEx',null);

        //if form
        if(!empty($form)){

            $item->attributes = $form;
            $nameTrl = !empty($form['title']) ? $form['title'] : array();
            $descriptionTrl = !empty($form['custom_content']) ? $form['custom_content'] : array();

            if($item->validate()){

                $transaction = Yii::app()->db->beginTransaction();

                try
                {
                    $item->updated_by_id = Yii::app()->user->id;
                    $item->updated_time = time();
                    $item->readonly = 0;
                    $ok = $item->update();

                    if($ok && !empty($nameTrl) && !empty($descriptionTrl))
                    {
                        foreach($languages as $lng)
                        {
                            $name = !empty($nameTrl[$lng->id]) ? $nameTrl[$lng->id] : '';
                            $description =  !empty($descriptionTrl[$lng->id]) ? $descriptionTrl[$lng->id] : '';
                            $trl = $item->getOrCreateTrl($lng->id);

                            $trl->title = $name;
                            $trl->custom_content = $description;

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

        //each type of widget have own edit-form template
        $editing_templates = array(
            Constants::WIDGET_TYPE_MENU => 'widget_menu_edit',
            Constants::WIDGET_TYPE_TEXT => 'widget_text_edit',
            Constants::WIDGET_TYPE_BLOCK => 'widget_block_edit',
            Constants::WIDGET_TYPE_BREADCRUMBS => 'widget_breadcrumbs_edit',
            Constants::WIDGET_TYPE_BLOCKS => 'widget_blocks_edit',
            Constants::WIDGET_TYPE_FILTER => 'widget_filter_edit'
        );

        //render form
        $this->render($editing_templates[$item->type_id],array(
                'model' => $item,
                'languages' => $languages,
                'templates' => $templates,
                'categories' => $categories)
        );
    }

    /******************************************** P O S I T I O N S ****************************************************/

    /**
     * List all positions
     */
    public function actionPositions()
    {
        $positions = WidgetPositionEx::model()->findAll();
        $this->render('positions_list',array('items' => $positions));
    }

    /**
     * Adding new position
     */
    public function actionPositionAdd()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $position = new WidgetPositionEx();
        $statuses = Constants::statusList();
        $form = Yii::app()->request->getParam('WidgetPositionEx',null);

        if(!empty($form)){

            $position->attributes = $form;

            if($position->validate()){
                $position->updated_time = time();
                $position->created_time = time();
                $position->updated_by_id = Yii::app()->user->id;
                $position->created_by_id = Yii::app()->user->id;
                $position->save();


                $this->redirect(Yii::app()->createUrl('admin/widgets/positions'));
            }
        }

        $this->render('positions_edit',array('model' => $position, 'statuses' => $statuses));
    }

    /**
     * Editing position
     * @param $id
     * @throws CHttpException
     */
    public function actionPositionEdit($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $position = WidgetPositionEx::model()->findByPk((int)$id);

        if(empty($position)){
            throw new CHttpException(404);
        }

        $statuses = Constants::statusList();
        $form = Yii::app()->request->getParam('WidgetPositionEx',null);

        if(!empty($form)){

            $position->attributes = $form;

            if($position->validate()){
                $position->updated_time = time();
                $position->updated_by_id = Yii::app()->user->id;
                $position->save();

                //success message
                Yii::app()->user->setFlash('success',__a('Success: All data saved'));
            }else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }
        }

        $this->render('positions_edit',array('model' => $position, 'statuses' => $statuses));
    }

    /**************************************** R E G I S T R A T I O N S ************************************************/

    /**
     * List all registered widgets for every position
     */
    public function actionRegistration()
    {
        $positions = WidgetPositionEx::model()->findAll();
        $this->render('register_list',array('positions' => $positions));
    }

    public function actionRegister()
    {
        if(Yii::app()->request->isPostRequest){

        }else{
            throw new CHttpException(404);
        }
        debugvar($_POST);
        exit();
    }
}