<?php

class m131206_150647_soft_deletion extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophcotherapya_exceptional','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_exceptional_intervention','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_mrservicein','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_patientsuit','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_relativecon','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophcotherapya_therapydiag','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('et_ophcotherapya_exceptional','deleted');
		$this->dropColumn('et_ophcotherapya_exceptional_intervention','deleted');
		$this->dropColumn('et_ophcotherapya_mrservicein','deleted');
		$this->dropColumn('et_ophcotherapya_patientsuit','deleted');
		$this->dropColumn('et_ophcotherapya_relativecon','deleted');
		$this->dropColumn('et_ophcotherapya_therapydiag','deleted');
	}
}
