<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_slug_column extends CI_Migration {

    public function up()
    {
        $custom_query = "ALTER TABLE users ADD slug VARCHAR(128)";
        $this->db->query($custom_query);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'slug');
    }
}