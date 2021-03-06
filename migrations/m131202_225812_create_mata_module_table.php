<?php

class m131202_225812_create_mata_module_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('matamodule', array(
			'Id' => 'pk',
			'Name' => 'varchar(32) NOT NULL',
			'MataModuleGroupId' =>  'int(11)',
			'Config' => 'text',
			));

		$this->addForeignKey("FK_MataModuleGroup", "matamodule", "MataModuleGroupId", "matamodulegroup", "Id");
	}

	public function safeDown()
	{
	}
}