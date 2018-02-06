<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class TrashesModel extends CI_Model
{

    protected $table = "Trashes";

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
        $this->db->set('name', $args['trashName']);
        $this->db->sert('img_url', $args['img_url']);

        if($this->db->insert($this->table)){
            return $id;
        }else{
            return FALSE;
        }
    }
}
