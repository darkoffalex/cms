<?php

/**
 * This is the model class for table "widget_trl".
 *
 * The followings are the available columns in table 'widget_trl':
 * @property integer $id
 * @property integer $widget_id
 * @property integer $lng_id
 * @property string $title
 * @property string $custom_content
 *
 * The followings are the available model relations:
 * @property Language $lng
 * @property Widget $widget
 */
class WidgetTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'widget_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('widget_id, lng_id', 'numerical', 'integerOnly'=>true),
			array('title, custom_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, widget_id, lng_id, title, custom_content', 'safe', 'on'=>'search'),
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
			'lng' => array(self::BELONGS_TO, 'Language', 'lng_id'),
			'widget' => array(self::BELONGS_TO, 'Widget', 'widget_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'widget_id' => 'Widget',
			'lng_id' => 'Lng',
			'title' => 'Title',
			'custom_content' => 'Custom Content',
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
		$criteria->compare('widget_id',$this->widget_id);
		$criteria->compare('lng_id',$this->lng_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('custom_content',$this->custom_content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WidgetTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
