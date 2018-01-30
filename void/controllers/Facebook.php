<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends MY_Controller {


	public function index()
	{

    }

    private function verifyToken($userToken)
    {
        // URL for request
        $url = "https://graph.facebook.com/debug_token?input_token=@@&access_token=131305744244577|UtAbiRWQsZZ199KRvZxrdiJMDnU";
        $url = str_replace("@@", $userToken, $url);


        // decode response from Facebook Graph API
        $response = file_get_contents($url);
        $response = json_decode($response);

        // return function of the validity of response
        if($response->data->is_valid){
            return array(
                "valid" => TRUE,
                "fb_id" => $response->data->user_id
            );
        }else{
            return array(
                "valid" => FALSE
            );
        }
    }

    public function authorizeLogin($userToken)
    {
        $graph = $this->verifyToken($userToken);
        // if not valide
        if(!$graph['valid']){
            echo json_encode(array(
                "error" => "User Token is not valid"
            ));
            exit;
        }
        /**
         * Verify the id
         */
        $bingbin_id = $this->_users->isRegister_FB($graph['fb_id']);
        if(!$bingbin_id)
        {
            $this->_users->add(array(
                'facebook_id' => $graph['fb_id']
            ));
        }

        /**
         * if valid, generate a BingBinToken and send it to communicate
         */
        $token = $this->tokens->generateToken();

        /* SAVE TOKEN ACCESS IN BASE */
        $this->_bingbintokens->save(array(
            "token" => $token,
            "id_user" => $bingbin_id
        ));

        /* RETURN TOKEN TO TERMINAL */
        echo json_encode(array(
            "token" => $token
        ));
    }
}
