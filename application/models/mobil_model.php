<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mobil_model extends CI_Model {

    public function list_mobil()
    {
        $this->db->order_by('id','desc');
        return $this->db->get('mobil');
    }

    public function posting_mobil($data)
    {
       return $this->db->insert('mobil', $data);
    }

    public function update_mobil($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('mobil', $data);
    }

    public function get_mobil($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('mobil');
    }

    public function get_mobil_on_sopir()
    {
        $query = "SELECT m.id as id, m.type as type, m.plat as plat, s.nama_sopir as nama_sopir, m.dt_type as dt_type, m.dt as dt FROM mobil as m, sopir as s WHERE m.sopir = s.id AND s.status != 0 AND m.status != 2";
        return $this->db->query($query);
    }
    public function get_mobil_and_sopir($id)
    {
        $query = "SELECT m.id as id, m.type as type, m.plat as plat, s.id as id_sopir, s.nama_sopir as nama_sopir, m.dt_type as dt_type, m.dt as dt FROM mobil as m, sopir as s WHERE m.sopir = s.id AND s.status != 0 AND m.id = $id";
        return $this->db->query($query);
    }

}

/* End of file Mobil_model.php */
