<?php

/**
 * This is the model class for table "content_item_field".
 *
 * The followings are the available columns in table 'content_item_field':
 * @property integer $id
 * @property string $label
 * @property string $field_name
 * @property integer $content_type_id
 * @property integer $field_type_id
 * @property integer $priority
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $readonly
 * @property integer $use_wysiwyg
 *
 * The followings are the available model relations:
 * @property ContentType $contentType
 * @property ContentItemFieldTrl[] $contentItemFieldTrls
 * @property ContentItemFieldValue[] $contentItemFieldValues
 */
class ContentItemField extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'content_item_field';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_type_id, field_type_id, priority, created_by_id, updated_by_id, created_time, updated_time, readonly, use_wysiwyg', 'numerical', 'integerOnly'=>true),
			array('label, field_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, field_name, content_type_id, field_type_id, priority, created_by_id, updated_by_id, created_time, updated_time, readonly, use_wysiwyg', 'safe', 'on'=>'search'),
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
			'contentType' => array(self::BELONGS_TO, 'ContentType', 'content_type_id'),
			'contentItemFieldTrls' => array(self::HAS_MANY, 'ContentItemFieldTrl', 'field_id'),
			'contentItemFieldValues' => array(self::HAS_MANY, 'ContentItemFieldValue', 'field_id'),
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
			'field_name' => 'Field Name',
			'content_type_id' => 'Content Type',
			'field_type_id' => 'Field Type',
			'priority' => 'Priority',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'readonly' => 'Readonly',
			'use_wysiwyg' => 'Use Wysiwyg',
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
		$criteria->compare('field_name',$this->field_name,true);
		$criteria->compare('content_type_id',$this->content_type_id);
		$criteria->compare('field_type_id',$this->field_type_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('use_wysiwyg',$this->use_wysiwyg);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContentItemField the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
