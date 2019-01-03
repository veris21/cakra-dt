<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sopir_model extends CI_Model {

    public function list_sopir()
    {
        $this->db->order_by('id','desc');
        return $this->db->get('sopir');
    }

    public function sopir_posting($data)
    {
        return $this->db->insert('sopir', $data);
    }

    public function get_sopir_one($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('sopir');
    }

}

/* End of file Sopir_model.php */
