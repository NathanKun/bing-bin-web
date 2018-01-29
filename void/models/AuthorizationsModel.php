<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AuthorizationsModel extends CI_Model
{

    protected $table = "Authorizations";

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

    // ***************************************
    // Args : label|body|private|album|sondage
    // ***************************************
    public function add($args = array())
    {
        $id = uniqid(substr($args['name'], 0, 5), true);
        $this->db->set('id', $id);
        $this->db->set('name', $args['name']);
        $this->db->set('email', $args['mail']);

        $this->db->insert($this->table);

        return $id;
    }
}
