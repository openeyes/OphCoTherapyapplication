<?php

class m131210_144532_soft_deletion extends CDbMigration
{
	public function up()
	{
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
	}
}
