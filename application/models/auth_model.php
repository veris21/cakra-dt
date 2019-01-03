<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function check_user($username, $password)
    {
       $this->db->where('username', $username);
       $this->db->where('password', $password);
       return $this->db->get('user');
    }

}

/* End of file Auth_model.php */
