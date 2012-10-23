<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Auth extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			)
		));
		$this->dbforge->add_key('group_id', TRUE);
		$this->dbforge->create_table('groups');


		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => FALSE
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => FALSE
			)
		));
		$this->dbforge->add_key('user_id', TRUE);
		$this->dbforge->add_key('group_id', TRUE);
		$this->dbforge->create_table('members');


		$this->dbforge->add_field(array(
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => FALSE
			),
			'resource_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => FALSE
			),
			'item_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => FALSE
			)
		));
		$this->dbforge->add_key('item_id', TRUE);
		$this->dbforge->add_key('resource_id', TRUE);
		$this->dbforge->add_key('group_id', TRUE);
		$this->dbforge->create_table('mapper');

		$this->dbforge->add_field(array(
			'resource_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'tablename' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
			'action' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
		));
		$this->dbforge->add_key('resource_id', TRUE);
		$this->dbforge->create_table('resources');

	}

	public function down()
	{
	}

}