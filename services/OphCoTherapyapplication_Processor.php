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

class OphCoTherapyapplication_Processor {
	private $events_by_id = array();
	private $controller = null;
	
	private $_viewpath = null;
	
	/**
	 * wrapper for crude caching of event data by id - might need a flushing mechanism if this class gets wider
	 * usage to manage the events in this module
	 * 
	 * @param unknown $event_id
	 * @return multitype:
	 */
	private function getEvent($event_id) {
		if (!isset($this->events_by_id[$event_id])) {
			
			$event = Event::model()->findByPk($event_id);
			$this->events_by_id[$event_id]['event'] = $event;
			
			$event_type = EventType::model()->find('class_name = ?',array('OphCoTherapyapplication'));
			
			$criteria = new CDbCriteria;
			$criteria->compare('event_type_id',$event_type->id);
			$criteria->order = 'display_order asc';
						
			$elements = array();
			
			
			foreach (ElementType::model()->findAll($criteria) as $element_type) {
				$element_class = $element_type->class_name;
			
				if ($element = $element_class::model()->find('event_id = ?',array($event->id))) {
					$elements[$element_class] = $element;
				}
			}
			
			$this->events_by_id[$event_id]['elements'] = $elements;
		}
		
		return $this->events_by_id[$event_id];
	}
	
	/**
	 * get a controller class for use with rendering etc
	 * 
	 * @return CController $controller
	 */
	protected function getController() {
		if (!$this->controller) {
			if (isset(Yii::app()->controller)) {
				$this->controller = Yii::app()->controller;
			}
			else {
				$this->controller = new CController('OphCoTherapyapplication');
			}
		}
		return $this->controller;
	}
	
	/**
	 * get the view path for email templates
	 * 
	 * @return string
	 */
	protected function getViewPath() {
		if (!$this->_viewpath) {
			$module = Yii::app()->getModule('OphCoTherapyapplication');
			$this->_viewpath = $module->getViewPath() . DIRECTORY_SEPARATOR . 'email';
		}
		return $this->_viewpath;
	}
	
	public function addProcessWarning($event_id, $warning) {
		if (!isset($this->events_by_id[$event_id]['warnings']) ) {
			$this->events_by_id[$event_id]['warnings'] = array();
		}
		$this->events_by_id[$event_id]['warnings'][] = $warning;
	}
	
	public function getProcessWarnings($event_id) {
		if (isset($this->events_by_id[$event_id]['warnings'])) {
			return $this->events_by_id[$event_id]['warnings'];
		}
		else {
			return array();
		}
	}
	
	/**
	 * determine if the the event can be processed for application
	 * 
	 * @param unknown $event_id
	 * @return boolean
	 */
	public function canProcessEvent($event_id) {
		$event_data = $this->getEvent($event_id);
		$elements = $event_data['elements'];
		$event = $event_data['event'];
		if (!isset($elements['Element_OphCoTherapyapplication_Email'])) {
			// need to determine if the appropriate information has been captured for the relevant eyes in examination
			if ($api = Yii::app()->moduleAPI->get('OphCiExamination')) {
				$el_diag  = $elements['Element_OphCoTherapyapplication_Therapydiagnosis'];
				$sides = array();
				$missing_sides = array();
				
				if ($el_diag->hasLeft()) {
					if (count($api->getInjectionManagementQuestionsForDisorder($el_diag->left_diagnosis_id))) {
						$sides[] = 'left';
					}
				}
				if ($el_diag->hasRight()) {
					if (count($api->getInjectionManagementQuestionsForDisorder($el_diag->right_diagnosis_id))) {
						$sides[] = 'right';
					}
				}
				
				foreach ($sides as $side) {
					if (!$api->getInjectionManagementComplexInEpisodeForDisorder($event->episode->patient, $event->episode, $side, $el_diag->{$side . '_diagnosis_id'})) {
						$missing_sides[] = $side;
					}
				}
				
				if (!count($missing_sides)) {
					return true;
				}
				
				// log warnings - false falls out at the end
				foreach ($missing_sides as $missing) {
					$this->addProcessWarning($event_id, 'No Injection Management has been created for ' . $missing . ' diagnosis ' . $el_diag->{$missing . '_diagnosis'}->term);
				}
			
			}
		}
		
		return false;
		
	}
	
	protected function generatePDFForSide($data, $side) {
		$pdf = new OETCPDF();
		$pdf->setAuthor('OpenEyes');
		$pdf->setTitle('Therapy Application');
		$pdf->SetSubject('Therapy Application');
		
		$template_data = array();
		foreach ($data as $k => $v) {
			$template_data[$k] = $v;
		}
		$template_data['side'] = $side;
		$template_data['treatment'] = $template_data['suitability']->{$side . '_treatment'};
		
		$controller = $this->getController();
		
		if ($data['suitability']->{$side . "_nice_compliance"}) {
			$file = $this->getViewPath() . DIRECTORY_SEPARATOR . 'pdf_compliant';
		}
		else {
			$file = $this->getViewPath() . DIRECTORY_SEPARATOR . 'pdf_noncompliant';
		}
		
		if ($template_data['treatment']->template_code) {
			$specific = $file . "_" . $template_data['treatment']->template_code . ".php";
			if (file_exists($specific)) {
				$file = $specific;
			}
			else {
				$file .= ".php";
			}
		}
		
		if (file_exists($file)) {
			$body = $controller->renderInternal($file, $template_data, true);
			
			$letter = new OELetter();
			$letter->setBarcode("E:" . $data['event']->id);
			$letter->addBody($body);
			$letter->render($pdf);
			
			// TODO, need to fix this to save to a better location
			// TODO: when we have the file management stuff, this should be creating a File object to
			// store the PDF ...
			$filename = Yii::app()->basePath."/fileassets/".$pdf->getDocref().".pdf";
			$pdf->Output($filename, "F");
			
			return $filename;
		}
	}
	
	protected function generateEmailForSide($data, $side) {
		$template_data = array();
		foreach ($data as $k => $v) {
			$template_data[$k] = $v;
		}
		$template_data['side'] = $side;
		$template_data['treatment'] = $template_data['suitability']->{$side . '_treatment'};
		
		if ($this->eventSideIsCompliant($data['event']->id, $side)) {
			$file = 'email_compliant.php';
		}
		else {
			$file = 'email_noncompliant.php';
		}
		
		$view = $this->getViewPath() . DIRECTORY_SEPARATOR . $file;
		$controller = $this->getController();
		
		return $controller->renderInternal($view, $template_data, true);
		
	}
	
	/**
	 * determine if the side of the event is compliant
	 * 
	 * @param unknown $event_id
	 * @param unknown $side
	 */
	public function eventSideIsCompliant($event_id, $side) {
		$event_data = $this->getEvent($event_id);
		// TODO: check that the side is relevant for the application
		return $event_data['elements']['Element_OphCoTherapyapplication_PatientSuitability']->{$side . '_nice_compliance'};
	}
	
	/**
	 * processes the application for the event with id $event_id returns a boolean to indicate whether this was successful
	 * or not.
	 * 
	 * @param integer $event_id
	 * @throws Exception
	 * @return boolean
	 */
	public function processEvent($event_id) {
		$event_data = $this->getEvent($event_id);
		if (isset($elements['Element_OphCoTherapyapplication_Email'])) {
			throw new Exception('Cannot re-process an event');
		}
		
		$event = $event_data['event'];
		
		$data = array(
				'patient' => $event->episode->patient,
				'event' => $event,
				'diagnosis' => $event_data['elements']['Element_OphCoTherapyapplication_Therapydiagnosis'],
				'suitability' => $event_data['elements']['Element_OphCoTherapyapplication_PatientSuitability'],
				'service_info' => $event_data['elements']['Element_OphCoTherapyapplication_MrServiceInformation'],
				'contraindications' => @$event_data['elements']['Element_OphCoTherapyapplication_Relativecontraindications'],
		);
		if (isset($event_data['elements']['Element_OphCoTherapyapplication_ExceptionalCircumstances'])) {
			$data['exceptional'] = $event_data['elements']['Element_OphCoTherapyapplication_ExceptionalCircumstances'];
		}
		
		$email_el = new Element_OphCoTherapyapplication_Email();
		$email_el->event_id = $event_id;
		// set the eye value to that of the diagnosis
		$email_el->eye_id = $data['diagnosis']->eye_id;
		
		if ($data['diagnosis']->hasLeft()) {
			if ($file = $this->generatePDFForSide($data, 'left')) {
				$email_el->left_application = $file;
			}
			$email_el->left_email_text = $this->generateEmailForSide($data, 'left');
		}
		
		if ($data['diagnosis']->hasRight()) {
			if ($file = $this->generatePDFForSide($data, 'right')) {
				$email_el->right_application = $file;
			}
			$email_el->right_email_text = $this->generateEmailForSide($data,'right');
		}
		
		// send email
		$email_el->save();
		$email_el->sendEmail();
		
		// do audit
		
		return true;
	}
}