<?php $this->load->view('header'); ?>
<?php

$tarif_ritasi = 0;
$rit = 0;
$kf = 0;
$isi = 0;
$solar_pakai = 0;
$dari = '';
$tujuan = '';
$tot_km = 0;
$jam_kirim = '';
$jam_tiba = '';
$km =0;
$bor = 0;
$pokok = 0;
$tambahan = 0;
$total = 0;

switch ($dt['status']) {
    case 0:
       $status = 'RUSAK';
        break;
        case 2:
       $status = 'STANDBY';
        break;

}
 
if($dt['tarif']!='' || $dt['tarif']!=NULL){ 
    $tarif = $this->tarif_model->get_tarif_one($dt['tarif'])->row_array();
    $tarif_ritasi = $tarif['tarif']; 
} 

if($dt['tujuan']!='' || $dt['tujuan']!=NULL){ 
    $tujuan =  $dt['tujuan']; 
}

if($dt['dari']!='' || $dt['dari']!=NULL){ 
    $dari = $dt['dari']; 
}

if($dt['isi_solar']!='' || $dt['isi_solar']!=NULL){ 
    $isi = $dt['isi_solar']; 
}

if($dt['solar_pakai']!='' || $dt['solar_pakai']!=NULL){ 
    $solar_pakai = $dt['solar_pakai']; 
}

if($dt['kfsolar']!='' || $dt['kfsolar']!=NULL){
    $kfs = $this->solar_model->get_kfsolar($dt['kfsolar'])->row_array();
    $kf =  $kfs['kfsolar'];
}
if($dt['km']!='' || $dt['km']!=NULL){
    $km = $dt['km']; 
}

if($dt['rit']!='' || $dt['rit']!=NULL){
    $rit = $dt['rit']; 
}


if($dt['jam_kirim']!='' || $dt['jam_kirim']!=NULL){
    $jam_kirim = $dt['jam_kirim']; 
}

if($dt['jam_tiba']!='' || $dt['jam_tiba']!=NULL){
    $jam_tiba = $dt['jam_tiba']; 
}


if($dt['status']==1){
    $tot_km = ($km*$dt['status_ritasi'])*$rit.' KM';
} 

// if($dt['status']!=1){
//     $bor = 40000;
// }else{
    // if($tarif_ritasi*$rit < 75000){
    //     $bor = number_format(75000,0);
    // }else{
        $bor = ($tarif_ritasi*$rit);
    // }
    
// }


if($dt['pokok']!='' || $dt['pokok']!=NULL){
    $pokok = intval($dt['pokok']); 
}

if($dt['tambahan']!='' || $dt['tambahan']!=NULL){
    $tambahan = intval($dt['tambahan']); 
}

$total = ($pokok + $tambahan + $bor);

?>
<main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
            <!-- Heading -->
            <div class="card mb-4 wow fadeIn">
                <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        <a href="#" target="_blank">Home</a>
                        <span>/</span>
                        <span>DT Record Details</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <!-- <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="print_dt(<?php //echo $dt['id']; ?>)">
                            <i class="fa fa-print"></i> Print data
                        </button> -->
                       
                    </div>
                </div>
            </div>
            <!--  -->
            <!--  -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><b>Per Tanggal </b> <?php 
                    echo $dt['tanggal']; 
                    ?><span class="pull-right"><?php echo $mobil['plat'].'/'.$sopir['nama_sopir']; ?></span></h4> 
                </div>
                <div class="card-body">
                    <table style="width:100%" class="display table table-bordered table-sm table-responsive-sm">
                    <thead class="blue-grey lighten-4">
                    <tr align="center">
                        <th colspan="2">Solar</th>
                        <th colspan="2">KM/Rit</th>
                        <th colspan="4">Keterangan</th>
                        <th colspan="2">Jumlah</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($dt['status']==1){ ?>
                        <tr>
                            <td>Isi Solar</td>
                            <td align="center"><?php echo $isi ;?> Ltr</td>

                            <td>KM</td>
                            <td align="center"><?php echo $km; ?> Km</td>
                            

                            <td>Dari</td>
                            <td><?php echo $dari; ?></td>
                            
                            <td>Tujuan</td>
                            <td><?php echo $tujuan; ?></td>
                            
                            <td>Total KM</td>
                            <td align="right" class="jm"><?php echo $tot_km; ?></td>
                            
                        </tr>
                        <tr>
                            <td>Pakai Solar</td>
                            <td align="center"><?php echo $solar_pakai; ?> Ltr</td>

                            <td>Rit</td>
                            <td><?php 
                            echo $rit; 
                            echo ' / ';
                            echo $pp = ($dt['status_ritasi']==1 ? 'P' : 'PP');
                            ?></td>
                            

                            <td>Berangkat</td>
                            <td align="center"><?php echo $jam_kirim; ?> WIB</td>
                            
                            <td>Tiba</td>
                            <td align="center"><?php echo $jam_tiba; ?> WIB</td>
                            

                            <td>Tarif Ritasi</td>
                            <td  align="right" class="jm"><?php echo 'Rp.'.number_format($tarif_ritasi,0);?></td>
                            
                        </tr>
                        <tr>
                             <td>Sisa/Selisih</td>
                             <td align="center"><?php echo $sisa = ($isi-$solar_pakai); ?> Ltr</td>
                             <td>KfSolar</td>
                             <td align="center"><?php echo $kf; ?></td>
                             <td>Pengirim</td>
                             <td><?php echo $dt['pengirim'];?></td>
                             <td>Penerima</td>
                             <td><?php echo $dt['penerima'];?></td>
                             <td>BOR Ritasi</td>
                             <td align="right" class="jm"><b>Rp.<?php echo $bor; ?></b></td>
                        </tr>
                        <tr>
                        <td colspan="8"></td>
                        <td>Pokok</td>
                        <td align="right" class="jm"><?php echo 'Rp.'.number_format($pokok,0);?></td>
                        </tr>
                        <tr>
                        <td colspan="8"></td>
                        <td>Lembur</td>
                        <td align="right" class="jm"><?php echo 'Rp.'.number_format($tambahan,0);?></td>
                        </tr>
                        <tr>
                        <td align="center" class="jm" colspan="8">Jumlah</td>
                        <td align="right" class="jm" colspan="2"> <b><?php echo 'Rp.'.number_format($total,0);?></b> </td>
                        </tr>
                    <?php }else{ ?>
                    <tr>
                        <td rowspan="4" colspan="8"><button class="btn btn-lg btn-outline-warning btn-block"><?php echo $status; ?></button></td>
                    </tr>
                    <tr>
                    <td>Total KM</td>
                    <td align="right" class="jm"><?php echo $tot_km; ?></td>
                    </tr>
                    <tr>
                    <td>Tarif Ritasi</td>
                    <td  align="right" class="jm"><?php echo 'Rp.'.number_format($tarif_ritasi,0).'/Rit';?></td>
                    </tr>
                    <tr>
                    <td>BOR Ritasi</td>
                    <td align="right" class="jm"><b>Rp.<?php echo $bor; ?></b></td>
                    </tr>
                    <tr>
                    <td colspan="8"></td>
                    <td>Pokok</td>
                    <td align="right" class="jm"><?php echo 'Rp.'.number_format($pokok,0);?></td>
                    </tr>
                    <tr>
                    <td colspan="8"></td>
                    <td>Lembur</td>
                    <td align="right" class="jm"><?php echo 'Rp.'.number_format($tambahan,0);?></td>
                    </tr>
                    <tr>
                    <td align="center" class="jm" colspan="8">Jumlah</td>
                    <td align="right" class="jm" colspan="2"> <b><?php echo 'Rp.'.number_format($total,0);?></b> </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <!--  -->
            <!--  -->
        </div>
</main>