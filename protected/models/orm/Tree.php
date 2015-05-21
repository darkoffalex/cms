<?php

/**
 * This is the model class for table "tree".
 *
 * The followings are the available columns in table 'tree':
 * @property integer $id
 * @property integer $parent_id
 * @property string $branch
 * @property string $label
 * @property integer $status_id
 * @property integer $item_sort_type_id
 * @property integer $priority
 * @property integer $created_by_id
 * @property integer $updated_by_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property string $template_name
 * @property string $layout_name
 * @property string $item_template_name
 * @property integer $readonly
 *
 * The followings are the available model relations:
 * @property ContentItem[] $contentItems
 * @property ImageOfTree[] $imageOfTrees
 * @property Menu[] $menus
 * @property TreeTrl[] $treeTrls
 * @property Widget[] $widgets
 */
class Tree extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tree';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, status_id, item_sort_type_id, priority, created_by_id, updated_by_id, created_time, updated_time, readonly', 'numerical', 'integerOnly'=>true),
			array('branch, label, template_name, layout_name, item_template_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, branch, label, status_id, item_sort_type_id, priority, created_by_id, updated_by_id, created_time, updated_time, template_name, layout_name, item_template_name, readonly', 'safe', 'on'=>'search'),
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
			'contentItems' => array(self::HAS_MANY, 'ContentItem', 'tree_id'),
			'imageOfTrees' => array(self::HAS_MANY, 'ImageOfTree', 'tree_id'),
			'menus' => array(self::HAS_MANY, 'Menu', 'tree_id'),
			'treeTrls' => array(self::HAS_MANY, 'TreeTrl', 'tree_id'),
			'widgets' => array(self::HAS_MANY, 'Widget', 'tree_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'branch' => 'Branch',
			'label' => 'Label',
			'status_id' => 'Status',
			'item_sort_type_id' => 'Item Sort Type',
			'priority' => 'Priority',
			'created_by_id' => 'Created By',
			'updated_by_id' => 'Updated By',
			'created_time' => 'Created Time',
			'updated_time' => 'Updated Time',
			'template_name' => 'Template Name',
			'layout_name' => 'Layout Name',
			'item_template_name' => 'Item Template Name',
			'readonly' => 'Readonly',
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('branch',$this->branch,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('item_sort_type_id',$this->item_sort_type_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('created_by_id',$this->created_by_id);
		$criteria->compare('updated_by_id',$this->updated_by_id);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('updated_time',$this->updated_time);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('layout_name',$this->layout_name,true);
		$criteria->compare('item_template_name',$this->item_template_name,true);
		$criteria->compare('readonly',$this->readonly);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tree the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
