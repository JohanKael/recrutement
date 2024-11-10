<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE email_user = " . $username . " AND password_user = " . $password;

        if ($query) {
            return $query;
        }

        return null;
    }
}