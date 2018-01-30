<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {


	public function index() //home function
	{
		$this->var['content']['motivations'] = json_decode(file_get_contents('void/parameters/welcome-fr/motivation-section.json'), true);
		$this->var['content']['intro'] = json_decode(file_get_contents('void/parameters/welcome-fr/intro-section.json'), true);
		$this->var['content']['services'] = json_decode(file_get_contents('void/parameters/welcome-fr/services-section.json'), true);
		$this->var['content']['app'] = json_decode(file_get_contents('void/parameters/welcome-fr/app-section.json'), true);
		$this->var['content']['story'] = json_decode(file_get_contents('void/parameters/welcome-fr/story-section.json'), true);
		$this->var['content']['contact'] = json_decode(file_get_contents('void/parameters/welcome-fr/contact-section.json'), true);
		$this->var['content']['team'] = json_decode(file_get_contents('void/parameters/welcome-fr/team-section.json'), true);


		$this->setView('welcome/index');
		$this->layout('main','header-landpage');
	}

	public function testInterface()
	{
		$this->setView('welcome/testInterface');
		$this->layout('main','header-landpage');
	}

	public function register(){
		$rep = array();

		$this->load->library('form_validation');

		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('mail','Mail','required|valid_email');

		$valid = $this->form_validation->run();

		if($valid){
			$rep['valid'] = TRUE;

			/* SAVE IN BASE */
			$id = null;
			try{
				$id = $this->_authorizations->add(array(
					'name' => $this->input->post('name'),
					'mail' => $this->input->post('mail'),
				));
			}
			catch(Exception $e){
				$rep['errors'] = 'Error during insertion';
			}

			//$rep['infos'] = $id;

		}else{
			$rep['valid'] = FALSE;
			$rep['errors'] = validation_errors();
		}

		echo json_encode($rep);
	}

}
