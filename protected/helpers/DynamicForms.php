<?php

class DynamicForms
{
    protected static $_instance;
    public $form_validation_errors = array();
    public $form_stored_values = array();
    public $feedback_content = array();

    public static function getInstance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    /**
     * Check if form of specified widget has errors
     * @param $widgetId
     * @return bool
     */
    public function hasErrors($widgetId)
    {
        return !empty($this->form_validation_errors[$widgetId]);
    }

    /**
     * Returns errors for specified widgets
     * @param $widgetId
     * @return array
     */
    public function getErrors($widgetId)
    {
        return !empty($this->form_validation_errors[$widgetId]) ? $this->form_validation_errors[$widgetId] : array();
    }


    /**
     * Returns stored value
     * @param int $widgetId
     * @param int $fieldId
     * @return null
     */
    public function getOldValue($widgetId, $fieldId)
    {
        return !empty($this->form_stored_values[$widgetId][$fieldId]) ? $this->form_stored_values[$widgetId][$fieldId] : null;
    }

    /**
     * Handles request from feedback-type forms
     * @param CHttpRequest $request
     */
    public function feedbackFormRequestHandle($request)
    {

        /* @var $request CHttpRequest */

        //get entered to form values
        $params = $request->getParam(ContentItemFieldEx::FORM_FIELD_GROUP);

        //validation errors container (error messages for fields)
        $validationErrors = array();

        //if not empty form values
        if(!empty($params)){

            //pass through given data
            foreach($params as $widgetId => $fields){

                //find feedback form widget
                $widget = WidgetEx::model()->findByAttributes(array(
                    'id' => (int)$widgetId,
                    'type_id' => Constants::WIDGET_TYPE_FORM,
                    'form_type_id' => Constants::FORM_WIDGET_FEEDBACK
                ));

                //if widget found
                if(!empty($widget))
                {
                    //if should check captcha
                    if($widget->form_captcha){

                        //get captcha value
                        $captchaValue = !empty($fields['cap']) ? $fields['cap'] : null;

                        //check captcha code
                        if($captchaValue !== $this->getCapCode()) {
                            $validationErrors['cap'] = __('CAPTCHA is wrong');
                        }
                    }

                    //pass through all given from request fields
                    foreach($fields as $fieldId => $value)
                    {
                        //pass only through numerical fields
                        if(!is_numeric($fieldId)){
                            continue;
                        }

                        //store value
                        $this->form_stored_values[$widget->id][$fieldId] = $value;

                        /* @var $fieldObject ContentItemFieldEx */
                        $fieldObject = ContentItemFieldEx::model()->findByPk((int)$fieldId);
                        $fieldTitle = !empty($fieldObject->trl->name) ? $fieldObject->trl->name : $fieldObject->label;


                        //TODO: parse correctly all content, store it for saving
                        //$this->feedback_content[$fieldObject->label] = $value;


                        //if this is numeric field
                        if($fieldObject->field_type_id == Constants::FIELD_TYPE_NUMERIC|| $fieldObject->field_type_id == Constants::FIELD_TYPE_PRICE)
                        {
                            //check if entered value is number
                            if(!is_numeric($value)){
                                $validationErrors[$fieldObject->id] = __('Only numbers allowed for field').' "'.$fieldTitle.'"';
                            }

                            //if this simple number (not price) field - check if value is decimal
                            if($fieldObject->field_type_id == Constants::FIELD_TYPE_NUMERIC && preg_match('/^[0-9]+$/', $value) == false){
                                $validationErrors[$fieldObject->id] = __('Only decimal numbers allowed for field').' "'.$fieldTitle.'"';
                            }

                            //get other validation settings for current field (from widget)
                            $validationParams = $widget->validationConfigFor($fieldObject->id);
                            $validation_rule = !empty($validationParams['rule']) ? $validationParams['rule'] : null;
                            $interval = !empty($validationParams['interval']) ? $validationParams['interval'] : array();

                            //if should check for non-zero
                            if($validation_rule == Constants::FORM_VAL_FIELD_NOT_ZERO)
                            {
                                if($value == 0 || empty($value)){
                                    $validationErrors[$fieldObject->id] = __('Zero and emptiness not allowed for field').' "'.$fieldTitle.'"';
                                }
                            }

                            //if should check for positive values
                            if($validation_rule == Constants::FORM_VAL_FIELD_POSITIVE)
                            {
                                if($value <= 0){
                                    $validationErrors[$fieldObject->id] = __('Only positive numbers allowed for field').' "'.$fieldTitle.'"';
                                }
                            }

                            //if should check for negative values
                            if($validation_rule == Constants::FORM_VAL_FIELD_NEGATIVE)
                            {
                                if($value >= 0){
                                    $validationErrors[$fieldObject->id] = __('Only negative numbers allowed for field').' "'.$fieldTitle.'"';
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
                                    $validationErrors[$fieldObject->id] = __('Only numeric value between'.' '.$from.' '.'and'.' '.$to.' '.'allowed for field').' "'.$fieldTitle.'"';
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
                                    $validationErrors[$fieldObject->id] = '"'.$fieldTitle.'" '.__('should not be empty');
                                }
                            }

                            //if should check for field length
                            if($validation_rule == Constants::FORM_VAL_FIELD_LENGTH)
                            {
                                if(strlen($value) > $specified_value){
                                    $validationErrors[$fieldObject->id] ='"'.$fieldTitle.'" '.__('max length is').' '.$specified_value;
                                }
                            }
                        }

                        //if this is checkbox
                        elseif($fieldObject->field_type_id == Constants::FIELD_TYPE_BOOLEAN){

                            //check if entered value is number/boolean
                            if(!is_numeric($value)){
                                $validationErrors[$fieldObject->id] = __('Only boolean values (1 or 0) allowed for field').' "'.$fieldTitle.'"';
                            }
                        }

                    }

                    //if we have some errors
                    if(!empty($validationErrors)){

                        //store errors
                        $this->form_validation_errors[$widget->id] = $validationErrors;
                    }

                    //if have no errors
                    else{

                        //TODO: make a feedback

                    }

                }

            }

        }

    }

    /**
     * Get correct info from entered field's value
     * @param ContentItemFieldEx $fieldObj
     * @param string|int|null $value
     * @return mixed
     */
    private function obtainFeedbackFieldValue($fieldObj,$value)
    {
        switch($fieldObj->field_type_id){

            case Constants::FIELD_TYPE_PRICE:
            case Constants::FIELD_TYPE_NUMERIC:
            case Constants::FIELD_TYPE_TEXT:
                return $value;
                break;

            case Constants::FIELD_TYPE_SELECTABLE:
                return $fieldObj->getSelectableVariantTitle($value);
                break;

            case Constants::FIELD_TYPE_MULTIPLE_CHECKBOX:
                $variants = $fieldObj->getSelectableVariants();
                return $value;
                break;

            default:
                return $value;
                break;

        }
    }

    /**
     * Regenerates CAPTCHA code and stores it in session
     * @param int $length
     * @return string
     */
    public function regenerateCaptchaCode($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters)-1)];
        }

        Yii::app()->getSession()->add('captcha_code',$code);

        return $code;
    }

    /**
     * Returns current CAPTCHA code (stored in session)
     * @return mixed
     */
    public function getCapCode()
    {
        return Yii::app()->getSession()->get('captcha_code', '');
    }

    /**
     * Get rendered CAPTCHA image
     * @param int $width
     * @param int $height
     * @param int $padding
     * @param int $background
     * @param int $color
     * @param int $transparent
     * @param int $offset
     * @param string $font
     * @return string
     */
    public function getCapUrl($width = null, $height = null, $padding = null, $background = null, $color = null, $transparent = null, $offset = null, $font = null)
    {
        $parameters = get_defined_vars();

        foreach($parameters as $index => $value){
            if(empty($value)){
                unset($parameters[$index]);
            }
        }

        return Yii::app()->createUrl('captcha/render',$parameters);
    }

    /**
     * Returns correct field name for CAPTCHA field (for forms)
     * @param $widgetId
     * @return string
     */
    public function getCapFieldName($widgetId)
    {
        return ContentItemFieldEx::FORM_FIELD_GROUP.'['.$widgetId.'][cap]';
    }
}