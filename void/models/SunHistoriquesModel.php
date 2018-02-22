<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class SunHistoriquesModel extends CI_Model
{

    protected $table = "Sun_Historiques";

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

    public function save($args = array())
    {
        $id = uniqid(time(), true);

        $this->db->set('id', $id);
        $this->db->set('id_receiver_user', $args['id_receiver']);
        $this->db->set('id_sending_user', $args['id_sender']);
        $this->db->set('sending_date', time());

        if($this->db->insert($this->table)){
            return $id;
        }else{
            return FALSE;
        }
    }

    public function inDuration($id, $duration)
    {
        return $this->db->select('*')
        ->from($this->table)
        ->where('sending_date >=', $duration)
        ->where('id_sending_user', $id)
        ->get()
        ->result();
    }
}
