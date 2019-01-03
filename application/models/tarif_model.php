<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tarif_model extends CI_Model {

    public function posting_tarif_baru($data)
    {
        return $this->db->insert('tarif', $data);
    }    
    public function list_tarif()
    {
        $this->db->order_by('id','desc');
        return $this->db->get('tarif');
    }

    public function get_tarif_one($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('tarif');
    }

    public function tarif_pokok()
    {
        $this->db->select('g.id id, g.gaji_pokok pokok, t.type type, t.jamAwal jamAwal, t.jamAkhir jamAkhir, g.status status');
        $this->db->from('ref_gaji g, type_dt t');
        $this->db->where('g.type_dt = t.id');
        return $this->db->get();
    }

    function get_ref_tarif($type, $km)
    {
        $query = "SELECT * FROM tarif WHERE $km BETWEEN minJarak AND maxJarak AND hotmix=$type";
        return $this->db->query($query);

        // $this->db->where('hotmix', $type);
        // $this->db->where('minJarak', '>='.$km);
        // $this->db->where('maxJarak', '<='.$km);
        // return $this->db->get('tarif');
    }

}

/* End of file Tarif_model.php */
