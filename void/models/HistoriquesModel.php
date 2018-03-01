<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class HistoriquesModel extends CI_Model
{

    protected $table = "Historiques";

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
        $this->db->set('id_trashe', $args['id_trash']);
        $this->db->set('id_user', $args['id_user']);
        $this->db->set('date_of_scan', time());

        if($this->db->insert($this->table)){
            return $id;
        }else{
            return FALSE;
        }
    }

    public function inDuration($duration)
    {
        return $this->db->select('*')
        ->from($this->table)
        ->where('date_of_scan >=', $duration)
        ->order_by('date_of_scan','DESC')
        ->get()
        ->result();
    }

    public function summary($id_user)
    {
        $ret = $this->db->select('count(id_type) as quantity, id_type as type_trash')
            ->from($this->table)
            ->join('Trashes', $this->table.'.id_trashe = Trashes.id')
            ->where('id_user', $id_user)
            ->group_by('id_type')
            ->get()
            ->result();
        return $ret;
    }

    public function limited_history($id_user, $limit = false)
    {
        $this->db->select('*')
            ->from($this->table)
            ->join('Trashes', $this->table.'.id_trashe = Trashes.id')
            ->where('id_user', $id_user);
        if($limit !== FALSE)
        {
            $this->db->limit($limit);
        }
        return $this->db->get()
            ->result();
    }
}
