<?php

class Controller extends CController
{
	public $layout='//layouts/main';

    public $title = "";
    public $keywords = "";
    public $description = "";

    public $themeName = "";

    /**
     * @var GlobalSettingsEx
     */
    public $global_settings = null;

    /**
     * Perform before every action
     * @param CAction $action
     * @return bool
     */
    protected function beforeAction($action)
    {
        //get global settings
        $this->global_settings = GlobalSettingsEx::model()->find();

        //get theme
        Yii::app()->theme = !empty($this->global_settings->active_theme) ? $this->global_settings->active_theme : null;

        //get theme name
        $this->themeName = !empty(Yii::app()->theme->name) ? Yii::app()->theme->name : '';

        //initialize dynamic widgets
        DynamicWidget::getInstance()->initialize($this,$this->themeName);

        //handle filtration requests
        $this->preSetFiltrationHandler();

        //handle form's requests
        $this->preSetFormHandler();

        //before action - parent call
        return parent::beforeAction($action);
    }

    /**
     * Constructor override
     * @param string $id
     * @param null $module
     */
    public function __construct($id,$module=null)
    {
        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');

        //get from URL request or use default
        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);

        parent::__construct($id,$module);
    }

    /**
     * Setup the language
     * @param $lng
     */
    public function setLanguage($lng)
    {
        $objUser = Yii::app()->user;
        $request = Yii::app()->request;

        Yii::app()->language = $lng;
        $objUser->setState('language', $lng);
        $request->cookies['language'] = new CHttpCookie('lng', $lng);

        if ($objUser->hasState('language')) {
            Yii::app()->language = $objUser->getState('language');
        }
        elseif (isset($request->cookies['language'])) {
            Yii::app()->language = $request->cookies['language']->value;
        }
    }

    /**
     * If got filtration request from form - set it to session
     */
    public function preSetFiltrationHandler()
    {
        $params = Yii::app()->getRequest()->getParam(ContentItemFieldEx::FILTER_FIELDS_GROUP);

        if(!empty($params)){

            Yii::app()->session['filtration'] = $params;

            if(isset($params['clean'])){
                unset(Yii::app()->session['filtration']);
            }
        }
    }

    /**
     * If got feedback request from form - handle it
     */
    public function preSetFormHandler()
    {
        //get params from POST request
        $params = Yii::app()->getRequest()->getParam(ContentItemFieldEx::FORM_FIELD_GROUP);
        $validationErrors = array();

        if(!empty($params)){

            //pass through given data
            foreach($params as $widgetId => $fields){

                //find widget
                $widget = WidgetEx::model()->findByPk((int)$widgetId);

                //if widget found and this is correct widget
                if(!empty($widget) && $widget->type_id == Constants::WIDGET_TYPE_FORM){

                    //depends on widget form type
                    switch($widget->form_type_id)
                    {
                        //if widget-form has feedback type
                        case Constants::FORM_WIDGET_FEEDBACK:

                            foreach($fields as $fieldId => $value)
                            {
                                /* @var $fieldObject ContentItemFieldEx */
                                $fieldObject = ContentItemFieldEx::model()->findByPk((int)$fieldId);

                                //if this is numeric field
                                if($fieldObject->field_type_id == Constants::FIELD_TYPE_NUMERIC|| $fieldObject->field_type_id == Constants::FIELD_TYPE_PRICE)
                                {
                                    //check if entered value is number
                                    if(!is_numeric($fields)){
                                        $validationErrors[$fieldObject->id] = __('Only numbers allowed');
                                    }

                                    //if this simple number (not price) field - check if value is decimal
                                    if($fieldObject->field_type_id == Constants::FIELD_TYPE_NUMERIC && !is_int($value)){
                                        $validationErrors[$fieldObject->id] = __('Only decimal numbers allowed');
                                    }

                                    //get other validation settings for current field (from widget)
                                    $validationParams = $widget->validationConfigFor($fieldObject->id);
                                    $validation_rule = !empty($validationParams['rule']) ? $validationParams['rule'] : null;
                                    $interval = !empty($validationParams['interval']) ? $validationParams['interval'] : array();

                                    //if should check for non-zero
                                    if($validation_rule == Constants::FORM_VAL_FIELD_NOT_ZERO)
                                    {
                                        if($value == 0 || empty($value)){
                                            $validationErrors[$fieldObject->id] = __('Zero and emptiness not allowed');
                                        }
                                    }

                                    //if should check for positive values
                                    if($validation_rule == Constants::FORM_VAL_FIELD_POSITIVE)
                                    {
                                        if($value <= 0){
                                            $validationErrors[$fieldObject->id] = __('Only positive numbers allowed');
                                        }
                                    }

                                    //if should check for negative values
                                    if($validation_rule == Constants::FORM_VAL_FIELD_NEGATIVE)
                                    {
                                        if($value >= 0){
                                            $validationErrors[$fieldObject->id] = __('Only negative numbers allowed');
                                        }
                                    }

                                    //if should check for interval
                                    if($validation_rule == Constants::FORM_VAL_FIELD_NUM_INTERVAL)
                                    {
                                        //get interval from widget configuration
                                        $from = !empty($interval[0]) ? $interval[0] : 0;
                                        $to = !empty($interval[1]) ? $interval[1] : 0;

                                        //check
                                        if(!($value >= $from && $value <= $to)){
                                            $validationErrors[$fieldObject->id] = __('Only value between'.' '.$from.' '.'and'.' '.$to.' '.'allowed');
                                        }
                                    }
                                }
                                //if this is text field
                                elseif($fieldObject->field_type_id == Constants::FIELD_TYPE_TEXT)
                                {
                                    //get other validation settings for current field (from widget)
                                    $validationParams = $widget->validationConfigFor($fieldObject->id);
                                    $validation_rule = !empty($validationParams['rule']) ? $validationParams['rule'] : null;
                                    $specified_value = !empty($validationParams['specified']) ? $validationParams['specified'] : null;

                                    //if should check for emptiness
                                    if($validation_rule == Constants::FORM_VAL_FIELD_NOT_EMPTY)
                                    {
                                        if(empty($value)){
                                            $validationErrors[$fieldObject->id] = __('Field should not be empty');
                                        }
                                    }

                                    if($validation_rule == Constants::FORM_VAL_FIELD_LENGTH)
                                    {
                                        if(strlen($value) > $specified_value){
                                            $validationErrors[$fieldObject->id] = __('Max length of this field is').' '.$specified_value;
                                        }
                                    }
                                }
                            }

                            if(empty($validationErrors))
                            {
                                //TODO: add feedback
                            }
                            else
                            {

                            }

                            break;

                        //if widget-form has login type
                        case Constants::FORM_WIDGET_LOGIN:
                            //TODO: perform login stuff
                            break;

                        //if widget-form has registration type
                        case Constants::FORM_WIDGET_REGISTRATION:
                            //TODO: perform registration stuff
                            break;
                    }

                }

            }

        }

    }
}