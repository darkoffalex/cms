<?php

class CategoriesController extends ControllerAdmin
{
    /**
     * Main entry point
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/categories/list'));
    }

    /**
     * List all categories
     */
    public function actionList($parent = 0)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.main-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.main-menu.js',CClientScript::POS_END);

        //get all categories recursively sorted and grouped into roots
        $roots = TreeEx::model()->getChildrenRecursiveGrouped(0);

        //if this is ajax (used for quick table refresh) - render just table partial, else - render full template
        if(!Yii::app()->request->isAjaxRequest){
            $this->render('list',array('roots' => $roots, 'parent' => $parent));
        }else{
            $this->renderPartial('_list',array('roots' => $roots, 'parent' => $parent));
        }
    }

    /**
     * Changing sequence with drag-n-drop
     */
    public function actionReorder()
    {
        $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['old'];
        $new = $orders['new'];

        Sort::ReorderItems("TreeEx",$previous,$new);

        echo "OK";
        Yii::app()->end();
    }

    /**
     * Moves priority
     * @param $id
     * @param $dir
     * @throws CHttpException
     */
    public function actionMove($id,$dir)
    {
        $category = TreeEx::model()->findByPk((int)$id);

        if(empty($category)){
            throw new CHttpException(404);
        }

        Sort::Move($category,$dir,'TreeEx',array('parent_id' => $category->parent_id));

        if(Yii::app()->request->isAjaxRequest){
            echo "OK";
            Yii::app()->end();
        }else{
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    /**
     * Deletes category
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        $category = TreeEx::model()->findByPk((int)$id);

        if(empty($category)){
            throw new CHttpException(404);
        }

        $category->recursiveDelete();

        if(Yii::app()->request->isAjaxRequest){
            echo "OK";
            Yii::app()->end();
        }else{
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    /**
     * Adding a category
     */
    public function actionAdd()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //get all site languages
        $languages = Language::model()->findAll();

        //get all available parent items
        $parents = TreeEx::model()->listAllItemsForForms(0,'-',true,__a('None'));

        //get statuses
        $statuses = Constants::statusList();

        //templates
        $theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;
        $templates = TemplateHelper::getStandardTemplates($theme);
        $item_templates = TemplateHelper::getStandardTemplates($theme,'Item');

        //model
        $model = new TreeEx();

        //get form params from request
        $formParams = Yii::app()->request->getPost('TreeEx',null);

        //if got something from form
        if(!empty($formParams)){
            $model->attributes = $formParams;

            if($model->validate()){

                //open transaction
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();

                try
                {
                    //set main params and sav
                    $model->created_by_id = Yii::app()->user->id;
                    $model->updated_by_id = Yii::app()->user->id;
                    $model->created_time = time();
                    $model->updated_time = time();
                    $model->status_id = Constants::STATUS_VISIBLE;
                    $model->readonly = 0;
                    $model->priority = Sort::GetNextPriority('TreeEx',array('parent_id' => $model->parent_id));
                    $model->save();

                    //set branch and update
                    $model->branch = $model->findBranch(true);
                    $model->update();

                    //save translatable data
                    foreach($languages as $lng)
                    {
                        $name = !empty($formParams['name']) ? $formParams['name'] : '';
                        $description = !empty($formParams['description'][$lng->id]) ? $formParams['description'][$lng->id] : '';
                        $text = !empty($formParams['text'][$lng->id]) ? $formParams['text'][$lng->id] : '';
                        $meta_title = !empty($formParams['meta_title'][$lng->id]) ? $formParams['meta_title'][$lng->id] : '';
                        $meta_keywords = !empty($formParams['meta_keywords'][$lng->id]) ? $formParams['meta_keywords'][$lng->id] : '';

                        $trl = $model->getOrCreateTrl($lng->id,true);
                        $trl->name = $name;
                        $trl->description = $description;
                        $trl->text = $text;
                        $trl->meta_title = $meta_title;
                        $trl->meta_keywords = $meta_keywords;

                        if($trl->isNewRecord){
                            $trl->save();
                        }else{
                            $trl->update();
                        }
                    }

                    //apply changes
                    $transaction->commit();

                    //redirect to list
                    $this->redirect(Yii::app()->createUrl('admin/categories/list'));
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


        //render form
        $this->render('add',array(
            'languages' => $languages,
            'parents' => $parents,
            'statuses' => $statuses,
            'model' => $model,
            'templates' => $templates,
            'item_templates' => $item_templates
        ));
    }


    /**
     * Editing category
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //get all site languages
        $languages = Language::model()->findAll();

        //get all available parent items
        $parents = TreeEx::model()->listAllItemsForForms(0,'-',true,__a('None'));

        //get statuses
        $statuses = Constants::statusList();

        //templates
        $theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;
        $templates = TemplateHelper::getStandardTemplates($theme);
        $item_templates = TemplateHelper::getStandardTemplates($theme,'Item');

        //find category
        $model = TreeEx::model()->findByPk((int)$id);

        //if not found
        if(empty($model)){
            throw new CHttpException(404);
        }

        //get form params from request
        $formParams = Yii::app()->request->getPost('TreeEx',null);

        //if got something from form
        if(!empty($formParams)){

            //if selected other parent - we need new priority
            $needNewPriority = $model->parent_id != !empty($formParams['parent_id']) ? $formParams['parent_id'] : 0;

            //store main attributes
            $model->attributes = $formParams;

            //if valid data
            if($model->validate()){

                //open transaction
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();

                try
                {
                    //set main params and save
                    $model->updated_by_id = Yii::app()->user->id;
                    $model->updated_time = time();
                    $model->readonly = 0;

                    //if parent changed
                    if($needNewPriority){
                        $model->priority = Sort::GetNextPriority('TreeEx',array('parent_id' => $model->parent_id));
                    }

                    //update
                    $model->update();

                    //set branch and update
                    $model->branch = $model->findBranch(true);
                    $model->update();

                    //save translatable data
                    foreach($languages as $lng)
                    {
                        $name = !empty($formParams['name']) ? $formParams['name'] : '';
                        $description = !empty($formParams['description'][$lng->id]) ? $formParams['description'][$lng->id] : '';
                        $text = !empty($formParams['text'][$lng->id]) ? $formParams['text'][$lng->id] : '';
                        $meta_title = !empty($formParams['meta_title'][$lng->id]) ? $formParams['meta_title'][$lng->id] : '';
                        $meta_keywords = !empty($formParams['meta_keywords'][$lng->id]) ? $formParams['meta_keywords'][$lng->id] : '';

                        $trl = $model->getOrCreateTrl($lng->id);
                        $trl->name = $name;
                        $trl->description = $description;
                        $trl->text = $text;
                        $trl->meta_title = $meta_title;
                        $trl->meta_keywords = $meta_keywords;

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

        //render form
        $this->render('edit',array(
                'languages' => $languages,
                'parents' => $parents,
                'statuses' => $statuses,
                'model' => $model,
                'templates' => $templates,
                'item_templates' => $item_templates
            ));
    }
}