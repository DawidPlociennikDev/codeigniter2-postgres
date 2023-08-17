<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_user_by_email(string $email) : object
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function insert_user($data) : int
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
}
