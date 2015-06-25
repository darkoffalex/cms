<?php

class TranslationsController extends ControllerAdmin
{
    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/translations/list'));
    }

    /**
     * List & add
     * @param int|null $id
     * @param int $page
     * @throws CHttpException
     */
    public function actionList($id = null, $page = 1)
    {
        /* @var $currentLng Language */
        /* @var $languages Language[] */
        /* @var $labels TranslationEx[] */

        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.labels.css');
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.lightbox.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.labels.js',CClientScript::POS_END);
        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery.js' => false);

        $model = new TranslationEx();

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
            if(isset($_POST['TranslationEx']))
            {

                $model->attributes = $_POST['TranslationEx'];

                if($model->validate())
                {
                    $model->save();
                }
            }
        }


        //current language
        $currentLng = Language::model()->findByPk((int)$id);
        //languages
        $languages = Language::model()->findAll(array('order' => 'priority ASC'));
        //translations
        $labels = TranslationEx::model()->findAll();

        if(empty($currentLng)){
            if(!empty($languages)){
                $currentLng = $languages[0];
            }
        }


        //paginate items
        $perPage = !empty($this->global_settings->per_page_qnt) ? $this->global_settings->per_page_qnt : 10;
        $items = CPager::getInstance($labels,$perPage,$page)->getPreparedArray();

        //if on page was deleted last item - go to one page back
        if(count($items) == 0 && $page > 1){
            $this->redirect(Yii::app()->createUrl('admin/translations/list',array('id' => $currentLng->id, 'page' => $page-1)));
        }

        if(!empty($languages)){
            $this->render('list', array(
                    'items' => $items,
                    'current_lng' => $currentLng,
                    'languages' => $languages,
                    'lng_id' => $currentLng->id,
                    'model' => $model
                ));
        }else{
            $this->render('no_languages');
        }
    }

    /**
     * Delete translation and back to previous page
     * @param $id
     */
    public function actionDelete($id)
    {
        //delete translation
        TranslationEx::model()->deleteByPk((int)$id);
        //go back
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Update
     */
    public function actionUpdate()
    {
        $translations = Yii::app()->request->getPost('translations',array());
        $isOk = false;

        if(!empty($translations)){

            foreach($translations as $id => $valueArr)
            {
                if(is_array($valueArr)){
                    foreach($valueArr as $lngId => $val)
                    {
                        $trans = TranslationEx::model()->findByPk($id);
                        if(!empty($trans)){
                            $trl = $trans->getOrCreateTrl($lngId);
                            $trl->value = $val;
                            $isOk = $trl->isNewRecord ? $trl->save() : $trl->update();
                        }
                    }
                }
            }

        }

        if(Yii::app()->request->isAjaxRequest){
            //message back to script
            echo $isOk ? 'OK' : 'FAILED';
            Yii::app()->end();
        }else{
            //go back
            $this->redirect(Yii::app()->request->urlReferrer);
        }

    }
}