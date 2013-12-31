<?php

class m131230_155546_email_groups extends CDbMigration
{
	public function up()
	{
		$this->createTable('ophcotherapya_email_recipient', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'site_id' => 'int(10) unsigned not null',
				'name' => 'varchar(255) collate utf8_bin not null',
				'email' => 'varchar(255) collate utf8_bin not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophcotherapya_email_recipient_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophcotherapya_email_recipient_cui_fk` (`created_user_id`)',
				'KEY `ophcotherapya_email_recipient_site_id_fk` (`site_id`)',
				'CONSTRAINT `ophcotherapya_email_recipient_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_email_recipient_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophcotherapya_email_recipient_site_id_fk` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
	}

	public function down()
	{
		$this->dropTable('ophcotherapya_email_recipient');
	}
}
