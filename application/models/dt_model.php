<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dt_model extends CI_Model {

    public function list_dt()
    {
        $this->db->order_by('id','desc');
        return $this->db->get('dt');
        /* ---------- */
    }

    public function get_dt_on_dt($mobil)
    {
        $this->db->where('mobil',$mobil);
        return $this->db->get('dt');
    }

    public function export_dt($startDate, $endDate)
    {
        $query = 'SELECT 
        dt.id as id, 
        dt.tanggal as tanggal, 
        dt.no_tiket as no_tiket,
        dt.ltl as ltl, 
        dt.penerima as penerima,
        dt.pengirim as pengirim,
        dt.dari as dari,
        dt.tujuan as tujuan,
        dt.jam_kirim as jam_kirim,
        dt.jam_tiba as jam_tiba,
        dt.km as km,
        dt.rit as rit,
        dt.pokok as pokok,
        dt.membawa as membawa,
        dt.untuk as untuk,
        dt.pos_proyek as pos_proyek, 
        dt.status as status,
        dt.status_ritasi as status_ritasi,
        dt.tarif as tarif,
        dt.kfsolar as kfsolar,
        dt.solar_pakai as solar_pakai,
        dt.isi_solar as isi_solar,
        dt.jumlah_kirim as jumlah_kirim,
        dt.tambahan as tambahan,
        dt.satuan_jumlah as satuan_jumlah,
        m.plat as plat, 
        m.dt as dt_mobil, 
        s.nama_sopir as sopir
        FROM dt as dt, sopir as s, mobil as m 
        WHERE dt.mobil = m.id AND m.sopir = s.id AND dt.tanggal >= "'.$startDate.'" AND dt.tanggal <= "'.$endDate.'"';
        return $this->db->query($query);
    }

    public function get_dt($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('dt');
    }

    public function total_ritasi_bulan_ini($m,$y)
    {
        $query = 'SELECT * FROM dt WHERE tanggal LIKE "'.$y.'-'.$m.'-%"';
        return $this->db->query($query);
    }

    public function ritasi_bulan_on_dt($y, $mobil)
    {
        $query = 'SELECT * FROM dt WHERE mobil= '.$mobil.' AND tanggal LIKE "'.$y.'-%"';
        return $this->db->query($query);
    }

    public function record_dt($data)
    {
        return $this->db->insert('dt',$data);
    }


    public function get_dt_on_tgl_and_mobil($tanggal, $mobil){
        $query = 'SELECT * FROM dt WHERE mobil= '.$mobil.' AND tanggal = "'.$tanggal.'"';
        return $this->db->query($query);
    }

    public function get_dt_on_proyek($id){
        $this->db->where('pos_proyek', $id);
        return $this->db->get('dt');
    }

    public function rm_all_dt()
    {
        $this->db->truncate('pos_proyek');
        $this->db->truncate('solar');
        $this->db->truncate('gaji');
        $this->db->truncate('dt');
        $this->db->truncate('dt_history');
        $this->db->truncate('mobil_history');
        return $this->db->truncate('dt');
    }
}

/* End of file Dt_model.php */
