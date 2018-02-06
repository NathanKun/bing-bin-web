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

    public function rank()
    {
        $query = $this->db->select('*')
            ->from($this->table)
            ->order_by('eco_point','DESC')
            ->get()
            ->result();
        return $query;
    }

    public function logMatchPwd($pseudo, $password){
        $rep = $this->db->select('*')
            ->from($this->table)
            ->where('pseudo', $pseudo)
            ->where('password', $password)
            ->get()
            ->result();
        if(isset($rep[0])){
            return $rep[0];
        }else{
            return FALSE;
        }
    }

    public function existingPseudo($pseudo){
        $rep = $this->db->select('*')
            ->from($this->table)
            ->where('pseudo', $pseudo)
            ->get()
            ->result();
        if(isset($rep[0])){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function existingEmail($email){
        $rep = $this->db->select('*')
            ->from($this->table)
            ->where('email', $email)
            ->get()
            ->result();
        if(isset($rep[0])){
            return $rep[0];
        }else{
            return FALSE;
        }
    }

    public function add($args = array())
    {
        $id = uniqid(time(), true);
        $this->db->set('id', $id);

        if(isset($args['name'])){
            $this->db->set('name', $args['name']);
        }
        if(isset($args['mail'])){
            $this->db->set('email', $args['mail']);
        }
        if(isset($args['facebook_id'])){
            $this->db->set('fb_id', $args['facebook_id']);
        }
        if(isset($args['name'])){
            $this->db->set('name', $args['name']);
        }
        if(isset($args['firstname'])){
            $this->db->set('firstname', $args['firstname']);
        }
        if(isset($args['pseudo'])){
            $this->db->set('pseudo', $args['pseudo']);
        }
        if(isset($args['password'])){
            $this->db->set('password', $args['password']);
        }
        if(isset($args['img_url'])){
            $this->db->set('img_url', $args['img_url']);
        }

        $this->db->insert($this->table);

        return $id;
    }

    public function setEcoPoint($id, $value)
    {
        $this->db->set('eco_point', $value);
        $this->db->where('id',$id);

        $this->db->update($this->table);
    }

    /*
     * $user_id : a facebook user id for the app
     */
    public function isRegister_FB($user_id)
    {
        $rep = $this->db->select('*')
            ->from($this->table)
            ->where('fb_id', $user_id)
            ->get()
            ->result();
        if(isset($rep[0])){
            return $rep[0];
        }else{
            return false;
        }
    }

    public function isRegister_Google($user_id)
    {

    }
}
