<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property integer $status_id
 * @property integer $role_id
 * @property integer $readonly
 * @property string $name
 * @property string $surname
 * @property string $signature
 * @property string $avatar_filename
 * @property string $photo_filename
 * @property string $phone
 * @property string $mobile_phone
 * @property string $address
 * @property string $fax
 * @property integer $shop_client_type
 * @property string $shop_company_name
 * @property string $shop_personal_code
 * @property string $shop_company_code
 * @property string $shop_bank_name
 * @property string $shop_bank_account
 * @property string $shop_vat_code
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property string $ip_list
 * @property string $last_ip
 * @property integer $last_visit_time
 *
 * The followings are the available model relations:
 * @property Role $role
 * @property Comment[] $comments
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login', 'required'),
			array('status_id, role_id, readonly, shop_client_type, created_time, updated_time, created_by_id, updated_by_id, last_visit_time', 'numerical', 'integerOnly'=>true),
			array('login, phone, mobile_phone, fax', 'length', 'max'=>20),
			array('email', 'length', 'max'=>50),
			array('name, surname', 'length', 'max'=>30),
			array('signature, address', 'length', 'max'=>200),
			array('shop_company_name, shop_personal_code, shop_company_code, shop_bank_name, shop_bank_account, shop_vat_code', 'length', 'max'=>40),
			array('password, avatar_filename, photo_filename, ip_list, last_ip', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login, email, password, status_id, role_id, readonly, name, surname, signature, avatar_filename, photo_filename, phone, mobile_phone, address, fax, shop_client_type, shop_company_name, shop_personal_code, shop_company_code, shop_bank_name, shop_bank_account, shop_vat_code, created_time, updated_time, created_by_id, updated_by_id, ip_list, last_ip, last_visit_time', 'safe', 'on'=>'search'),
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
			'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'email' => 'Email',
			'password' => 'Password',
			'status_id' => 'Status',
			'role_id' => 'Role',
			'readonly' => 'Readonly',
			'name' => 'Name',
			'surname' => 'Surname',
			'signature' => 'Signature',
			'avatar_filename' => 'Avatar Filename',
			'photo_filename' => 'Photo Filename',
			'phone' => 'Phone',
			'mobile_phone' => 'Mobile Phone',
			'address' => 'Address',
			'fax' => 'Fax',
			'shop_client_type' => 'Shop Client Type',
			'shop_company_name' => 'Shop Company Name',
			'shop_personal_code' => 'Shop Personal Code',
			'shop_company_code' => 'Shop Company Code',
			'shop_bank_name' => 'Shop Bank Name',
			'shop_bank_account' => 'Shop Bank Account',
			'shop_vat_code' => 'Shop Vat Code',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'ip_list' => 'Ip List',
			'last_ip' => 'Last Ip',
			'last_visit_time' => 'Last Visit Time',
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('signature',$this->signature,true);
		$criteria->compare('avatar_filename',$this->avatar_filename,true);
		$criteria->compare('photo_filename',$this->photo_filename,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile_phone',$this->mobile_phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('shop_client_type',$this->shop_client_type);
		$criteria->compare('shop_company_name',$this->shop_company_name,true);
		$criteria->compare('shop_personal_code',$this->shop_personal_code,true);
		$criteria->compare('shop_company_code',$this->shop_company_code,true);
		$criteria->compare('shop_bank_name',$this->shop_bank_name,true);
		$criteria->compare('shop_bank_account',$this->shop_bank_account,true);
		$criteria->compare('shop_vat_code',$this->shop_vat_code,true);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('ip_list',$this->ip_list,true);
		$criteria->compare('last_ip',$this->last_ip,true);
		$criteria->compare('last_visit_time',$this->last_visit_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
