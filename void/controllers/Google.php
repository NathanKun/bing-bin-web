<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google extends MY_Controller {


	public function index()
	{

    }

    /*
     * $userToken : a google user token for the app
     */
    private function verifyToken($userToken)
    {
        // URL for request
        $url = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=@@";
        $url = str_replace("@@", $userToken, $url);

        // decode response from Google
        try{
            $response = file_get_contents($url);
            $response = json_decode($response);
        }catch(Exception $e){
            return array(
                "valid" => FALSE,
                "error" => "A problem has happening with the Google serveur : the token may be invalid"
            );
        }

        // return function of the validity of response
        if($response->email_verified){
            return array(
                "valid" => TRUE,
                "data" => $response
            );
        }else{
            return array(
                "valid" => FALSE
            );
        }
    }

    /*
     * $userToken : a google user token for the app
     */
    public function authorizeLogin($userToken)
    {
        $graph = $this->verifyToken($userToken);
        // if not valide
        if(!$graph['valid']){
            echo json_encode(array(
                "error" => "User Token is not valid or a problem has happening with the cummincation with Google server"
            ));
            exit;
        }
        /**
         * Verify the id
         */
        $bingbin_id = $this->_users->existingEmail($graph['data']->email);

        if(!$bingbin_id)
        {
            $bingbin_id = $this->_users->add(array(
                'google_id' => 1,
                'mail' => $graph['data']->email,
                'firstname' => $graph['data']->given_name,
                'name' => $graph['data']->family_name,
                'img_url' => $graph['data']->picture
            ));
            $bingbin_id = $this->_users->get($bingbin_id)[0];
        }

        $this->invalidOldTokens($bingbin_id->id);

        /* RETURN TOKEN TO TERMINAL */
        echo json_encode(array(
            "token" => $this->updateToken($bingbin_id->id)
        ));
    }
}
