<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property integer $id
 * @property integer $order_id
 * @property integer $image_id
 * @property string $product_name
 * @property integer $product_description
 * @property string $product_code
 * @property integer $product_weight
 * @property integer $product_sizes_w
 * @property integer $product_sizes_h
 * @property integer $product_sizes_l
 * @property integer $quantity
 * @property integer $price
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $created_by_id
 * @property integer $updated_by_id
 *
 * The followings are the available model relations:
 * @property Image $image
 * @property Order $order
 */
class OrderItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, image_id, product_description, product_weight, product_sizes_w, product_sizes_h, product_sizes_l, quantity, price, created_time, updated_time, created_by_id, updated_by_id', 'numerical', 'integerOnly'=>true),
			array('product_name, product_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_id, image_id, product_name, product_description, product_code, product_weight, product_sizes_w, product_sizes_h, product_sizes_l, quantity, price, created_time, updated_time, created_by_id, updated_by_id', 'safe', 'on'=>'search'),
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
			'image' => array(self::BELONGS_TO, 'Image', 'image_id'),
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'image_id' => 'Image',
			'product_name' => 'Product Name',
			'product_description' => 'Product Description',
			'product_code' => 'Product Code',
			'product_weight' => 'Product Weight',
			'product_sizes_w' => 'Product Sizes W',
			'product_sizes_h' => 'Product Sizes H',
			'product_sizes_l' => 'Product Sizes L',
			'quantity' => 'Quantity',
			'price' => 'Price',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('image_id',$this->image_id);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_description',$this->product_description);
		$criteria->compare('product_code',$this->product_code,true);
		$criteria->compare('product_weight',$this->product_weight);
		$criteria->compare('product_sizes_w',$this->product_sizes_w);
		$criteria->compare('product_sizes_h',$this->product_sizes_h);
		$criteria->compare('product_sizes_l',$this->product_sizes_l);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
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
	 * @return OrderItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
