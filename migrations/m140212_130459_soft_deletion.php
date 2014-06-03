<?php

class m140212_130459_soft_deletion extends OEMigration
{
	public function up()
	{
		$this->renameColumn('ophcotherapya_exceptional_deviationreason', 'enabled', 'active');
		$this->renameColumn('ophcotherapya_exceptional_standardintervention', 'enabled', 'active');
		$this->renameColumn('ophcotherapya_exceptional_startperiod', 'enabled', 'active');

		$this->addColumn('ophcotherapya_treatment','active','boolean not null default true');
		$this->addColumn('ophcotherapya_filecoll','active','boolean not null default true');
		$this->addColumn('ophcotherapya_relevanttreatment','active','boolean not null default true');
	}

	public function down()
	{
		$this->dropColumn('ophcotherapya_filecoll','active');
		$this->dropColumn('ophcotherapya_relevanttreatment','active');
		$this->dropColumn('ophcotherapya_treatment','active');

		$this->renameColumn('ophcotherapya_exceptional_deviationreason', 'active', 'enabled');
		$this->renameColumn('ophcotherapya_exceptional_standardintervention', 'active', 'enabled');
		$this->renameColumn('ophcotherapya_exceptional_startperiod', 'active', 'enabled');
	}
}
