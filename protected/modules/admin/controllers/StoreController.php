<?php

class StoreController extends ControllerAdmin
{
    /**
     * Entry point
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('admin/store/orders'));
    }


    /*********************************************** O R D E R S *****************************************************/


    public function actionOrders($page = 1, $search = null)
    {
        $this->renderText('In progress');
        //TODO: implement order listing here
    }

    public function actionOrderDetails($id)
    {
        $this->renderText('In progress');
        //TODO: implement here listing order items and delivery
    }

    /******************************************** D E L I V E R Y *****************************************************/

    /**
     * List all deliveries
     */
    public function actionDelivery()
    {
        $delivery = OrderDeliveryEx::model()->findAll();
        $this->render('delivery_list',array('items' => $delivery));
    }

    /**
     * Delete delivery and go back
     * @param $id
     */
    public function actionDeleteDelivery($id)
    {
        OrderDeliveryEx::model()->deleteByPk($id);
        $this->redirect(Yii::app()->getRequest()->getUrlReferrer());
    }

    /**
     * Adding new delivery
     * @throws CDbException
     */
    public function actionAddDelivery()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $delivery = new OrderDeliveryEx(); //delivery object
        $languages = Language::model()->findAll(); //languages
        $statuses = Constants::statusList(); //statuses
        $form = Yii::app()->request->getPost('OrderDeliveryEx',null); //get form data

        //if got something from post
        if(!empty($form)){

            //set main attributes
            $delivery->attributes = $form;

            //if all data valid
            if($delivery->validate()){

                //open transaction
                $transaction = Yii::app()->getDb()->beginTransaction();

                //try to save all data
                try{
                    $delivery->price = priceToCents($form['price']);
                    $delivery->created_by_id = Yii::app()->getUser()->id;
                    $delivery->created_time = time();
                    $delivery->updated_by_id = Yii::app()->getUser()->id;
                    $delivery->updated_time = time();
                    $delivery-> save();

                    foreach($languages as $language){
                        $title = !empty($form['title'][$language->id]) ? $form['title'][$language->id] : '';
                        $trl = $delivery->getOrCreateTrl($language->id);
                        $trl -> title = $title;
                        $ok = $trl->isNewRecord ? $trl->save() : $trl->update();
                    }

                    //apply changes
                    $transaction->commit();

                    //redirect to list
                    $this->redirect(Yii::app()->createUrl('admin/store/delivery'));

                }catch (Exception $ex){

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
        $this->render('delivery_edit',array('model' => $delivery, 'languages' => $languages, 'statuses' => $statuses));
    }


    /**
     * Editing delivery
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionEditDelivery($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        $delivery = OrderDeliveryEx::model()->findByPk((int)$id); //delivery object

        //if not found - error 404
        if(empty($delivery)){
            throw new CHttpException(404);
        }

        $languages = Language::model()->findAll(); //languages
        $statuses = Constants::statusList(); //statuses
        $form = Yii::app()->request->getPost('OrderDeliveryEx',null); //get form data


        //if got something from post
        if(!empty($form)){

            debugvar($form);
            exit();

            //set main attributes
            $delivery->attributes = $form;

            //if all data valid
            if($delivery->validate()){

                //open transaction
                $transaction = Yii::app()->getDb()->beginTransaction();

                //try to save all data
                try{
                    $delivery->price = priceToCents($form['price']);
                    $delivery->updated_by_id = Yii::app()->getUser()->id;
                    $delivery->updated_time = time();
                    $delivery-> update();

                    foreach($languages as $language){
                        $title = !empty($form['title'][$language->id]) ? $form['title'][$language->id] : '';
                        $trl = $delivery->getOrCreateTrl($language->id);
                        $trl -> title = $title;
                        $ok = $trl->isNewRecord ? $trl->save() : $trl->update();
                    }

                    //apply changes
                    $transaction->commit();

                    //success message
                    Yii::app()->user->setFlash('success',__a('Success : All data saved'));

                }catch (Exception $ex){

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
        $this->render('delivery_edit',array('model' => $delivery, 'languages' => $languages, 'statuses' => $statuses));
    }


}