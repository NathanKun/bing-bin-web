<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $var = array(
		'css' => array(),
		'js' => array(),
		'output' => array(),
		'header' => '',
		'layout' => ''
	);


	/*
	 * header : contenu html du header
	 * output : contenu html des vues
	 */

	public function __contruct()
	{
		parent::__construct();
	}

	protected function addCss($file, $newFolder = null)
	{
		$folder = ($newFolder == null) ? 'css' : $newFolder;
		$this->var['css'][] = $folder.'/'.$file;
	}

	protected function addJs($file, $newFolder = null)
	{
		$folder = ($newFolder == null) ? 'js' : $newFolder;
		$this->var['js'][] = $folder.'/'.$file;
	}

	protected function setView($view)
	{
		$this->var['output'][] = $this->load->view($view, $this->var, true);
	}

	protected function layout($layout = 'main', $header = 'header', $headerText = "header-fr")
	{
		$this->var['headerText'] = json_decode(file_get_contents('void/parameters/'.$headerText.'.json'), true);
		$this->var['header'] = $this->load->view('components/'.$header, $this->var, true);

		$this->load->view('components/layout/'.$layout, $this->var);
	}

	protected function WIP()
	{
		$this->setView('wip');
		$this->layout();
	}

	protected function member()
	{
		if($this->session->userdata('member') == null)
		{
			redirect('welcome','refresh');
		}
	}

	protected function admin()
	{
		if($this->session->userdata('member') != null && !$this->session->userdata('member')->admin)
		{
			redirect('welcome','refresh');
		}
	}
}
