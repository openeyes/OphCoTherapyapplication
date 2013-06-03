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
 * This is the model class for table "et_ophcotherapya_exceptional".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property boolean $left_standard_intervention_exists
 * @property string $left_details
 * @property integer $left_intervention_id
 * @property string $left_description
 * @property integer $left_patient_factors
 * @property string $left_patient_factor_details
 * @property boolean $right_standard_intervention_exists
 * @property string $right_details
 * @property integer $right_intervention_id
 * @property string $right_description
 * @property integer $right_patient_factors
 * @property string $right_patient_factor_details
 *
 * The followings are the available model relations:
 *
 * @property ElementType $element_type
 * @property EventType $eventType
 * @property Event $event
 * @property User $user
 * @property User $usermodified
 * @property array(OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention) $left_previnterventions
 * @property array(OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention) $right_previnterventions
 */

class Element_OphCoTherapyapplication_ExceptionalCircumstances extends SplitEventTypeElement
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
		return 'et_ophcotherapya_exceptional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, eye_id, left_standard_intervention_exists, left_details, left_intervention_id, left_description, left_patient_factors, ' .
					'left_patient_factor_details, right_standard_intervention_exists, right_details, right_intervention_id, right_description, ' . 
					'right_patient_factors, right_patient_factor_details', 'safe'),
			array('left_standard_intervention_exists, left_intervention_id, left_description, left_patient_factors,', 
					'requiredIfSide', 'side' => 'left'),
			array('right_standard_intervention_exists, right_intervention_id, right_description, right_patient_factors,',
					'requiredIfSide', 'side' => 'right'),
			array('left_details', 'requiredIfStandardInterventionExists', 'side' => 'left'),
			array('right_details', 'requiredIfStandardInterventionExists', 'side' => 'right'),
			array('left_patient_factor_details', 'requiredIfPatientFactors', 'side' => 'left'),
			array('right_patient_factor_details', 'requiredIfPatientFactors', 'side' => 'right'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, event_id, left_standard_intervention_exists, left_details, left_intervention_id, left_description, left_patient_factors, ' .
					'left_patient_factor_details, right_standard_intervention_exists, right_details, right_intervention_id, right_description, ' . 
					'right_patient_factors, right_patient_factor_details', 'safe', 'on' => 'search'),
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
			'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
			'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
			'left_intervention' => array(self::BELONGS_TO, 'Element_OphCoTherapyapplication_ExceptionalCircumstances_Intervention', 'left_intervention_id'),
			'right_intervention' => array(self::BELONGS_TO, 'Element_OphCoTherapyapplication_ExceptionalCircumstances_Intervention', 'right_intervention_id'),
			'previnterventions' => array(self::HAS_MANY, 'OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention', 'exceptional_id'),
			'left_previnterventions' => array(self::HAS_MANY, 'OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention', 'exceptional_id', 
					'on' => 'left_previnterventions.exceptional_side_id = ' . SplitEventTypeElement::LEFT),
			'right_previnterventions' => array(self::HAS_MANY, 'OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention', 'exceptional_id',
					'on' => 'right_previnterventions.exceptional_side_id = ' . SplitEventTypeElement::RIGHT),
			'filecollection_assignments' => array(self::HAS_MANY, 'OphCoTherapyapplication_ExceptionalCircumstances_FileCollectionAssignment' , 'exceptional_id' ),
			'left_filecollections' => array(self::HAS_MANY, 'OphCoTherapyapplication_FileCollection', 'collection_id', 'through' => 'filecollection_assignments', 'on' => 'filecollection_assignments.exceptional_side_id = ' . SplitEventTypeElement::LEFT),
			'right_filecollections' => array(self::HAS_MANY, 'OphCoTherapyapplication_FileCollection', 'collection_id', 'through' => 'filecollection_assignments', 'on' => 'filecollection_assignments.exceptional_side_id = ' . SplitEventTypeElement::RIGHT),
		);
	}

	public function sidedFields() {
		return array('standard_intervention_exists', 'details', 'intervention_id', 'description', 'patient_factors', 'patient_factor_details');
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'id' => 'ID',
			'event_id' => 'Event',
			'left_standard_intervention_exists' => 'Standard Intervention Exists',
			'left_details' => 'Details and standard algorithm of care',
			'left_intervention_id' => 'Intervention',
			'left_description' => 'Description',
			'left_patient_factors' => 'Patient Factors',
			'left_patient_factor_details' => 'Patient Factor Details',
			'left_previnterventions' => 'Previous Interventions',
			'left_filecollections' => 'File Sets',
			'right_standard_intervention_exists' => 'Standard Intervention Exists',
			'right_description' => 'Description',
			'right_details' => 'Details and standard algorithm of care',
			'right_intervention_id' => 'Intervention',
			'right_patient_factors' => 'Patient Factors',
			'right_patient_factor_details' => 'Patient Factor Details',
			'right_previnterventions' => 'Previous Interventions',
			'right_filecollections' => 'File Sets',
		);
		foreach(array('left', 'right') as $side) {
			if ($this->{$side . '_intervention'}) {
				$labels[$side . '_description'] = $this->{$side . '_intervention'}->description_label;
			}
		}
		
		return $labels;
		
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
		$criteria->compare('standard_intervention_exists', $this->standard_intervention_exists);
		$criteria->compare('details', $this->details);
		$criteria->compare('interventions_id', $this->interventions_id);
		$criteria->compare('description', $this->description);
		$criteria->compare('patient_factors', $this->patient_factors);
		$criteria->compare('patient_factor_details', $this->patient_factor_details);
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
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
	public function requiredIfStandardInterventionExists($attribute, $params) {
		if (($params['side'] == 'left' && $this->eye_id != 2) || ($params['side'] == 'right' && $this->eye_id != 1)) {
			if ($this->{$params['side'] . '_standard_intervention_exists'} && $this->$attribute == null) {
				$this->addError($attribute, ucfirst($params['side'])." ".$this->getAttributeLabel($attribute)." cannot be blank.");
			}
		}
	}
	
	public function requiredIfPatientFactors($attribute, $params) {
		if (($params['side'] == 'left' && $this->eye_id != 2) || ($params['side'] == 'right' && $this->eye_id != 1)) {
			if ($this->{$params['side'] . '_patient_factors'} && $this->$attribute == null) {
				$this->addError($attribute, ucfirst($params['side'])." ".$this->getAttributeLabel($attribute)." cannot be blank.");
			}
		}
	}
	
	/**
	 * set the previous interventions for the specified side
	 * 
	 * @param integer $side - SplitEventTypeElement::LEFT or SplitEventTypeElement::RIGHT
	 * @param array $interventions - array of arrays(treatment_id, stopreason_id, (optional) id)
	 */
	public function updatePreviousInterventions($side, $interventions) {
		$curr_by_id = array();
		$save = array();
		
		// note we operate on previnterventions relation here, so that we avoid any custom assignment 
		// that might have taken place for the purposes of validation 
		// TODO: when looking at OE-2927 it might be better if we update the interventions in a different way
		// where the changes are stored when set for validation, and then afterSave is used to do the actual database changes
		foreach ($this->previnterventions as $curr) {
			if ($curr->exceptional_side_id == $side) {
				$curr_by_id[$curr->id] = $curr;
			}
		}
		
		foreach ($interventions as $intervention) {
			if (isset($intervention['id'])) {
				$curr_by_id[$intervention['id']]->attributes = $intervention;
				$save[] = $curr_by_id[$intervention['id']];
				unset($curr_by_id[$intervention['id']]);
			} 
			else {
				$prev = new OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention();
				$prev->attributes = $intervention;
				$prev->exceptional_id = $this->id;
				$prev->exceptional_side_id = $side;
				$save[] = $prev;
			}
		}
		
		foreach ($save as $s) {
			$s->save();
		}
		
		foreach ($curr_by_id as $id => $del) {
			$del->delete();
		}
	}
	
	/*
	 * update the file collections to support the exceptional circumstances of this application for the given side
	 * 
	 * @param string $side - left or right
	 * @param int[] $collection_ids - uids of the file collections to be used for this side.
	 */
	public function updateFileCollections($side, $collection_ids) {
		$curr_by_id = array();
		$save = array();
		
		foreach ($this->filecollection_assignments as $f) {
			if ($f->exceptional_side_id == $side) {
				$curr_by_id[$curr->id] = $curr;
			}
		}
		
		foreach ($collection_ids as $coll_id) {
			if (!array_key_exists($coll_id, $curr_by_id)) {
				$ass = new OphCoTherapyapplication_ExceptionalCircumstances_FileCollectionAssignment();
				$ass->attributes = array('exceptional_id' => $this->id, 'exceptional_side_id' => $side, 'collection_id' => $coll_id);
				$save[] = $ass;
			}
			else {
				unset($curr_by_id[$coll_id]);
			}
			
			foreach ($save as $s) {
				$s->save();
			}
			
			foreach ($curr_by_id as $curr) {
				$curr->delete();
			}
		}
	}
}
?>