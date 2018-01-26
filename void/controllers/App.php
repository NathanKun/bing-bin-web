<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Controller {


	public function index()
	{

    }

    public function getEcoPoint()
    {
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
        }
    }
}
