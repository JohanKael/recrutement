<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

	public function index()
	{
		$this->load->view('login');
	}

    public function login(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $conditions = [
            '' => $email,
            '' => $password 
        ];
        $checkLogin = $this->dao->select_where("", $conditions);
        if($checkLogin != null){
            $this->session->set_userdata("user_info", $checkLogin[0]);
            redirect("home_controller");
        }else{
            redirect('login_controller');
        }
    }
}
