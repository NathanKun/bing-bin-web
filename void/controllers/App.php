<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Controller {


	public function index()
	{

    }

    public function getEcoPoint($userToken)
    {
        $token_info = $this->_bingbintokens->isTokenValid($userToken);

        if(!$token_info){
            echo json_encode(array(
                "error" => "The token is not valid"
            ));
            exit;
        }

        //update token information

        // function process
        /*
        $this->load->library('form_validation');

        $this->form_validation->set_rules('login','Login','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('field','field','required');

        $validate = $this->form_validation->run();

        if($validate === TRUE)
        {
            echo json_encode(array(
                'validate' => TRUE,
                'field_value' => $this->input->post('field')
            ));
        }
        else{
            echo json_encode(array(
                'validate' => FALSE,
            ));
        }*/
        echo json_encode(array(
            "validate" => "Token is valid",
            'info' => "We are now able to have interfaces"
        ));
    }

    /*
     * Definition
     * ==========
     * Args (POST) : pseudo|password
     * /////////////////////////////
     * Way of work
     * ===========
     * check if psuedo match with password and send BingBinToken
     * else send an error
     */
    public function loginAuthorize()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pseudo','Pseudo','required');
        $this->form_validation->set_rules('password','Password','required');

        $run = $this->form_validation->run();

        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => array(
                    "pseudo" => form_error('pseudo'),
                    'password' => form_error('password')
                )
            ));
            exit;
        }

        $match = $this->_users->logMatchPwd(
            $this->input->post('pseudo'),
            $this->input->post('password')
        );

        if(!$match){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'Pseudo and Password didn\'t match'
            ));
            exit;
        }

        $token = generateToken();

        try{
            /* SAVE TOKEN ACCESS IN BASE */
            $this->_bingbintokens->save(array(
                "token" => $token,
                "id_user" => $match->id
            ));
        }catch(Exception $e)
        {
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'And Error append during token generation'
            ));
            exit;
        }


        echo json_encode(array(
            "valid" => TRUE,
            "data" => $match,
            "token" => $token
        ));
    }

    /*
     * Definition
     * ==========
     * Args (POST) : pseudo|password|name|firstname|email
     * /////////////////////////////
     * Way of work
     * ===========
     * create a new account if :
     * - email isn't take
     * - login isn't take
     */
    public function registerValidation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pseudo','Pseudo','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('email','E-Mail','required|valid_email');
        $this->form_validation->set_rules('firstname','FirstName','required');
        $this->form_validation->set_rules('name','Name','required');

        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => validation_errors()
            ));
            exit;
        }

        // Test there's not infos already take
        if($this->_users->existingPseudo($this->input->post('pseudo')) ){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'Pseudo is already take'
            ));
            exit;
        }
        if($this->_users->existingEmail($this->input->post('email')) ){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'An account with this email is already existing'
            ));
            exit;
        }

        //create account
        $account_id = $this->_users->add(array(
            "name" => $this->input->post("name"),
            "firstname" => $this->input->post("firstname"),
            "mail" => $this->input->post("email"),
            "pseudo" => $this->input->post('pseudo'),
            'password' => $this->input->post('password')
        ));

        //return a token
        $token = generateToken();
        try{
            /* SAVE TOKEN ACCESS IN BASE */
            $this->_bingbintokens->save(array(
                "token" => $token,
                "id_user" => $account_id
            ));
        }catch(Exception $e)
        {
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'And Error append during token generation'
            ));
            exit;
        }

        echo json_encode(array(
            "valid" => TRUE,
            "token" => $token
        ));
    }

    /*
     * Definition
     * ==========
     * Args (POST) : BingBinToken
     * /////////////////////////////
     * Way of work
     * ===========
     * return all information for a person
     */
    public function getMyInfo()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('BingBinToken','BingBinToken','required');

        // check data
        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Missing argument : BingBinToken"
            ));
            exit;
        }

        // check if token existing
        $token_info = $this->_bingbintokens->isTokenValid($this->input->post('BingBinToken'));
        if(!$token_info){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "The Token is not valid"
            ));
            exit;
        }

        //return information
        $person_info = $this->_users->get($token_info->id_user);

        echo json_encode(array(
            "valid" => TRUE,
            "data" => $person_info[0]
        ));
    }

    public function getRank()
    {
        $this->load->library('form_validation');

        // check argument
        $this->form_validation->set_rules('BingBinToken', 'BingBinToken', 'required');
        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Argument Missing"
            ));
            exit;
        }

        // get person
        $token_info = $this->_bingbintokens->isTokenValid($vaa);
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
            if($v->id == $person->id){
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
        echo json_encode(array(
            'valid' => TRUE,
            'rank' => $compteur
        ));
    }
}
