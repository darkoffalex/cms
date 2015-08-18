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
        $types = ContentTypeEx::model()->listAllItemsForForms(__a('No filtration'));

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

                    //clean filtration params filtration not selected
                    if(empty($item->filtrationByType)){
                        $item->filtration_array_json = null;
                    }

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
            Constants::WIDGET_TYPE_MENU => 'widget_edit_menu',
            Constants::WIDGET_TYPE_TEXT => 'widget_edit_text',
            Constants::WIDGET_TYPE_BREADCRUMBS => 'widget_edit_crumbs',
            Constants::WIDGET_TYPE_BLOCKS => 'widget_edit_blocks',
            Constants::WIDGET_TYPE_FILTER => 'widget_edit_filter'
        );

        //render form
        $this->render($editing_templates[$item->type_id],array(
                'model' => $item,
                'languages' => $languages,
                'templates' => $templates,
                'categories' => $categories,
                'types' => $types
            )
        );
    }

    /**
     * Edit filtration for block widget
     * @param $id
     * @throws CHttpException
     */
    public function actionEditFiltration($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $item = WidgetEx::model()->findByPk((int)$id);

        if(empty($item) || empty($item->filtrationByType)){
            throw new CHttpException(404);
        }

        $conditions = Yii::app()->request->getPost('ConditionsForm',array());
        if(!empty($conditions)){

            $filtrationArray = array();

            foreach($conditions as $fieldId => $params)
            {
                $field = ContentItemFieldEx::model()->findByPk($fieldId);
                if(!empty($field->field_type_id)){

                    $value = !empty($params['value']) ? $params['value'] : '';
                    $condition = !empty($params['condition']) ? $params['condition'] : '';

                    switch($field->field_type_id)
                    {
                        case Constants::FIELD_TYPE_NUMERIC:
                            $filtrationArray[$field->id] = array((int)$value,$condition);
                            break;
                        case Constants::FIELD_TYPE_PRICE:
                            $filtrationArray[$field->id] = array((int)(priceToCents($value)),$condition);
                            break;
                        case Constants::FIELD_TYPE_DATE:
                            $d = DateTime::createFromFormat('m/d/Y',$value);
                            $filtrationArray[$field->id] = array((int)$d->getTimestamp(),$condition);
                            break;
                        case Constants::FIELD_TYPE_BOOLEAN:
                            $filtrationArray[$field->id] = array(1,$condition);
                            break;
                    }
                }
            }

            $conditionString = json_encode($filtrationArray);
            $item->filtration_array_json = $conditionString;
            $item->updated_by_id = Yii::app()->user->id;
            $item->updated_time = time();
            $item->update();

            //success message
            Yii::app()->user->setFlash('success',__a('Success: All data saved'));
        }

        $this->render('widget_edit_blocks_filter',array('model' => $item));
    }

    /**
     * Settings for filter widget
     * @param $id
     * @throws CHttpException
     */
    public function actionFilterSettings($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //find widget item
        $item = WidgetEx::model()->findByPk((int)$id);

        //fail if not found
        if(empty($item) || empty($item->filtrationByType)){
            throw new CHttpException(404);
        }

        //get settings from request
        $settings = Yii::app()->getRequest()->getPost('FilterSettings',array());

        //if not empty settings
        if(!empty($settings)){

            //prepared array for storage
            $result = array();

            //for each field
            foreach($settings as $fieldId => $params){

                //get all settings
                $type = !empty($params['filter_type']) ? $params['filter_type'] : Constants::FILTER_CONDITION_EQUAL;
                $variants = !empty($params['variants']) ? reformatArray($params['variants']) : array();
                $intervals = !empty($params['intervals']) ? reformatArray($params['intervals']) : array();

                //prepare them
                $result[$fieldId]['type'] = $type;
                $result[$fieldId]['variants'] = !hasJustEmptyKeys($variants) ? $variants : array();
                $result[$fieldId]['intervals'] = !hasJustEmptyKeys($intervals) ? $intervals : array();
            }

            //convert to json
            $jsonEncodedResult = json_encode($result);

            //set to widget
            $item->filtration_array_json = $jsonEncodedResult;
            $item->update();
        }

        $this->render('widget_edit_filter_settings',array('model' => $item));
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

    /**
     * Delete position
     * @param $id
     */
    public function actionPositionDelete($id)
    {
        //delete by pk
        WidgetPositionEx::model()->deleteByPk((int)$id);

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
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

    /**
     * Register widget to specified position
     * @throws CHttpException
     */
    public function actionRegister()
    {
        //get widget and position id
        $widgetId = Yii::app()->request->getParam('wid_id',null);
        $positionId = Yii::app()->request->getParam('pos_id',null);

        //try find widget and position by id's
        $widget = WidgetEx::model()->findByPk((int)$widgetId);
        $position = WidgetPositionEx::model()->findByPk((int)$positionId);

        //if not found something - error
        if(empty($widget) || empty($position)){
            throw new CHttpException(404);
        }

        //new widget registration
        $registration = new WidgetRegistrationEx();
        $registration->widget_id = $widgetId;
        $registration->position_id = $positionId;
        $registration->priority = Sort::GetNextPriority('WidgetRegistrationEx',array('position_id' => $positionId));
        $registration->created_by_id = Yii::app()->user->id;
        $registration->updated_by_id = Yii::app()->user->id;
        $registration->created_time = time();
        $registration->updated_time = time();
        $registration->readonly = 0;
        $registration->save();

        //go back to previous page (list)
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Delete registration from position
     * @param $id
     */
    public function actionUnregister($id)
    {
        //delete by pk
        WidgetRegistrationEx::model()->deleteByPk((int)$id);

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Change registration order
     * @param $id
     * @param $dir
     * @throws CHttpException
     */
    public function actionMoveRegistered($id,$dir)
    {
        $reg = WidgetRegistrationEx::model()->findByPk((int)$id);

        if(empty($reg)){
            throw new CHttpException(404);
        }

        Sort::Move($reg,$dir,'WidgetRegistrationEx',array('position_id' => $reg->position_id));

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}