<?php

class TypesController extends ControllerAdmin
{
    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/types/list'));
    }

    /**
     * Listing all types
     * @param int $page
     */
    public function actionList($page = 1)
    {
        //find all types
        $types = ContentTypeEx::model()->findAll();

        //how many show on one page
        $perPage = getif($this->global_settings->per_page_qnt,10);

        //paginated items
        $items = CPager::getInstance($types,$perPage,$page)->getPreparedArray();

        //render list
        $this->render('list_types',array('items' => $items));
    }

    /**
     * Adding new type
     */
    public function actionAddType()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //templates
        $templates = TemplateHelper::getStandardTemplates($this->global_settings->active_theme,'Item');

        //model
        $model = new ContentTypeEx();

        //get form params from request
        $formParams = Yii::app()->request->getPost('ContentTypeEx',null);

        //if got something from form
        if(!empty($formParams)){

            $model->attributes = $formParams;

            if($model->validate()){

                $model->created_time = time();
                $model->updated_time = time();
                $model->created_by_id = Yii::app()->user->id;
                $model->updated_by_id = Yii::app()->user->id;
                $model->save();

                $this->redirect(Yii::app()->createUrl('admin/types/list'));
            }

        }

        $this->render('add_type',array('model' => $model, 'templates' => $templates));
    }

    /**
     * Edit type
     * @param $id
     * @throws CHttpException
     */
    public function actionEditType($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $model = ContentTypeEx::model()->findByPk((int)$id);

        if(empty($model)){
            throw new CHttpException(404);
        }

        //templates
        $templates = TemplateHelper::getStandardTemplates($this->global_settings->active_theme,'Item');

        //get form params from request
        $formParams = Yii::app()->request->getPost('ContentTypeEx',null);

        //if got something from form
        if(!empty($formParams)){

            $model->attributes = $formParams;

            if($model->validate()){

                $model->updated_time = time();
                $model->updated_by_id = Yii::app()->user->id;
                $model->update();

                //success message
                Yii::app()->user->setFlash('success',__a('Success: All data saved'));
            }

        }

        $this->render('edit_type',array('model' => $model, 'templates' => $templates));
    }

    /**
     * Deleting type
     * @param $id
     */
    public function actionDeleteType($id)
    {
        //delete type
        ContentTypeEx::model()->deleteByPk((int)$id);

        //back to list
        $this->redirect(Yii::app()->createUrl('admin/types/list'));
    }

    /******************************************* F I E L D S *********************************************************/

    /**
     * Listing field of specified content type
     * @param $id
     * @throws CHttpException
     */
    public function actionFields($id)
    {
        //find content type
        $type = ContentTypeEx::model()->findByPk((int)$id);

        //404 - if not found
        if(empty($type)){
            throw new CHttpException(404);
        }

        $fields = $type->contentItemFields;

        //render list
        $this->render('list_fields',array('items' => $fields, 'type' => $type));
    }

    /**
     * Add field for specified content type
     * @param $id
     * @throws CHttpException
     */
    public function actionAddField($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //find content type
        $type = ContentTypeEx::model()->findByPk((int)$id);

        //404 - if not found
        if(empty($type)){
            throw new CHttpException(404);
        }

        //new field model
        $model = new ContentItemFieldEx();
        //list of field types
        $fieldTypes = Constants::fieldTypeList();
        //get all site languages
        $languages = Language::model()->findAll();
        //get form params from request
        $formParams = Yii::app()->request->getPost('ContentItemFieldEx',null);

        //if got something from post
        if(!empty($formParams)){

            $model->attributes = $formParams;

            if($model->validate()){

                //open transaction
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();

                try
                {
                    $model->content_type_id = $type->id;
                    $model->priority = Sort::GetNextPriority("ContentItemFieldEx",array('content_type_id' => $type->id));
                    $model->created_time = time();
                    $model->created_by_id = Yii::app()->user->id;
                    $model->updated_time = time();
                    $model->updated_by_id = Yii::app()->user->id;
                    $model->save();

                    //save translatable data
                    foreach($languages as $lng)
                    {
                        $name = getif($formParams['name'][$lng->id],'');
                        $description = getif($formParams['description'][$lng->id],'');

                        $trl = $model->getOrCreateTrl($lng->id);
                        $trl -> name = $name;
                        $trl -> description = $description;

                        if($trl->isNewRecord){
                            $trl->save();
                        }else{
                            $trl->update();
                        }
                    }

                    //apply changes
                    $transaction->commit();

                    //back to list
                    $this->redirect(Yii::app()->createUrl('admin/types/fields',array('id' => $type->id)));
                }
                catch(Exception $ex)
                {
                    //discard changes
                    $transaction->rollback();

                    //exit script and show error message
                    exit($ex->getMessage());
                }

            }
        }

        $this->render('add_field',array(
                'model' => $model,
                'fieldTypes' => $fieldTypes,
                'contentType' => $type,
                'languages' => $languages
            ));
    }

    /**
     * Edit field
     * @param $id
     * @throws CHttpException
     */
    public function actionEditField($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //find field
        $model = ContentItemFieldEx::model()->findByPk((int)$id);

        //404 - if not found
        if(empty($model)){
            throw new CHttpException(404);
        }

        //find content type
        $type = $model->contentType;
        //list of field types
        $fieldTypes = Constants::fieldTypeList();
        //get all site languages
        $languages = Language::model()->findAll();
        //get form params from request
        $formParams = Yii::app()->request->getPost('ContentItemFieldEx',null);

        //if got something from post
        if(!empty($formParams)){

            $model->attributes = $formParams;

            if($model->validate()){

                //open transaction
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();

                try
                {
                    $model->updated_time = time();
                    $model->updated_by_id = Yii::app()->user->id;
                    $model->update();

                    //save translatable data
                    foreach($languages as $lng)
                    {
                        $name = getif($formParams['name'][$lng->id],'');
                        $description = getif($formParams['description'][$lng->id],'');

                        $trl = $model->getOrCreateTrl($lng->id);
                        $trl -> name = $name;
                        $trl -> description = $description;

                        if($trl->isNewRecord){
                            $trl->save();
                        }else{
                            $trl->update();
                        }
                    }

                    //apply changes
                    $transaction->commit();

                    //success message
                    Yii::app()->user->setFlash('success',__a('Success: All data saved'));
                }
                catch(Exception $ex)
                {
                    //discard changes
                    $transaction->rollback();

                    //exit script and show error message
                    exit($ex->getMessage());
                }
            }else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }

        }

        $this->render('edit_field',array(
                'model' => $model,
                'fieldTypes' => $fieldTypes,
                'contentType' => $type,
                'languages' => $languages
            ));
    }


    /**
     * Delete field
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteField($id)
    {
        //find field
        $field = ContentItemFieldEx::model()->findByPk((int)$id);

        //404 - if not found
        if(empty($field)){
            throw new CHttpException(404);
        }
        //get ID of content type
        $contentTypeId = $field->content_type_id;

        //delete field
        $deleted = $field->delete();

        //back to list
        $this->redirect(Yii::app()->createUrl('admin/types/fields',array('id' => $contentTypeId)));
    }
}