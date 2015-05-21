<?php

/**
 * This is the model class for table "content_item_field_value".
 *
 * The followings are the available columns in table 'content_item_field_value':
 * @property integer $id
 * @property integer $field_id
 * @property integer $content_item_id
 * @property integer $numeric_value
 * @property string $text_value
 *
 * The followings are the available model relations:
 * @property ContentItem $contentItem
 * @property ContentItemField $field
 * @property ContentItemFieldValueTrl[] $contentItemFieldValueTrls
 * @property FileOfValue[] $fileOfValues
 * @property ImageOfValue[] $imageOfValues
 */
class ContentItemFieldValue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'content_item_field_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('field_id, content_item_id, numeric_value', 'numerical', 'integerOnly'=>true),
			array('text_value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, field_id, content_item_id, numeric_value, text_value', 'safe', 'on'=>'search'),
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
			'contentItem' => array(self::BELONGS_TO, 'ContentItem', 'content_item_id'),
			'field' => array(self::BELONGS_TO, 'ContentItemField', 'field_id'),
			'contentItemFieldValueTrls' => array(self::HAS_MANY, 'ContentItemFieldValueTrl', 'value_id'),
			'fileOfValues' => array(self::HAS_MANY, 'FileOfValue', 'value_id'),
			'imageOfValues' => array(self::HAS_MANY, 'ImageOfValue', 'value_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'field_id' => 'Field',
			'content_item_id' => 'Content Item',
			'numeric_value' => 'Numeric Value',
			'text_value' => 'Text Value',
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
		$criteria->compare('field_id',$this->field_id);
		$criteria->compare('content_item_id',$this->content_item_id);
		$criteria->compare('numeric_value',$this->numeric_value);
		$criteria->compare('text_value',$this->text_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContentItemFieldValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
