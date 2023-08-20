<?php

require 'application/models/traits/slug_trait.php';
use Models\Traits\SlugTrait;

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    use SlugTrait;

    public function customQuery(string $email)
    {
        $query = $this->db->query('EXPLAIN SELECT * FROM users');
        print_r($query->row());exit;
        return $query->row();
    }

    public function getUserByEmail(string $email)
    {
		log_message('error', json_encode($this->user_model->getUserByEmailWithEXPLAIN($email)));
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function getUserByEmailWithEXPLAIN(string $email)
    {
        $query = $query = $this->db->query("EXPLAIN ANALYZE VERBOSE SELECT * FROM users WHERE email = '{$email}'");
        return $query->row();
    }

    public function insertUser(array $data): int
    {
        $data['slug'] = User_model::slugName($data['first_name']. ' ' . $data['last_name']);
        $this->db->insert('users', $data);
        return (int) $this->db->insert_id();
    }

    public function updateUserLoginDate(int $user_id) : void
    {
        $this->db->where('id', $user_id);
        $this->db->update('users', ['login_at' => date('Y-m-d H:i:s')]);
    }

    public function getUserComments(int $id)
    {
		log_message('error', json_encode($this->user_model->getUserCommentsWithEXPLAIN($id)));
        $query = $query = $this->db->query("SELECT users.*, comments.*
            FROM users
            LEFT JOIN comments ON users.id = comments.user_id
            WHERE users.id = {$id}");
        return $query->row();
    }

    public function getUserCommentsWithEXPLAIN(int $id)
    {
        $query = $query = $this->db->query("EXPLAIN ANALYZE VERBOSE 
            SELECT users.*, comments.*
            FROM users
            LEFT JOIN comments ON users.id = comments.user_id
            WHERE users.id = {$id}");
        return $query->row();
    }
}
