<?php

class m131202_225811_create_mata_module_group_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('matamodulegroup', array(
			'Id' => 'pk',
			'Name' => 'varchar(64) NOT NULL',
			'Order' => 'tinyint(2) NOT NULL',
			));
	}

	public function safeDown()
	{
	}
}