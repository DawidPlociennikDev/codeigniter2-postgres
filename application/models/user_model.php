<?php

require 'application/models/traits/slug_trait.php';
use Models\Traits\SlugTrait;

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    use SlugTrait;

    public function custom_query(string $email) : object
    {
        $query = $this->db->query('EXPLAIN SELECT * FROM users');
        print_r($query->row());exit;
        return $query->row();
    }

    public function get_user_by_email(string $email) : object
    {
		log_message('error', json_encode($this->user_model->get_user_by_email_with_EXPLAIN($email)));
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_user_by_email_with_EXPLAIN(string $email) : object
    {
        $query = $query = $this->db->query("EXPLAIN ANALYZE VERBOSE SELECT * FROM users WHERE email = '{$email}'");
        return $query->row();
    }

    public function insert_user(array $data)
    {
        $data['slug'] = User_model::slugName($data['first_name']. ' ' . $data['last_name']);
        $this->db->insert('users', $data);
        return (int) $this->db->insert_id();
    }

    public function get_user_comments(int $id) : object
    {
		log_message('error', json_encode($this->user_model->get_user_comments_with_EXPLAIN($id)));
        $query = $query = $this->db->query("SELECT users.*, comments.*
            FROM users
            LEFT JOIN comments ON users.id = comments.user_id
            WHERE users.id = {$id}");
        return $query->row();
    }

    public function get_user_comments_with_EXPLAIN(int $id) : object
    {
        $query = $query = $this->db->query("EXPLAIN ANALYZE VERBOSE 
            SELECT users.*, comments.*
            FROM users
            LEFT JOIN comments ON users.id = comments.user_id
            WHERE users.id = {$id}");
        return $query->row();
    }
}
