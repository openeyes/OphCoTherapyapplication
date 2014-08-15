<?php

class m140815_150043_rename_event extends CDbMigration
{
	public function up()
	{
		$this->update('event_type',array('name' => 'Therapy application'),"class_name = 'OphCoTherapyapplication'");
	}

	public function down()
	{
		$this->update('event_type',array('name' => 'Therapy Application'),"class_name = 'OphCoTherapyapplication'");
	}
}
