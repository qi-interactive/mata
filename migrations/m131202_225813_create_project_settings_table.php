<?php

class m131202_225813_create_project_settings_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('matamodule', array(
			'Key' => 'varchar(128) pk',
			'Value' => 'TEXT NOT NULL',
			));

	}

	public function safeDown()
	{
	}
}