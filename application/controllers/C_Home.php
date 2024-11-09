<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

/* FONCTION DE REDIRECTION VERS LA PAGE D'ACCEUIL */
	public function index() {
        $data['pageTitle'] = "Gestion Home";    //titre de la page de destination
        $data['pageToLoad'] = "home/Welcome";   //path de la page destination
        
		$this->load->view('home/Home', $data);  //page principale
	}

    public function clearCheckValidation() {
        $this->session->unset_userdata('checkValidation');
        echo json_encode(['status' => 'success']);
    }
    
}
