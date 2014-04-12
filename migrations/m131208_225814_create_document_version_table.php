<?php

class m131202_225814_create_document_version_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('documentversion', array(
			'DocumentId' => 'varchar(128) pk',
			'Revision' => 'TEXT NOT NULL',
			'DateCreated' => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
			'ModelAttributes' => "LONGTEXT NOT NULL",
			'CreatorMataUserId' => "int(11) NOT NULL",
			'IsPublished' => "tinyint(1) NOT NULL DEFAULT 0"
			));

	}

	public function safeDown()
	{
	}
}