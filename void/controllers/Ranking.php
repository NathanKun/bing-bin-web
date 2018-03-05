<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ranking extends MY_Controller {

    /*
     * Definition
     * ==========
     * Args (POST) : BingBinToken
     * /////////////////////////////
     * Way of work
     * ===========
     * return the rank of the person
     */
    /* NOT USED */
    public function getRank()
    {
        $this->load->library('form_validation');

        // check argument
        $this->form_validation->set_rules('BingBinToken', 'BingBinToken', 'trim|required');
        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Argument Missing"
            ));
            exit;
        }

        // get person
        $token_info = $this->checkToken($this->input->post('BingBinToken'));
        if(!$token_info){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Token is not valid"
            ));
            exit;
        }
        $person = $this->_users->get($token_info->id_user)[0];
        if(!$person){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "No user was found"
            ));
            exit;
        }

        $compteur = $this->computeRank($person->id);

        echo json_encode(array(
            'valid' => TRUE,
            'rank' => $compteur
        ));
    }

    /* NOT USED */
    private function computeRank($person_id)
    {
        // process for get rank
        $ranks = $this->_users->rank();
        $compteur = 0;
        $i = 0;
        $found = false;
        foreach($ranks as $v){
            if($compteur >=1 && $v->eco_point == $ranks[$compteur + $i -1]->eco_point){
                $i++;
            }else{
                $compteur++;
                $compteur += $i;
                $i = 0;
            }
            if($v->id == $person_id){
                $found = true;
                break;
            }
        }
        /*
        while($ranks[0]->id != $person->id){
            $compteur++;
        }*/
        // if noone was found, no rank
        if(!$found){
            $compteur = 0;
        }

        return $compteur;
    }

    /*
     * Definition
     * ==========
     * Args (POST) :
     * - BingBinToken
     * - duration : day|week|month|all
     * /////////////////////////////
     * Way of work
     * ===========
     * return the ladder
     */
    public function getLadder()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('BingBinToken','BingBinToken','trim|required');
        $this->form_validation->set_rules('Duration','Duration','trim|required|in_list[day,week,month,all]');
        $this->form_validation->set_rules('limit','Limite','is_natural_no_zero');

        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Argument Missing"
            ));
            exit;
        }

        $limit = false;
        if($this->input->post('limit') !== "")
        {
            $limit = $this->input->post('limit');
        }

        $token_info = $this->checkToken($this->input->post('BingBinToken'));
        if(!$token_info){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Invalid token"
            ));
            exit;
        }

        $duration = $this->input->post('Duration');
        $ladder = $this->periodLadder($duration, $limit);
        $user_rank = 0;

        foreach($ladder as $l => $v){
            if($l == $token_info->id_user){
                $user_rank = $v['rank'];
            }
            $v['has_receive_sun_point'] = $this->hasSendSunPointTo($token_info->id_user, $l);
        }

        echo json_encode(array(
            "valid" => TRUE,
            "user_rank" => $user_rank,
            'ladder' => $ladder
        ));
    }

    // duration = in_list[day,month,week,all]
    /*
     * This function will select and compute all the point win during the
     * selected duration and return short with all info of users
     * $id_user => array_user_info()
     */
    private function periodLadder($duration, $limit = false)
    {
        $date = new DateTime();
        $timestamp = 0;
        switch($duration){
            case 'day':
                $timestamp = strtotime($date->format('d-m-Y'));
            break;
            case 'week':
                $date->sub(new DateInterval('P7D'));
                $timestamp = strtotime($date->format('d-m-Y'));
            break;
            case 'month':
                $date->sub(new DateInterval('P30D'));
                $timestamp = strtotime($date->format('d-m-Y'));
            break;
        }

        $ladders = $this->_historiques->inDuration($timestamp);

        /*
         * $result : array with id_user in key, and amount of eco_point in value;
         */

        $result = array();

        //compute the sum of eco_point for each user in the specify duration
        foreach($ladders as $l)
        {
            if(!isset($result[$l->id_user])){
                $result[$l->id_user] = 0;
            }
            $trash = $this->_trashes->get($l->id_trashe)[0];
            $trash_info = $this->_trashescategories->get($trash->id_type)[0];
            $result[$l->id_user] += $trash_info->eco_point;
        }
        arsort($result);

        return $this->computeLadder($result, $limit);
    }

    /*
     * This function will compute the rank function of user's eco_point and
     * return a table with user's information
     * $ladders : $id_user => amount_eco_point (associative tab)
     */
    private function computeLadder($ladders, $limit = false)
    {
        $result = array();
        $compteur = 0; // rank of the user
        $i = 0; // tmp rank, use for people who have same quantity of eco_point
        $found = false;
        $prec_value = 0;
        foreach($ladders as $l => $v){
            $result[$l] = 0; // initialise value in tab
            
            // incremente the ladder value
            // if amount_eco_point is the same as the user before, same rank so inc a tmp value
            // else inc rank and reset the tmp value
            if($compteur >=1 && $v == $prec_value){
                $i++;
            }else{
                $compteur++;
                $compteur += $i;
                $i = 0;
            }
            $user = $this->_users->get($l)[0];


            $result[$l] = array(
                'rank' => $compteur,
                'eco_point' => $v,
				"id" => $user->id,
				"name" => $user->name,
				"firstname" => $user->firstname,
				"email" => $user->email,
				"img_url" => $user->img_url,
				"date_nais" => $user->date_nais,
				"fb_id" => $user->fb_id,
				"pseudo" => $user->pseudo,
				'sun_point' => $user->sun_point,
				'id_rabbit' => $user->id_usagi,
				'id_leaf' => $user->id_leaf
            );
            $prec_value = $v;

            if($limit !== FALSE && ($i + $compteur) >= $limit)
            {
                break;
            }
        }
        return $result;
    }
    
    private function hasSendSunPointTo($id_user, $id_target)
    {
        $date = new DateTime();
        $duration = $timestamp = strtotime($date->format('d-m-Y'));
        
        $sun_point_histo = $this->_sunhistoriques->inDuration($$id_user, $duration);
        foreach($sun_point_histo as $k=>$v)
        {
            if($v->id_receiver_user == $id_target){
                return true;
            }
        }
        return false;
    }
}
