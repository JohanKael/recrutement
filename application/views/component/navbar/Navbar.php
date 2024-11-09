<?php 
$user_info = $this->session->userdata('user_info'); 
if (strpos($user_info['email_user'], '.work') === false) {
    $this->load->view('component/navbar/Navbar_Fournisseur');
} else {
    $this->load->view('component/navbar/Navbar_Entreprise');
}
?>