<?php

class m131204_163326_table_versioning extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE `et_ophcotherapya_exceptional_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned NOT NULL DEFAULT '3',
	`left_standard_intervention_exists` tinyint(1) unsigned NOT NULL,
	`left_standard_intervention_id` int(10) unsigned DEFAULT NULL,
	`left_standard_previous` tinyint(1) DEFAULT NULL,
	`left_condition_rare` tinyint(1) DEFAULT NULL,
	`left_incidence` text COLLATE utf8_bin,
	`left_intervention_id` int(10) unsigned DEFAULT NULL,
	`left_description` text COLLATE utf8_bin,
	`left_patient_different` text COLLATE utf8_bin,
	`left_patient_gain` text COLLATE utf8_bin,
	`left_patient_factors` tinyint(1) unsigned DEFAULT NULL,
	`left_patient_factor_details` text COLLATE utf8_bin,
	`left_start_period_id` int(10) unsigned DEFAULT NULL,
	`left_urgency_reason` text COLLATE utf8_bin,
	`right_standard_intervention_exists` tinyint(1) unsigned DEFAULT NULL,
	`right_standard_intervention_id` int(10) unsigned DEFAULT NULL,
	`right_standard_previous` tinyint(1) DEFAULT NULL,
	`right_condition_rare` tinyint(1) DEFAULT NULL,
	`right_incidence` text COLLATE utf8_bin,
	`right_intervention_id` int(10) unsigned DEFAULT NULL,
	`right_description` text COLLATE utf8_bin,
	`right_patient_different` text COLLATE utf8_bin,
	`right_patient_gain` text COLLATE utf8_bin,
	`right_patient_factors` tinyint(1) unsigned DEFAULT NULL,
	`right_patient_factor_details` text COLLATE utf8_bin,
	`right_start_period_id` int(10) unsigned DEFAULT NULL,
	`right_urgency_reason` text COLLATE utf8_bin,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`left_patient_expectations` text COLLATE utf8_bin,
	`right_patient_expectations` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_exceptional_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_exceptional_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_exceptional_ev_fk` (`event_id`),
	KEY `acv_et_ophcotherapya_exceptional_lsi_fk` (`left_standard_intervention_id`),
	KEY `acv_et_ophcotherapya_exceptional_linterventions_fk` (`left_intervention_id`),
	KEY `acv_et_ophcotherapya_exceptional_rsi_fk` (`right_standard_intervention_id`),
	KEY `acv_et_ophcotherapya_exceptional_rinterventions_fk` (`right_intervention_id`),
	KEY `acv_et_ophcotherapya_exceptional_eye_id_fk` (`eye_id`),
	KEY `acv_et_ophcotherapya_exceptional_lspid_fk` (`left_start_period_id`),
	KEY `acv_et_ophcotherapya_exceptional_rspid_fk` (`right_start_period_id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_linterventions_fk` FOREIGN KEY (`left_intervention_id`) REFERENCES `et_ophcotherapya_exceptional_intervention` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_lsi_fk` FOREIGN KEY (`left_standard_intervention_id`) REFERENCES `ophcotherapya_exceptional_standardintervention` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_lspid_fk` FOREIGN KEY (`left_start_period_id`) REFERENCES `ophcotherapya_exceptional_startperiod` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_rinterventions_fk` FOREIGN KEY (`right_intervention_id`) REFERENCES `et_ophcotherapya_exceptional_intervention` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_rsi_fk` FOREIGN KEY (`right_standard_intervention_id`) REFERENCES `ophcotherapya_exceptional_standardintervention` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_rspid_fk` FOREIGN KEY (`right_start_period_id`) REFERENCES `ophcotherapya_exceptional_startperiod` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophcotherapya_exceptional_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophcotherapya_exceptional_version');

		$this->createIndex('et_ophcotherapya_exceptional_aid_fk','et_ophcotherapya_exceptional_version','id');
		$this->addForeignKey('et_ophcotherapya_exceptional_aid_fk','et_ophcotherapya_exceptional_version','id','et_ophcotherapya_exceptional','id');

		$this->addColumn('et_ophcotherapya_exceptional_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophcotherapya_exceptional_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophcotherapya_exceptional_version','version_id');
		$this->alterColumn('et_ophcotherapya_exceptional_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophcotherapya_exceptional_intervention_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`description_label` varchar(128) COLLATE utf8_bin NOT NULL,
	`is_deviation` tinyint(1) NOT NULL DEFAULT '0',
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_exceptional_intervention_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_exceptional_intervention_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_intervention_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_exceptional_intervention_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophcotherapya_exceptional_intervention_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophcotherapya_exceptional_intervention_version');

		$this->createIndex('et_ophcotherapya_exceptional_intervention_aid_fk','et_ophcotherapya_exceptional_intervention_version','id');
		$this->addForeignKey('et_ophcotherapya_exceptional_intervention_aid_fk','et_ophcotherapya_exceptional_intervention_version','id','et_ophcotherapya_exceptional_intervention','id');

		$this->addColumn('et_ophcotherapya_exceptional_intervention_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophcotherapya_exceptional_intervention_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophcotherapya_exceptional_intervention_version','version_id');
		$this->alterColumn('et_ophcotherapya_exceptional_intervention_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophcotherapya_mrservicein_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`consultant_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`site_id` int(10) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_mrservicein_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_mrservicein_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_mrservicein_ev_fk` (`event_id`),
	KEY `acv_et_ophcotherapya_mrservicein_consultant_id_fk` (`consultant_id`),
	KEY `acv_et_ophcotherapya_mrservicein_site_id_fk` (`site_id`),
	CONSTRAINT `acv_et_ophcotherapya_mrservicein_site_id_fk` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_mrservicein_consultant_id_fk` FOREIGN KEY (`consultant_id`) REFERENCES `firm` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_mrservicein_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_mrservicein_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_mrservicein_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophcotherapya_mrservicein_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophcotherapya_mrservicein_version');

		$this->createIndex('et_ophcotherapya_mrservicein_aid_fk','et_ophcotherapya_mrservicein_version','id');
		$this->addForeignKey('et_ophcotherapya_mrservicein_aid_fk','et_ophcotherapya_mrservicein_version','id','et_ophcotherapya_mrservicein','id');

		$this->addColumn('et_ophcotherapya_mrservicein_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophcotherapya_mrservicein_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophcotherapya_mrservicein_version','version_id');
		$this->alterColumn('et_ophcotherapya_mrservicein_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophcotherapya_patientsuit_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned NOT NULL DEFAULT '3',
	`left_treatment_id` int(10) unsigned DEFAULT NULL,
	`left_angiogram_baseline_date` date DEFAULT NULL,
	`left_nice_compliance` tinyint(1) unsigned DEFAULT NULL,
	`right_treatment_id` int(10) unsigned DEFAULT NULL,
	`right_angiogram_baseline_date` date DEFAULT NULL,
	`right_nice_compliance` tinyint(1) unsigned DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_patientsuit_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_patientsuit_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_patientsuit_ev_fk` (`event_id`),
	KEY `acv_et_ophcotherapya_patientsuit_ltreatment_fk` (`left_treatment_id`),
	KEY `acv_et_ophcotherapya_patientsuit_rtreatment_fk` (`right_treatment_id`),
	KEY `acv_et_ophcotherapya_patientsuit_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophcotherapya_patientsuit_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_patientsuit_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_patientsuit_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_patientsuit_ltreatment_fk` FOREIGN KEY (`left_treatment_id`) REFERENCES `ophcotherapya_treatment` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_patientsuit_rtreatment_fk` FOREIGN KEY (`right_treatment_id`) REFERENCES `ophcotherapya_treatment` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_patientsuit_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophcotherapya_patientsuit_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophcotherapya_patientsuit_version');

		$this->createIndex('et_ophcotherapya_patientsuit_aid_fk','et_ophcotherapya_patientsuit_version','id');
		$this->addForeignKey('et_ophcotherapya_patientsuit_aid_fk','et_ophcotherapya_patientsuit_version','id','et_ophcotherapya_patientsuit','id');

		$this->addColumn('et_ophcotherapya_patientsuit_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophcotherapya_patientsuit_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophcotherapya_patientsuit_version','version_id');
		$this->alterColumn('et_ophcotherapya_patientsuit_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophcotherapya_relativecon_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`cerebrovascular_accident` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`ischaemic_attack` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`myocardial_infarction` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_relativecon_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_relativecon_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_relativecon_ev_fk` (`event_id`),
	CONSTRAINT `acv_et_ophcotherapya_relativecon_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_relativecon_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_relativecon_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophcotherapya_relativecon_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophcotherapya_relativecon_version');

		$this->createIndex('et_ophcotherapya_relativecon_aid_fk','et_ophcotherapya_relativecon_version','id');
		$this->addForeignKey('et_ophcotherapya_relativecon_aid_fk','et_ophcotherapya_relativecon_version','id','et_ophcotherapya_relativecon','id');

		$this->addColumn('et_ophcotherapya_relativecon_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophcotherapya_relativecon_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophcotherapya_relativecon_version','version_id');
		$this->alterColumn('et_ophcotherapya_relativecon_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophcotherapya_therapydiag_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned NOT NULL DEFAULT '3',
	`left_diagnosis1_id` int(10) unsigned DEFAULT NULL,
	`left_diagnosis2_id` int(10) unsigned DEFAULT NULL,
	`right_diagnosis1_id` int(10) unsigned DEFAULT NULL,
	`right_diagnosis2_id` int(10) unsigned DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_therapydiag_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_therapydiag_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_therapydiag_ev_fk` (`event_id`),
	KEY `acv_et_ophcotherapya_therapydiag_ldiagnosis1_id_fk` (`left_diagnosis1_id`),
	KEY `acv_et_ophcotherapya_therapydiag_rdiagnosis1_id_fk` (`right_diagnosis1_id`),
	KEY `acv_et_ophcotherapya_therapydiag_ldiagnosis2_id_fk` (`left_diagnosis2_id`),
	KEY `acv_et_ophcotherapya_therapydiag_rdiagnosis2_id_fk` (`right_diagnosis2_id`),
	KEY `acv_et_ophcotherapya_therapydiag_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_ldiagnosis1_id_fk` FOREIGN KEY (`left_diagnosis1_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_rdiagnosis1_id_fk` FOREIGN KEY (`right_diagnosis1_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_ldiagnosis2_id_fk` FOREIGN KEY (`left_diagnosis2_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_rdiagnosis2_id_fk` FOREIGN KEY (`right_diagnosis2_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_therapydiag_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophcotherapya_therapydiag_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophcotherapya_therapydiag_version');

		$this->createIndex('et_ophcotherapya_therapydiag_aid_fk','et_ophcotherapya_therapydiag_version','id');
		$this->addForeignKey('et_ophcotherapya_therapydiag_aid_fk','et_ophcotherapya_therapydiag_version','id','et_ophcotherapya_therapydiag','id');

		$this->addColumn('et_ophcotherapya_therapydiag_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophcotherapya_therapydiag_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophcotherapya_therapydiag_version','version_id');
		$this->alterColumn('et_ophcotherapya_therapydiag_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_decisiontree_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_decisiontree_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_decisiontree_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophcotherapya_decisiontree_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_decisiontree_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_decisiontree_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_decisiontree_version');

		$this->createIndex('ophcotherapya_decisiontree_aid_fk','ophcotherapya_decisiontree_version','id');
		$this->addForeignKey('ophcotherapya_decisiontree_aid_fk','ophcotherapya_decisiontree_version','id','ophcotherapya_decisiontree','id');

		$this->addColumn('ophcotherapya_decisiontree_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_decisiontree_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_decisiontree_version','version_id');
		$this->alterColumn('ophcotherapya_decisiontree_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_decisiontreenode_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`decisiontree_id` int(10) unsigned NOT NULL,
	`parent_id` int(10) unsigned DEFAULT NULL,
	`question` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`outcome_id` int(10) unsigned DEFAULT NULL,
	`default_function` varchar(64) COLLATE utf8_bin DEFAULT NULL,
	`default_value` varchar(16) COLLATE utf8_bin DEFAULT NULL,
	`response_type_id` int(10) unsigned DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_decisiontreenode_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_decisiontreenode_cui_fk` (`created_user_id`),
	KEY `acv_ophcotherapya_decisiontreenode_dti_fk` (`decisiontree_id`),
	KEY `acv_ophcotherapya_decisiontreenode_pi_fk` (`parent_id`),
	KEY `acv_ophcotherapya_decisiontreenode_oi_fk` (`outcome_id`),
	KEY `acv_ophcotherapya_decisiontreenode_rti_fk` (`response_type_id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenode_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenode_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenode_dti_fk` FOREIGN KEY (`decisiontree_id`) REFERENCES `ophcotherapya_decisiontree` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenode_pi_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophcotherapya_decisiontreenode` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenode_oi_fk` FOREIGN KEY (`outcome_id`) REFERENCES `ophcotherapya_decisiontreeoutcome` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenode_rti_fk` FOREIGN KEY (`response_type_id`) REFERENCES `ophcotherapya_decisiontreenode_responsetype` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_decisiontreenode_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_decisiontreenode_version');

		$this->createIndex('ophcotherapya_decisiontreenode_aid_fk','ophcotherapya_decisiontreenode_version','id');
		$this->addForeignKey('ophcotherapya_decisiontreenode_aid_fk','ophcotherapya_decisiontreenode_version','id','ophcotherapya_decisiontreenode','id');

		$this->addColumn('ophcotherapya_decisiontreenode_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_decisiontreenode_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_decisiontreenode_version','version_id');
		$this->alterColumn('ophcotherapya_decisiontreenode_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_decisiontreenode_responsetype_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`label` varchar(32) COLLATE utf8_bin NOT NULL,
	`datatype` varchar(16) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_decisiontreenode_rtype_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_decisiontreenode_rtype_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophcotherapya_decisiontreenode_rtype_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_decisiontreenode_rtype_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_decisiontreenode_responsetype_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_decisiontreenode_responsetype_version');

		$this->createIndex('ophcotherapya_decisiontreenode_responsetype_aid_fk','ophcotherapya_decisiontreenode_responsetype_version','id');
		$this->addForeignKey('ophcotherapya_decisiontreenode_responsetype_aid_fk','ophcotherapya_decisiontreenode_responsetype_version','id','ophcotherapya_decisiontreenode_responsetype','id');

		$this->addColumn('ophcotherapya_decisiontreenode_responsetype_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_decisiontreenode_responsetype_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_decisiontreenode_responsetype_version','version_id');
		$this->alterColumn('ophcotherapya_decisiontreenode_responsetype_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_decisiontreenodechoice_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`node_id` int(10) unsigned NOT NULL,
	`label` varchar(32) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_decisiontreenodechoice_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_decisiontreenodechoice_cui_fk` (`created_user_id`),
	KEY `acv_ophcotherapya_decisiontreenodechoice_ni_fk` (`node_id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenodechoice_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenodechoice_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenodechoice_ni_fk` FOREIGN KEY (`node_id`) REFERENCES `ophcotherapya_decisiontreenode` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_decisiontreenodechoice_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_decisiontreenodechoice_version');

		$this->createIndex('ophcotherapya_decisiontreenodechoice_aid_fk','ophcotherapya_decisiontreenodechoice_version','id');
		$this->addForeignKey('ophcotherapya_decisiontreenodechoice_aid_fk','ophcotherapya_decisiontreenodechoice_version','id','ophcotherapya_decisiontreenodechoice','id');

		$this->addColumn('ophcotherapya_decisiontreenodechoice_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_decisiontreenodechoice_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_decisiontreenodechoice_version','version_id');
		$this->alterColumn('ophcotherapya_decisiontreenodechoice_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_decisiontreenoderule_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`node_id` int(10) unsigned NOT NULL,
	`parent_check` varchar(4) COLLATE utf8_bin DEFAULT NULL,
	`parent_check_value` varchar(16) COLLATE utf8_bin DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_decisiontreenoderule_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_decisiontreenoderule_cui_fk` (`created_user_id`),
	KEY `acv_ophcotherapya_decisiontreenoderule_ni_fk` (`node_id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenoderule_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenoderule_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_decisiontreenoderule_ni_fk` FOREIGN KEY (`node_id`) REFERENCES `ophcotherapya_decisiontreenode` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_decisiontreenoderule_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_decisiontreenoderule_version');

		$this->createIndex('ophcotherapya_decisiontreenoderule_aid_fk','ophcotherapya_decisiontreenoderule_version','id');
		$this->addForeignKey('ophcotherapya_decisiontreenoderule_aid_fk','ophcotherapya_decisiontreenoderule_version','id','ophcotherapya_decisiontreenoderule','id');

		$this->addColumn('ophcotherapya_decisiontreenoderule_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_decisiontreenoderule_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_decisiontreenoderule_version','version_id');
		$this->alterColumn('ophcotherapya_decisiontreenoderule_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_decisiontreeoutcome_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(32) COLLATE utf8_bin NOT NULL,
	`outcome_type` varchar(16) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_decisiontreeoutcome_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_decisiontreeoutcome_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophcotherapya_decisiontreeoutcome_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_decisiontreeoutcome_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_decisiontreeoutcome_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_decisiontreeoutcome_version');

		$this->createIndex('ophcotherapya_decisiontreeoutcome_aid_fk','ophcotherapya_decisiontreeoutcome_version','id');
		$this->addForeignKey('ophcotherapya_decisiontreeoutcome_aid_fk','ophcotherapya_decisiontreeoutcome_version','id','ophcotherapya_decisiontreeoutcome','id');

		$this->addColumn('ophcotherapya_decisiontreeoutcome_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_decisiontreeoutcome_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_decisiontreeoutcome_version','version_id');
		$this->alterColumn('ophcotherapya_decisiontreeoutcome_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_email_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`eye_id` tinyint(4) NOT NULL,
	`email_text` text COLLATE utf8_bin,
	`archived` tinyint(4) NOT NULL DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL,
	`last_modified_date` datetime NOT NULL,
	`created_user_id` int(10) unsigned NOT NULL,
	`created_date` datetime NOT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_created_date` (`created_date`),
	KEY `acv_ophcotherapya_email_ei_fk` (`event_id`),
	KEY `acv_ophcotherapya_email_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_email_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophcotherapya_email_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_ophcotherapya_email_ibfk_2` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_email_ibfk_3` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_email_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_email_version');

		$this->createIndex('ophcotherapya_email_aid_fk','ophcotherapya_email_version','id');
		$this->addForeignKey('ophcotherapya_email_aid_fk','ophcotherapya_email_version','id','ophcotherapya_email','id');

		$this->addColumn('ophcotherapya_email_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_email_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_email_version','version_id');
		$this->alterColumn('ophcotherapya_email_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_email_attachment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`email_id` int(10) unsigned NOT NULL,
	`file_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_email_att_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_email_att_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_email_att_fi_fk` (`file_id`),
	KEY `acv_et_ophcotherapya_email_att_ei_fk` (`email_id`),
	CONSTRAINT `acv_et_ophcotherapya_email_att_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_email_att_ei_fk` FOREIGN KEY (`email_id`) REFERENCES `ophcotherapya_email` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_email_att_fi_fk` FOREIGN KEY (`file_id`) REFERENCES `protected_file` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_email_att_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_email_attachment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_email_attachment_version');

		$this->createIndex('ophcotherapya_email_attachment_aid_fk','ophcotherapya_email_attachment_version','id');
		$this->addForeignKey('ophcotherapya_email_attachment_aid_fk','ophcotherapya_email_attachment_version','id','ophcotherapya_email_attachment','id');

		$this->addColumn('ophcotherapya_email_attachment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_email_attachment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_email_attachment_version','version_id');
		$this->alterColumn('ophcotherapya_email_attachment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_exceptional_deviationreason_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_exceptional_deviationreason_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_exceptional_deviationreason_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_deviationreason_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_deviationreason_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_exceptional_deviationreason_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_exceptional_deviationreason_version');

		$this->createIndex('ophcotherapya_exceptional_deviationreason_aid_fk','ophcotherapya_exceptional_deviationreason_version','id');
		$this->addForeignKey('ophcotherapya_exceptional_deviationreason_aid_fk','ophcotherapya_exceptional_deviationreason_version','id','ophcotherapya_exceptional_deviationreason','id');

		$this->addColumn('ophcotherapya_exceptional_deviationreason_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_exceptional_deviationreason_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_exceptional_deviationreason_version','version_id');
		$this->alterColumn('ophcotherapya_exceptional_deviationreason_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_exceptional_deviationreason_ass_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`element_id` int(10) unsigned NOT NULL,
	`side_id` tinyint(1) NOT NULL,
	`deviationreason_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_except_devrass_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_except_devrass_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_except_devrass_ei_fk` (`element_id`),
	KEY `acv_et_ophcotherapya_except_devrass_ci_fk` (`deviationreason_id`),
	CONSTRAINT `acv_et_ophcotherapya_except_devrass_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_except_devrass_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_except_devrass_ei_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophcotherapya_exceptional` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_except_devrass_ci_fk` FOREIGN KEY (`deviationreason_id`) REFERENCES `ophcotherapya_exceptional_deviationreason` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_exceptional_deviationreason_ass_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_exceptional_deviationreason_ass_version');

		$this->createIndex('ophcotherapya_exceptional_deviationreason_ass_aid_fk','ophcotherapya_exceptional_deviationreason_ass_version','id');
		$this->addForeignKey('ophcotherapya_exceptional_deviationreason_ass_aid_fk','ophcotherapya_exceptional_deviationreason_ass_version','id','ophcotherapya_exceptional_deviationreason_ass','id');

		$this->addColumn('ophcotherapya_exceptional_deviationreason_ass_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_exceptional_deviationreason_ass_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_exceptional_deviationreason_ass_version','version_id');
		$this->alterColumn('ophcotherapya_exceptional_deviationreason_ass_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_exceptional_filecoll_assignment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`exceptional_id` int(10) unsigned NOT NULL,
	`exceptional_side_id` tinyint(1) NOT NULL,
	`collection_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_except_filecollass_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_except_filecollass_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_except_filecollass_ei_fk` (`exceptional_id`),
	KEY `acv_et_ophcotherapya_except_filecollass_ci_fk` (`collection_id`),
	CONSTRAINT `acv_et_ophcotherapya_except_filecollass_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_except_filecollass_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_except_filecollass_ei_fk` FOREIGN KEY (`exceptional_id`) REFERENCES `et_ophcotherapya_exceptional` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_except_filecollass_ci_fk` FOREIGN KEY (`collection_id`) REFERENCES `ophcotherapya_filecoll` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_exceptional_filecoll_assignment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_exceptional_filecoll_assignment_version');

		$this->createIndex('ophcotherapya_exceptional_filecoll_assignment_aid_fk','ophcotherapya_exceptional_filecoll_assignment_version','id');
		$this->addForeignKey('ophcotherapya_exceptional_filecoll_assignment_aid_fk','ophcotherapya_exceptional_filecoll_assignment_version','id','ophcotherapya_exceptional_filecoll_assignment','id');

		$this->addColumn('ophcotherapya_exceptional_filecoll_assignment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_exceptional_filecoll_assignment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_exceptional_filecoll_assignment_version','version_id');
		$this->alterColumn('ophcotherapya_exceptional_filecoll_assignment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_exceptional_pastintervention_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`exceptional_id` int(10) unsigned NOT NULL,
	`exceptional_side_id` tinyint(1) NOT NULL,
	`treatment_id` int(10) unsigned DEFAULT NULL,
	`stopreason_id` int(10) unsigned NOT NULL,
	`start_date` datetime NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`stopreason_other` text COLLATE utf8_bin,
	`comments` text COLLATE utf8_bin,
	`start_va` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	`end_va` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	`end_date` datetime NOT NULL,
	`is_relevant` tinyint(1) NOT NULL DEFAULT '0',
	`relevanttreatment_id` int(10) unsigned DEFAULT NULL,
	`relevanttreatment_other` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_exceptional_previntervention_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_exceptional_previntervention_cui_fk` (`created_user_id`),
	KEY `acv_ophcotherapya_exceptional_previntervention_ei_fk` (`exceptional_id`),
	KEY `acv_ophcotherapya_exceptional_previntervention_ti_fk` (`treatment_id`),
	KEY `acv_ophcotherapya_exceptional_previntervention_sri_fk` (`stopreason_id`),
	KEY `acv_ophcotherapya_pastintervention_rtui_fk` (`relevanttreatment_id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_previntervention_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_previntervention_ei_fk` FOREIGN KEY (`exceptional_id`) REFERENCES `et_ophcotherapya_exceptional` (`id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_previntervention_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_previntervention_sri_fk` FOREIGN KEY (`stopreason_id`) REFERENCES `ophcotherapya_exceptional_pastintervention_stopreason` (`id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_previntervention_ti_fk` FOREIGN KEY (`treatment_id`) REFERENCES `ophcotherapya_treatment` (`id`),
	CONSTRAINT `acv_ophcotherapya_pastintervention_rtui_fk` FOREIGN KEY (`relevanttreatment_id`) REFERENCES `ophcotherapya_relevanttreatment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_exceptional_pastintervention_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_exceptional_pastintervention_version');

		$this->createIndex('ophcotherapya_exceptional_pastintervention_aid_fk','ophcotherapya_exceptional_pastintervention_version','id');
		$this->addForeignKey('ophcotherapya_exceptional_pastintervention_aid_fk','ophcotherapya_exceptional_pastintervention_version','id','ophcotherapya_exceptional_pastintervention','id');

		$this->addColumn('ophcotherapya_exceptional_pastintervention_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_exceptional_pastintervention_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_exceptional_pastintervention_version','version_id');
		$this->alterColumn('ophcotherapya_exceptional_pastintervention_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_exceptional_pastintervention_stopreason_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`other` tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `acv_otherapya_exceptional_previntervention_stopreason_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_exceptional_previntervention_stopreason_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_previntervention_stopreason_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_otherapya_exceptional_previntervention_stopreason_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_exceptional_pastintervention_stopreason_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_exceptional_pastintervention_stopreason_version');

		$this->createIndex('ophcotherapya_exceptional_pastintervention_stopreason_aid_fk','ophcotherapya_exceptional_pastintervention_stopreason_version','id');
		$this->addForeignKey('ophcotherapya_exceptional_pastintervention_stopreason_aid_fk','ophcotherapya_exceptional_pastintervention_stopreason_version','id','ophcotherapya_exceptional_pastintervention_stopreason','id');

		$this->addColumn('ophcotherapya_exceptional_pastintervention_stopreason_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_exceptional_pastintervention_stopreason_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_exceptional_pastintervention_stopreason_version','version_id');
		$this->alterColumn('ophcotherapya_exceptional_pastintervention_stopreason_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_exceptional_standardintervention_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`enabled` tinyint(1) NOT NULL DEFAULT '1',
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_exceptional_standardintervention_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_exceptional_standardintervention_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_standardintervention_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_standardintervention_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_exceptional_standardintervention_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_exceptional_standardintervention_version');

		$this->createIndex('ophcotherapya_exceptional_standardintervention_aid_fk','ophcotherapya_exceptional_standardintervention_version','id');
		$this->addForeignKey('ophcotherapya_exceptional_standardintervention_aid_fk','ophcotherapya_exceptional_standardintervention_version','id','ophcotherapya_exceptional_standardintervention','id');

		$this->addColumn('ophcotherapya_exceptional_standardintervention_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_exceptional_standardintervention_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_exceptional_standardintervention_version','version_id');
		$this->alterColumn('ophcotherapya_exceptional_standardintervention_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_exceptional_startperiod_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`urgent` tinyint(1) DEFAULT '0',
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`application_description` varchar(511) COLLATE utf8_bin DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_exceptional_startperiod_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_exceptional_startperiod_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_startperiod_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_exceptional_startperiod_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_exceptional_startperiod_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_exceptional_startperiod_version');

		$this->createIndex('ophcotherapya_exceptional_startperiod_aid_fk','ophcotherapya_exceptional_startperiod_version','id');
		$this->addForeignKey('ophcotherapya_exceptional_startperiod_aid_fk','ophcotherapya_exceptional_startperiod_version','id','ophcotherapya_exceptional_startperiod','id');

		$this->addColumn('ophcotherapya_exceptional_startperiod_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_exceptional_startperiod_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_exceptional_startperiod_version','version_id');
		$this->alterColumn('ophcotherapya_exceptional_startperiod_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_filecoll_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(256) COLLATE utf8_bin NOT NULL,
	`zipfile_id` int(10) unsigned DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`summary` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_filecoll_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_filecoll_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_filecoll_zi_fk` (`zipfile_id`),
	CONSTRAINT `acv_et_ophcotherapya_filecoll_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_filecoll_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_filecoll_zi_fk` FOREIGN KEY (`zipfile_id`) REFERENCES `protected_file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_filecoll_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_filecoll_version');

		$this->createIndex('ophcotherapya_filecoll_aid_fk','ophcotherapya_filecoll_version','id');
		$this->addForeignKey('ophcotherapya_filecoll_aid_fk','ophcotherapya_filecoll_version','id','ophcotherapya_filecoll','id');

		$this->addColumn('ophcotherapya_filecoll_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_filecoll_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_filecoll_version','version_id');
		$this->alterColumn('ophcotherapya_filecoll_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_filecoll_assignment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`collection_id` int(10) unsigned NOT NULL,
	`file_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_filecollass_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_filecollass_cui_fk` (`created_user_id`),
	KEY `acv_et_ophcotherapya_filecollass_ci_fk` (`collection_id`),
	KEY `acv_et_ophcotherapya_filecollass_fi_fk` (`file_id`),
	CONSTRAINT `acv_et_ophcotherapya_filecollass_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_filecollass_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_filecollass_ci_fk` FOREIGN KEY (`collection_id`) REFERENCES `ophcotherapya_filecoll` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_filecollass_fi_fk` FOREIGN KEY (`file_id`) REFERENCES `protected_file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_filecoll_assignment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_filecoll_assignment_version');

		$this->createIndex('ophcotherapya_filecoll_assignment_aid_fk','ophcotherapya_filecoll_assignment_version','id');
		$this->addForeignKey('ophcotherapya_filecoll_assignment_aid_fk','ophcotherapya_filecoll_assignment_version','id','ophcotherapya_filecoll_assignment','id');

		$this->addColumn('ophcotherapya_filecoll_assignment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_filecoll_assignment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_filecoll_assignment_version','version_id');
		$this->alterColumn('ophcotherapya_filecoll_assignment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_patientsuit_decisiontreenoderesponse_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`patientsuit_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned NOT NULL,
	`node_id` int(10) unsigned NOT NULL,
	`value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_patientsuit_dtnoderesponse_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_patientsuit_dtnoderesponse_cui_fk` (`created_user_id`),
	KEY `acv_ophcotherapya_patientsuit_dtnoderesponse_psi_fk` (`patientsuit_id`),
	KEY `acv_ophcotherapya_patientsuit_dtnoderesponse_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_ophcotherapya_patientsuit_dtnoderesponse_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_patientsuit_dtnoderesponse_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_ophcotherapya_patientsuit_dtnoderesponse_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_patientsuit_dtnoderesponse_psi_fk` FOREIGN KEY (`patientsuit_id`) REFERENCES `et_ophcotherapya_patientsuit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_patientsuit_decisiontreenoderesponse_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_patientsuit_decisiontreenoderesponse_version');

		$this->createIndex('ophcotherapya_patientsuit_decisiontreenoderesponse_aid_fk','ophcotherapya_patientsuit_decisiontreenoderesponse_version','id');
		$this->addForeignKey('ophcotherapya_patientsuit_decisiontreenoderesponse_aid_fk','ophcotherapya_patientsuit_decisiontreenoderesponse_version','id','ophcotherapya_patientsuit_decisiontreenoderesponse','id');

		$this->addColumn('ophcotherapya_patientsuit_decisiontreenoderesponse_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_patientsuit_decisiontreenoderesponse_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_patientsuit_decisiontreenoderesponse_version','version_id');
		$this->alterColumn('ophcotherapya_patientsuit_decisiontreenoderesponse_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_relevanttreatment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`other` tinyint(1) NOT NULL DEFAULT '0',
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_relevanttreatment_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_relevanttreatment_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophcotherapya_relevanttreatment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_relevanttreatment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_relevanttreatment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_relevanttreatment_version');

		$this->createIndex('ophcotherapya_relevanttreatment_aid_fk','ophcotherapya_relevanttreatment_version','id');
		$this->addForeignKey('ophcotherapya_relevanttreatment_aid_fk','ophcotherapya_relevanttreatment_version','id','ophcotherapya_relevanttreatment','id');

		$this->addColumn('ophcotherapya_relevanttreatment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_relevanttreatment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_relevanttreatment_version','version_id');
		$this->alterColumn('ophcotherapya_relevanttreatment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_therapydisorder_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`disorder_id` int(10) unsigned NOT NULL,
	`parent_id` int(10) unsigned DEFAULT NULL,
	`display_order` int(10) NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_therapydisorder_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_therapydisorder_cui_fk` (`created_user_id`),
	KEY `acv_ophcotherapya_therapydisorder_di_fk` (`disorder_id`),
	KEY `acv_ophcotherapya_therapydisorder_pi_fk` (`parent_id`),
	CONSTRAINT `acv_ophcotherapya_therapydisorder_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_therapydisorder_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_therapydisorder_di_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_ophcotherapya_therapydisorder_pi_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophcotherapya_therapydisorder` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_therapydisorder_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_therapydisorder_version');

		$this->createIndex('ophcotherapya_therapydisorder_aid_fk','ophcotherapya_therapydisorder_version','id');
		$this->addForeignKey('ophcotherapya_therapydisorder_aid_fk','ophcotherapya_therapydisorder_version','id','ophcotherapya_therapydisorder','id');

		$this->addColumn('ophcotherapya_therapydisorder_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_therapydisorder_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_therapydisorder_version','version_id');
		$this->alterColumn('ophcotherapya_therapydisorder_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_treatment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`drug_id` int(10) unsigned NOT NULL,
	`decisiontree_id` int(10) unsigned DEFAULT NULL,
	`contraindications_required` tinyint(1) NOT NULL,
	`template_code` varchar(8) COLLATE utf8_bin DEFAULT NULL,
	`intervention_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`dose_and_frequency` varchar(256) COLLATE utf8_bin NOT NULL,
	`administration_route` varchar(256) COLLATE utf8_bin NOT NULL,
	`cost` int(10) unsigned NOT NULL,
	`cost_type_id` int(10) unsigned NOT NULL,
	`monitoring_frequency` int(10) unsigned NOT NULL,
	`monitoring_frequency_period_id` int(10) unsigned NOT NULL,
	`duration` varchar(512) COLLATE utf8_bin NOT NULL,
	`toxicity` text COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophcotherapya_treatment_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophcotherapya_treatment_cui_fk` (`created_user_id`),
	KEY `acv_ophcotherapya_treatment_dti_fk` (`decisiontree_id`),
	KEY `acv_ophcotherapya_treatment_dri_fk` (`drug_id`),
	KEY `acv_ophcotherapya_treatment_ct_fk` (`cost_type_id`),
	KEY `acv_ophcotherapya_treatment_mfp_fk` (`monitoring_frequency_period_id`),
	CONSTRAINT `acv_ophcotherapya_treatment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_treatment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophcotherapya_treatment_dti_fk` FOREIGN KEY (`decisiontree_id`) REFERENCES `ophcotherapya_decisiontree` (`id`),
	CONSTRAINT `acv_ophcotherapya_treatment_dri_fk` FOREIGN KEY (`drug_id`) REFERENCES `ophtrintravitinjection_treatment_drug` (`id`),
	CONSTRAINT `acv_ophcotherapya_treatment_ct_fk` FOREIGN KEY (`cost_type_id`) REFERENCES `ophcotherapya_treatment_cost_type` (`id`),
	CONSTRAINT `acv_ophcotherapya_treatment_mfp_fk` FOREIGN KEY (`monitoring_frequency_period_id`) REFERENCES `period` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_treatment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_treatment_version');

		$this->createIndex('ophcotherapya_treatment_aid_fk','ophcotherapya_treatment_version','id');
		$this->addForeignKey('ophcotherapya_treatment_aid_fk','ophcotherapya_treatment_version','id','ophcotherapya_treatment','id');

		$this->addColumn('ophcotherapya_treatment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_treatment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_treatment_version','version_id');
		$this->alterColumn('ophcotherapya_treatment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophcotherapya_treatment_cost_type_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophcotherapya_treatment_cost_type_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophcotherapya_treatment_cost_type_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophcotherapya_treatment_cost_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophcotherapya_treatment_cost_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophcotherapya_treatment_cost_type_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophcotherapya_treatment_cost_type_version');

		$this->createIndex('ophcotherapya_treatment_cost_type_aid_fk','ophcotherapya_treatment_cost_type_version','id');
		$this->addForeignKey('ophcotherapya_treatment_cost_type_aid_fk','ophcotherapya_treatment_cost_type_version','id','ophcotherapya_treatment_cost_type','id');

		$this->addColumn('ophcotherapya_treatment_cost_type_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophcotherapya_treatment_cost_type_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophcotherapya_treatment_cost_type_version','version_id');
		$this->alterColumn('ophcotherapya_treatment_cost_type_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->addColumn('et_ophcotherapya_exceptional','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_exceptional_intervention','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_mrservicein','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_patientsuit','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_relativecon','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_therapydiag','deleted','tinyint(1) unsigned not null');

		$this->addColumn('ophcotherapya_decisiontree','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontree_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenode','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenode_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenode_responsetype','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenode_responsetype_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenodechoice','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenodechoice_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenoderule','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreenoderule_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreeoutcome','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_decisiontreeoutcome_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_email','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_email_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_email_attachment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_email_attachment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_deviationreason','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_deviationreason_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_deviationreason_ass','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_deviationreason_ass_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_filecoll_assignment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_filecoll_assignment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_pastintervention','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_pastintervention_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_pastintervention_stopreason','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_pastintervention_stopreason_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_standardintervention','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_standardintervention_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_startperiod','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_exceptional_startperiod_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_filecoll','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_filecoll_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_filecoll_assignment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_filecoll_assignment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_patientsuit_decisiontreenoderesponse','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_patientsuit_decisiontreenoderesponse_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_relevanttreatment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_relevanttreatment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_therapydisorder','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_therapydisorder_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_treatment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_treatment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_treatment_cost_type','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophcotherapya_treatment_cost_type_version','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('ophcotherapya_decisiontree','deleted');
		$this->dropColumn('ophcotherapya_decisiontree_version','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenode','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenode_version','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenode_responsetype','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenode_responsetype_version','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenodechoice','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenodechoice_version','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenoderule','deleted');
		$this->dropColumn('ophcotherapya_decisiontreenoderule_version','deleted');
		$this->dropColumn('ophcotherapya_decisiontreeoutcome','deleted');
		$this->dropColumn('ophcotherapya_decisiontreeoutcome_version','deleted');
		$this->dropColumn('ophcotherapya_email','deleted');
		$this->dropColumn('ophcotherapya_email_version','deleted');
		$this->dropColumn('ophcotherapya_email_attachment','deleted');
		$this->dropColumn('ophcotherapya_email_attachment_version','deleted');
		$this->dropColumn('ophcotherapya_exceptional_deviationreason','deleted');
		$this->dropColumn('ophcotherapya_exceptional_deviationreason_version','deleted');
		$this->dropColumn('ophcotherapya_exceptional_deviationreason_ass','deleted');
		$this->dropColumn('ophcotherapya_exceptional_deviationreason_ass_version','deleted');
		$this->dropColumn('ophcotherapya_exceptional_filecoll_assignment','deleted');
		$this->dropColumn('ophcotherapya_exceptional_filecoll_assignment_version','deleted');
		$this->dropColumn('ophcotherapya_exceptional_pastintervention','deleted');
		$this->dropColumn('ophcotherapya_exceptional_pastintervention_version','deleted');
		$this->dropColumn('ophcotherapya_exceptional_pastintervention_stopreason','deleted');
		$this->dropColumn('ophcotherapya_exceptional_pastintervention_stopreason_version','deleted');
		$this->dropColumn('ophcotherapya_exceptional_standardintervention','deleted');
		$this->dropColumn('ophcotherapya_exceptional_standardintervention_version','deleted');
		$this->dropColumn('ophcotherapya_exceptional_startperiod','deleted');
		$this->dropColumn('ophcotherapya_exceptional_startperiod_version','deleted');
		$this->dropColumn('ophcotherapya_filecoll','deleted');
		$this->dropColumn('ophcotherapya_filecoll_version','deleted');
		$this->dropColumn('ophcotherapya_filecoll_assignment','deleted');
		$this->dropColumn('ophcotherapya_filecoll_assignment_version','deleted');
		$this->dropColumn('ophcotherapya_patientsuit_decisiontreenoderesponse','deleted');
		$this->dropColumn('ophcotherapya_patientsuit_decisiontreenoderesponse_version','deleted');
		$this->dropColumn('ophcotherapya_relevanttreatment','deleted');
		$this->dropColumn('ophcotherapya_relevanttreatment_version','deleted');
		$this->dropColumn('ophcotherapya_therapydisorder','deleted');
		$this->dropColumn('ophcotherapya_therapydisorder_version','deleted');
		$this->dropColumn('ophcotherapya_treatment','deleted');
		$this->dropColumn('ophcotherapya_treatment_version','deleted');
		$this->dropColumn('ophcotherapya_treatment_cost_type','deleted');
		$this->dropColumn('ophcotherapya_treatment_cost_type_version','deleted');

		$this->dropColumn('et_ophcotherapya_exceptional','deleted');
		$this->dropColumn('et_ophcotherapya_exceptional_intervention','deleted');
		$this->dropColumn('et_ophcotherapya_mrservicein','deleted');
		$this->dropColumn('et_ophcotherapya_patientsuit','deleted');
		$this->dropColumn('et_ophcotherapya_relativecon','deleted');
		$this->dropColumn('et_ophcotherapya_therapydiag','deleted');

		$this->dropTable('et_ophcotherapya_exceptional_version');
		$this->dropTable('et_ophcotherapya_exceptional_intervention_version');
		$this->dropTable('et_ophcotherapya_mrservicein_version');
		$this->dropTable('et_ophcotherapya_patientsuit_version');
		$this->dropTable('et_ophcotherapya_relativecon_version');
		$this->dropTable('et_ophcotherapya_therapydiag_version');
		$this->dropTable('ophcotherapya_decisiontree_version');
		$this->dropTable('ophcotherapya_decisiontreenode_version');
		$this->dropTable('ophcotherapya_decisiontreenode_responsetype_version');
		$this->dropTable('ophcotherapya_decisiontreenodechoice_version');
		$this->dropTable('ophcotherapya_decisiontreenoderule_version');
		$this->dropTable('ophcotherapya_decisiontreeoutcome_version');
		$this->dropTable('ophcotherapya_email_version');
		$this->dropTable('ophcotherapya_email_attachment_version');
		$this->dropTable('ophcotherapya_exceptional_deviationreason_version');
		$this->dropTable('ophcotherapya_exceptional_deviationreason_ass_version');
		$this->dropTable('ophcotherapya_exceptional_filecoll_assignment_version');
		$this->dropTable('ophcotherapya_exceptional_pastintervention_version');
		$this->dropTable('ophcotherapya_exceptional_pastintervention_stopreason_version');
		$this->dropTable('ophcotherapya_exceptional_standardintervention_version');
		$this->dropTable('ophcotherapya_exceptional_startperiod_version');
		$this->dropTable('ophcotherapya_filecoll_version');
		$this->dropTable('ophcotherapya_filecoll_assignment_version');
		$this->dropTable('ophcotherapya_patientsuit_decisiontreenoderesponse_version');
		$this->dropTable('ophcotherapya_relevanttreatment_version');
		$this->dropTable('ophcotherapya_therapydisorder_version');
		$this->dropTable('ophcotherapya_treatment_version');
		$this->dropTable('ophcotherapya_treatment_cost_type_version');
	}
}
