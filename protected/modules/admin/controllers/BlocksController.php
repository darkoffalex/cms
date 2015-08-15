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
        $perPage = Constants::PER_PAGE;
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
                    $block->template_name = !empty($block->contentType->predefined_template_name) ? $block->contentType->predefined_template_name : $block->tree->item_template_name;

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
                    $trlName = !empty($form['name']) ? $form['name'] : array();
                    $trlMetaTitle = !empty($form['meta_title']) ? $form['meta_title'] : array();
                    $trlKeywords = !empty($form['meta_keywords']) ? $form['meta_keywords'] : array();

                    foreach($languages as $language)
                    {
                        $trl = $block->getOrCreateTrl($language->id);
                        $trl -> name = !empty($trlName[$language->id]) ? $trlName[$language->id] : '';
                        $trl -> meta_title = !empty($trlMetaTitle[$language->id]) ? $trlMetaTitle[$language->id] : '';
                        $trl -> meta_keywords = !empty($trlKeywords[$language->id]) ? $trlKeywords[$language->id] : '';

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
        $theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;
        $templates = TemplateHelper::getStandardTemplates($theme,'Item');
        //languages
        $languages = Language::model()->findAll();
        //content items - prepare array for selection
        $linked = ContentItemEx::model()->dropDownListOrderedByCats();
        //content item model
        $block = ContentItemEx::model()->findByPk((int)$id);
        if(empty($block)){
            throw new CHttpException(404);
        }

        //get data from form
        $form = Yii::app()->request->getPost('ContentItemEx',array());
        $files = $_FILES;


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
                        $block->template_name = !empty($block->contentType->predefined_template_name) ? $block->contentType->predefined_template_name : $block->tree->item_template_name;
                    }

                    $block->update();

                    //update translatable attributes
                    $trlName = !empty($form['name']) ? $form['name'] : array();
                    $trlMetaTitle = !empty($form['meta_title']) ? $form['meta_title'] : array();
                    $trlKeywords = !empty($form['meta_keywords']) ? $form['meta_keywords'] : array();

                    foreach($languages as $language)
                    {
                        $trl = $block->getOrCreateTrl($language->id);
                        $trl -> name = !empty($trlName[$language->id]) ? $trlName[$language->id] : '';
                        $trl -> meta_title = !empty($trlMetaTitle[$language->id]) ? $trlMetaTitle[$language->id] : '';
                        $trl -> meta_keywords = !empty($trlKeywords[$language->id]) ? $trlKeywords[$language->id] : '';

                        if($trl->isNewRecord){
                            $trl->save();
                        }else{
                            $trl->update();
                        }
                    }

                    //get dynamic fields
                    $dynamic = !empty($form['dynamic']) ? $form['dynamic'] : array();
                    $dynamic_trl = !empty($form['dynamic_trl']) ? $form['dynamic_trl'] : array();

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
                                    case Constants::FIELD_TYPE_LINKED_BLOCK:
                                        $objValue->numeric_value = $valueContent;
                                        break;
                                    case Constants::FIELD_TYPE_SELECTABLE:
                                        $objValue->text_value = $valueContent;
                                        break;
                                    case Constants::FIELD_TYPE_MULTIPLE_CHECKBOX:
                                        $result = array();

                                        if(is_array($valueContent)){
                                            foreach($valueContent as $value => $state){
                                                $result[] = $value;
                                            }
                                        }

                                        $objValue->text_value = json_encode($result);
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
                                    $trlObjValue -> text = !empty($trlValuesArr[$language->id]) ? $trlValuesArr[$language->id] : '';
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

                    //file validation status
                    $allRightWithFiles = true;

                    //if array of files not empty
                    if(!empty($files)){

                        //pass through all files
                        foreach($files as $fieldName => $fileArr){

                            //obtain a field ID
                            list($title, $fieldId) = array_pad(explode('_',$fieldName), 2, '');

                            //find field by ID
                            $field = ContentItemFieldEx::model()->findByPk((int)$fieldId);

                            //if field found
                            if(!empty($field)){

                                //find or create value of this field for this block
                                $valueObj = $field->getValueFor($block->id);
                                if($valueObj->isNewRecord){
                                    $valueObj->save();
                                }

                                //depending on field's type
                                switch($field->field_type_id)
                                {
                                    //do this for image type
                                    case Constants::FIELD_TYPE_IMAGE:

                                        //get uploaded file's instance
                                        $mediaValidation = new MediaUploadForm();
                                        $mediaValidation->image = CUploadedFile::getInstanceByName($fieldName);

                                        //if file set
                                        if(!empty($mediaValidation->image) && $mediaValidation->image->size > 0)
                                        {
                                            //if file valid
                                            if($mediaValidation->validate()){

                                                //save file to directory with new random name
                                                $uploadPath = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'images';
                                                $randomName = uniqid().'.'.$mediaValidation->image->extensionName;
                                                $destinationName = $uploadPath.DS.$randomName;

                                                //if image saved
                                                if($mediaValidation->image->saveAs($destinationName)){

                                                    //create record in database
                                                    $image = new ImageEx();
                                                    $image -> label = $randomName;
                                                    $image -> filename = $randomName;
                                                    $image -> original_filename = $mediaValidation->image->name;
                                                    $image -> extension = $mediaValidation->image->extensionName;
                                                    $image -> size = $mediaValidation->image->size;
                                                    $image -> mime_type = $mediaValidation->image->type;
                                                    $image -> created_by_id = Yii::app()->user->id;
                                                    $image -> created_time = time();
                                                    $image -> updated_by_id = Yii::app()->user->id;
                                                    $image -> updated_time = time();
                                                    $image -> save();

                                                    //relate with field value
                                                    $iov = new ImageOfValueEx();
                                                    $iov -> image_id = $image->id;
                                                    $iov -> value_id = $valueObj->id;
                                                    $iov -> priority = Sort::GetNextPriority('ImageOfValueEx', array('value_id' => $valueObj->id));
                                                    $iov -> save();
                                                }
                                            }else{
                                                //error message
                                                Yii::app()->user->setFlash('error',__a('Error : File not valid'));
                                                $allRightWithFiles = false;
                                            }
                                        }
                                        break;

                                    case Constants::FIELD_TYPE_FILE:

                                        //get uploaded file's instance
                                        $mediaValidation = new MediaUploadForm();
                                        $mediaValidation->file = CUploadedFile::getInstanceByName($fieldName);

                                        //if file set
                                        if(!empty($mediaValidation->file) && $mediaValidation->file->size > 0)
                                        {
                                            //if file valid
                                            if($mediaValidation->validate()){

                                                //save file to directory with new random name
                                                $uploadPath = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'files';
                                                $randomName = uniqid().'.'.$mediaValidation->file->extensionName;
                                                $destinationName = $uploadPath.DS.$randomName;

                                                //if file saved
                                                if($mediaValidation->file->saveAs($destinationName)){

                                                    //create record in database
                                                    $file = new FileEx();
                                                    $file -> label = $randomName;
                                                    $file -> filename = $randomName;
                                                    $file -> original_filename = $mediaValidation->file->name;
                                                    $file -> extension = $mediaValidation->file->extensionName;
                                                    $file -> size = $mediaValidation->file->size;
                                                    $file -> mime_type = $mediaValidation->file->type;
                                                    $file -> created_by_id = Yii::app()->user->id;
                                                    $file -> created_time = time();
                                                    $file -> updated_by_id = Yii::app()->user->id;
                                                    $file -> updated_time = time();
                                                    $file -> save();

                                                    //relate with field value
                                                    $fov = new FileOfValueEx();
                                                    $fov -> file_id = $file->id;
                                                    $fov -> value_id = $valueObj->id;
                                                    $fov -> priority = Sort::GetNextPriority('FileOfValueEx', array('value_id' => $valueObj->id));
                                                    $fov -> save();
                                                }
                                            }else{
                                                //error message
                                                Yii::app()->user->setFlash('error',__a('Error : File not valid'));
                                                $allRightWithFiles = false;
                                            }
                                        }
                                        break;
                                }
                            }
                        }
                    }

                    //apply changes
                    $transaction->commit();

                    //if with files all right too
                    if($allRightWithFiles){
                        //success message
                        Yii::app()->user->setFlash('success',__a('Success: All data saved'));
                    }

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
                'templates' => $templates,
                'linked' => $linked
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

    /**
     * Deletes image directly (image record and file)
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteImageDirect($id)
    {
        //delete image directly (not relation, but image)
        $image = ImageEx::model()->findByPk((int)$id);

        //if not found
        if(empty($image)){
            throw new CHttpException(404);
        }

        //delete uploaded file
        $image->deleteFile();
        //delete record
        $image->delete();

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);

    }

    /**
     * Deletes not directly, just relation (leaves image record and file)
     * @param $id
     */
    public function actionDeleteImage($id)
    {
        //delete just relation between field value and image
        ImageOfValueEx::model()->deleteByPk((int)$id);

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Delete file directly (file record and file)
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteFileDirect($id)
    {
        //delete file directly (not relation, but file)
        $file = FileEx::model()->findByPk((int)$id);

        //if not found
        if(empty($file)){
            throw new CHttpException(404);
        }

        //delete uploaded file
        $file->deleteFile();
        //delete record
        $file->delete();

        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}