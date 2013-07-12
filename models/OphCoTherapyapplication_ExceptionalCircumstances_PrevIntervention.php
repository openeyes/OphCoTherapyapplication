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
 * @property date $treatment_date
 * @property integer $treatment_id
 * @property integer $stopreason_id
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
			array('treatment_date, treatment_id, stopreason_id', 'safe'),
			array('treatment_date, treatment_id, stopreason_id', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, treatment_date, treatment_id, stopreason_id', 'safe', 'on' => 'search'),
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
			'treatment_date' => 'Date',
			'treatment_id' => 'Treatment',
			'stopreason_id' => 'Reason for stopping',
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
		$criteria->compare('name', $this->name, true);
		$criteria->compare('date', $this->date, true);

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
}
