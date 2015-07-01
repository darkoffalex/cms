<?php

/**
 * This is the model class for table "global_settings".
 *
 * The followings are the available columns in table 'global_settings':
 * @property integer $home_page_category_id
 * @property string $webmaster_email
 * @property string $admin_email
 * @property string $admin_phone
 * @property string $site_name
 * @property string $site_description
 * @property string $site_keywords
 * @property integer $per_page_qnt
 * @property integer $images_qnt
 * @property integer $files_qnt
 * @property string $active_theme
 */
class GlobalSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'global_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_name', 'required'),
			array('home_page_category_id, per_page_qnt, images_qnt, files_qnt', 'numerical', 'integerOnly'=>true),
			array('webmaster_email, admin_email, admin_phone, site_description, site_keywords, active_theme', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('home_page_category_id, webmaster_email, admin_email, admin_phone, site_name, site_description, site_keywords, per_page_qnt, images_qnt, files_qnt, active_theme', 'safe', 'on'=>'search'),
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
			'home_page_category_id' => 'Home Page Category',
			'webmaster_email' => 'Webmaster Email',
			'admin_email' => 'Admin Email',
			'admin_phone' => 'Admin Phone',
			'site_name' => 'Site Name',
			'site_description' => 'Site Description',
			'site_keywords' => 'Site Keywords',
			'per_page_qnt' => 'Per Page Qnt',
			'images_qnt' => 'Images Qnt',
			'files_qnt' => 'Files Qnt',
			'active_theme' => 'Active Theme',
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

		$criteria->compare('home_page_category_id',$this->home_page_category_id);
		$criteria->compare('webmaster_email',$this->webmaster_email,true);
		$criteria->compare('admin_email',$this->admin_email,true);
		$criteria->compare('admin_phone',$this->admin_phone,true);
		$criteria->compare('site_name',$this->site_name,true);
		$criteria->compare('site_description',$this->site_description,true);
		$criteria->compare('site_keywords',$this->site_keywords,true);
		$criteria->compare('per_page_qnt',$this->per_page_qnt);
		$criteria->compare('images_qnt',$this->images_qnt);
		$criteria->compare('files_qnt',$this->files_qnt);
		$criteria->compare('active_theme',$this->active_theme,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GlobalSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
