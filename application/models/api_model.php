<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{
    public function getComments()
    {
        $query = $this->db->get('comments');
        return $query->result();
    }

    public function putComment(int $commentId, array $data)
    {
        $this->db->where('id', $commentId);
        $query = $this->db->update('comments', $data);
        return $query;
    }

    public function patchComment(int $commentId, array $data)
    {
        $this->db->where('id', $commentId);
        $query = $this->db->update('comments', $data);
        return $query;
    }

    public function createComment(array $data)
    {
        $query = $this->db->insert('comments', $data);
        return $this->db->insert_id();
    }

    public function deleteComment(int $commentId)
    {
        $query = $this->db->delete('comments', ['id' => $commentId]);
        return $query;
    }

    public function checkExist(int $commentId)
    {
        return $this->db->get_where('comments', array('id' => $commentId))->row();
    }
}
