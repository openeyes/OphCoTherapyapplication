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

class DefaultController extends BaseEventTypeController {

	// TODO: check this is in line with Jamie's change circa 3rd April 2013
	protected function beforeAction($action)
	{
		if (!Yii::app()->getRequest()->getIsAjaxRequest() && !(in_array($action->id,$this->printActions())) ) {
			Yii::app()->getClientScript()->registerCssFile(Yii::app()->createUrl('css/spliteventtype.css'));
			Yii::app()->getClientScript()->registerScriptFile(Yii::app()->createUrl('js/spliteventtype.js'));
		}
		
		$res = parent::beforeAction($action);
	
		return $res;
	}
	
	public function actionCreate() {
		$this->jsVars['decisiontree_url'] = Yii::app()->createUrl('OphCoTherapyapplication/default/getDecisionTree/');
		parent::actionCreate();
	}

	public function actionUpdate($id) {
		$this->jsVars['decisiontree_url'] = Yii::app()->createUrl('OphCoTherapyapplication/default/getDecisionTree/');
		parent::actionUpdate($id);
	}

	public function actionView($id) {
		parent::actionView($id);
	}

	public function actionPrint($id) {
		parent::actionPrint($id);
	}
	
	public function getDefaultElements($action, $event_type_id=false, $event=false) {
		$elements = parent::getDefaultElements($action, $event_type_id, $event);
		
		if ($action == 'create' && empty($_POST)) { 
			// set any calculated defaults on the elements
			foreach ($elements as $element) {
				if (get_class($element) == 'Element_OphCoTherapyapplication_Therapydiagnosis') {
					// get the list of valid diagnosis codes
					$valid_disorders = OphCoTherapyapplication_TherapyDisorder::model()->findAll();
					$vd_ids = array();
					foreach ($valid_disorders as $vd) {
						$vd_ids[] = $vd->disorder_id;
					}
					
					$episode = $this->episode;
					
					if ($episode) {
						$element->eye_id = $episode->eye_id;
						
						// foreach eye
						foreach (array(SplitEventTypeElement::LEFT, SplitEventTypeElement::RIGHT) as $eye_id) {
							$prefix = $eye_id == SplitEventTypeElement::LEFT ? 'left' : 'right';
							// check if the episode diagnosis applies
							if ( ($episode->eye_id == $eye_id || $episode->eye_id == SplitEventTypeElement::BOTH) 
								&& in_array($episode->disorder_id, $vd_ids) ) {
								$element->{$prefix . '_diagnosis_id'} = $episode->disorder_id;
							}
							// otherwise get ordered list of diagnoses for the eye in this episode, and check
							else {
								if ($api = Yii::app()->moduleAPI->get('OphCiExamination'))  {
									$disorders = $api->getOrderedDisorders($this->patient, $episode);
									foreach ($disorders as $disorder) {
										if ( ($disorder['eye_id'] == $eye_id || $disorder['eye_id'] == 3) && in_array($disorder['disorder_id'], $vd_ids)) {
											$element->{$prefix . '_diagnosis_id'} = $disorder['disorder_id'];
											break;
										}
									}
								}
							}
						}
					}
					
				} // end Therapydiagnosis setup
			}
		}
		return $elements;
		
	}
	
	public function actionGetDecisionTree() {
		
		if (!$this->patient = Patient::model()->findByPk((int)@$_GET['patient_id'])) {
			throw new CHttpException(403, 'Invalid patient_id.');
		}
		if (!$treatment = OphCoTherapyapplication_Treatment::model()->findByPk((int)@$_GET['treatment_id']) ) {
			throw new CHttpException(403, 'Invalid treatment_id.');
		}
		
		$element = new Element_OphCoTherapyapplication_PatientSuitability();
		
		$side = @$_GET['side'];
		if (!in_array($side, array('left', 'right'))) {
			throw Exception('Invalid side argument');
		}

		$element->{$side . '_treatment'} = $treatment;
		
		
		$form = Yii::app()->getWidgetFactory()->createWidget($this,'BaseEventTypeCActiveForm',array(
				'id' => 'clinical-create',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'sliding'),
		));
		
		// NEED TO WORK OUT what we should initialise here (and in the form for patient suitability)
		// so that we can set the right values for this form.
		$this->renderPartial(
				'form_OphCoTherapyapplication_DecisionTree',
				array('element' => $element, 'form' => $form, 'side' => $side),
				false, false
				);
	}
	
	public function getNodeResponseValue($element, $side, $node_id) {
		if (isset($_POST['Element_OphCoTherapyapplication_PatientSuitability'][$side . '_DecisionTreeResponse']) ) {
			// responses have been posted, so should operate off the value for this node.
			return @$_POST['Element_OphCoTherapyapplication_PatientSuitability'][$side . '_DecisionTreeResponse'][$node_id];
		}
		foreach ($element->{$side . '_responses'} as $response) {
			if ($response->node_id == $node_id) {
				return $response->value;
			}
		}
		$node = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk($node_id);
		
		return $node->getDefaultValue($side, $this->patient);
	}
	
	/*
	 * similar to setPOSTManyToMany, but will actually call methods on the elements that will create database entries
	* should be called on create and update.
	*
	*/
	protected function storePOSTManyToMany($elements) {
		foreach ($elements as $el) {
			if (get_class($el) == 'Element_OphCoTherapyapplication_PatientSuitability') {
				// note we don't do this in POST Validation as we don't need to validate the values of the decision tree selection
				// this is really just for record keeping - we are mainly interested in whether or not it's got compliance value
				$el->updateDecisionTreeResponses(Element_OphCoTherapyapplication_PatientSuitability::LEFT, 
						isset($_POST['Element_OphCoTherapyapplication_PatientSuitability']['left_DecisionTreeResponse']) ? 
						$_POST['Element_OphCoTherapyapplication_PatientSuitability']['left_DecisionTreeResponse'] : 
						array());
				$el->updateDecisionTreeResponses(Element_OphCoTherapyapplication_PatientSuitability::RIGHT,
						isset($_POST['Element_OphCoTherapyapplication_PatientSuitability']['right_DecisionTreeResponse']) ?
						$_POST['Element_OphCoTherapyapplication_PatientSuitability']['right_DecisionTreeResponse'] :
						array());
				
			}
		}
	}
	
	/*
	 * strip elements out that the data does not  have an eye_id for
	 * 
	 * @param array(Element) list of elements
	 * @param array() associative array of data for elements (typically $_POST)
	 * 
	 */
	private function filterElementsByData($elements, $data) {
		$required_elements = array();
		foreach ($elements as $element) {
			if ($element->hasAttribute('eye_id') && !$data[get_class($element)]['eye_id']) {
				continue;
			}
			$required_elements[] = $element;
		}
		
		return $required_elements;
	}
	
	/*
	 * extending parent behaviour to drop the elements not needed if the eye_id is not defined
	 * (note this is relying on the web interface to have behaved correctly to set this value according
	 * to the behaviour rules)
	 * 
	 */
	protected function validatePOSTElements($elements) {
		return parent::validatePOSTElements($this->filterElementsByData($elements, $_POST));
	}
	
	/*
	 * ensures Many Many fields processed for elements
	*/
	public function createElements($elements, $data, $firm, $patientId, $userId, $eventTypeId) {
		$req_elements = $this->filterElementsByData($elements, $data);
		
		if ($id = parent::createElements($req_elements, $data, $firm, $patientId, $userId, $eventTypeId)) {
			// create has been successful, store many to many values
			$this->storePOSTManyToMany($req_elements);
		}
		return $id;
	}
	
	/*
	 * ensures Many Many fields processed for elements
	*/
	public function updateElements($elements, $data, $event) {
		$req_elements = $this->filterElementsByData($elements, $data);
		
		if ($response = parent::updateElements($req_elements, $data, $event)) {
			// update has been successful, now need to deal with many to many changes
			$this->storePOSTManyToMany($elements);
		}
		return $response;
	}
} 
