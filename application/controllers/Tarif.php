<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif extends CI_Controller {
  public function __construct()
  {
      parent::__construct();
      cek_login();
  }
  public function index()
    {
    $data['data'] = $this->tarif_model->list_tarif()->result();
    $data['pokok'] = $this->tarif_model->tarif_pokok()->result();
		$data['main_content'] = 'tarif';
		$this->load->view('temp', $data);
    }

    public function tarif_input()
    {
      $tarif = $this->input->post('tarif');
      $hotmix = $this->input->post('hotmix');
      $minJarak = $this->input->post('minJarak');
      $maxJarak = $this->input->post('maxJarak');
      $data = array('hotmix'=>$hotmix,
      'minJarak'=>$minJarak, 'maxJarak'=>$maxJarak, 'tarif'=>$tarif);
      $posting = $this->tarif_model->posting_tarif_baru($data);
      if($posting){
        $status =  TRUE;
        $message =  "Success Tambah Data";
      }else {
        $status =  FALSE;
        $message =  "Gagal Tambah Data";
      }
        echo json_encode(array('status'=>$status,'message'=>$message));
    }

    public function pokok_input()
    {
      $pokok = $this->input->post('pokok');
      $type_dt = $this->input->post('type_dt');  //Ref Type-DT ID
      $status = 1;
    }
    public function type_dt_input()
    {
      $type = $this->input->post('type');
      $jamAwal = $this->input->post('jamAwal');
      $jamAkhir = $this->input->post('jamAkhir');
      $status = 1;
    }

     public function get_tarif(){
      $km = $this->input->post('km');
      $type = $this->input->post('isHotmix');
      // $data = array('type'=>$type,'km'=>$km);
      $data = $this->tarif_model->get_ref_tarif($type,$km)->row_array();
      if($data)
      {
        echo json_encode($data);
      }
    }


}

/* End of file Tarif.php */
