<?php

/**
 * This is the model class for table "widget".
 *
 * The followings are the available columns in table 'widget':
 * @property integer $id
 * @property string $label
 * @property integer $type_id
 * @property integer $tree_id
 * @property string $template_name
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $readonly
 * @property integer $breadcrumbs_root_level
 * @property integer $block_limit
 * @property integer $include_from_nested
 * @property integer $filtration_by_type_id
 * @property string $filtration_array_json
 * @property string $feedback_email
 * @property integer $form_type_id
 * @property integer $form_captcha
 * @property integer $form_feedback_type_id
 *
 * The followings are the available model relations:
 * @property WidgetTrl[] $widgetTrls
 * @property WidgetRegistration[] $widgetRegistrations
 * @property Feedback[] $feedbacks
 * @property ContentType $filtrationByType
 * @property Tree $tree
 */
class Widget extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'widget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label', 'required'),
			array('type_id, tree_id, created_by_id, updated_by_id, created_time, updated_time, readonly, breadcrumbs_root_level, block_limit, include_from_nested, filtration_by_type_id, form_type_id, form_captcha, form_feedback_type_id', 'numerical', 'integerOnly'=>true),
			array('template_name, filtration_array_json, feedback_email', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, type_id, tree_id, template_name, created_by_id, updated_by_id, created_time, updated_time, readonly, breadcrumbs_root_level, block_limit, include_from_nested, filtration_by_type_id, filtration_array_json, feedback_email, form_type_id, form_captcha, form_feedback_type_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'widgetTrls' => array(self::HAS_MANY, 'WidgetTrl', 'widget_id'),
			'widgetRegistrations' => array(self::HAS_MANY, 'WidgetRegistration', 'widget_id'),
			'feedbacks' => array(self::HAS_MANY, 'Feedback', 'widget_id'),
			'filtrationByType' => array(self::BELONGS_TO, 'ContentType', 'filtration_by_type_id'),
			'tree' => array(self::BELONGS_TO, 'Tree', 'tree_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label' => 'Label',
			'type_id' => 'Type',
			'tree_id' => 'Tree',
			'template_name' => 'Template Name',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'readonly' => 'Readonly',
			'breadcrumbs_root_level' => 'Breadcrumbs Root Level',
			'block_limit' => 'Block Limit',
			'include_from_nested' => 'Include From Nested',
			'filtration_by_type_id' => 'Filtration By Type',
			'filtration_array_json' => 'Filtration Array Json',
			'feedback_email' => 'Feedback Email',
			'form_type_id' => 'Form Type',
			'form_captcha' => 'Form Captcha',
			'form_feedback_type_id' => 'Form Feedback Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('tree_id',$this->tree_id);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('breadcrumbs_root_level',$this->breadcrumbs_root_level);
		$criteria->compare('block_limit',$this->block_limit);
		$criteria->compare('include_from_nested',$this->include_from_nested);
		$criteria->compare('filtration_by_type_id',$this->filtration_by_type_id);
		$criteria->compare('filtration_array_json',$this->filtration_array_json,true);
		$criteria->compare('feedback_email',$this->feedback_email,true);
		$criteria->compare('form_type_id',$this->form_type_id);
		$criteria->compare('form_captcha',$this->form_captcha);
		$criteria->compare('form_feedback_type_id',$this->form_feedback_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Widget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
