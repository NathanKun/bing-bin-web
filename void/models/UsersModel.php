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

    // ***************************************
    // Args : label|body|private|album|sondage
    // ***************************************
    public function add($args = array())
    {

        $this->db->set('id', uniqid(substr($args['name'], 0, 5), true));
        $this->db->set('name', $args['name']);
        $this->db->set('mail', $args['mail']);

        return $this->db->insert($this->table);
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
