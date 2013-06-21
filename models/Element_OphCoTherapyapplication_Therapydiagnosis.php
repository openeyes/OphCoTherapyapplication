<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * This is the model class for table "et_ophcotherapya_therapydiag".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $left_diagnosis1_id
 * @property integer $right_diagnosis1_id
 * @property integer $left_diagnosis2_id
 * @property integer $right_diagnosis2_id 
 *
 * The followings are the available model relations:
 *
 * @property ElementType $element_type
 * @property EventType $eventType
 * @property Event $event
 * @property User $user
 * @property User $usermodified
 * @property Disorder $left_diagnosis1
 * @property Disorder $right_diagnosis1
 * @property Disorder $left_diagnosis2
 * @property Disorder $right_diagnosis2
 */

class Element_OphCoTherapyapplication_Therapydiagnosis extends SplitEventTypeElement
{
	public $service;

	/**
	 * Returns the static model of the specified AR class.
	 * @return the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophcotherapya_therapydiag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, left_diagnosis1_id, left_diagnosis2_id, right_diagnosis1_id, right_diagnosis2_id, eye_id', 'safe'),
			array('left_diagnosis1_id', 'requiredIfSide', 'side' => 'left'),
			array('left_diagnosis2_id', 'requiredIfSecondary', 'dependent' => 'left_diagnosis1_id'),
			array('right_diagnosis1_id', 'requiredIfSide', 'side' => 'right'),
			array('right_diagnosis2_id', 'requiredIfSecondary', 'dependent' => 'right_diagnosis1_id'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, event_id, left_diagnosis1_id, right_diagnosis1_id, left_diagnosis2_id, right_diagnosis2_id, eye_id', 'safe', 'on' => 'search'),
		);
	}
	
	public function sidedFields() {
		return array('diagnosis1_id', 'diagnosis2_id');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
			'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
			'left_diagnosis1' => array(self::BELONGS_TO, 'Disorder', 'left_diagnosis1_id'),
			'right_diagnosis1' => array(self::BELONGS_TO, 'Disorder', 'right_diagnosis1_id'),
			'left_diagnosis2' => array(self::BELONGS_TO, 'Disorder', 'left_diagnosis2_id'),
			'right_diagnosis2' => array(self::BELONGS_TO, 'Disorder', 'right_diagnosis2_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
			'left_diagnosis1_id' => 'Diagnosis',
			'right_diagnosis1_id' => 'Diagnosis',
			'left_diagnosis2_id' => 'Secondary To',
			'right_diagnosis2_id' => 'Secondary To',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);
		$criteria->compare('left_diagnosis1_id', $this->left_diagnosis1_id);
		$criteria->compare('right_diagnosis1_id', $this->right_diagnosis1_id);
		$criteria->compare('left_diagnosis2_id', $this->left_diagnosis2_id);
		$criteria->compare('right_diagnosis2_id', $this->right_diagnosis2_id);
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	public function getLevel1TherapyDiagnoses() {
		$criteria = new CDbCriteria;
		// FIXME: MySQL specific condition here
		$criteria->condition = 'parent_id IS NULL';
		$criteria->order = 'display_order asc';
		
		return OphCoTherapyapplication_TherapyDisorder::model()->with('disorder')->findAll($criteria);
	}

	protected function beforeSave()
	{
		return parent::beforeSave();
	}

	protected function afterSave()
	{

		return parent::afterSave();
	}

	protected function beforeValidate()
	{
		return parent::beforeValidate();
	}
	
	/*
	 * check that the standard intervention description is given if the element is flagged appropriately
	*/
	public function requiredIfSecondary($attribute, $params) {
		if ($this->$params['dependent'] && !$this->$attribute) {
			$criteria = new CDbCriteria;
			// FIXME: mysql dependent NULL check
			$criteria->condition = 'disorder_id = :did AND parent_id IS NULL';
			$criteria->params = array(':did' => $this->$params['dependent']);
			if ($td = OphCoTherapyapplication_TherapyDisorder::model()->with('disorder')->find($criteria)) {
				if ($td->getLevel2Disorders()) {
					$this->addError($attribute, $td->disorder->term . " must be secondary to another diagnosis");
				}
			}
		}
	}
}
?>