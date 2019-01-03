<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
	
	public function index()
	{
		$data['main_content'] = 'main';
		$this->load->view('temp', $data);
	}
}
