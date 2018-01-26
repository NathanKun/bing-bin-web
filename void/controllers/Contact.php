<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller {


	public function index()
	{
        // *********************************
        // Process get information from JSON
        // *********************************
        $tmp = json_decode(file_get_contents(_PAR.'app/contact.json'),true);
        $var = array();
        $var['coord_pres'] = $tmp['president'];
        $var['coord_admin'] = $tmp['admin'];

		$this->loadView('contact/index', $var);
	}
}
