<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Controller {

    /*
     * Definition
     * ==========
     * Args (POST) : pseudo|password
     * /////////////////////////////
     * Way of work
     * ===========
     * check if psuedo match with password and send BingBinToken
     * else send an error
     */
    public function loginAuthorize()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Mail','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');

        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'Argument missing'
            ));
            exit;
        }

        // $match : contain all information about the user
        $match = $this->_users->mailMatchPwd(
            $this->input->post('email'),
            sha1($this->input->post('password'))
        );
        unset($match->password);

        if(!$match){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'Mail and Password didn\'t match'
            ));
            exit;
        }

        $this->invalidOldTokens($match->id);

        echo json_encode(array(
            "valid" => TRUE,
            "data" => $match,
            "token" => $this->updateToken($match->id)
        ));
    }

    /*
     * Definition
     * ==========
     * Args (POST) : pseudo|password|name|firstname|email
     * /////////////////////////////
     * Way of work
     * ===========
     * create a new account if :
     * - email isn't take
     * - login isn't take
     */
    public function registerValidation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pseudo','Pseudo','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('email','E-Mail','trim|required|valid_email');
        $this->form_validation->set_rules('firstname','FirstName','trim|required');
        $this->form_validation->set_rules('name','Name','trim|required');

        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => validation_errors()
            ));
            exit;
        }

        // Test there's not infos already take
        if($this->_users->existingPseudo($this->input->post('pseudo')) ){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'Pseudo is already take'
            ));
            exit;
        }
        if($this->_users->existingEmail($this->input->post('email')) ){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => 'An account with this email is already existing'
            ));
            exit;
        }

        //create account
        $account_id = $this->_users->add(array(
            "name" => $this->input->post("name"),
            "firstname" => $this->input->post("firstname"),
            "mail" => $this->input->post("email"),
            "pseudo" => $this->input->post('pseudo'),
            'password' => sha1($this->input->post('password'))
        ));

        echo json_encode(array(
            "valid" => TRUE,
            "token" => $this->updateToken($account_id)
        ));
    }

    /*
     * Definition
     * ==========
     * Args (POST) : BingBinToken
     * /////////////////////////////
     * Way of work
     * ===========
     * return all information for a person
     */
    public function getMyInfo()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('BingBinToken','BingBinToken','trim|required');

        // check data
        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Missing argument : BingBinToken"
            ));
            exit;
        }

        // check if token existing
        $token_info = $this->checkToken($this->input->post('BingBinToken'));
        if(!$token_info){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "The Token is not valid"
            ));
            exit;
        }

        //return information
        echo json_encode($this->infoFor($token_info->id_user));
    }

    /*
     * Definition
     * ==========
     * Args (POST) :
     * - BingBinToken
     * - trashName
     * - trashCategory
     * FILE : trashPicture
     * /////////////////////////////
     * Way of work
     * ===========
     * return all information for a person
     */
    public function uploadScan()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('BingBinToken','BingBinToken','trim|required');
        $this->form_validation->set_rules('trashName','TrashName','trim|required');
        $this->form_validation->set_rules('trashCategory','trashCategory','trim|required');

        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Argument Missing"
            ));
            exit;
        }

        $token_info = $this->checkToken($this->input->post('BingBinToken'));
        if(!$token_info){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Invalid token"
            ));
            exit;
        }

        $type_info = $this->_trashescategories->get($this->input->post('trashCategory'));
        if($type_info == NULL){
            echo json_encode(array(
                'valid' => FALSE,
                'error' => 'Type of trash isn\'t valid'
            ));
            exit;
        }
        $type_info = $type_info[0];
        $img_name = $this->savePhoto('img');

        $id_trash = $this->_trashes->save(array(
            'trashName' => $this->input->post('trashName'),
            'id_type' => $this->input->post('trashCategory'),
            'img_url' => $img_name
        ));
        if(!$id_trash){
            echo json_encode(array(
                'valid' => FALSE,
                'error' => 'Error during saving the trash'
            ));
            exit;
        }
        $id_historique = $this->_historiques->save(array(
            'id_trash' => $id_trash,
            'id_user' => $token_info->id_user
        ));
        if(!$id_historique){
            echo json_encode(array(
                'valid' => FALSE,
                'error' => 'Error during saving the trash'
            ));
            exit;
        }
        // process for eco_point
        if(!$this->addEcoPoint($token_info->id_user, $type_info->id)){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "An error happend during saving eco_point"
            ));
            exit;
        }
        
        $return = $this->infoFor($token_info->id_user);
        $return['gain_eco_point'] = $type_info->eco_point;

        echo json_encode($return);
    }

    /*
     * Definition
     * ==========
     * Args (POST) :
     * - BingBinToken
     * /////////////////////////////
     * Way of work
     * ===========
     * return info for trashesCategories
     */
    public function getTrashesCategories()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('BingBinToken','BingBinToken','trim|required');

        $run = $this->form_validation->run();
        if(!$run){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Argument Missing"
            ));
            exit;
        }

        $token_info = $this->checkToken($this->input->post('BingBinToken'));
        if(!$token_info){
            echo json_encode(array(
                "valid" => FALSE,
                "error" => "Invalid token"
            ));
            exit;
        }

        echo json_encode($this->_trashescategories->getAll());
    }

    private function infoFor($bingbin_id)
    {
        $person_info = $this->_users->get($bingbin_id)[0];

                return array(
                    "valid" => TRUE,
                    "data" => array(
                        "name" => $person_info->name,
                        "firstname" => $person_info->firstname,
                        "email" => $person_info->email,
                        "img_url" => $person_info->img_url,
                        "date_nais" => $person_info->date_nais,
                        "fb_id" => $person_info->fb_id,
                        "pseudo" => $person_info->pseudo,
                        "eco_point" => $person_info->eco_point
                ));
    }

    private function savePhoto($picture_name)
    {
        if ($_FILES[$picture_name]['error'] > 0){
            echo json_encode(array(
                'valid' => FALSE,
                'error' => 'Error during the transfert of the picture'
            ));
            exit;
        }
        $extension = substr(mime_content_type($_FILES[$picture_name]['tmp_name']), strpos(mime_content_type($_FILES[$picture_name]['tmp_name']), '/')+1);
        if(strtolower($extension) != "jpeg" && strtolower($extension) != 'png'){
            echo json_encode(array(
                'valid' => FALSE,
                'error' => 'The file isn\'t a picture'
            ));
            exit;
        }

        $name = md5(uniqid(rand(), true));
        $name .= '.'.$extension;

        $resultat = move_uploaded_file($_FILES[$picture_name]['tmp_name'],'assets/img/scanResult/'.$name);
        if (!$resultat){
            echo json_encode(array(
                'valid' => TRUE,
                'url' => 'Error during saving the photo'
            ));
            exit;
        }
        return $name;
    }

    private function addEcoPoint($bingbin_id, $type_id)
    {
        //var_dump($bingbin_id);
        $person = $this->_users->get($bingbin_id)[0];
        $type = $this->_trashescategories->get($type_id)[0];
        //var_dump($person);
        //var_dump($type);
        return $this->_users->setEcoPoint($person->id, $person->eco_point + $type->eco_point);
    }
}
