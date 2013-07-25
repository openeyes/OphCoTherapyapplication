<?php

class m130724_103306_previousintervention_tweaks extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophcotherapya_exceptional_previntervention_stopreason', 'other', 'boolean NOT NULL DEFAULT False');
		$this->insert('ophcotherapya_exceptional_previntervention_stopreason', array('name' => 'Other', 'display_order' => 6, 'other' => true));
		
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'stopreason_other', 'text');
		$this->addColumn('ophcotherapya_exceptional_previntervention', 'comments', 'text');
		
		$this->insert('ophcotherapya_exceptional_standardintervention',array('name'=>'Intravitreal Eylea', 'display_order'=>6));
	}

	public function down()
	{
		// If these first statement fails, you have data issues to deal with before you can migrate down
		$this->delete('ophcotherapya_exceptional_previntervention_stopreason', 'other = true');
		$this->delete('ophcotherapya_exceptional_standardintervention', "name = 'Intravitreal Eylea'");
		
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'comments');
		$this->dropColumn('ophcotherapya_exceptional_previntervention', 'stopreason_other');
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