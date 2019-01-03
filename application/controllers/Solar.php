<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solar extends CI_Controller {
  public function __construct()
  {
      parent::__construct();
      cek_login();
  }
  public function index()
    {
      $data['solar']        = $this->solar_model->list_solar()->result();
      $data['kfsolar']      = $this->solar_model->list_kfsolar()->result();
      $data['main_content'] = 'solar';
		$this->load->view('temp', $data);
    }

}

/* End of file Solar.php */
