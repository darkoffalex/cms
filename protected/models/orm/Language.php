<?php

/**
 * This is the model class for table "language".
 *
 * The followings are the available columns in table 'language':
 * @property integer $id
 * @property string $label
 * @property string $name
 * @property string $prefix
 * @property integer $status
 * @property integer $priority
 *
 * The followings are the available model relations:
 * @property RoleTrl[] $roleTrls
 * @property TreeTrl[] $treeTrls
 * @property ContentItemFieldValueTrl[] $contentItemFieldValueTrls
 * @property ImageTrl[] $imageTrls
 * @property FileTrl[] $fileTrls
 * @property ContentItemFieldTrl[] $contentItemFieldTrls
 * @property WidgetTrl[] $widgetTrls
 * @property ContentItemTrl[] $contentItemTrls
 * @property TranslationTrl[] $translationTrls
 * @property OrderDeliveryTrl[] $orderDeliveryTrls
 */
class Language extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label, prefix', 'required'),
			array('status, priority', 'numerical', 'integerOnly'=>true),
			array('prefix', 'length', 'max'=>2),
			array('name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, name, prefix, status, priority', 'safe', 'on'=>'search'),
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
			'roleTrls' => array(self::HAS_MANY, 'RoleTrl', 'lng_id'),
			'treeTrls' => array(self::HAS_MANY, 'TreeTrl', 'lng_id'),
			'contentItemFieldValueTrls' => array(self::HAS_MANY, 'ContentItemFieldValueTrl', 'lng_id'),
			'imageTrls' => array(self::HAS_MANY, 'ImageTrl', 'lng_id'),
			'fileTrls' => array(self::HAS_MANY, 'FileTrl', 'lng_id'),
			'contentItemFieldTrls' => array(self::HAS_MANY, 'ContentItemFieldTrl', 'lng_id'),
			'widgetTrls' => array(self::HAS_MANY, 'WidgetTrl', 'lng_id'),
			'contentItemTrls' => array(self::HAS_MANY, 'ContentItemTrl', 'lng_id'),
			'translationTrls' => array(self::HAS_MANY, 'TranslationTrl', 'lng_id'),
			'orderDeliveryTrls' => array(self::HAS_MANY, 'OrderDeliveryTrl', 'lng_id'),
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
			'name' => 'Name',
			'prefix' => 'Prefix',
			'status' => 'Status',
			'priority' => 'Priority',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Language the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
