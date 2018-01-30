<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends MY_Controller {


	public function index()
	{

    }

    public function verifyToken($userToken)
    {
        // URL for request
        $url = "https://graph.facebook.com/debug_token?input_token=@@&access_token=131305744244577|UtAbiRWQsZZ199KRvZxrdiJMDnU";
        $url = str_replace("@@", $userToken, $url);


        // decode response from Facebook Graph API
        $response = file_get_contents($url);
        $response = json_decode($response);

        // return function of the validity of response
        if($response->data->is_valid){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function authorizeLogin($userToken)
    {
        // if not valide
        if(!$this->verifyToken($userToken)){
            echo json_encode(array(
                "error" => "User Token is not valid"
            ));
            exit;
        }

        /**
         * if valid, generate a BingBinToken and send it to communicate
         */
        $time = microtime();
        $token = uniqid($time, true);
        $token = str_replace(" ","", $token);
        $token = str_replace(".","", $token);
        $token = substr($token, 2);

        /* SAVE TOKEN ACCESS IN BASE */

        /* RETURN TOKEN TO TERMINAL */
        echo json_encode(array(
            "token" => $token
        ));
    }
}
