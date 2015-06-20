<?php

class BlocksController extends ControllerAdmin
{
    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/blocks/list'));
    }


    /**
     * Listing all content items
     * @param int $tid
     * @param int $cid
     * @param int $page
     */
    public function actionList($tid = 0, $cid = 0, $page = 1)
    {
        //all content types
        $contentTypes = ContentTypeEx::model()->findAll();
        //all categories (assoc array for drop-downs)
        $categoriesList = TreeEx::model()->listAllItemsForForms(0,'-');
        //selected type
        $selectedType = ContentTypeEx::model()->findByPk((int)$tid);
        //selected category
        $selectedCategory = TreeEx::model()->findByPk((int)$cid);

        //empty conditions
        $conditions = array();

        //add required conditions
        if(!empty($selectedType)){
            $conditions['content_type_id'] = $selectedType->id;
        }
        if(!empty($selectedCategory)){
            $conditions['tree_id'] = $selectedCategory->id;
        }

        //find all content blocks by conditions
        $blocks = ContentItemEx::model()->findAllByAttributes($conditions,array('order' => 'priority ASC'));

        //paginate items
        $perPage = getif($this->global_settings->per_page_qnt,10);
        $items = CPager::getInstance($blocks,$perPage,$page)->getPreparedArray();

        //render list
        $this->render('list',array(
                'items' => $items,
                'types' => $contentTypes,
                'categories' => $categoriesList,
                'selectedType' => $selectedType,
                'selectedCategory' => $selectedCategory
            ));
    }

    /**
     * Adding a new block
     * @param int $cid
     */
    public function actionAdd($cid = 0)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);


        //all content types (assoc array for drop-downs)
        $contentTypes = ContentTypeEx::model()->listAllItemsForForms();
        //all categories (assoc array for drop-downs)
        $categoriesList = TreeEx::model()->listAllItemsForForms(0,'-');
        //selected category
        $selectedCategory = TreeEx::model()->findByPk((int)$cid);
        //statuses
        $statuses = Constants::statusList();
        //languages
        $languages = Language::model()->findAll();

        //new content item model
        $block = new ContentItemEx();

        //get data from form
        $form = Yii::app()->request->getPost('ContentItemEx',array());

        //if form not empty
        if(!empty($form)){
            //set main attributes to model
            $block->attributes = $form;

            //if valid
            if($block->validate()){

                //transaction
                $transaction = Yii::app()->db->beginTransaction();

                try
                {
                    //obtain a template name
                    $block->template_name = getif($block->contentType->predefined_template_name,$block->tree->item_template_name);

                    //calc priority
                    $block->priority = Sort::GetNextPriority('ContentItemEx',array('tree_id' => $block->tree_id));

                    //statistics data
                    $block->created_by_id = Yii::app()->user->id;
                    $block->created_time = time();
                    $block->updated_by_id = Yii::app()->user->id;
                    $block->updated_time = time();
                    $block->readonly = 0;

                    //save
                    $block->save();

                    //save translatable attributes
                    $trlName = getif($form['name'],array());
                    $trlMetaTitle = getif($form['meta_title'],array());
                    $trlKeywords = getif($form['meta_keywords'],array());

                    foreach($languages as $language)
                    {
                        $trl = $block->getOrCreateTrl($language->id);
                        $trl -> name = getif($trlName[$language->id],'');
                        $trl -> meta_title = getif($trlMetaTitle[$language->id],'');
                        $trl -> meta_keywords = getif($trlKeywords[$language->id],'');

                        if($trl->isNewRecord){
                            $trl->save();
                        }else{
                            $trl->update();
                        }
                    }

                    //commit
                    $transaction->commit();

                    //back to list (filtered by content type and category)
                    $this->redirect(Yii::app()->createUrl('admin/blocks/list',array('tid' => $block->content_type_id, 'cid' => $block->tree_id)));
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

        $this->render('add',array(
                'model' => $block,
                'types' => $contentTypes,
                'categories' => $categoriesList,
                'selectedCategory' => $selectedCategory,
                'statuses' => $statuses,
                'languages' => $languages
            )
        );
    }


    /**
     * Edit fields
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //all categories (assoc array for drop-downs)
        $categoriesList = TreeEx::model()->listAllItemsForForms(0,'-');
        //statuses
        $statuses = Constants::statusList();
        //templates
        $templates = TemplateHelper::getStandardTemplates($this->global_settings->active_theme,'Item');
        //languages
        $languages = Language::model()->findAll();
        //content item model
        $block = ContentItemEx::model()->findByPk((int)$id);
        if(empty($block)){
            throw new CHttpException(404);
        }

        //get data from form
        $form = Yii::app()->request->getPost('ContentItemEx',array());
        $files = $_FILES; //TODO: implement file appending

        //if something got from form
        if(!empty($form)){
            //set main attributes
            $block->attributes = $form;

            //if valid
            if($block->validate())
            {
                //transaction
                $transaction = Yii::app()->db->beginTransaction();

                //try save
                try
                {
                    //update main attributes
                    $block->updated_by_id = Yii::app()->user->id;
                    $block->updated_time = time();

                    //if template name not set by user
                    if(empty($block->template_name)){
                        //take it from content type or category
                        $block->template_name = getif($block->contentType->predefined_template_name,$block->tree->item_template_name);
                    }

                    $block->update();

                    //update translatable attributes
                    $trlName = getif($form['name'],array());
                    $trlMetaTitle = getif($form['meta_title'],array());
                    $trlKeywords = getif($form['meta_keywords'],array());

                    foreach($languages as $language)
                    {
                        $trl = $block->getOrCreateTrl($language->id);
                        $trl -> name = getif($trlName[$language->id],'');
                        $trl -> meta_title = getif($trlMetaTitle[$language->id],'');
                        $trl -> meta_keywords = getif($trlKeywords[$language->id],'');

                        if($trl->isNewRecord){
                            $trl->save();
                        }else{
                            $trl->update();
                        }
                    }

                    //get dynamic fields
                    $dynamic = getif($form['dynamic'],array());
                    $dynamic_trl = getif($form['dynamic_trl'],array());

                    //saving dynamic not translatable fields
                    if(!empty($dynamic))
                    {
                        //pass through all not translatable fields
                        foreach($dynamic as $fieldId => $valueContent)
                        {
                            //get field
                            $field = ContentItemFieldEx::model()->findByPk($fieldId);

                            //if field not empty
                            if(!empty($field))
                            {
                                //get field's value
                                $objValue = $field->getValueFor($block->id);

                                //depending on field's type
                                switch($field->field_type_id)
                                {
                                    //parse received data and write it to value
                                    case Constants::FIELD_TYPE_NUMERIC:
                                        $objValue->numeric_value = $valueContent;
                                        break;
                                    case Constants::FIELD_TYPE_PRICE:
                                        $objValue->numeric_value = priceToCents($valueContent);
                                        break;
                                    case Constants::FIELD_TYPE_TEXT:
                                        $objValue->text_value = $valueContent;
                                        break;
                                    case Constants::FIELD_TYPE_BOOLEAN:
                                        $objValue->numeric_value = $valueContent;
                                        break;
                                    case Constants::FIELD_TYPE_DATE:
                                        $d = DateTime::createFromFormat('m/d/Y',$valueContent);
                                        $objValue->numeric_value = $d->getTimestamp();
                                        break;
                                }

                                //save or update field's value of current content item
                                if($objValue->isNewRecord){
                                    $objValue->save();
                                }else{
                                    $objValue->update();
                                }
                            }

                        }
                    }
                    //saving dynamic translatable fields
                    if(!empty($dynamic_trl))
                    {
                        //pass through all translatable fields
                        foreach($dynamic_trl as $fieldId => $trlValuesArr)
                        {
                            //get field
                            $field = ContentItemFieldEx::model()->findByPk($fieldId);

                            //if field exist and has correct type
                            if(!empty($field) && $field->field_type_id == Constants::FIELD_TYPE_TEXT_TRL)
                            {
                                //get or create value object of this field for this content item
                                $objValue = $field->getValueFor($block->id);
                                if($objValue->isNewRecord){
                                    $objValue->save();
                                }

                                //pas through all languages
                                foreach($languages as $language)
                                {
                                    //get translatable value's part
                                    $trlObjValue = $objValue->getOrCreateTrl($language->id);
                                    //set text
                                    $trlObjValue -> text = getif($trlValuesArr[$language->id],'');
                                    //save or update
                                    if($trlObjValue->isNewRecord){
                                        $trlObjValue->save();
                                    }else{
                                        $trlObjValue->update();
                                    }
                                }
                            }
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
            }
            //if some main fields not valid
            else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }
        }

        //render form
        $this->render('edit',array(
                'model' => $block,
                'categories' => $categoriesList,
                'statuses' => $statuses,
                'languages' => $languages,
                'templates' => $templates
            ));
    }

    /**
     * Deletes content item
     * @param $id
     */
    public function actionDelete($id)
    {
        //delete
        ContentItemEx::model()->deleteByPk((int)$id);
        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}