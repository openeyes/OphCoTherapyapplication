<?php

class m130916_154503_additional_mr_patient_shortcodes extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCoTherapyapplication'));

		$event_type->registerShortcode('tdl','getLetterApplicationDiagnosisLeft','Therapy application diagnosis for left eye');
		$event_type->registerShortcode('tdr','getLetterApplicationDiagnosisRight','Therapy application diagnosis for right eye');

		$event_type->registerShortcode('ttl','getLetterApplicationTreatmentLeft','Therapy application treatment for left eye');
		$event_type->registerShortcode('ttr','getLetterApplicationTreatmentRight','Therapy application treatment for right eye');


	}

	public function down()
	{
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'tdl'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'tdr'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'ttl'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'ttr'));
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