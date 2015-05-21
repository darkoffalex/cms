<?php

/**
 * This is the model class for table "widget".
 *
 * The followings are the available columns in table 'widget':
 * @property integer $id
 * @property string $label
 * @property integer $tree_id
 * @property integer $widget_type_id
 * @property string $template_name
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $readonly
 *
 * The followings are the available model relations:
 * @property Tree $tree
 * @property WidgetType $widgetType
 * @property WidgetRegistration[] $widgetRegistrations
 * @property WidgetTrl[] $widgetTrls
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
			array('tree_id, widget_type_id, created_by_id, updated_by_id, created_time, updated_time, readonly', 'numerical', 'integerOnly'=>true),
			array('label, template_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, tree_id, widget_type_id, template_name, created_by_id, updated_by_id, created_time, updated_time, readonly', 'safe', 'on'=>'search'),
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
			'tree' => array(self::BELONGS_TO, 'Tree', 'tree_id'),
			'widgetType' => array(self::BELONGS_TO, 'WidgetType', 'widget_type_id'),
			'widgetRegistrations' => array(self::HAS_MANY, 'WidgetRegistration', 'widget_id'),
			'widgetTrls' => array(self::HAS_MANY, 'WidgetTrl', 'widget_id'),
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
			'tree_id' => 'Tree',
			'widget_type_id' => 'Widget Type',
			'template_name' => 'Template Name',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'readonly' => 'Readonly',
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
		$criteria->compare('tree_id',$this->tree_id);
		$criteria->compare('widget_type_id',$this->widget_type_id);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('readonly',$this->readonly);

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
