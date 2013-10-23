<?php

class m131023_100530_both_eye_shortcodes extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCoTherapyapplication'));

		$event_type->registerShortcode('tdb','getLetterApplicationDiagnosisBoth','Therapy application diagnosis for both eyes');
		$event_type->registerShortcode('ttb','getLetterApplicationTreatmentBoth','Therapy application treatment for both eyes');
	}

	public function down()
	{
		$this->delete('patient_shortcode','method = :meth',array(':meth'=>'getLetterApplicationTreatmentBoth'));
		$this->delete('patient_shortcode','method = :meth',array(':meth'=>'getLetterApplicationDiagnosisBoth'));
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