<?php

/**
 * This is the model class for table "content_item".
 *
 * The followings are the available columns in table 'content_item':
 * @property integer $id
 * @property integer $tree_id
 * @property string $label
 * @property string $template_name
 * @property string $priority
 * @property integer $status_id
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $readonly
 * @property integer $content_type_id
 *
 * The followings are the available model relations:
 * @property ContentItemTrl[] $contentItemTrls
 * @property ContentType $contentType
 * @property Tree $tree
 * @property ContentItemFieldValue[] $contentItemFieldValues
 */
class ContentItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'content_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tree_id, status_id, created_by_id, updated_by_id, created_time, updated_time, readonly, content_type_id', 'numerical', 'integerOnly'=>true),
			array('label, template_name, priority', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tree_id, label, template_name, priority, status_id, created_by_id, updated_by_id, created_time, updated_time, readonly, content_type_id', 'safe', 'on'=>'search'),
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
			'contentItemTrls' => array(self::HAS_MANY, 'ContentItemTrl', 'item_id'),
			'contentType' => array(self::BELONGS_TO, 'ContentType', 'content_type_id'),
			'tree' => array(self::BELONGS_TO, 'Tree', 'tree_id'),
			'contentItemFieldValues' => array(self::HAS_MANY, 'ContentItemFieldValue', 'content_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tree_id' => 'Tree',
			'label' => 'Label',
			'template_name' => 'Template Name',
			'priority' => 'Priority',
			'status_id' => 'Status',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'readonly' => 'Readonly',
			'content_type_id' => 'Content Type',
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
		$criteria->compare('tree_id',$this->tree_id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('content_type_id',$this->content_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContentItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
