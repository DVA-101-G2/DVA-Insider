<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Usertables extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_type' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE
			),
			'user_email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_email_authentication' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_email_authentication_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_password' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_password_salt' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_ranks' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_firstname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_surname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'user_registered' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'user_last_login' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'user_online' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE
			),
			'user_image' => array(
				'type' => 'BLOB',
			)
		));
		$this->dbforge->add_key('user_id', TRUE);
		$this->dbforge->create_table('users');
		$this->dbforge->add_field(array(
			'activity_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'activity_visibility' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'unsigned' => TRUE,
			),
			'activity_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'activity_timestamp' => array(
				'type' => 'INT',
				'constraint' => 11
			),
			'activity_data' => array(
				'type' => 'TEXT',
			)
		));
		$this->dbforge->add_key('activity_id', TRUE);
		$this->dbforge->create_table('user_activities');
		
		$this->dbforge->add_field(array(
			'user_rank_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'rank_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'rank_color' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			)
		));
		$this->dbforge->add_key('user_rank_id', TRUE);
		$this->dbforge->create_table('user_ranks');
	}

	public function down()
	{
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('user_activities');
		$this->dbforge->drop_table('user_ranks');
	}
	
}