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

class Payroll extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
    public function index()
    {
        $data['dt']   = $this->payroll_model->gaji_list()->result();
		$data['main_content'] = 'payroll';
		$this->load->view('temp', $data);
    }

    public function payroll_details($id)
    {
        $data['data'] = $this->payroll_model->get_gaji($id)->row_array();
        $data['mobil']  = $this->mobil_model->get_mobil_and_sopir($data['data']['mobil'])->row_array();
        $data['dt']   = $this->dt_model->ritasi_bulan_on_dt($data['data']['bulan'], $data['data']['mobil'])->result();
        $data['main_content'] = 'payroll_details';
		$this->load->view('temp', $data);
    }

    public function export_pdf_one($id){
    $data['data'] = $this->payroll_model->get_gaji($id)->row_array();
    $data['mobil']  = $this->mobil_model->get_mobil_and_sopir($data['data']['mobil'])->row_array();
    $data['dt']   = $this->dt_model->ritasi_bulan_on_dt($data['data']['bulan'], $data['data']['mobil'])->result();
    $html = $this->load->view('pdf/payroll_one', $data, TRUE);
    $this->pdfgenerator->generate($html, $data['mobil']['plat']."(".date('d-M-Y').")");
    }


    public function init_gaji()
    {
        $mobil = $this->input->post('mobil');
        $so = $this->mobil_model->get_mobil_and_sopir($mobil)->row_array();
        $b = $this->input->post('bulan');
        $exp = explode('-', $b);
        $bulan = $exp['0'].'-'.$exp[1];
        $data = array(
            'mobil'=>$mobil,
            'bulan'=>$bulan,
            'pokok'=>0,
            'bor'=>0,
            'lembur'=>0,
            'sopir'=>$so['id_sopir'],
            'status'=>0
        );
        $id = $this->payroll_model->init_gaji($data);
        if($id){
            echo json_encode(array('id'=>$id));
        }
    }

    public function export_excel()
    {
        $bulan = $this->input->post('bulan');
        $fileName = 'Ekspor-Gaji-'.$bulan.'.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $b = explode('-',$bulan);
        $bulanFormated = bulan($b[1]).' '.$b[0];
        
        $sheet->getStyle('A4:Z4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:Z4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        $sheet->getStyle('A4:Z4')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:Z4')->getFont()->setSize(10);
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
        $sheet->getColumnDimension('L')->setAutoSize(true);

       
        $sheet->mergeCells('A1:B2');
        $sheet->setCellValue('A1', 'Masa Aktif Kerja :');
        $sheet->mergeCells('C1:E2');
        $sheet->setCellValue('C1', $bulanFormated);
        $sheet->getStyle('A1:B2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:B2')->getFont()->setSize(14);
        $sheet->getStyle('C1:E2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('C1:E2')->getFont()->setSize(14);

        $sheet->setCellValue('A4', 'DT');
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->getStyle('A4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('B4', 'PLAT MOBIL');
        $sheet->getStyle('B4')->getFont()->setBold(true);
        $sheet->getStyle('B4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('B4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('B4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('B4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('C4', 'DRIVER');
        $sheet->getStyle('C4')->getFont()->setBold(true);
        $sheet->getStyle('C4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('C4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('C4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('D4', 'Total Ritasi');
        $sheet->getStyle('D4')->getFont()->setBold(true);
        $sheet->getStyle('D4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('D4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('D4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('D4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('E4', 'Total KM');
        $sheet->getStyle('E4')->getFont()->setBold(true);
        $sheet->getStyle('E4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('E4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('E4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('F4', 'Hari Kerja');
        $sheet->getStyle('F4')->getFont()->setBold(true);
        $sheet->getStyle('F4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('F4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('F4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('G4', 'Standby/Rusak');
        $sheet->getStyle('G4')->getFont()->setBold(true);
        $sheet->getStyle('G4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('G4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('G4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('G4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('H4', 'Upah Pokok');
        $sheet->getStyle('H4')->getFont()->setBold(true);
        $sheet->getStyle('H4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('I4', 'Upah Ritasi');
        $sheet->getStyle('I4')->getFont()->setBold(true);
        $sheet->getStyle('I4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('J4', 'Upah Lembur');
        $sheet->getStyle('J4')->getFont()->setBold(true);
        $sheet->getStyle('J4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('J4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('J4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('J4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('K4', 'Total Pembayaran');
        $sheet->getStyle('K4')->getFont()->setBold(true);
        $sheet->getStyle('K4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('L4', 'Status Pembayaran');
        $sheet->getStyle('L4')->getFont()->setBold(true);
        $sheet->getStyle('L4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('L4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('L4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('L4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Loop Data Gaji 
        $data = $this->payroll_model->gaji_bulan($bulan)->result();
        $i = 5;
        $total_bor = 0;
        $total_pokok = 0;
        $total_jumlah = 0;
        $total_lembur = 0;
        foreach ($data as $gaji) {
         $total = 0;
         $mobil = $this->mobil_model->get_mobil_and_sopir($gaji->mobil)->row_array();

         $dt = $this->dt_model->ritasi_bulan_on_dt($bulan, $gaji->mobil)->result();

         $total_rit = 0;
         $total_km = 0;
         $total_hari = 0;
         $total_standby = 0;

         $check_sama = array();
         foreach ($dt as $dts) {
             $total_rit += $dts->rit;
             $total_km += $dts->km;

             
              $total_hari += 1;
                
                         

             if($dts->status!=1){
                 $total_standby +=1;
             }
         }
         
         $total = ($gaji->pokok + $gaji->bor + $gaji->lembur);

         $total_bor +=$gaji->bor;
         $total_lembur +=$gaji->lembur;
         $total_pokok += $gaji->pokok;
         $total_jumlah +=$total;

         $status = ($gaji->status == 1 ? "TELAH DIBAYARKAN" : "BELUM DIBAYARKAN");

         $sheet->setCellValue('A'.$i, 'DT-'.$mobil['dt'].'/'.$mobil['type']);
         $sheet->setCellValue('B'.$i, $mobil['plat']);
         $sheet->setCellValue('C'.$i, $mobil['nama_sopir']);

         $sheet->setCellValue('D'.$i, $total_rit);
         $sheet->setCellValue('E'.$i, $total_km);
         $sheet->setCellValue('F'.$i, $total_hari);
         $sheet->setCellValue('G'.$i, $total_standby);

         $sheet->setCellValue('H'.$i, $gaji->pokok);
         $sheet->setCellValue('I'.$i, $gaji->bor);
         $sheet->setCellValue('J'.$i, $gaji->lembur);
         $sheet->setCellValue('K'.$i, $total);
         $sheet->setCellValue('L'.$i, $status);

        $sheet->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.$i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.$i)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.$i)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

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

         // Number Format =======
         $sheet->getStyle('H'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');
         $sheet->getStyle('I'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');
         $sheet->getStyle('J'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');
         $sheet->getStyle('K'.$i)->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');

         $i++;
        }

        $sheet->mergeCells('A'.($i+1).':G'.($i+1));
        $sheet->setCellValue('A'.($i+1), 'Total :');
        $sheet->setCellValue('H'.($i+1), $total_pokok);
        $sheet->setCellValue('I'.($i+1), $total_bor);
        $sheet->setCellValue('J'.($i+1), $total_lembur);
        $sheet->setCellValue('K'.($i+1), $total_jumlah);

        $sheet->getStyle('A'.($i+1).':G'.($i+1))->getFont()->setBold(true);
        $sheet->getStyle('A'.($i+1).':G'.($i+1))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.($i+1).':G'.($i+1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.($i+1).':G'.($i+1))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A'.($i+1).':G'.($i+1))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        
        // 
        $sheet->getStyle('H'.($i+1))->getFont()->setBold(true);
        $sheet->getStyle('H'.($i+1))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H'.($i+1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H'.($i+1))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H'.($i+1))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //
        // 
        $sheet->getStyle('I'.($i+1))->getFont()->setBold(true);
        $sheet->getStyle('I'.($i+1))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I'.($i+1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I'.($i+1))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I'.($i+1))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //
        // 
        $sheet->getStyle('J'.($i+1))->getFont()->setBold(true);
        $sheet->getStyle('J'.($i+1))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('J'.($i+1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('J'.($i+1))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('J'.($i+1))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //
        // 
        $sheet->getStyle('K'.($i+1))->getFont()->setBold(true);
        $sheet->getStyle('K'.($i+1))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K'.($i+1))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K'.($i+1))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K'.($i+1))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // 

        $sheet->getStyle('A'.($i+1).':L'.($i+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

         // Number Format =======
         $sheet->getStyle('H'.($i+1))->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');
         $sheet->getStyle('I'.($i+1))->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');
         $sheet->getStyle('J'.($i+1))->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');
         $sheet->getStyle('K'.($i+1))->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* \(#,##0.00\);_("Rp. "* "-"??_);_(@_)');

        $writer = new Xlsx($spreadsheet);
        $writer->save($fileName); 
        echo json_encode(array('link'=>$fileName));

    }

}

/* End of file Payroll.php */
