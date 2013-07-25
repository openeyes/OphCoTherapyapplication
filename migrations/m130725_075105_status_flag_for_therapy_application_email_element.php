<?php

class m130725_075105_status_flag_for_therapy_application_email_element extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophcotherapya_email','sent','tinyint(1) unsigned NOT NULL DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('et_ophcotherapya_email','sent');
	}
}
