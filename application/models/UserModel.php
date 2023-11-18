<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function get_user()
    {
        $query = $this->db->get("users");
        return $query->result();
        // alert();
        // return $this->db->get("users")->result_array();
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function edit_user($id)
    {
        // $this->db->where('id',$id);
        // $query = $this->db->get('users');
        // return $query->row();

        $this->db->where("id", $id);
        $this->db->limit(1);
        $user = $this->db->get("users");
        return $user->row_array();
    }

    public function update_user($id, $data)
    {
        // $this->db->where('id', $id);
        // return $this->db->update('users', $data);

        $this->db->where("id", $id);
        // print_r($data); die;
        return $this->db->update("users", $data);
        // return $user->row_array();
    }

    public function delete_user($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }
}
