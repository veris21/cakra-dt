<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_model extends CI_Model {

    public function gaji_list()
    {
        return $this->db->get('gaji');
    }

    public function gaji_mobil_bulan($mobil, $bulan)
    {
        $query = 'SELECT * FROM gaji WHERE mobil = '.$mobil.' AND bulan="'.$bulan.'"';
        return $this->db->query($query);
    }

    public function gaji_bulan($bulan)
    {
        $query = 'SELECT * FROM gaji WHERE bulan="'.$bulan.'"';
        return $this->db->query($query);
    }

    public function init_gaji($post)
    {
        $this->db->insert('gaji', $post);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function get_gaji($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('gaji');
    }

    public function update_gaji($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('gaji', $data);
    }

    public function ref_pokok($type_dt)
    {
        $this->db->where('type_dt', $type_dt);
        return $this->db->get('ref_gaji');
    }

}

/* End of file Payroll_model.php */
