<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property string $code
 * @property integer $client_type_id
 * @property integer $payment_type_id
 * @property integer $delivery_id
 * @property string $delivery_address
 * @property integer $time_ordered
 * @property integer $time_paid
 * @property integer $time_delivered
 * @property integer $status_id
 * @property string $payment_sys_status_code
 * @property integer $payment_sys_status_id
 * @property string $client_name
 * @property string $client_surname
 * @property string $client_email
 * @property string $client_phone
 * @property string $client_comment
 * @property string $client_personacl_code
 * @property integer $client_is_company
 * @property string $client_company_name
 * @property string $client_company_code
 * @property string $client_company_vat_code
 * @property string $client_company_bank
 * @property string $client_company_bank_account
 * @property string $client_company_address
 * @property string $client_company_postal_index
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $created_by_id
 * @property integer $updated_by_id
 *
 * The followings are the available model relations:
 * @property OrderItem[] $orderItems
 * @property OrderDelivery $delivery
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_personacl_code', 'required'),
			array('client_type_id, payment_type_id, delivery_id, time_ordered, time_paid, time_delivered, status_id, payment_sys_status_id, client_is_company, created_time, updated_time, created_by_id, updated_by_id', 'numerical', 'integerOnly'=>true),
			array('code, delivery_address, payment_sys_status_code, client_name, client_surname, client_email, client_phone, client_comment, client_company_name, client_company_code, client_company_vat_code, client_company_bank, client_company_bank_account, client_company_address, client_company_postal_index', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, client_type_id, payment_type_id, delivery_id, delivery_address, time_ordered, time_paid, time_delivered, status_id, payment_sys_status_code, payment_sys_status_id, client_name, client_surname, client_email, client_phone, client_comment, client_personacl_code, client_is_company, client_company_name, client_company_code, client_company_vat_code, client_company_bank, client_company_bank_account, client_company_address, client_company_postal_index, created_time, updated_time, created_by_id, updated_by_id', 'safe', 'on'=>'search'),
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
			'orderItems' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
			'delivery' => array(self::BELONGS_TO, 'OrderDelivery', 'delivery_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'client_type_id' => 'Client Type',
			'payment_type_id' => 'Payment Type',
			'delivery_id' => 'Delivery',
			'delivery_address' => 'Delivery Address',
			'time_ordered' => 'Time Ordered',
			'time_paid' => 'Time Paid',
			'time_delivered' => 'Time Delivered',
			'status_id' => 'Status',
			'payment_sys_status_code' => 'Payment Sys Status Code',
			'payment_sys_status_id' => 'Payment Sys Status',
			'client_name' => 'Client Name',
			'client_surname' => 'Client Surname',
			'client_email' => 'Client Email',
			'client_phone' => 'Client Phone',
			'client_comment' => 'Client Comment',
			'client_personacl_code' => 'Client Personacl Code',
			'client_is_company' => 'Client Is Company',
			'client_company_name' => 'Client Company Name',
			'client_company_code' => 'Client Company Code',
			'client_company_vat_code' => 'Client Company Vat Code',
			'client_company_bank' => 'Client Company Bank',
			'client_company_bank_account' => 'Client Company Bank Account',
			'client_company_address' => 'Client Company Address',
			'client_company_postal_index' => 'Client Company Postal Index',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('client_type_id',$this->client_type_id);
		$criteria->compare('payment_type_id',$this->payment_type_id);
		$criteria->compare('delivery_id',$this->delivery_id);
		$criteria->compare('delivery_address',$this->delivery_address,true);
		$criteria->compare('time_ordered',$this->time_ordered);
		$criteria->compare('time_paid',$this->time_paid);
		$criteria->compare('time_delivered',$this->time_delivered);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('payment_sys_status_code',$this->payment_sys_status_code,true);
		$criteria->compare('payment_sys_status_id',$this->payment_sys_status_id);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('client_surname',$this->client_surname,true);
		$criteria->compare('client_email',$this->client_email,true);
		$criteria->compare('client_phone',$this->client_phone,true);
		$criteria->compare('client_comment',$this->client_comment,true);
		$criteria->compare('client_personacl_code',$this->client_personacl_code,true);
		$criteria->compare('client_is_company',$this->client_is_company);
		$criteria->compare('client_company_name',$this->client_company_name,true);
		$criteria->compare('client_company_code',$this->client_company_code,true);
		$criteria->compare('client_company_vat_code',$this->client_company_vat_code,true);
		$criteria->compare('client_company_bank',$this->client_company_bank,true);
		$criteria->compare('client_company_bank_account',$this->client_company_bank_account,true);
		$criteria->compare('client_company_address',$this->client_company_address,true);
		$criteria->compare('client_company_postal_index',$this->client_company_postal_index,true);
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
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
