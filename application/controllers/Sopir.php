<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sopir extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
    public function index()
    {
        $data['data'] = $this->sopir_model->list_sopir()->result();
		$data['main_content'] = 'sopir';
		$this->load->view('temp', $data);
    }

    public function sopir_input()
    {
        $nama = $this->input->post('nama');
        $hp = $this->input->post('hp');
        // $dt = $this->input->post('dt');
        $data = array(
            'nama_sopir'=>$nama,
            'hp'=>$hp,
            'status'=>1,
            'foto'=>'no-img.jpg'
        );
        $posting = $this->sopir_model->sopir_posting($data);
        if($posting){
            $status =  TRUE;
            $message =  "Success Tambah Data";
          }else {
            $status =  FALSE;
            $message =  "Gagal Tambah Data";
          }
        echo json_encode(array('status'=>$status,'message'=>$message));
    }

}

/* End of file Sopir.php */
