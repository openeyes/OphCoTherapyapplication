<?php 
class m130311_142448_event_type_OphCoTherapyapplication extends CDbMigration
{
	public function up() {

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
		$this->insert('ophcotherapya_decisiontreenode_responsetype',array('label'=>'choice','datatype'=> 'ch'));
		
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
				'CONSTRAINT `et_ophcotherapya_decisiontreenode_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontreenode_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
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
				'CONSTRAINT `et_ophcotherapya_decisiontreenoderule_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontreenoderule_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
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
				'CONSTRAINT `et_ophcotherapya_decisiontreenodechoice_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_decisiontreenodechoice_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_decisiontreenodechoice_ni_fk` FOREIGN KEY (`node_id`) REFERENCES `ophcotherapya_decisiontreenode` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		// --- EVENT TYPE ENTRIES ---

		// create an event_type entry for this event type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphCoTherapyapplication'))->queryRow()) {
			$group = $this->dbConnection->createCommand()->select('id')->from('event_group')->where('name=:name',array(':name'=>'Communication events'))->queryRow();
			$this->insert('event_type', array('class_name' => 'OphCoTherapyapplication', 'name' => 'TherapyApplication','event_group_id' => $group['id']));
		}
		// select the event_type id for this event type name
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphCoTherapyapplication'))->queryRow();

		// --- ELEMENT TYPE ENTRIES ---

		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'TherapyDiagnosis',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'TherapyDiagnosis','class_name' => 'Element_OphCoTherapyapplication_Therapydiagnosis', 'event_type_id' => $event_type['id'], 'display_order' => 1));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'TherapyDiagnosis'))->queryRow();
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Patient Suitability',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Patient Suitability','class_name' => 'Element_OphCoTherapyapplication_PatientSuitability', 'event_type_id' => $event_type['id'], 'display_order' => 1));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Patient Suitability'))->queryRow();
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Relative ContraIndications',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Relative ContraIndications','class_name' => 'Element_OphCoTherapyapplication_RelativeContraindications', 'event_type_id' => $event_type['id'], 'display_order' => 1));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Relative ContraIndications'))->queryRow();
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'MR Service Information',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'MR Service Information','class_name' => 'Element_OphCoTherapyapplication_MrServiceInformation', 'event_type_id' => $event_type['id'], 'display_order' => 1));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'MR Service Information'))->queryRow();
		// create an element_type entry for this element type name if one doesn't already exist
		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Exceptional Circumstances',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Exceptional Circumstances','class_name' => 'Element_OphCoTherapyapplication_ExceptionalCircumstances', 'event_type_id' => $event_type['id'], 'display_order' => 1));
		}
		// select the element_type_id for this element type name
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Exceptional Circumstances'))->queryRow();



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_therapydiag', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'diagnosis_id' => 'int(10) unsigned NOT NULL', // Diagnosis
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_therapydiag_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_therapydiag_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_therapydiag_ev_fk` (`event_id`)',
				'KEY `et_ophcotherapya_therapydiag_diagnosis_id_fk` (`diagnosis_id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophcotherapya_therapydiag_diagnosis_id_fk` FOREIGN KEY (`diagnosis_id`) REFERENCES `disorder` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// element lookup table ophcotherapya_patientsuit_treatment
		$this->createTable('ophcotherapya_patientsuit_treatment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'decisiontree_id' => 'int(10) unsigned',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'available' => 'boolean DEFAULT True',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_patientsuit_treatment_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_patientsuit_treatment_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_patientsuit_treatment_dti_fk` (`decisiontree_id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_treatment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_treatment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_treatment_dti_fk` FOREIGN KEY (`decisiontree_id`) REFERENCES `ophcotherapya_decisiontree` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophcotherapya_patientsuit_treatment',array('name'=>'Avastin','display_order'=>1));
		$this->insert('ophcotherapya_patientsuit_treatment',array('name'=>'Eylea','display_order'=>2));
		$this->insert('ophcotherapya_patientsuit_treatment',array('name'=>'Lucentis','display_order'=>3));
		$this->insert('ophcotherapya_patientsuit_treatment',array('name'=>'Macugen','display_order'=>4));
		$this->insert('ophcotherapya_patientsuit_treatment',array('name'=>'PDT','display_order'=>5));
		$this->insert('ophcotherapya_patientsuit_treatment',array('name'=>'Ozurdex','display_order'=>6));
		$this->insert('ophcotherapya_patientsuit_treatment',array('name'=>'Intravitreal triamcinolone','display_order'=>7));



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_patientsuit', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'treatment_id' => 'int(10) unsigned NOT NULL', // Treatment
				'angiogram_baseline_date' => 'date DEFAULT NULL', // Angiogram Baseline Date
				'nice_compliance' => 'tinyint(1) unsigned NOT NULL DEFAULT 0', // NICE Compliance
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_patientsuit_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_patientsuit_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_patientsuit_ev_fk` (`event_id`)',
				'KEY `ophcotherapya_patientsuit_treatment_fk` (`treatment_id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_treatment_fk` FOREIGN KEY (`treatment_id`) REFERENCES `ophcotherapya_patientsuit_treatment` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->createTable('ophcotherapya_patientsuit_decisiontreenoderesponse', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'patientsuit_id' => 'int(10) unsigned NOT NULL',
				'node_id' => 'int(10) unsigned NOT NULL',
				'value' => 'varchar(16) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_patientsuit_flownoderesponse_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_patientsuit_flownoderesponse_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_patientsuit_flownoderesponse_psi_fk` (`patientsuit_id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_flownoderesponse_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_patientsuit_flownoderesponse_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_patientsuit_flownoderesponse_psi_fk` FOREIGN KEY (`patientsuit_id`) REFERENCES `et_ophcotherapya_patientsuit` (`id`)',
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

		// element lookup table et_ophcotherapya_exceptional_interventions
		$this->createTable('et_ophcotherapya_exceptional_interventions', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_exceptional_interventions_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_exceptional_interventions_cui_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_interventions_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_interventions_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('et_ophcotherapya_exceptional_interventions',array('name'=>'Additional','display_order'=>1));
		$this->insert('et_ophcotherapya_exceptional_interventions',array('name'=>'Deviation','display_order'=>2));



		// create the table for this element type: et_modulename_elementtypename
		$this->createTable('et_ophcotherapya_exceptional', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'standard_intervention_exists' => 'tinyint(1) unsigned NOT NULL DEFAULT 0', // Standard Intervention Exists
				'details' => 'text DEFAULT \'\'', // Details and standard algorithm of care
				'interventions_id' => 'int(10) unsigned NOT NULL', // interventions
				'description' => 'text DEFAULT \'\'', // Description
				'patient_factors' => 'tinyint(1) unsigned NOT NULL DEFAULT 0', // Patient Factors
				'patient_factor_details' => 'text DEFAULT \'\'', // Details
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophcotherapya_exceptional_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophcotherapya_exceptional_cui_fk` (`created_user_id`)',
				'KEY `et_ophcotherapya_exceptional_ev_fk` (`event_id`)',
				'KEY `et_ophcotherapya_exceptional_interventions_fk` (`interventions_id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophcotherapya_exceptional_interventions_fk` FOREIGN KEY (`interventions_id`) REFERENCES `et_ophcotherapya_exceptional_interventions` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

	}

	public function down() {
		// --- drop any element related tables ---
		// --- drop element tables ---
		$this->dropTable('et_ophcotherapya_therapydiag');



		$this->dropTable('ophcotherapya_patientsuit_decisiontreenoderesponse');
		
		$this->dropTable('et_ophcotherapya_patientsuit');


		$this->dropTable('ophcotherapya_patientsuit_treatment');

		$this->dropTable('et_ophcotherapya_relativecon');



		$this->dropTable('et_ophcotherapya_mrservicein');



		$this->dropTable('et_ophcotherapya_exceptional');


		$this->dropTable('et_ophcotherapya_exceptional_interventions');


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
		
		

		// echo "m000000_000001_event_type_OphCoTherapyapplication does not support migration down.\n";
		// return false;
		echo "If you are removing this module you may also need to remove references to it in your configuration files\n";
		return true;
	}
}
?>