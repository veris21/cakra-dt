<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyek extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
    public function index()
    {
        $data['data']   = $this->proyek_model->list_proyek()->result();
		$data['main_content'] = 'proyek';
		$this->load->view('temp', $data);
    }

    public function input_proyek()
    {
        $nama_pos = $this->input->post('nama_pos');
        $keterangan = $this->input->post('keterangan');
        $tanggalMulai = $this->input->post('tanggalMulai');
        $tanggalBerakhir = $this->input->post('tanggalBerakhir');
        
        $data = array('nama_pos'=>$nama_pos, 'keterangan'=>$keterangan, 'tanggalMulai'=>$tanggalMulai, 'tanggalBerakhir'=>$tanggalBerakhir,'status'=>0);
        $posting = $this->proyek_model->insert_proyek($data);
        if ($posting) {
            echo json_encode(array('status'=>TRUE));
        }
    }

    public function details_proyek($id)
    {
        $data['data']   = $this->proyek_model->get_proyek($id)->row_array();
        $data['dt']     = $this->dt_model->get_dt_on_proyek($id)->result();
		$data['main_content'] = 'proyek_details';
		$this->load->view('temp', $data);
    }

}

/* End of file proyek.php */
