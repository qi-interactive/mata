<?php

class m131202_225812_create_mata_module_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('matamodule', array(
			'Id' => 'pk',
			'Name' => 'varchar(32) NOT NULL',
			'MataModuleGroupId' =>  'tinyint(2)',
			'Config' => 'text',
			));

		$this->addForeignKey("FK_MataModuleGroup", "MataModule", "MataModuleGroupId", "MataModuleGroup", "Id");
	}

	public function safeDown()
	{
	}
}