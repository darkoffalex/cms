<?php

/**
 * This is the model class for table "user_info".
 *
 * The followings are the available columns in table 'user_info':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $last_name
 * @property string $middle_name
 * @property string $nick_name
 * @property integer $avatar_pic_id
 * @property integer $address_as_text
 * @property integer $preferred_langauge_id
 * @property integer $preferred_country_id
 * @property integer $preferred_city_id
 * @property string $prefered_admin_language
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class UserInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, avatar_pic_id, address_as_text, preferred_langauge_id, preferred_country_id, preferred_city_id', 'numerical', 'integerOnly'=>true),
			array('name, last_name, middle_name, nick_name, prefered_admin_language', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, name, last_name, middle_name, nick_name, avatar_pic_id, address_as_text, preferred_langauge_id, preferred_country_id, preferred_city_id, prefered_admin_language', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'Users', 'info_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'name' => 'Name',
			'last_name' => 'Last Name',
			'middle_name' => 'Middle Name',
			'nick_name' => 'Nick Name',
			'avatar_pic_id' => 'Avatar Pic',
			'address_as_text' => 'Address As Text',
			'preferred_langauge_id' => 'Preferred Langauge',
			'preferred_country_id' => 'Preferred Country',
			'preferred_city_id' => 'Preferred City',
			'prefered_admin_language' => 'Prefered Admin Language',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('avatar_pic_id',$this->avatar_pic_id);
		$criteria->compare('address_as_text',$this->address_as_text);
		$criteria->compare('preferred_langauge_id',$this->preferred_langauge_id);
		$criteria->compare('preferred_country_id',$this->preferred_country_id);
		$criteria->compare('preferred_city_id',$this->preferred_city_id);
		$criteria->compare('prefered_admin_language',$this->prefered_admin_language,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->main;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
