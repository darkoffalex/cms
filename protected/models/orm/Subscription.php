<?php

/**
 * This is the model class for table "subscription".
 *
 * The followings are the available columns in table 'subscription':
 * @property integer $id
 * @property string $email
 * @property integer $period_in_seconds
 * @property string $special_attributes
 * @property integer $last_time_send
 * @property integer $status_id
 * @property string $subscriber_ip
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $created_by_id
 * @property integer $updated_by_id
 */
class Subscription extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, period_in_seconds', 'required'),
			array('period_in_seconds, last_time_send, status_id, created_time, updated_time, created_by_id, updated_by_id', 'numerical', 'integerOnly'=>true),
			array('special_attributes, subscriber_ip', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, period_in_seconds, special_attributes, last_time_send, status_id, subscriber_ip, created_time, updated_time, created_by_id, updated_by_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'period_in_seconds' => 'Period In Seconds',
			'special_attributes' => 'Special Attributes',
			'last_time_send' => 'Last Time Send',
			'status_id' => 'Status',
			'subscriber_ip' => 'Subscriber Ip',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('period_in_seconds',$this->period_in_seconds);
		$criteria->compare('special_attributes',$this->special_attributes,true);
		$criteria->compare('last_time_send',$this->last_time_send);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('subscriber_ip',$this->subscriber_ip,true);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subscription the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
