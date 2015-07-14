<?php

/**
 * This is the model class for table "role".
 *
 * The followings are the available columns in table 'role':
 * @property integer $id
 * @property string $label
 * @property string $permissions
 * @property integer $permission_level
 * @property integer $readonly
 * @property integer $admin_access
 * @property integer $created_time
 * @property integer $updated_time
 * @property integer $created_by_id
 * @property integer $updated_by_id
 *
 * The followings are the available model relations:
 * @property RoleTrl[] $roleTrls
 * @property User[] $users
 */
class Role extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('label', 'required'),
			array('permission_level, readonly, admin_access, created_time, updated_time, created_by_id, updated_by_id', 'numerical', 'integerOnly'=>true),
			array('permissions', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, permissions, permission_level, readonly, admin_access, created_time, updated_time, created_by_id, updated_by_id', 'safe', 'on'=>'search'),
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
			'roleTrls' => array(self::HAS_MANY, 'RoleTrl', 'role_id'),
			'users' => array(self::HAS_MANY, 'User', 'role_id'),
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
			'permissions' => 'Permissions',
			'permission_level' => 'Permission Level',
			'readonly' => 'Readonly',
			'admin_access' => 'Admin Access',
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
		$criteria->compare('label',$this->label,true);
		$criteria->compare('permissions',$this->permissions,true);
		$criteria->compare('permission_level',$this->permission_level);
		$criteria->compare('readonly',$this->readonly);
		$criteria->compare('admin_access',$this->admin_access);
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
	 * @return Role the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
