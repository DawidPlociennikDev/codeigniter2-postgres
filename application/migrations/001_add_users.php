<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'unique' => TRUE
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'login_at' => array(
				'type' => 'TIMESTAMP',
				'NULL' => TRUE
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => '128',
				'NULL' => TRUE
			),
		));

        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users');

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 5,
				'unsigned' => TRUE,
			),
			'comment' => array(
				'type' => 'TEXT',
            ),
			'created_at timestamp default current_timestamp',
		));

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('user_id'); 
		$this->dbforge->create_table('comments');
        $this->db->query('ALTER TABLE comments ADD CONSTRAINT fk_comments_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
	}

	public function down()
	{
		$this->db->query('ALTER TABLE comments DROP CONSTRAINT fk_comments_users');
		$this->dbforge->drop_table('comments');
		$this->dbforge->drop_table('users');
	}
}