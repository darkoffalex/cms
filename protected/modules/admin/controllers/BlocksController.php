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
                //obtain a template name
                $block->template_name = getif($block->contentType->predefined_template_name,$block->tree->template_name);
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

                //back to list (filtered by content type and category)
                $this->redirect(Yii::app()->createUrl('admin/blocks/list',array('tid' => $block->content_type_id, 'cid' => $block->tree_id)));
            }
        }

        $this->render('add',array(
                'model' => $block,
                'types' => $contentTypes,
                'categories' => $categoriesList,
                'selectedCategory' => $selectedCategory,
                'statuses' => $statuses
            )
        );
    }


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
        $files = $_FILES;

        if(!empty($form)){
            $block->attributes = $form;
            if($block->validate())
            {
                debugvar($form);
                debugvar($files);
                exit();
            }
        }

        $this->render('edit',array(
                'model' => $block,
                'categories' => $categoriesList,
                'statuses' => $statuses,
                'languages' => $languages
            ));
    }
}