<?php

/**
 * This is the model class for table "image".
 *
 * The followings are the available columns in table 'image':
 * @property integer $id
 * @property string $label
 * @property string $filename
 * @property string $original_filename
 * @property string $extension
 * @property string $mime_type
 * @property integer $size
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $created_time
 * @property integer $updated_time
 *
 * The followings are the available model relations:
 * @property ImageOfTree[] $imageOfTrees
 * @property ImageOfValue[] $imageOfValues
 * @property ImageTrl[] $imageTrls
 */
class Image extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('size, created_by_id, updated_by_id, created_time, updated_time', 'numerical', 'integerOnly'=>true),
			array('label, filename, original_filename, extension, mime_type', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, filename, original_filename, extension, mime_type, size, created_by_id, updated_by_id, created_time, updated_time', 'safe', 'on'=>'search'),
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
			'imageOfTrees' => array(self::HAS_MANY, 'ImageOfTree', 'image_id'),
			'imageOfValues' => array(self::HAS_MANY, 'ImageOfValue', 'image_id'),
			'imageTrls' => array(self::HAS_MANY, 'ImageTrl', 'image_id'),
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
			'filename' => 'Filename',
			'original_filename' => 'Original Filename',
			'extension' => 'Extension',
			'mime_type' => 'Mime Type',
			'size' => 'Size',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
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
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('original_filename',$this->original_filename,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('mime_type',$this->mime_type,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Image the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
