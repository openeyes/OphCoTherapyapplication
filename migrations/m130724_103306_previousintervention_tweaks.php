<?php

class m130724_103306_previousintervention_tweaks extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophcotherapya_exceptional_previntervention_stopreason', 'other', 'boolean NOT NULL DEFAULT False');
		$this->insert('ophcotherapya_exceptional_previntervention_stopreason', array('name' => 'Other', 'display_order' => 6, 'other' => true));
		
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'stopreason_other', 'text');
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'comments', 'text');
		
	}

	public function down()
	{
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'comments');
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'stopreason_other');
		$this->delete('ophcotherapya_exceptional_previntervention_stopreason', 'other = true');
		$this->dropColumn('ophcotherapya_exceptional_previntervention_stopreason', 'other');
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