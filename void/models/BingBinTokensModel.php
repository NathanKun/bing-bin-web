<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class BingBinTokensModel extends CI_Model
{

    protected $table = "BingBinTokens";

    public function getAll()
    {
        return $this->db->select('*')
            ->from($this->table)
            ->get()
            ->result();
    }

    public function save($args = array())
    {
        $time = time();
        $this->db->set('id', uniqid("bbt", true));
        $this->db->set('id_user', $args['id_user']);
        $this->db->set('emit_date', $time);
        $this->db->set('token_value', $args['token']);
        $this->db->set('expire_date', $time + 7*24*3600);

        return $this->db->insert($this->table);
    }
}
