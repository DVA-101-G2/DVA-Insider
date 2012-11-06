<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Widgets extends CI_Migration {

	public function up() {
		$this->dbforge->add_field(array(
			'widget_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'widget_owner' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE
			),
			'widget_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
			'widget_group' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			),
			'widget_data' => array(
				'type' => 'TEXT'
			)
		));
		$this->dbforge->add_key('widget_id', TRUE);
		$this->dbforge->create_table('widgets');

	}

	public function down() {
		$this->dbforge->drop_table('widgets');
	}

}