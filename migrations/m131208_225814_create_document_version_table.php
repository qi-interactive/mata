<?php

class m131208_225814_create_document_version_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('documentversion', array(
			'DocumentId' => 'varchar(128)',
			'Revision' => 'TEXT NOT NULL',
			'DateCreated' => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
			'ModelAttributes' => "LONGTEXT NOT NULL",
			'CreatorMataUserId' => "int(11) NOT NULL",
			'IsPublished' => "tinyint(1) NOT NULL DEFAULT 0",
			'PRIMARY KEY (`DocumentId`)'
			));

	}

	public function safeDown()
	{
	}
}