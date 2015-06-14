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

    public function actionFields($id)
    {
        $type = ContentTypeEx::model()->findByPk((int)$id);

        if(empty($type)){
            throw new CHttpException(404);
        }

        $fields = $type->contentItemFields;

        //render list
        $this->render('list_fields',array('items' => $fields, 'type' => $type));
    }
}