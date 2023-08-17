<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_user_by_email(string $email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_user_by_emailEXPLAIN(string $email)
    {
        // $query = $this->db->query("EXPLAIN SELECT * FROM users WHERE email = " . $email);
        // return $query->result_array();
    }

    public function get_user_by_emailSTATS(string $email)
    {
        $query = $this->db->query("SELECT * FROM pg_stat_statements");
        return $query->result_array();
    }

    public function insert_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
}
