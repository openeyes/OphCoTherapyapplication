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

	/*
	protected function setPOSTManyToMany($element) {
		if (get_class($element) == 'Element_OphCoTherapyapplication_PatientSuitability') {
			// process responses:
			$responses = array();
			
			foreach (@$_POST['Element_OphCoTherapyapplication_PatientSuitability']['DecisionTreeResponse'] as $node_id => $response) {
				$resp = new OphCoTherapyapplication_PatientSuitability_DecisionTreeNodeResponse();
				$resp->node_id = $node_id;
				$resp->value = $response;
				$responses[] = $resp;
			}
			$element->responses = $responses;
		}
	}
	*/
	
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
	
	public function actionGetDecisionTree() {
		$treatment = OphCoTherapyapplication_Treatment::model()->findByPk((int)@$_GET['treatment_id']);
		$element = new Element_OphCoTherapyapplication_PatientSuitability();
		$element->treatment = $treatment;
		
		$form = Yii::app()->getWidgetFactory()->createWidget($this,'BaseEventTypeCActiveForm',array(
				'id' => 'clinical-create',
				'enableAjaxValidation' => false,
				'htmlOptions' => array('class' => 'sliding'),
		));
		
		// NEED TO WORK OUT what we should initialise here (and in the form for patient suitability)
		// so that we can set the right values for this form.
		$this->renderPartial(
				'form_OphCoTherapyapplication_DecisionTree',
				array('element' => $element, 'form' => $form),
				false, false
				);
	}
	
	public function getNodeResponseValue($element, $node_id) {
		if (isset($_POST['Element_OphCoTherapyapplication_PatientSuitability']['DecisionTreeResponse']) ) {
			// responses have been posted, so should operate off the value for this node.
			return @$_POST['Element_OphCoTherapyapplication_PatientSuitability']['DecisionTreeResponse'][$node_id];
		}
		foreach ($element->responses as $response) {
			if ($response->node_id == $node_id) {
				return $response->value;
			}
		}
		$node = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk($node_id);
		return $node->getDefaultValue($element);
	}
	
	/*
	 * similar to setPOSTManyToMany, but will actually call methods on the elements that will create database entries
	* should be called on create and update.
	*
	*/
	protected function storePOSTManyToMany($elements) {
		foreach ($elements as $el) {
			if (get_class($el) == 'Element_OphCoTherapyapplication_PatientSuitability') {
				$el->updateDecisionTreeResponses(isset($_POST['Element_OphCoTherapyapplication_PatientSuitability']['DecisionTreeResponse']) ? 
						$_POST['Element_OphCoTherapyapplication_PatientSuitability']['DecisionTreeResponse'] : 
						array());
				
			}
		}
	}
	
	/*
	 * ensures Many Many fields processed for elements
	*/
	public function createElements($elements, $data, $firm, $patientId, $userId, $eventTypeId) {
		if ($id = parent::createElements($elements, $data, $firm, $patientId, $userId, $eventTypeId)) {
			// create has been successful, store many to many values
			$this->storePOSTManyToMany($elements);
		}
		return $id;
	}
	
	/*
	 * ensures Many Many fields processed for elements
	*/
	public function updateElements($elements, $data, $event) {
		if ($response = parent::updateElements($elements, $data, $event)) {
			// update has been successful, now need to deal with many to many changes
			$this->storePOSTManyToMany($elements);
		}
		return $response;
	}
} 
