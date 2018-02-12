<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends MY_Controller {


	public function index()
	{

    }

    /*
     * $userToken : a facebook user token for the app
     */
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
    private function getFbInfo($token){
        $url = "https://graph.facebook.com/me?fields=id,first_name,last_name,email,picture&access_token=@@";
        $url = str_replace("@@", $token, $url);


        // decode response from Facebook Graph API
        $response = file_get_contents($url);
        $response = json_decode($response);

        // return function of the validity of response
        if($response->id){
            return $response;
        }else{
            return array(
                "valid" => FALSE
            );
        }
    }

    /*
     * $userToken : a facebook user token for the app
     */
    public function authorizeLogin($userToken)
    {
        $graph = $this->verifyToken($userToken);
        // if not valide
        if(!$graph['valid']){
            echo json_encode(array(
                'valid'=>FALSE,
                "error" => "User Token is not valid or a problem has happening with the cummincation with Facebook server"
            ));
            exit;
        }
        /**
         * Verify the id and create account if user isn't register
         */
        $fb_info = $this->getFbInfo($userToken);
        $bingbin_id = FALSE;
        try{
            $bingbin_id = $this->_users->existingEmail($fb_info->email);
        }catch(Exception $e){
            //nothing
        }

        if(!$bingbin_id)
        {
            $bingbin_id = $this->_users->add(array(
                'facebook_id' => 1,
                'name' => $fb_info->last_name,
                'firstname' => $fb_info->first_name,
                'mail' => $fb_info->email,
                'img_url' => $fb_info->picture->data->url
            ));
        }else{
            $bingbin_id = $bingbin_id->id;
        }

        $this->invalidOldTokens($bingbin_id);

        /* RETURN TOKEN TO TERMINAL */
        echo json_encode(array(
            "token" => $this->updateToken($bingbin_id)
        ));
    }
}
