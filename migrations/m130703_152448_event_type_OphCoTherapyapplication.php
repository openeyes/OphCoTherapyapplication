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

class m130703_152448_event_type_OphCoTherapyapplication extends CDbMigration
{
	public function up()
	{
		if (!Yii::app()->hasModule('OphTrIntravitrealinjection')) {
			throw new Exception("OphTrIntravitrealinjection is required for this module to work");
		}

		if (!in_array('ophtrintravitinjection_treatment_drug',Yii::app()->db->getSchema()->tableNames)) {
			throw new Exception("OphTrIntravitrealinjection is required for this module to work");
		}

		// file collection table
		$this->createTable('ophcotherapya_filecoll', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(256) NOT NULL',
				'zipfile_id' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_filecoll_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_filecoll_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_filecoll_zi_fk` (`zipfile_id`)',
				'CONSTRAINT `et_ophcotherapya_filecoll_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_filecoll_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_filecoll_zi_fk` FOREIGN KEY (`zipfile_id`) REFERENCES `protected_file` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// file collection file assignments
		$this->createTable('ophcotherapya_filecoll_assignment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'collection_id' => 'int(10) unsigned NOT NULL',
				'file_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_filecollass_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_filecollass_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_filecollass_ci_fk` (`collection_id`)',
				'KEY `et_ophcotherapya_filecollass_fi_fk` (`file_id`)',
				'CONSTRAINT `et_ophcotherapya_filecollass_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_filecollass_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_filecollass_ci_fk` FOREIGN KEY (`collection_id`) REFERENCES `ophcotherapya_filecoll` (`id`)',
				'CONSTRAINT `et_ophcotherapya_filecollass_fi_fk` FOREIGN KEY (`file_id`) REFERENCES `protected_file` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// decision tree table creation
		$this->createTable('ophcotherapya_decisiontree', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_decisiontree_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_decisiontree_cui_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontree_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontree_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->createTable('ophcotherapya_decisiontreeoutcome', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(32) NOT NULL',
				'outcome_type' => 'varchar(16) NOT NULL', //understood by code so should be one of a fixed set of string values
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_decisiontreeoutcome_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_decisiontreeoutcome_cui_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontreeoutcome_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontreeoutcome_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_decisiontreeoutcome',array('name'=>'Compliant','outcome_type'=> 'COMP'));
		$this->insert('ophcotherapya_decisiontreeoutcome',array('name'=>'Non-Compliant','outcome_type'=> 'NCOM'));

		$this->createTable('ophcotherapya_decisiontreenode_responsetype', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'label' => 'varchar(32) NOT NULL',
				'datatype' => 'varchar(16) NOT NULL', // datatype that should be understood by the code for casting of response values (choices will all be strings)
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_decisiontreenode_rtype_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_decisiontreenode_rtype_cui_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontreenode_rtype_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontreenode_rtype_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_decisiontreenode_responsetype',array('label'=>'Integer','datatype'=> 'int'));
		$this->insert('ophcotherapya_decisiontreenode_responsetype',array('label'=>'string','datatype'=> 'str'));
		$this->insert('ophcotherapya_decisiontreenode_responsetype',array('label'=>'yes/no','datatype'=> 'bool'));
		$this->insert('ophcotherapya_decisiontreenode_responsetype',array('label'=>'Visual Acuity','datatype'=> 'va'));

		$this->createTable('ophcotherapya_decisiontreenode', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'decisiontree_id' => 'int(10) unsigned NOT NULL',
				'parent_id' => 'int(10) unsigned',
				'question' => 'varchar(256)',
				'outcome_id' => 'int(10) unsigned',
				'default_function' => 'varchar(64)',
				'default_value' => 'varchar(16)',
				'response_type_id' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_decisiontreenode_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_decisiontreenode_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_decisiontreenode_dti_fk` (`decisiontree_id`)',
				'KEY `ophcotherapya_decisiontreenode_pi_fk` (`parent_id`)',
				'KEY `ophcotherapya_decisiontreenode_oi_fk` (`outcome_id`)',
				'KEY `ophcotherapya_decisiontreenode_rti_fk` (`response_type_id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenode_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenode_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenode_dti_fk` FOREIGN KEY (`decisiontree_id`) REFERENCES `ophcotherapya_decisiontree` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenode_pi_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophcotherapya_decisiontreenode` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenode_oi_fk` FOREIGN KEY (`outcome_id`) REFERENCES `ophcotherapya_decisiontreeoutcome` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenode_rti_fk` FOREIGN KEY (`response_type_id`) REFERENCES `ophcotherapya_decisiontreenode_responsetype` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->createTable('ophcotherapya_decisiontreenoderule', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'node_id' => 'int(10) unsigned NOT NULL',
				'parent_check' => 'varchar(4)',
				'parent_check_value' => 'varchar(16)',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_decisiontreenoderule_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_decisiontreenoderule_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_decisiontreenoderule_ni_fk` (`node_id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenoderule_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenoderule_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenoderule_ni_fk` FOREIGN KEY (`node_id`) REFERENCES `ophcotherapya_decisiontreenode` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->createTable('ophcotherapya_decisiontreenodechoice', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'node_id' => 'int(10) unsigned NOT NULL',
				'label' => 'varchar(32) NOT NULL',
				'display_order' => 'int(10) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_decisiontreenodechoice_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_decisiontreenodechoice_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_decisiontreenodechoice_ni_fk` (`node_id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenodechoice_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenodechoice_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenodechoice_ni_fk` FOREIGN KEY (`node_id`) REFERENCES `ophcotherapya_decisiontreenode` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// disorder lookup for therapies
		$this->createTable('ophcotherapya_therapydisorder', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'disorder_id' => 'int(10) unsigned NOT NULL',
				'parent_id' => 'int(10) unsigned',
				'display_order' => 'int(10) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_therapydisorder_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_therapydisorder_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_therapydisorder_di_fk` (`disorder_id`)',
				'KEY `ophcotherapya_therapydisorder_pi_fk` (`parent_id`)',
				'CONSTRAINT `ophcotherapya_therapydisorder_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_therapydisorder_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_therapydisorder_di_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `ophcotherapya_therapydisorder_pi_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophcotherapya_therapydisorder` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>75971007,'display_order'=>1));
		$cnv_id = Yii::app()->db->getLastInsertID();

		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>267718000,'display_order'=>1, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>57190000,'display_order'=>2, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>312950007,'display_order'=>3, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>240740001,'display_order'=>4, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>314269007,'display_order'=>5, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>86103006,'display_order'=>6, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>255024002,'display_order'=>7, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>255025001,'display_order'=>8, 'parent_id' => $cnv_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>2532009,'display_order'=>9, 'parent_id' => $cnv_id));

		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>37231002,'display_order'=>2));
		$mac_id = Yii::app()->db->getLastInsertID();

		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>4855003,'display_order'=>1, 'parent_id' => $mac_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>24596005,'display_order'=>2, 'parent_id' => $mac_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>68478007,'display_order'=>3, 'parent_id' => $mac_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>232024000,'display_order'=>4, 'parent_id' => $mac_id));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>276436007,'display_order'=>5, 'parent_id' => $mac_id));

		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>312956001,'display_order'=>3));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>313001006,'display_order'=>4));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>360455002,'display_order'=>5));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>128473001,'display_order'=>6));
		$this->insert('ophcotherapya_therapydisorder',array('disorder_id'=>78370002,'display_order'=>7));

		// --- EVENT TYPE ENTRIES ---

		// create an event_type entry for this event type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphCoTherapyapplication'))->queryRow()) {
			$group = $this->dbConnection->createCommand()->select('id')->from('event_group')->where('name=:name',array(':name'=>'Communication events'))->queryRow();
			$this->insert('event_type', array('class_name' => 'OphCoTherapyapplication', 'name' => 'Therapy Application','event_group_id' => $group['id']));
		}
		// select the event_type id for this event type name
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphCoTherapyapplication'))->queryRow();

		// --- ELEMENT TYPE ENTRIES ---

		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Diagnosis',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Diagnosis','class_name' => 'Element_OphCoTherapyapplication_Therapydiagnosis', 'event_type_id' => $event_type['id'], 'display_order' => 10));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'TherapyDiagnosis'))->queryRow();
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Patient Suitability',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Patient Suitability','class_name' => 'Element_OphCoTherapyapplication_PatientSuitability', 'event_type_id' => $event_type['id'], 'display_order' => 15));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Patient Suitability'))->queryRow();
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Relative ContraIndications',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Relative ContraIndications','class_name' => 'Element_OphCoTherapyapplication_RelativeContraindications', 'event_type_id' => $event_type['id'], 'required' => false, 'display_order' =>20));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Relative ContraIndications'))->queryRow();
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'MR Service Information',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'MR Service Information','class_name' => 'Element_OphCoTherapyapplication_MrServiceInformation', 'event_type_id' => $event_type['id'], 'display_order' => 30));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'MR Service Information'))->queryRow();

		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Exceptional Circumstances',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Exceptional Circumstances','class_name' => 'Element_OphCoTherapyapplication_ExceptionalCircumstances', 'event_type_id' => $event_type['id'], 'required' => false, 'display_order' => 40));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Exceptional Circumstances'))->queryRow();

		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Application Email',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Application Email','class_name' => 'Element_OphCoTherapyapplication_Email', 'event_type_id' => $event_type['id'], 'display_order' => 50, 'default' => false, 'required' => false));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Application Email'))->queryRow();

		// get the id for both eyes

		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;

		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_therapydiag', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT ' . $both_eyes_id,
				'left_diagnosis1_id' => 'int(10) unsigned', // Left Diagnosis
				'left_diagnosis2_id' => 'int(10) unsigned', // Left Diagnosis
				'right_diagnosis1_id' => 'int(10) unsigned', // Right Diagnosis
				'right_diagnosis2_id' => 'int(10) unsigned', // Right Diagnosis
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_therapydiag_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_therapydiag_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_therapydiag_ev_fk` (`event_id`)',
				'KEY `et_ophcotherapya_therapydiag_ldiagnosis1_id_fk` (`left_diagnosis1_id`)',
				'KEY `et_ophcotherapya_therapydiag_rdiagnosis1_id_fk` (`right_diagnosis1_id`)',
				'KEY `et_ophcotherapya_therapydiag_ldiagnosis2_id_fk` (`left_diagnosis2_id`)',
				'KEY `et_ophcotherapya_therapydiag_rdiagnosis2_id_fk` (`right_diagnosis2_id`)',
				'KEY `et_ophcotherapya_therapydiag_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_ldiagnosis1_id_fk` FOREIGN KEY (`left_diagnosis1_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_rdiagnosis1_id_fk` FOREIGN KEY (`right_diagnosis1_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_ldiagnosis2_id_fk` FOREIGN KEY (`left_diagnosis2_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_rdiagnosis2_id_fk` FOREIGN KEY (`right_diagnosis2_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)'
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// element lookup table et_ophcotherapya_exceptional_intervention
		$this->createTable('ophcotherapya_treatment_cost_type', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_treatment_cost_type_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_treatment_cost_type_cui_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophcotherapya_treatment_cost_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_treatment_cost_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_treatment_cost_type',array('name'=>'Month'));
		$this->insert('ophcotherapya_treatment_cost_type',array('name'=>'Injection'));

		// element lookup table ophcotherapya_treatment
		// NOTE dependency on the ophtrintravitinjection_treatment_drug table and therefore the OphTrIntravitinjection module
		$this->createTable('ophcotherapya_treatment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'drug_id' => 'int(10) unsigned NOT NULL',
				'decisiontree_id' => 'int(10) unsigned',
				'contraindications_required' => 'boolean NOT NULL',
				'template_code' => 'varchar(8)',
				'intervention_name' => 'varchar(128) NOT NULL',
				'dose_and_frequency' => 'varchar(256) NOT NULL',
				'administration_route' => 'varchar(256) NOT NULL',
				'cost' => 'int(10) unsigned not null',
				'cost_type_id' => 'int(10) unsigned NOT NULL',
				'monitoring_frequency' => 'int(10) unsigned NOT NULL',
				'monitoring_frequency_period_id' => 'int(10) unsigned NOT NULL',
				'duration' => 'varchar(512) NOT NULL',
				'toxicity' => 'text NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_treatment_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_treatment_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_treatment_dti_fk` (`decisiontree_id`)',
				'KEY `ophcotherapya_treatment_dri_fk` (`drug_id`)',
				'KEY `ophcotherapya_treatment_ct_fk` (`cost_type_id`)',
				'KEY `ophcotherapya_treatment_mfp_fk` (`monitoring_frequency_period_id`)',
				'CONSTRAINT `ophcotherapya_treatment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_treatment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_treatment_dti_fk` FOREIGN KEY (`decisiontree_id`) REFERENCES `ophcotherapya_decisiontree` (`id`)',
				'CONSTRAINT `ophcotherapya_treatment_dri_fk` FOREIGN KEY (`drug_id`) REFERENCES `ophtrintravitinjection_treatment_drug` (`id`)',
				'CONSTRAINT `ophcotherapya_treatment_ct_fk` FOREIGN KEY (`cost_type_id`) REFERENCES `ophcotherapya_treatment_cost_type` (`id`)',
				'CONSTRAINT `ophcotherapya_treatment_mfp_fk` FOREIGN KEY (`monitoring_frequency_period_id`) REFERENCES `period` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// TODO: loop through injection drugs and create treatment objects
		/*
		$this->insert('ophcotherapya_treatment',array('name'=>'Avastin','display_order'=>1, 'contraindications_required' => true));
		$this->insert('ophcotherapya_treatment',array('name'=>'Eylea','display_order'=>2, 'contraindications_required' => true));
		$this->insert('ophcotherapya_treatment',array('name'=>'Lucentis','display_order'=>3, 'contraindications_required' => true));
		$this->insert('ophcotherapya_treatment',array('name'=>'Macugen','display_order'=>4, 'contraindications_required' => true));
		$this->insert('ophcotherapya_treatment',array('name'=>'PDT','display_order'=>5, 'contraindications_required' => false));
		$this->insert('ophcotherapya_treatment',array('name'=>'Ozurdex','display_order'=>6, 'contraindications_required' => false));
		$this->insert('ophcotherapya_treatment',array('name'=>'Intravitreal triamcinolone','display_order'=>7, 'contraindications_required' => false));
		*/

		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_patientsuit', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT ' . $both_eyes_id,
				'left_treatment_id' => 'int(10) unsigned', // Treatment
				'left_angiogram_baseline_date' => 'date DEFAULT NULL', // Angiogram Baseline Date
				'left_nice_compliance' => 'tinyint(1) unsigned', // NICE Compliance
				'right_treatment_id' => 'int(10) unsigned', // Treatment
				'right_angiogram_baseline_date' => 'date DEFAULT NULL', // Angiogram Baseline Date
				'right_nice_compliance' => 'tinyint(1) unsigned', // NICE Compliance
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_patientsuit_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_patientsuit_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_patientsuit_ev_fk` (`event_id`)',
				'KEY `et_ophcotherapya_patientsuit_ltreatment_fk` (`left_treatment_id`)',
				'KEY `et_ophcotherapya_patientsuit_rtreatment_fk` (`right_treatment_id`)',
				'KEY `et_ophcotherapya_patientsuit_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_ltreatment_fk` FOREIGN KEY (`left_treatment_id`) REFERENCES `ophcotherapya_treatment` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_rtreatment_fk` FOREIGN KEY (`right_treatment_id`) REFERENCES `ophcotherapya_treatment` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->createTable('ophcotherapya_patientsuit_decisiontreenoderesponse', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'patientsuit_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL',
				'node_id' => 'int(10) unsigned NOT NULL',
				'value' => 'varchar(16) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_patientsuit_dtnoderesponse_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_patientsuit_dtnoderesponse_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_patientsuit_dtnoderesponse_psi_fk` (`patientsuit_id`)',
				'KEY `ophcotherapya_patientsuit_dtnoderesponse_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_dtnoderesponse_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_dtnoderesponse_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_dtnoderesponse_psi_fk` FOREIGN KEY (`patientsuit_id`) REFERENCES `et_ophcotherapya_patientsuit` (`id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_dtnoderesponse_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_relativecon', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'cerebrovascular_accident' => 'tinyint(1) unsigned NOT NULL DEFAULT 0', // Cerebrovascular accident
				'ischaemic_attack' => 'tinyint(1) unsigned NOT NULL DEFAULT 0', // Ischaemic Attack
				'myocardial_infarction' => 'tinyint(1) unsigned NOT NULL DEFAULT 0', // Myocardial Infarction
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_relativecon_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_relativecon_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_relativecon_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophcotherapya_relativecon_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_relativecon_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_relativecon_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_mrservicein', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'consultant_id' => 'int(10) unsigned NOT NULL', // Consultant
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_mrservicein_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_mrservicein_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_mrservicein_ev_fk` (`event_id`)',
				'KEY `et_ophcotherapya_mrservicein_consultant_id_fk` (`consultant_id`)',
				'CONSTRAINT `et_ophcotherapya_mrservicein_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_mrservicein_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_mrservicein_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophcotherapya_mrservicein_consultant_id_fk` FOREIGN KEY (`consultant_id`) REFERENCES `firm` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// element lookup table et_ophcotherapya_exceptional_intervention
		$this->createTable('et_ophcotherapya_exceptional_intervention', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'description_label' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'is_deviation' => 'boolean NOT NULL DEFAULT false',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_exceptional_intervention_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_exceptional_intervention_cui_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_intervention_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_intervention_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('et_ophcotherapya_exceptional_intervention',array('name'=>'In addition to the standard (Additional)', 'description_label' => 'Details of additional', 'display_order'=>1));
		$this->insert('et_ophcotherapya_exceptional_intervention',array('name'=>'Instead of the standard (Deviation)','description_label' => 'Details of deviation', 'is_deviation' => true, 'display_order'=>2));

		$this->createTable('ophcotherapya_exceptional_standardintervention', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'enabled' => 'boolean NOT NULL DEFAULT true',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_exceptional_standardintervention_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_exceptional_standardintervention_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophcotherapya_exceptional_standardintervention_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_standardintervention_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_exceptional_standardintervention',array('name'=>'Observation', 'display_order'=>1));
		$this->insert('ophcotherapya_exceptional_standardintervention',array('name'=>'Conventional laser', 'display_order'=>2));
		$this->insert('ophcotherapya_exceptional_standardintervention',array('name'=>'Photodynamic therapy with vertoporfin', 'display_order'=>3));
		$this->insert('ophcotherapya_exceptional_standardintervention',array('name'=>'Intravitreal Ozurdex', 'display_order'=>4));
		$this->insert('ophcotherapya_exceptional_standardintervention',array('name'=>'Intravitreal Lucentis', 'display_order'=>5));

		$this->createTable('ophcotherapya_exceptional_deviationreason', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'enabled' => 'boolean NOT NULL DEFAULT true',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_exceptional_deviationreason_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_exceptional_deviationreason_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophcotherapya_exceptional_deviationreason_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_deviationreason_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_exceptional_deviationreason',array('name'=>'Contraindication', 'display_order'=>1));
		$this->insert('ophcotherapya_exceptional_deviationreason',array('name'=>'Side effects', 'display_order'=>2));
		$this->insert('ophcotherapya_exceptional_deviationreason',array('name'=>'No response', 'display_order'=>3));

		$this->createTable('ophcotherapya_exceptional_startperiod', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'urgent' => 'boolean DEFAULT false',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'enabled' => 'boolean NOT NULL DEFAULT true',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_exceptional_startperiod_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_exceptional_startperiod_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophcotherapya_exceptional_startperiod_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_startperiod_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_exceptional_startperiod',array('name'=>'4 weeks', 'display_order'=>1));
		$this->insert('ophcotherapya_exceptional_startperiod',array('name'=>'2 weeks', 'urgent' => true, 'display_order'=>2));
		$this->insert('ophcotherapya_exceptional_startperiod',array('name'=>'1 week', 'urgent' => true, 'display_order'=>3));

		// create the table for this element type: Element_OphCoTherapyapplication_ExceptionalCircumstances
		$this->createTable('et_ophcotherapya_exceptional', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT ' . $both_eyes_id,
				'left_standard_intervention_exists' => 'tinyint(1) unsigned NOT NULL', // Standard Intervention Exists
				'left_standard_intervention_id' => 'int(10) unsigned',
				'left_standard_previous' => 'boolean',
				'left_condition_rare' => 'boolean',
				'left_incidence' => 'text',
				'left_intervention_id' => 'int(10) unsigned', // interventions
				'left_description' => 'text DEFAULT \'\'', // Description
				'left_patient_different' => 'text',
				'left_patient_gain' => 'text',
				'left_patient_factors' => 'tinyint(1) unsigned', // Patient Factors
				'left_patient_factor_details' => 'text DEFAULT \'\'', // Details
				'left_start_period_id' => 'int(10) unsigned',
				'left_urgency_reason' => 'text',
				'right_standard_intervention_exists' => 'tinyint(1) unsigned', // Standard Intervention Exists
				'right_standard_intervention_id' => 'int(10) unsigned',
				'right_standard_previous' => 'boolean',
				'right_condition_rare' => 'boolean',
				'right_incidence' => 'text',
				'right_intervention_id' => 'int(10) unsigned', // interventions
				'right_description' => 'text DEFAULT \'\'', // Description
				'right_patient_different' => 'text',
				'right_patient_gain' => 'text',
				'right_patient_factors' => 'tinyint(1) unsigned', // Patient Factors
				'right_patient_factor_details' => 'text DEFAULT \'\'', // Details
				'right_start_period_id' => 'int(10) unsigned',
				'right_urgency_reason' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_exceptional_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_exceptional_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_exceptional_ev_fk` (`event_id`)',
				'KEY `et_ophcotherapya_exceptional_lsi_fk` (`left_standard_intervention_id`)',
				'KEY `et_ophcotherapya_exceptional_linterventions_fk` (`left_intervention_id`)',
				'KEY `et_ophcotherapya_exceptional_rsi_fk` (`right_standard_intervention_id`)',
				'KEY `et_ophcotherapya_exceptional_rinterventions_fk` (`right_intervention_id`)',
				'KEY `et_ophcotherapya_exceptional_eye_id_fk` (`eye_id`)',
				'KEY `et_ophcotherapya_exceptional_lspid_fk` (`left_start_period_id`)',
				'KEY `et_ophcotherapya_exceptional_rspid_fk` (`right_start_period_id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_lsi_fk` FOREIGN KEY (`left_standard_intervention_id`) REFERENCES `ophcotherapya_exceptional_standardintervention` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_linterventions_fk` FOREIGN KEY (`left_intervention_id`) REFERENCES `et_ophcotherapya_exceptional_intervention` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_rsi_fk` FOREIGN KEY (`right_standard_intervention_id`) REFERENCES `ophcotherapya_exceptional_standardintervention` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_rinterventions_fk` FOREIGN KEY (`right_intervention_id`) REFERENCES `et_ophcotherapya_exceptional_intervention` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_lspid_fk` FOREIGN KEY (`left_start_period_id`) REFERENCES `ophcotherapya_exceptional_startperiod` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_rspid_fk` FOREIGN KEY (`right_start_period_id`) REFERENCES `ophcotherapya_exceptional_startperiod` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->createTable('ophcotherapya_exceptional_deviationreason_ass', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'side_id' => 'tinyint(1) NOT NULL',
				'deviationreason_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_except_devrass_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_except_devrass_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_except_devrass_ei_fk` (`element_id`)',
				'KEY `et_ophcotherapya_except_devrass_ci_fk` (`deviationreason_id`)',
				'CONSTRAINT `et_ophcotherapya_except_devrass_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_except_devrass_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_except_devrass_ei_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophcotherapya_exceptional` (`id`)',
				'CONSTRAINT `et_ophcotherapya_except_devrass_ci_fk` FOREIGN KEY (`deviationreason_id`) REFERENCES `ophcotherapya_exceptional_deviationreason` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// file collection file assignments
		$this->createTable('ophcotherapya_exceptional_filecoll_assignment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'exceptional_id' => 'int(10) unsigned NOT NULL',
				'exceptional_side_id' => 'tinyint(1) NOT NULL',
				'collection_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_except_filecollass_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_except_filecollass_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_except_filecollass_ei_fk` (`exceptional_id`)',
				'KEY `et_ophcotherapya_except_filecollass_ci_fk` (`collection_id`)',
				'CONSTRAINT `et_ophcotherapya_except_filecollass_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_except_filecollass_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_except_filecollass_ei_fk` FOREIGN KEY (`exceptional_id`) REFERENCES `et_ophcotherapya_exceptional` (`id`)',
				'CONSTRAINT `et_ophcotherapya_except_filecollass_ci_fk` FOREIGN KEY (`collection_id`) REFERENCES `ophcotherapya_filecoll` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// lookup table for stopping reasons for previous interventions
		$this->createTable('ophcotherapya_exceptional_previntervention_stopreason', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_exceptional_previntervention_stopreason_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_exceptional_previntervention_stopreason_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophcotherapya_exceptional_previntervention_stopreason_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_previntervention_stopreason_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_exceptional_previntervention_stopreason',array('name'=>'Adverse effects','display_order'=>1));
		$this->insert('ophcotherapya_exceptional_previntervention_stopreason',array('name'=>'Course completed','display_order'=>2));
		$this->insert('ophcotherapya_exceptional_previntervention_stopreason',array('name'=>'No disease activity','display_order'=>3));
		$this->insert('ophcotherapya_exceptional_previntervention_stopreason',array('name'=>'No response','display_order'=>4));
		$this->insert('ophcotherapya_exceptional_previntervention_stopreason',array('name'=>'Poor response','display_order'=>5));

		// create the table for the previous interventions on the exceptional element
		$this->createTable('ophcotherapya_exceptional_previntervention', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'exceptional_id' => 'int(10) unsigned NOT NULL',
				'exceptional_side_id' => 'tinyint(1) NOT NULL',
				'treatment_id' => 'int(10) unsigned NOT NULL', // treatment
				'stopreason_id' => 'int(10) unsigned NOT NULL', // stop reason
				'treatment_date' => 'datetime NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_exceptional_previntervention_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_exceptional_previntervention_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_exceptional_previntervention_ei_fk` (`exceptional_id`)',
				'KEY `ophcotherapya_exceptional_previntervention_ti_fk` (`treatment_id`)',
				'KEY `ophcotherapya_exceptional_previntervention_sri_fk` (`stopreason_id`)',
				'CONSTRAINT `ophcotherapya_exceptional_previntervention_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_previntervention_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_previntervention_ei_fk` FOREIGN KEY (`exceptional_id`) REFERENCES `et_ophcotherapya_exceptional` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_previntervention_ti_fk` FOREIGN KEY (`treatment_id`) REFERENCES `ophcotherapya_treatment` (`id`)',
				'CONSTRAINT `ophcotherapya_exceptional_previntervention_sri_fk` FOREIGN KEY (`stopreason_id`) REFERENCES `ophcotherapya_exceptional_previntervention_stopreason` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_email', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT ' . $both_eyes_id,
				'left_email_text' => 'text',
				'right_email_text' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_email_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_email_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_email_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophcotherapya_email_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_email_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_email_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->createTable('ophcotherapya_email_attachment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL',
				'file_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_email_att_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_email_att_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_email_att_ei_fk` (`element_id`)',
				'KEY `et_ophcotherapya_email_att_eyei_fk` (`eye_id`)',
				'KEY `et_ophcotherapya_email_att_fi_fk` (`file_id`)',
				'CONSTRAINT `et_ophcotherapya_email_att_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_email_att_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_email_att_ei_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophcotherapya_email` (`id`)',
				'CONSTRAINT `et_ophcotherapya_email_att_eyei_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophcotherapya_email_att_fi_fk` FOREIGN KEY (`file_id`) REFERENCES `protected_file` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

	}

	public function down()
	{
		// --- drop any element related tables ---
		// --- drop element tables ---

		$this->dropTable('et_ophcotherapya_therapydiag');

		$this->dropTable('ophcotherapya_patientsuit_decisiontreenoderesponse');

		$this->dropTable('et_ophcotherapya_patientsuit');

		$this->dropTable('et_ophcotherapya_relativecon');

		$this->dropTable('ophcotherapya_email_attachment');
		$this->dropTable('et_ophcotherapya_email');

		$this->dropTable('et_ophcotherapya_mrservicein');


		$this->dropTable('ophcotherapya_exceptional_previntervention');
		$this->dropTable('ophcotherapya_exceptional_previntervention_stopreason');
		$this->dropTable('ophcotherapya_exceptional_filecoll_assignment');

		$this->dropTable('ophcotherapya_exceptional_deviationreason_ass');
		$this->dropTable('et_ophcotherapya_exceptional');
		$this->dropTable('ophcotherapya_exceptional_standardintervention');

		$this->dropTable('ophcotherapya_exceptional_deviationreason');
		$this->dropTable('ophcotherapya_exceptional_startperiod');

		$this->dropTable('et_ophcotherapya_exceptional_intervention');

		$this->dropTable('ophcotherapya_treatment');

		$this->dropTable('ophcotherapya_treatment_cost_type');

		// --- delete event entries ---
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphCoTherapyapplication'))->queryRow();

		foreach ($this->dbConnection->createCommand()->select('id')->from('event')->where('event_type_id=:event_type_id', array(':event_type_id'=>$event_type['id']))->queryAll() as $row) {
			$this->delete('audit', 'event_id='.$row['id']);
			$this->delete('event', 'id='.$row['id']);
		}

		// --- delete entries from element_type ---
		$this->delete('element_type', 'event_type_id='.$event_type['id']);

		// --- delete entries from event_type ---
		$this->delete('event_type', 'id='.$event_type['id']);

		// drop decision tree tables
		$this->dropTable('ophcotherapya_decisiontreenoderule');
		$this->dropTable('ophcotherapya_decisiontreenodechoice');
		$this->dropTable('ophcotherapya_decisiontreenode');
		$this->dropTable('ophcotherapya_decisiontreenode_responsetype');
		$this->dropTable('ophcotherapya_decisiontreeoutcome');
		$this->dropTable('ophcotherapya_decisiontree');

		// disorder lookup
		$this->dropForeignKey('ophcotherapya_therapydisorder_pi_fk', 'ophcotherapya_therapydisorder');
		$this->dropTable('ophcotherapya_therapydisorder');

		$this->dropTable('ophcotherapya_filecoll_assignment');

		$this->dropTable('ophcotherapya_filecoll');

		// echo "m000000_000001_event_type_OphCoTherapyapplication does not support migration down.\n";
		// return false;
		echo "If you are removing this module you may also need to remove references to it in your configuration files\n";
		return true;
	}
}
