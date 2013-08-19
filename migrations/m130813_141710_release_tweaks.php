<?php

class m130813_141710_release_tweaks extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophcotherapya_filecoll', 'summary', 'text');
		$this->addColumn('et_ophcotherapya_exceptional', 'left_patient_expectations', 'text');
		$this->addColumn('et_ophcotherapya_exceptional', 'right_patient_expectations', 'text');
		// expand to match possible values from VA values (practically unnecessary, but good for consistency)
		$this->alterColumn('ophcotherapya_patientsuit_decisiontreenoderesponse','value','varchar(255)');
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'start_va', 'varchar(255)');
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'end_va', 'varchar(255)');
		$this->renameColumn('ophcotherapya_exceptional_previntervention','treatment_date', 'start_date');
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'end_date', 'datetime NOT NULL');
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'is_relevant', 'boolean NOT NULL DEFAULT false');
		$this->renameTable('ophcotherapya_exceptional_previntervention', 'ophcotherapya_exceptional_pastintervention');
		$this->renameTable('ophcotherapya_relevanttreatment', 'ophcotherapya_exceptional_pastintervention_stopreason');

		$this->createTable('ophcotherapya_relevanttreatment', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
			'other' => 'boolean NOT NULL DEFAULT false',
			'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
			'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
			'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
			'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
			'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
			'PRIMARY KEY (`id`)',
			'KEY `ophcotherapya_relevanttreatment_lmui_fk` (`last_modified_user_id`)',
			'KEY `ophcotherapya_relevanttreatment_cui_fk` (`created_user_id`)',
			'CONSTRAINT `ophcotherapya_relevanttreatment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			'CONSTRAINT `ophcotherapya_relevanttreatment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');


		$this->insert('ophcotherapya_relevanttreatment',array('name'=>'Azathioprine','display_order'=>1));
		$this->insert('ophcotherapya_relevanttreatment',array('name'=>'Ciclosporin','display_order'=>2));
		$this->insert('ophcotherapya_relevanttreatment',array('name'=>'Methotrexate','display_order'=>3));
		$this->insert('ophcotherapya_relevanttreatment',array('name'=>'Mycophenolate','display_order'=>4));
		$this->insert('ophcotherapya_relevanttreatment',array('name'=>'Prednisolone','display_order'=>5));
		$this->insert('ophcotherapya_relevanttreatment',array('name'=>'Other', 'other' => true, 'display_order'=>6));

		$this->addColumn('ophcotherapya_exceptional_pastintervention', 'relevanttreatment_id', 'int(10) unsigned');
		$this->addForeignKey('ophcotherapya_pastintervention_rtui_fk', 'ophcotherapya_exceptional_pastintervention',
			'relevanttreatment_id', 'ophcotherapya_relevanttreatment', 'id');
		$this->addColumn('ophcotherapya_exceptional_pastintervention', 'relevanttreatment_other', 'varchar(255)');
		$this->alterColumn('ophcotherapya_exceptional_pastintervention', 'treatment_id', 'int(10) unsigned');

	}

	public function down()
	{
		$this->alterColumn('ophcotherapya_exceptional_pastintervention', 'treatment_id', 'int(10) unsigned NOT NULL');
		$this->dropColumn('ophcotherapya_exceptional_pastintervention', 'relevanttreatment_other');
		$this->dropForeignKey('ophcotherapya_pastintervention_rtui_fk', 'ophcotherapya_exceptional_pastintervention');
		$this->dropColumn('ophcotherapya_exceptional_pastintervention', 'relevanttreatment_id');
		$this->dropTable('ophcotherapya_relevanttreatment');
		$this->renameTable('ophcotherapya_exceptional_pastintervention_stopreason', 'ophcotherapya_relevanttreatment');
		$this->renameTable('ophcotherapya_exceptional_pastintervention', 'ophcotherapya_exceptional_previntervention');
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'is_relevant');
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'end_date');
		$this->renameColumn('ophcotherapya_exceptional_previntervention', 'start_date', 'treatment_date');
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'end_va');
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'start_va');
		$this->alterColumn('ophcotherapya_patientsuit_decisiontreenoderesponse','value','varchar(16)');
		$this->dropColumn('et_ophcotherapya_exceptional', 'right_patient_expectations');
		$this->dropColumn('et_ophcotherapya_exceptional', 'left_patient_expectations');
		$this->dropColumn('ophcotherapya_filecoll', 'summary');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}