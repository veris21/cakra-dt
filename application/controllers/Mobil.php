<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobil extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
    
    public function index()
    {
        $data['sopir'] = $this->sopir_model->list_sopir()->result();
        $data['data'] = $this->mobil_model->list_mobil()->result();
		$data['main_content'] = 'mobil';
		$this->load->view('temp', $data);
    }
    public function mobil_input()
    {
        $dt = $this->input->post('dt');
        $type_dt = $this->input->post('type_dt');
        $plat = $this->input->post('plat');
        $type = $this->input->post('type');
        $status_mobil = $this->input->post('status_mobil');
        $data = array(
            'dt'=>$dt,
            'plat'=>$plat,
            'type'=>$type,
            'type_dt'=>$type_dt,
            'status'=>$status_mobil
            );
        $posting = $this->mobil_model->posting_mobil($data);
        if($posting){
            $status =  TRUE;
            $message =  "Success Tambah Data";
          }else {
            $status =  FALSE;
            $message =  "Gagal Tambah Data";
          }
        echo json_encode(array('status'=>$status,'message'=>$message));
    }

    public function insert_sopir()
    {
        $sopir = $this->input->post('sopir');
        $id = $this->input->post('id_mobil');
        $data = array('sopir'=> $sopir);
        $posting = $this->mobil_model->update_mobil($id, $data);
        if($posting){
            $status =  TRUE;
            $message =  "Success Tambah Data";
          }else {
            $status =  FALSE;
            $message =  "Gagal Tambah Data";
          }
        echo json_encode(array('status'=>$status,'message'=>$message));

    }

    public function mobil_get($id,$b)
    {
        $g = null;
        $x = explode('-', $b);
        $bulan = $x[0].'-'.$x[1];
        $gaji = $this->payroll_model->gaji_mobil_bulan($id, $bulan);
        if($gaji->num_rows()>0){
            $g = $gaji->row_array();
        }
        $data = $this->mobil_model->get_mobil($id)->row_array();
        if($data){
            echo json_encode(array('data'=>$data,'gaji'=>$g));
        }
    }

    public function mobil_one($id)
    {
        $data = $this->mobil_model->get_mobil($id)->row_array();
        if($data){
            echo json_encode($data);
        }
    }

}

/* End of file Mobil.php */
