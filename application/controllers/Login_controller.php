<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
        $this->load->model('Users_model');
    }

	public function index()
	{
		$this->load->view('login');
	}

    public function login() {
        $this->load->library('session');
        $username = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->Users_model->login($username, $password);

        if ($user) {
            $userId= $this->session->set_userdata('user_id', $user->id_users);
            // var_dump($userId);
            redirect('index.php/C_Home');
        } else {
            $this->session->set_flashdata('error', 'Nom d\'utilisateur ou mot de passe incorrect');
            redirect('index.php/login_controller');
        }

        // echo $username;
    }

    /*public function login(){
        echo "ato";
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        //echo $email . ' ' . $password;
        $conditions = [
            'email_user' => $email,
            'password_user' => $password 
        ];
        $checkLogin = $this->dao->select_where("users", $conditions);
        if($checkLogin != null){
            $this->session->set_userdata("user_info", $checkLogin[0]);
            redirect("C_Home");
        }else{
            redirect('login_controller');
        }
    }*/

    public function disconnect(){
        $this->session->sess_destroy();
        redirect('login_controller');
    }

}
