<?php

class m140303_154021_transactions extends CDbMigration
{
	public $tables = array('et_ophcotherapya_exceptional','et_ophcotherapya_mrservicein','et_ophcotherapya_patientsuit','et_ophcotherapya_relativecon','et_ophcotherapya_therapydiag','ophcotherapya_decisiontree','ophcotherapya_decisiontreenode_responsetype','ophcotherapya_decisiontreenode','ophcotherapya_decisiontreenodechoice','ophcotherapya_decisiontreenoderule','ophcotherapya_decisiontreeoutcome','ophcotherapya_email_attachment','ophcotherapya_email_recipient_type','ophcotherapya_email_recipient','ophcotherapya_email','ophcotherapya_exceptional_deviationreason_ass','ophcotherapya_exceptional_deviationreason','ophcotherapya_exceptional_filecoll_assignment','ophcotherapya_exceptional_intervention','ophcotherapya_exceptional_pastintervention_stopreason','ophcotherapya_exceptional_pastintervention','ophcotherapya_exceptional_standardintervention','ophcotherapya_exceptional_startperiod','ophcotherapya_filecoll_assignment','ophcotherapya_filecoll','ophcotherapya_patientsuit_decisiontreenoderesponse','ophcotherapya_relevanttreatment','ophcotherapya_therapydisorder','ophcotherapya_treatment_cost_type','ophcotherapya_treatment');

	public function up()
	{
		foreach ($this->tables as $table) {
			$this->addColumn($table,'hash','varchar(40) not null');
			$this->addColumn($table,'transaction_id','int(10) unsigned null');
			$this->createIndex($table.'_tid',$table,'transaction_id');
			$this->addForeignKey($table.'_tid',$table,'transaction_id','transaction','id');

			$this->addColumn($table.'_version','hash','varchar(40) not null');
			$this->addColumn($table.'_version','transaction_id','int(10) unsigned null');
			$this->addColumn($table.'_version','deleted_transaction_id','int(10) unsigned null');
			$this->createIndex($table.'_vtid',$table.'_version','transaction_id');
			$this->addForeignKey($table.'_vtid',$table.'_version','transaction_id','transaction','id');
			$this->createIndex($table.'_dtid',$table.'_version','deleted_transaction_id');
			$this->addForeignKey($table.'_dtid',$table.'_version','deleted_transaction_id','transaction','id');
		}
	}

	public function down()
	{
		foreach ($this->tables as $table) {
			$this->dropColumn($table,'hash');
			$this->dropForeignKey($table.'_tid',$table);
			$this->dropIndex($table.'_tid',$table);
			$this->dropColumn($table,'transaction_id');

			$this->dropColumn($table.'_version','hash');
			$this->dropForeignKey($table.'_vtid',$table.'_version');
			$this->dropIndex($table.'_vtid',$table.'_version');
			$this->dropColumn($table.'_version','transaction_id');
			$this->dropForeignKey($table.'_dtid',$table.'_version');
			$this->dropIndex($table.'_dtid',$table.'_version');
			$this->dropColumn($table.'_version','deleted_transaction_id');
		}
	}
}
