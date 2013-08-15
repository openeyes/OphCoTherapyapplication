<?php /**
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
 * This is the model class for table "et_ophcotherapya_exceptional_interventions".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $exceptional_id
 * @property integer $exceptional_side_id
 * @property date $start_date
 * @property date $end_date
 * @property integer $treatment_id
 * @property string $start_va
 * @property string $end_va
 * @property integer $stopreason_id
 * @property string $stopreason_other
 * @property string $comments
 *
 * The followings are the available model relations:
 *
 * @property Element_OphCoTherapyapplication_ExceptionalCircumstances $exceptionalcircumstances
 * @property OphCoTherapyapplication_Treatment $treatment
 * @property OphCoTherapyapplication_StopReason $stop_reason
 */

class OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention extends BaseActiveRecord
{
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
		return 'ophcotherapya_exceptional_previntervention';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date, end_date, treatment_id, start_va, end_va, stopreason_id, stopreason_other, comments', 'safe'),
			array('start_date, end_date, treatment_id, start_va, end_va, stopreason_id', 'required'),
			array('stopreason_other', 'requiredIfStopReasonIsOther'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, start_date, end_date, treatment_id, start_va, end_va, stopreason_id, stopreason_other, comments', 'safe', 'on' => 'search'),
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
			'exceptionalcircumstances' => array(self::BELONGS_TO, 'Element_OphCoTherapyapplication_ExceptionalCircumstances', 'circumstances_id'),
			'treatment' => array(self::BELONGS_TO, 'OphCoTherapyapplication_Treatment', 'treatment_id'),
			'stopreason' => array(self::BELONGS_TO, 'OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention_StopReason', 'stopreason_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'start_date' => 'Start date',
			'end_date' => 'End date',
			'treatment_id' => 'Treatment',
			'start_va' => 'Pre treatment VA',
			'end_va' => 'Post treatment VA',
			'stopreason_id' => 'Reason for stopping',
			'stopreason_other' => 'Please describe the reason for stopping',
			'comments' => 'Comments'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('start_date', $this->start_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('treatment_id', $this->treatment_id, true);
		$criteria->compare('start_va', $this->start_va, true);
		$criteria->compare('end_va', $this->end_va, true);
		$criteria->compare('stopreason_id', $this->stopreason_id, true);
		$criteria->compare('stopreason_other', $this->stopreason_other, true);
		$criteria->compare('comments', $this->comments, true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions()
	{
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

	// internal store of valid va values that can be selected for start and end VA
	protected $_va_list = null;

	/**
	 * gets the valid VA values for use in a form.
	 *
	 * @return array key, value pair list
	 */
	public function getVaOptions()
	{
		if (is_null($this->_va_list)) {
			$va_list = OphCoTherapyapplication_Helper::getInstance()->getVaListForForm();
			if (!$this->isNewRecord) {
				$start_seen = false;
				$end_seen = false;
				foreach ($va_list as $key => $val) {
					if ($this->start_va == $key) {
						$start_seen = true;
					}
					if ($this->end_va == $key) {
						$end_seen = true;
					}
				}
				if (!$start_seen) {
					$va_list[] = array($this->start_va => $this->start_va);
				}
				if (!$end_seen) {
					$va_list[] = array($this->end_va => $this->end_va);
				}
			}
			$this->_va_list = $va_list;
		}
		return $this->_va_list;
	}
	
	
	/**
	 * validate that a reason is given if the stop reason select is of type other
	 * @param unknown $attribute
	 * @param unknown $params
	 */
	public function requiredIfStopReasonIsOther($attribute, $params)
	{
		if ($this->stopreason && $this->stopreason->other && $this->$attribute == null) {
			$this->addError($attribute, $this->getAttributeLabel($attribute)." is required when stop reason is set to " . $this->stopreason->name);
		}
	}

	/**
	 * get the text for the stopping reason for this treatment
	 *
	 * @return string
	 */
	public function getStopReasonText() {
		if ($this->stopreason) {
			if ($this->stopreason->other) {
				return $this->stopreason_other;
			} else {
				return $this->stopreason->name;
			}
		}
	}
}
