<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class TrashesCategoriesModel extends CI_Model
{

    protected $table = "TrashesTypes";

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
}
