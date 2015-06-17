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
}