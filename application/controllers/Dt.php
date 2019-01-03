<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH .'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class Dt extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->library('Excel');
    }
    

    public function index()
    {
        $data['mobil_sopir']    = $this->mobil_model->get_mobil_on_sopir()->result();
        $data['data'] = $this->dt_model->list_dt();
        $data['pos_proyek'] = $this->proyek_model->pos_proyek_aktif()->result();
		$data['main_content'] = 'dtrecord';
		$this->load->view('temp', $data);
    }

    public function details($id)
    {
        $data['dt'] = $this->dt_model->get_dt($id)->row_array();
        $data['mobil']  = $this->mobil_model->get_mobil($data['dt']['mobil'])->row_array();
        $data['sopir']  = $this->sopir_model->get_sopir_one($data['dt']['sopir'])->row_array();
        $data['main_content'] = 'dt_details';
		$this->load->view('temp', $data);   
    }
    
    public function record()
    {
        /*
        Note : 
        status { 0 = Rusak
                 1 = Aktif
                 2 = Standby
               }


        */
        
        $statusDT   = $this->input->post('status_standby_dt');
        if($statusDT=='on'){
            $mobil      = $this->input->post('mobil');
            $tanggal    = $this->input->post('tanggal');
            $no_tiket   = $this->input->post('no_tiket');
            $gaji_id = $this->input->post('gaji_id');

            $ex = explode('-', $tanggal);
            $bulan = $ex[0].'-'.$ex[1];

            $keteranganStandby = $this->input->post('isRusak');
            $statusRusak = $this->input->post('isStandby');
            $mobil_data = $this->mobil_model->get_mobil($mobil)->row_array();
            $type_dt = $mobil_data['dt_type'];
            $sopir = $mobil_data['sopir'];
            $g = $this->payroll_model->get_gaji($gaji_id)->row_array();
            
            $newBor = 0;


            $newPokok = 40000;



            $oldPokok = $g['pokok'];

            $oldBor =  $g['bor'];

            $bor = ($newBor+$oldBor);
            $pokok = ($newPokok+$oldPokok);

            if($statusRusak=='on'){
                $dt_insert = array(
                    'isLembur'=>'RUSAK',
                    'ltl'=>'L',
                    'no_tiket'=> $no_tiket,
                    'mobil'=>$mobil,
                    'sopir'=>$sopir,
                    'tanggal'=>$tanggal,
                    'untuk'=>$keteranganStandby,
                    'type_dt'=>$type_dt,
                    'pokok'=>$newPokok,
                    'status'=>0
                );
    
                $gaji_insert = array(
                    'pokok'=>$pokok, 
                    'bor' => $bor,
                );

                $dt = $this->dt_model->record_dt($dt_insert);
                if($dt){
                $this->payroll_model->update_gaji($g['id'], $gaji_insert);
                echo json_encode(array('status'=>TRUE));
                }

            }else{
                $dt_insert = array(
                    'ltl'=>'L',
                    'isLembur'=>'STANDBY',
                    'no_tiket'=> $no_tiket,
                    'mobil'=>$mobil,
                    'sopir'=>$sopir,
                    'tanggal'=>$tanggal,
                    'untuk'=>$keteranganStandby,
                    'type_dt'=>$type_dt,
                    'pokok'=>$newPokok,
                    'status'=>2
                );
    
                $gaji_insert = array(
                    'pokok'=>$pokok, 
                    'bor' => $bor,
                );
                $dt = $this->dt_model->record_dt($dt_insert);
                if($dt){
                $this->payroll_model->update_gaji($g['id'], $gaji_insert);
                echo json_encode(array('status'=>TRUE));
                }
            }
           
        }else{
            $type =1;
            /*/ ===========
            0 = Non Hotmix
            1 = Hotmix
            2 = Transport
            /*/
            $type_bawaan = $this->input->post('type_bawaan');
            switch ($type_bawaan) {
                case 0:
                $kfsolar = 3;
                    break;
                case 1:
                    $kfsolar = 2;
                        break;
                case 2:
                $kfsolar = 1;
                    break;
            }
            

            // ===========
            $mobil      = $this->input->post('mobil');
            $no_tiket   = $this->input->post('no_tiket');
            $tanggal    = $this->input->post('tanggal');
            $solar_pakai = $this->input->post('pakai_solar');
            $isi_solar = $this->input->post('isi_solar');
            $dari = $this->input->post('dari');
            $tujuan = $this->input->post('tujuan');
            $membawa = $this->input->post('membawa');
            $untuk = $this->input->post('untuk');
            $jam_berangkat = $this->input->post('berangkat');
            $jam_tiba = $this->input->post('sampai');
            $tambahan = $this->input->post('tambahan');
            $km = $this->input->post('km');
            $rit = $this->input->post('rit');

            $tarif = $this->input->post('tarif_id');
            $gaji_id = $this->input->post('gaji_id');
            $isLembur = $this->input->post('isLembur');

            $pengirim = $this->input->post('pengirim');
            $penerima = $this->input->post('penerima');

            $jumlah_kirim = $this->input->post('jumlah_kirim');
            $satuan_kirim = $this->input->post('satuan_kirim');
            $pos = $this->input->post('pos');
            $pp = $this->input->post('pp');

            $ex = explode('-', $tanggal);
            $bulan = $ex[0].'-'.$ex[1];

            $mobil_data = $this->mobil_model->get_mobil($mobil)->row_array();
            $type_dt = $mobil_data['dt_type'];
            $sopir = $mobil_data['sopir'];
            if($pp=='on'){
                $status_ritasi = 2 ;
            }else{
                $status_ritasi = 1 ;
            }
            $g = $this->payroll_model->get_gaji($gaji_id)->row_array();
            $b = $this->tarif_model->get_tarif_one($tarif)->row_array();
            $p = $this->payroll_model->ref_pokok($type_dt)->row_array();


           
                $oldTambahan = $g['tambahan'];
                $newBor = ($rit * $b['tarif']);

                $check_hari_ini = $this->dt_model->get_dt_on_tgl_and_mobil($tanggal, $mobil);
                if($check_hari_ini->num_rows() == 0){
                    $newPokok = $p['gaji_pokok'];
                }else{
                    $newPokok = 0;
                }

                $lembur = ($tambahan + $oldTambahan);


            $oldPokok = $g['pokok'];
            $oldBor =  $g['bor'];

            $bor = ($newBor+$oldBor);
            $pokok = ($newPokok + $oldPokok);

            $dt_insert = array(
                'isLembur'=>$isLembur,
                'no_tiket'=> $no_tiket,
                'ltl'=>'L',
                'mobil'=>$mobil,
                'sopir'=>$sopir,
                'jumlah_kirim'=>$jumlah_kirim,
                'satuan_jumlah'=>$satuan_kirim,
                'tanggal'=>$tanggal,
                'dari'=>$dari,
                'tujuan'=>$tujuan,
                'jam_kirim'=>$jam_berangkat,
                'jam_tiba'=>$jam_tiba,
                'membawa'=>$membawa,
                'untuk'=>$untuk,
                'rit'=>$rit,
                'km'=>$km,
                'kfsolar'=>$kfsolar,
                'pengirim'=>$pengirim,
                'penerima'=>$penerima,
                'pos_proyek'=>$pos,
                'tarif'=>$tarif,
                'pokok'=>$newPokok,
                'tambahan'=>$tambahan,
                'isi_solar'=>$isi_solar,
                'solar_pakai'=>$solar_pakai,
                'status_ritasi'=>$status_ritasi,
                'type_dt'=>$type_dt,
                'status'=>1
            );

        $gaji_insert = array(
            'pokok'=>$pokok, 
            'lembur'=>$lembur,
            'bor' => $bor,
        );
        
        $solar_insert = array(                
                'mobil'=>$mobil,
                'tanggal'=>$tanggal,
                'kmAwal'=>0,
                'kmAkhir'=>0,
                'kmDt'=> $km,
                'isi'=> $isi_solar,
                'pakai'=> $solar_pakai,
                'harga'=> 0,
                'kfsolar'=> $kfsolar,
                'kontrolKfSolar'=>0,
            );

        $dt = $this->dt_model->record_dt($dt_insert);
            if($dt){
                $this->payroll_model->update_gaji($g['id'], $gaji_insert);
                $this->solar_model->record_solar($solar_insert);
                echo json_encode(array(
                    'status'=>TRUE,
                ));
            }else{
                echo json_encode(array(
                    'status'=>FALSE
                ));
            }
           

        }

        
    }

    public function cek_lembur()
    {

        /*================================================

        Jam Hotmix 
        Jam Awal : <= 07:00 for 1,2,3 add tambahan Rp.20.000,-
        jam pra : <= 07:30 for 1,2,3 add tambahan Rp.10.000,-
        Jam Akhir : < 17:00 add tambahan Rp.20.000,-

        ===================================================*/
        $batas_jam_pagi = strtotime('07:00');
        $batas_pra_pagi = strtotime('07:30');
        $batas_jam_akhir = strtotime('17:00');
        $tambahan = 0;
        $status = 'NORMAL';

        $jamberangkat = $this->input->post('jamberangkat');
        $jamkerja = $this->input->post('jamkerja');
        $jamAkhir = $this->input->post('jamAkhir');
        $jamAwal = $this->input->post('jamAwal');
        $bulan = $this->input->post('bulan');
        $mobil_id = $this->input->post('mobil_id');
        $isHotmix = $this->input->post('isHotmix');

        $akhir = strtotime($jamAkhir);
        $awal = strtotime($jamAwal);
        
        $berangkat = strtotime($jamberangkat);
        $kerja = strtotime($jamkerja);

        $isAda = $this->dt_model->get_dt_on_tgl_and_mobil($bulan, intval($mobil_id));

        $count_sebelum = 0;
        $count_sesudah = 0;
        $count_pra = 0;
        
        if($isHotmix == 1){

                if($kerja > $batas_jam_pagi && $kerja < $batas_pra_pagi){
                    $diff = ($kerja - $batas_pra_pagi);
                    if($diff < 0){
                        $status = 'LEMBUR';
                        $jam = abs($diff/3600);
                    }else{
                        $jam = abs($diff/3600);   
                    }
                    foreach($isAda->result() as $result){
                    if(strtotime($result->jam_tiba) > $batas_jam_pagi && strtotime($result->jam_tiba) < $batas_pra_pagi){
                        $count_pra +=1;
                    }
                }
                if($count_pra >= 0 && $count_pra < 4){
                    $tambahan +=10000;
                }
            }

            if($kerja < $batas_jam_pagi){
                    $diff = ($kerja - $batas_jam_pagi);
                    if($diff < 0){
                        $status = 'LEMBUR';
                        $jam = abs($diff/3600);
                    }else{
                        $jam = abs($diff/3600);   
                    }
                    foreach($isAda->result() as $result){
                    if(strtotime($result->jam_tiba) < $batas_jam_pagi){
                        $count_sebelum +=1;
                    }
                }
                if($count_sebelum >= 0 && $count_sebelum < 4){
                    $tambahan +=20000;
                }
            }

            if($kerja > $batas_jam_akhir){
                $diff = ($kerja-$batas_jam_akhir);
                if($diff > 0){
                    $status = 'LEMBUR';
                    $jam = abs($diff/3600);
                }else{
                    $jam = abs($diff/3600);   
                }
                foreach($isAda->result() as $result){
                    if(strtotime($result->jam_tiba) > $batas_jam_akhir){
                        $count_sesudah +=1;
                    }
                }
                if($count_sesudah >= 0 && $count_sesudah < 4){
                    $tambahan +=20000;
                }
            }
            
            // if($isAda->num_rows() >= 0 && $isAda < 4){
            //     if($berangkat < $batas_jam_pagi ){
            //         $tambahan += 20000;
            //     }
            //     if($kerja > $batas_jam_akhir){
            //         $tambahan += 20000;
            //     }
            // }

        }
        

            

            echo json_encode(array(
            'status_lembur'=>$status, 
            'tambahan'=>$tambahan,
            'jam_berangkat'=>$jamberangkat,
            'jam_kerja'=>$jamkerja,
            'mobil_id'=>$mobil_id,
            'bulan'=>$bulan,
            'isHotmix'=>$isHotmix,
            'jam_akhir'=>$jamAkhir,
            'jam_awal'=>$jamAwal,
            'count_sebelum'=>$count_sebelum,
            'count_sesudah'=>$count_sesudah
        ));
    }

    public function remove_data()
    {
        $x = $this->dt_model->rm_all_dt();
        if($x){
            echo json_encode(array('status'=>TRUE));
        }
    }


    public function export_dt()
    {

        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $xls = $this->input->post('xls');
        $list = $this->dt_model->export_dt($startDate, $endDate);
        $check_type = ($xls == 'on') ? 'xls' : 'pdf' ;
        if($check_type=='xls'){
            $type = $check_type;
            $fileName = 'Eksport-DT-'.$startDate.'-to-'.$endDate.'.xlsx';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getStyle('A1:Z1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('DDDDDD');

            // $sheet->getStyle('A1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            // $sheet->getStyle('A1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            // $sheet->getStyle('A1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            // $sheet->getStyle('A1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


            $sheet->getStyle('A1:AA1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:AA1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
           
            $sheet->getStyle('A1:AA1')
            ->getAlignment()->setWrapText(true);
            $sheet->getStyle('A1:AA1')->getFont()->setSize(10);
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);$sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('J')->setAutoSize(true);
            $sheet->getColumnDimension('K')->setAutoSize(true);
            $sheet->getColumnDimension('L')->setAutoSize(true);$sheet->getColumnDimension('M')->setAutoSize(true);$sheet->getColumnDimension('N')->setAutoSize(true);$sheet->getColumnDimension('O')->setAutoSize(true);$sheet->getColumnDimension('P')->setAutoSize(true);$sheet->getColumnDimension('Q')->setAutoSize(true);$sheet->getColumnDimension('R')->setAutoSize(true);$sheet->getColumnDimension('S')->setAutoSize(true);$sheet->getColumnDimension('T')->setAutoSize(true);$sheet->getColumnDimension('U')->setAutoSize(true);$sheet->getColumnDimension('V')->setAutoSize(true);$sheet->getColumnDimension('W')->setAutoSize(true);
            $sheet->getColumnDimension('X')->setAutoSize(true);
            $sheet->getColumnDimension('Y')->setAutoSize(true);
            $sheet->getColumnDimension('Z')->setAutoSize(true);
            $sheet->getColumnDimension('AA')->setAutoSize(true);

            $sheet->setCellValue('A1', 'Tanggal');
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('A1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


            $sheet->setCellValue('B1', 'L/TL');
            $sheet->getStyle('B1')->getFont()->setBold(true);
            $sheet->getStyle('B1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('B1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('B1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('B1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('C1', 'No.BAK');
            $sheet->getStyle('C1')->getFont()->setBold(true);
            $sheet->getStyle('C1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('C1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('C1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('D1', 'Nopol');
            $sheet->getStyle('D1')->getFont()->setBold(true);
            $sheet->getStyle('D1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('D1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('D1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('D1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('E1', 'Sopir');
            $sheet->getStyle('E1')->getFont()->setBold(true);
            $sheet->getStyle('E1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('E1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('E1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('E1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('F1', 'Pengirim');
            $sheet->getStyle('F1')->getFont()->setBold(true);
            $sheet->getStyle('F1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('F1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('F1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('F1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('G1', 'Penerima');
            $sheet->getStyle('G1')->getFont()->setBold(true);
            $sheet->getStyle('G1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('G1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('G1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('G1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('H1', 'No.Tiket');
            $sheet->getStyle('H1')->getFont()->setBold(true); $sheet->getStyle('H1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('H1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('H1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


            $sheet->setCellValue('I1', 'Jam Kirim');
            $sheet->getStyle('I1')->getFont()->setBold(true);
            $sheet->getStyle('I1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('I1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('I1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('I1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('J1', 'Dari');
            $sheet->getStyle('J1')->getFont()->setBold(true);
            $sheet->getStyle('J1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('J1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('J1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('J1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('K1', 'Jam Terima');
            $sheet->getStyle('K1')->getFont()->setBold(true);
            $sheet->getStyle('K1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('K1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('K1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('K1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('L1', 'Tujuan');
            $sheet->getStyle('L1')->getFont()->setBold(true);
            $sheet->getStyle('L1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('L1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('L1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('L1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('M1', 'Kilometer');
            $sheet->getStyle('M1')->getFont()->setBold(true);
            $sheet->getStyle('M1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('M1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('M1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('M1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            $sheet->setCellValue('N1', 'RIT');
            $sheet->getStyle('N1')->getFont()->setBold(true);
            $sheet->getStyle('N1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('N1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('N1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('N1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('O1', 'PP/P');
            $sheet->getStyle('O1')->getFont()->setBold(true);
            $sheet->getStyle('O1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('O1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('O1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('O1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('P1', 'Tot. KM');
            $sheet->getStyle('P1')->getFont()->setBold(true);
            $sheet->getStyle('P1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('P1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('P1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('P1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('Q1', 'Keg./Bawa');
            $sheet->getStyle('Q1')->getFont()->setBold(true);
            $sheet->getStyle('Q1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Q1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Q1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Q1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('R1', 'Untuk/Ket');
            $sheet->getStyle('R1')->getFont()->setBold(true);
            $sheet->getStyle('R1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('R1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('R1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('R1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('S1', 'Isi Solar');
            $sheet->getStyle('S1')->getFont()->setBold(true);
            $sheet->getStyle('S1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('S1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('S1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('S1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('T1', 'Kf Solar');
            $sheet->getStyle('T1')->getFont()->setBold(true);
            $sheet->getStyle('T1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('T1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('T1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('T1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('U1', 'Pakai Solar');
            $sheet->getStyle('U1')->getFont()->setBold(true);
            $sheet->getStyle('U1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('U1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('U1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('U1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('V1', 'Tunjangan Pokok');
            $sheet->getStyle('V1')->getFont()->setBold(true);
            $sheet->getStyle('V1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('V1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('V1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('V1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('W1', 'Lembur Tambahan');
            $sheet->getStyle('W1')->getFont()->setBold(true);
            $sheet->getStyle('W1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('W1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('W1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('W1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


            $sheet->setCellValue('X1', 'Harga Satuan RIT');
            $sheet->getStyle('X1')->getFont()->setBold(true);
            $sheet->getStyle('X1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('X1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('X1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('X1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('Y1', 'BOR Ritasi');
            $sheet->getStyle('Y1')->getFont()->setBold(true);
            $sheet->getStyle('Y1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Y1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Y1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Y1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('Z1', 'Jumlah Kirim');
            $sheet->getStyle('Z1')->getFont()->setBold(true);
            $sheet->getStyle('Z1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Z1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Z1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('Z1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->setCellValue('AA1', 'Pos Proyek');
            $sheet->getStyle('AA1')->getFont()->setBold(true);
            $sheet->getStyle('AA1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('AA1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('AA1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('AA1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $i = 2;
            $total_km = 0;
            foreach ($list->result() as $l) {
                if($l->tarif!=NULL || $l->tarif !=''){
                    $tarif = $this->tarif_model->get_tarif_one($l->tarif)->row_array();
                    $tarif_satuan = $tarif['tarif'];
                }else{
                    $tarif_satuan = 0;
                }

                if($l->kfsolar!=NULL || $l->kfsolar !=''){
                    $solar = $this->solar_model->get_kfsolar($l->kfsolar)->row_array();
                    $kfsolar = $solar['kfsolar'];
                }else{
                    $kfsolar = 0;
                }

                if($l->status_ritasi==2){
                    $total_km = (($l->km*2)* $l->rit);
                }else{
                    $total_km = ($l->km* $l->rit);
                }

                if($l->status!=1){
                    $bor_ritasi = 40000;
                }else{
                    // if(($l->rit * $tarif_satuan) <= 75000){
                    //     $bor_ritasi = 75000;
                    // }else{
                        $bor_ritasi = ($l->rit * $tarif_satuan);
                    // }
                    
                }


                $pos = $this->proyek_model->get_proyek($l->pos_proyek)->row_array();
                $sheet->setCellValue('A'.$i, $l->tanggal);
                $sheet->setCellValue('B'.$i, $l->ltl);                
                $sheet->setCellValue('C'.$i, $l->dt_mobil);
                $sheet->setCellValue('D'.$i, $l->plat);
                $sheet->setCellValue('E'.$i, $l->sopir);
                $sheet->setCellValue('F'.$i, $l->pengirim);
                $sheet->setCellValue('G'.$i, $l->penerima);
                $sheet->setCellValue('H'.$i, $l->no_tiket);
                $sheet->setCellValue('I'.$i, $l->jam_kirim);
                $sheet->setCellValue('J'.$i, $l->dari);
                $sheet->setCellValue('K'.$i, $l->jam_tiba);
                $sheet->setCellValue('L'.$i, $l->tujuan);
                $sheet->setCellValue('M'.$i, $l->km);
                $sheet->setCellValue('N'.$i, $l->rit);
                $sheet->setCellValue('O'.$i, $l->status_ritasi);
                $sheet->setCellValue('P'.$i, $total_km);
                $sheet->setCellValue('Q'.$i, $l->membawa);

                $sheet->setCellValue('R'.$i, $l->untuk);
                if($l->status !=1){
                    // $sheet->getStyle('Q'.$i)->getFill()
                    // ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    // ->getStartColor()->setARGB('fff454');
                    $sheet->getStyle('R'.$i)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('fff454');
                }
                $sheet->setCellValue('S'.$i, $l->isi_solar);
                $sheet->setCellValue('T'.$i, $kfsolar);
                $sheet->setCellValue('U'.$i, $l->solar_pakai);
                $sheet->setCellValue('V'.$i, $l->pokok);

                $sheet->setCellValue('W'.$i, $l->tambahan);
                $sheet->setCellValue('X'.$i, $tarif_satuan);
                $sheet->setCellValue('Y'.$i, $bor_ritasi);
                $sheet->setCellValue('Z'.$i, $l->jumlah_kirim.' '.$l->satuan_jumlah);
                $sheet->setCellValue('AA'.$i, $pos['nama_pos']);



                $sheet->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('B'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('C'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('C'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('C'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('C'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('D'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('E'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('E'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('E'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('E'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('F'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('F'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('F'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('F'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('G'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('G'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('G'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('G'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('H'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('H'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('H'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('H'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('I'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('I'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('J'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('J'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('J'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('J'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('K'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('K'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('K'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('K'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('L'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('L'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('L'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('L'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('M'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('M'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('M'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('M'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('N'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('N'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('O'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('O'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('O'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('O'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('P'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('P'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('P'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('P'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('Q'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Q'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Q'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Q'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('R'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('R'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('R'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('R'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('S'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('S'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('S'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('S'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('T'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('T'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('T'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('T'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('U'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('U'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('U'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('U'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('V'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('V'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('V'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('V'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


                // Number Format =======
                $sheet->getStyle('V'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');

                $sheet->getStyle('W'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');

                $sheet->getStyle('X'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');

                $sheet->getStyle('Y'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');

                // =====


                $sheet->getStyle('W'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('W'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('W'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('W'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('X'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('X'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('X'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('X'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('Y'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Y'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Y'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Y'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('Z'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Z'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Z'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('Z'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $sheet->getStyle('AA'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('AA'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('AA'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('AA'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $i++;
            }
            $sheet->getStyle('A2:AA'.$i)
            ->getAlignment()->setWrapText(true);
            $writer = new Xlsx($spreadsheet);
            $sheet->getStyle('A2:AA'.$i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $sheet->getStyle('A2:AA'.$i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle('A2:AA'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A2:AA'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A2:AA'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A2:AA'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getStyle('A2:AA'.$i)->getFont()->setSize(9);

            $writer->save($fileName); 
            echo json_encode(array('link'=>$fileName));
            // force_download($fileName, NULL);
        }else{
            $type = 'pdf';
        }
    }


}

/* End of file Dt.php */
