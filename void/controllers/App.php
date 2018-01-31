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
        $this->form_validation->set_rules('pseudo','pseudo','required');
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

        echo json_encode(array(
            "valid" => TRUE,
            "data" => $match
        ));
    }


}
