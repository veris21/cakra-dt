<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Solar_model extends CI_Model {

    public function get_kfsolar($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('kfsolar');
    }

    public function list_solar()
    {
        return $this->db->get('solar');
    }

    public function list_kfsolar()
    {
        return $this->db->get('kfsolar');
    }

    public function record_solar($data)
    {
        return $this->db->insert('solar', $data);
    }
}

/* End of file Solar_model.php */
