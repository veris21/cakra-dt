<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class proyek_model extends CI_Model {

    function list_proyek()
    {
        return $this->db->get('pos_proyek');
    }
    
    function get_proyek($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('pos_proyek');
    }

    function pos_proyek_aktif(){
        $this->db->where('status', 0);
        return $this->db->get('pos_proyek');
    }

    public function insert_proyek($data)
    {
        return $this->db->insert('pos_proyek', $data);
    }

}

/* End of file Solar_model.php */
