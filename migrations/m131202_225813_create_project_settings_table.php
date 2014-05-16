<?php

class m131202_225813_create_project_settings_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('projectsetting', array(
			'Key' => 'varchar(128) NOT NULL',
			'Value' => 'text NOT NULL',
			'PRIMARY KEY (`Key`)'
			));

	}

	public function safeDown()
	{
	}
}