<?php

/**
 * This is the model class for table "content_type".
 *
 * The followings are the available columns in table 'content_type':
 * @property integer $id
 * @property string $label
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $readonly
 * @property string $predefined_template_name
 *
 * The followings are the available model relations:
 * @property ContentItem[] $contentItems
 * @property ContentItemField[] $contentItemFields
 * @property Widget[] $widgets
 */
class ContentType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'content_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_by_id, updated_by_id, created_time, updated_time, readonly', 'numerical', 'integerOnly'=>true),
			array('label, predefined_template_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, created_by_id, updated_by_id, created_time, updated_time, readonly, predefined_template_name', 'safe', 'on'=>'search'),
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
			'contentItems' => array(self::HAS_MANY, 'ContentItem', 'content_type_id'),
			'contentItemFields' => array(self::HAS_MANY, 'ContentItemField', 'content_type_id'),
			'widgets' => array(self::HAS_MANY, 'Widget', 'filtration_by_type_id'),
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
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'readonly' => 'Readonly',
			'predefined_template_name' => 'Predefined Template Name',
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
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('predefined_template_name',$this->predefined_template_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContentType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
