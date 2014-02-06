<?php

class m140206_085301_remove_soft_deletion_from_models_that_dont_need_it extends CDbMigration
{
	public $tables = array(
		'et_ophcotherapya_exceptional',
		'et_ophcotherapya_mrservicein',
		'et_ophcotherapya_patientsuit',
		'et_ophcotherapya_relativecon',
		'et_ophcotherapya_therapydiag',
		'ophcotherapya_decisiontreenode',
		'ophcotherapya_decisiontreenodechoice',
		'ophcotherapya_decisiontreenoderule',
		'ophcotherapya_email',
		'ophcotherapya_email_attachment',
		'ophcotherapya_exceptional_deviationreason_ass',
		'ophcotherapya_exceptional_filecoll_assignment',
		'ophcotherapya_exceptional_pastintervention',
		'ophcotherapya_filecoll_assignment',
		'ophcotherapya_patientsuit_decisiontreenoderesponse',
		'ophcotherapya_therapydisorder',
		'ophcotherapya_treatment',
	);

	public function up()
	{
		$this->execute("CREATE TABLE `ophcotherapya_email_recipient_version` (
				`id` int(10) unsigned NOT NULL,
				`site_id` int(10) unsigned DEFAULT NULL,
				`recipient_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				`recipient_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				`type_id` int(10) unsigned DEFAULT NULL,
				`display_order` tinyint(1) unsigned NOT NULL,
				`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
				`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
				`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
				`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
				`version_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
				`version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`version_id`),
				KEY `acv_ophcotherapya_email_recipient_lmui_fk` (`last_modified_user_id`),
				KEY `acv_ophcotherapya_email_recipient_cui_fk` (`created_user_id`),
				KEY `acv_ophcotherapya_email_recipient_site_id_fk` (`site_id`),
				KEY `acv_ophcotherapya_email_recipient_type_id_fk` (`type_id`),
				KEY `ophcotherapya_email_recipient_aid_fk` (`id`),
				CONSTRAINT `acv_ophcotherapya_email_recipient_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
				CONSTRAINT `acv_ophcotherapya_email_recipient_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
				CONSTRAINT `acv_ophcotherapya_email_recipient_site_id_fk` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`),
				CONSTRAINT `acv_ophcotherapya_email_recipient_type_id_fk` FOREIGN KEY (`type_id`) REFERENCES `ophcotherapya_email_recipient_type` (`id`),
				CONSTRAINT `ophcotherapya_email_recipient_aid_fk` FOREIGN KEY (`id`) REFERENCES `ophcotherapya_email_recipient` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		$this->execute("CREATE TABLE `ophcotherapya_email_recipient_type_version` (
				`id` int(10) unsigned NOT NULL,
				`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				`display_order` tinyint(1) unsigned NOT NULL,
				`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
				`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
				`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
				`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
				`version_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
				`version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`deleted` tinyint(1) unsigned NOT NULL,
				PRIMARY KEY (`version_id`),
				KEY `acv_ophcotherapya_email_recipient_type_lmui_fk` (`last_modified_user_id`),
				KEY `acv_ophcotherapya_email_recipient_type_cui_fk` (`created_user_id`),
				KEY `ophcotherapya_email_recipient_type_aid_fk` (`id`),
				CONSTRAINT `acv_ophcotherapya_email_recipient_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
				CONSTRAINT `acv_ophcotherapya_email_recipient_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
				CONSTRAINT `ophcotherapya_email_recipient_type_aid_fk` FOREIGN KEY (`id`) REFERENCES `ophcotherapya_email_recipient_type` (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

		foreach ($this->tables as $table) {
			$this->dropColumn($table,'deleted');
			$this->dropColumn($table.'_version','deleted');

			$this->dropForeignKey("{$table}_aid_fk",$table."_version");
		}
	}

	public function down()
	{
		foreach ($this->tables as $table) {
			$this->addColumn($table,'deleted','tinyint(1) unsigned not null');
			$this->addColumn($table."_version",'deleted','tinyint(1) unsigned not null');

			$this->addForeignKey("{$table}_aid_fk",$table."_version","id",$table,"id");
		}

		$this->dropTable('ophcotherapya_email_recipient_version');
		$this->dropTable('ophcotherapya_email_recipient_type_version');
	}
}
