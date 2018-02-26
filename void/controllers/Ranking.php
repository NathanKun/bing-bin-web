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

        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Argument Missing"
            ));
            exit;
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
        $ladder = $this->periodLadder($duration);
        $user_rank = 0;

        foreach($ladder as $l => $v){
            if($l == $token_info->id_user){
                $user_rank = $v['rank'];
            }
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
     * selected duration and return a table from an other function
     */
    private function periodLadder($duration)
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
        $result = array();

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

        return $this->computeLadder($result);
    }

    /*
     * This function will compute the rank function of user's eco_point and
     * return a table with user's information
     */
    private function computeLadder($ladders)
    {
        $result = array();
        $compteur = 0;
        $i = 0;
        $found = false;
        $prec_value = 0;
        foreach($ladders as $l => $v){
            $result[$l] = 0;
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
        }
        return $result;
    }
}
