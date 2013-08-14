<?php

class m130813_141710_release_tweaks extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophcotherapya_filecoll', 'summary', 'text');

	}

	public function down()
	{
		$this->dropColumn('ophcotherapya_filecoll', 'summary');
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