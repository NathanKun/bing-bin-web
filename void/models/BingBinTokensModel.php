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

    public function setExpireToken($token_id){
        $this->db->set('expire_date', time());
        $this->db->where('id', $token_id);
        $this->db->update($this->table);
    }

    public function invalidToken($bingbin_id)
    {
        $this->db->set('expire_date', time());
        $this->db->where('id_user', $bingbin_id);
        $this->db->where('expire_date >', time());
        $this->db->update($this->table);
    }

    public function isTokenValid($token){
        $rep = $this->db->select('*')
            ->from($this->table)
            ->where('token_value', $token)
            ->get()
            ->result();
        if(isset($rep[0])){
            return $rep[0];
        }else{
            return FALSE;
        }
    }

    public function getTokensFor($bingbin_id){
        $rep = $this->db->select('*')
            ->from($this->table)
            ->where('id_user', $bingbin_id)
            ->get()
            ->result();
        if(isset($rep)){
            return $rep;
        }else{
            return FALSE;
        }
    }
}
