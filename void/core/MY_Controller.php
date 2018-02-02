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

	protected function checkToken($token)
	{
		$token_info = $this->_bingbintokens->isTokenValid($token);

		if(!$token_info){
			return FALSE;
		}

		$current_time = time();
		if($current_time >= $token_info->expire_date){
			return FALSE;
		}

		return $token_info;
	}

	protected function updateToken($bingbin_id)
	{
		// check if no other token is running
		$tokens = $this->_bingbintokens->getTokensFor($bingbin_id);
		$tokensRunning = array();
		$currentTime = time();

		foreach($tokens as $t){
			if($t->expire_date > $currentTime){
				$this->_bingbintokens->setExpireToken($t->id);
			}
		}

		$token = generateToken();

		/* SAVE TOKEN ACCESS IN BASE */
		try{
			$this->_bingbintokens->save(array(
				"token" => $token,
				"id_user" => $bingbin_id
			));
			return $token;
		}catch(Exception $e){
			return FALSE;
		}
	}
}
