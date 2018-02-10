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
	/*
     * Definition
     * ==========
     * Args :
     * - BingBinToken
     * /////////////////////////////
     * Way of work
     * ===========
     * return token's info if valid, false else
     */
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

	/*
     * Definition
     * ==========
     * Args :
     * - bingbin_id
     * /////////////////////////////
     * Way of work
     * ===========
     * invalid all token for the user
     */
	protected function invalidOldTokens($bingbin_id)
	{
		// check if no other token is running
		$this->_bingbintokens->invalidToken($bingbin_id);
	}

	/*
     * Definition
     * ==========
     * Args :
     * - bingbin_id
     * /////////////////////////////
     * Way of work
     * ===========
     * create a token and return it for a user, or false if errors
     */
	protected function updateToken($bingbin_id)
	{
		$token = generateToken();

		/* SAVE TOKEN ACCESS IN BASE */
			$res = $this->_bingbintokens->save(array(
				"token" => $token,
				"id_user" => $bingbin_id
			));

		if($res){
			return $token;
		}else{
			return false;
		}
	}
}
