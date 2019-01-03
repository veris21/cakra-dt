<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
    }
    

    public function index()
    {
		$this->load->view('login');
    }

    public function login()
    {
        $username = strip_tags($this->input->post('username'));
        $password = strip_tags($this->input->post('password'));

        $user = $this->auth_model->check_user($username, $password)->row_array();
        if($user){
            $data = array( 
                'status' => TRUE,
                'status_login'=>'oke',
                'id'          => $user['id'],
                'fullname'   =>$user['nama_lengkap'],
                'role'     => $user['role'],
                'hp'          => $user['hp'],
                'alamat' => $user['alamat']
              );
              $this->session->set_flashdata(array('status'=>'aktif'));
              $this->session->set_userdata($data);
              echo json_encode($data);
              exit;
        }
    }

    public function logout()
    {
          $this->session->sess_destroy();
          redirect(base_url('auth'));
          exit;
    }


    

}

/* End of file Auth.php */