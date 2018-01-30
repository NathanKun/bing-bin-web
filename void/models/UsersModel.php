<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class UsersModel extends CI_Model
{

    protected $table = "Users";

    public function getAll()
    {
        return $this->db->select('*')
            ->from($this->table)
            ->get()
            ->result();
    }

    public function get($id)
    {
        return $this->db->select('*')
            ->from($this->table)
            ->where('id', $id)
            ->get()
            ->result();
    }

    public function add($args = array())
    {
        $id = uniqid(substr($args['name'], 0, 5), true);
        $this->db->set('id', $id);
        $this->db->set('name', $args['name']);
        $this->db->set('email', $args['mail']);

        $this->db->insert($this->table);

        return $id;
    }

    public function isRegister_FB($user_id)
    {
        return $this->db->select('*')
            ->from($this->table)
            ->where('fb_id', $user_id)
            ->get()
            ->result();
    }

    public function isRegister_Google($user_id)
    {

    }
}
