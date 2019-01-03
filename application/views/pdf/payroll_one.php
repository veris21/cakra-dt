<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Cover</title>
	<!-- -->
	
	<link rel="stylesheet" href="<?php echo base_url().'print.css' ?>">
	<!-- -->
   
</head>
<body>
<table width="100%" border="none">
<tr>
<td>
<h1><?php $x = explode('-',$data['bulan']);
                    $bulan = bulan($x[1]);
                    $tahun = $x[0];
                    echo ' '.$bulan.' '.$tahun;?></h1>
</td>
<td>
<h2 style="text-align:right;"><?php echo $mobil['nama_sopir'];?><span> / <?php echo $mobil['plat'];?></span></h2>
</td>
</tr>
</table>
                    <table border="1" class="display table table-bordered table-sm table-striped table-responsive-sm" width="100%">
                        <thead class="blue-grey lighten-4">
                            <tr align="center">
                                <th style="vertical-align: middle;text-align:center;" rowspan="2">Tanggal</th>
                                <th colspan="2">Keterangan</th>
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">Pos Proyek</th>
                                <th colspan="3">Rincian</th>
                            </tr>
                            <tr align="center">
                                <th>Ritasi</th>
                                <th>KM</th>
                                <th>Harga Per Ritasi</th>
                                <th>Pokok</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $total_gaji = 0;
                                $tot_rit = 0;
                                $hari = 0;
                                $hari_hotmix = 0;
                                $hari_non_hotmix = 0;
                                $hari_standby = 0;
                                $hari_transport = 0;
                                $hari_rusak = 0;

                                foreach ($dt as $dt) {

                                if($dt->status==2){
                                    $hari_standby++;
                                }
                                if($dt->status==0){
                                    $hari_rusak++;
                                }

                                $hari++;
                                $pos = '';
                                $harga_ritasi = 0;
                                $tot_km = 0;
                                $tot_rit += $dt->rit;
                                $jumlah = 0;
								$rts = 0;
								$rit = 0;
                                $km = 0;
                                $ht = NULL;
                                if($dt->tarif!=NULL || $dt->tarif!=''){
                                    $t = $this->tarif_model->get_tarif_one($dt->tarif)->row_array();
                                    $harga_ritasi = $t['tarif'];
									$rts = $dt->rit * $t['tarif'];
									$rit =  $dt->rit;
                                    $km = $dt->km;
                                    switch($t['hotmix']){
                                        case 1:
                                        $ht = 'HOTMIX';
                                        $hari_hotmix++;
                                        break;
                                        case 2:
                                        $ht = 'TRANSPORT';
                                        $hari_transport++;
                                        break;
                                        case 0:
                                        $ht = 'NON HOTMIX';
                                        $hari_non_hotmix++;
                                        break;
                                    }
                                }
                                $jumlah = $dt->pokok + $rts;
                                if($dt->status_ritasi==2){
                                    $tot_km = ($dt->km*2)*$dt->rit;
                                }else{
                                    $tot_km = ($dt->km)*$dt->rit;
                                }
                                if($dt->pos_proyek!=NULL || $dt->pos_proyek!=''){
                                    $p = $this->proyek_model->get_proyek($dt->pos_proyek)->row_array();
                                    $pos = $p['nama_pos'].'<br> ('.$p['keterangan'].' )';
                                }

                                $total_gaji += $jumlah;
                               ?>
                               <tr>
                                    <td style="text-align:center;"><?php echo $dt->tanggal; ?></td>
                                    <td style="text-align:center;"><?php echo $rit; ?></td>
                                    <td style="text-align:center;"><?php echo $km; ?></td>
                                    <td>
									<?php 
                                    if($dt->status==1){
                                        if($ht!=NULL){
                                            echo $ht.' - ';
                                        }
                                        echo $pos; 
                                    }elseif($dt->status==2){
                                        echo 'Standby/'.$dt->untuk;
                                    }elseif($dt->status==0){
                                        echo 'Rusak/'.$dt->untuk;
                                    }
                                    ?>
									</td>
                                    <td style="text-align:center;" align="right"><?php echo 'Rp. '.number_format($harga_ritasi,0).',-'; ?></td>
                                    <td style="text-align:center;" align="right"><?php echo 'Rp. '.number_format($dt->pokok,0).',-'; ?></td>
                                    <td style="text-align:center;" align="right"><?php echo 'Rp. '.number_format($jumlah,0).',-'; ?></td>
                               </tr>
                               <?php
                            } ?>
                        </tbody>
                        <tfoot class="blue-green lighten-4">
                            <tr>
                                <td style="text-align:center;" align="center"><b>Total RIT :</b></td>
                                <td style="text-align:center; padding-top:10px;" align="center" colspan="2"><h3><?php echo number_format($tot_rit,0); ?></h3></td>
                                <td style="text-align:right;" colspan="2" align="right">Pembayaran Bulan Ini :</td>
                                <td style="text-align:right; padding-top:10px;" colspan="2" align="right"><h3><?php echo 'Rp.'.number_format($total_gaji,2); ?></h3></td>
                            </tr>
                        </tfoot>
                    </table>
<!--  -->
<!-- <hr> -->
<br>
<table border="0">
<tr>
<td style="text-align:left;"> 
Total Masa Kerja
</td>
<td style="text-align:center;"> <?php echo $hari.' Hari'; ?></td>
<td style="text-align:left;"> 
Standby 
</td>
<td style="text-align:center;"><?php echo $hari_standby.' Hari'; ?></td>
<td style="text-align:center;" colspan="2" rowspan="8" border="0.1">Paraf Pengemudi
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<b>(  <?php echo $mobil['nama_sopir']; ?>  )</b>
</td>
</tr>
<tr>
<td style="text-align:left;"> 
Ritasi Hotmix
</td>
<td style="text-align:center;"> <?php echo $hari_hotmix.' Hari'; ?></td>
<td style="text-align:left;"> 
Ritasi Non Hotmix 
</td>
<td style="text-align:center;"><?php echo $hari_non_hotmix.' Hari'; ?></td>
</tr>
<tr>
<td style="text-align:left;"> 
Transport 
</td>
<td style="text-align:center;"><?php echo $hari_transport.' Hari'; ?></td>
<td style="text-align:left;"> 
Rusak 
</td>
<td style="text-align:center;"><?php echo $hari_rusak.' Hari'; ?></td>
</tr>
</table>
<!--  -->
</body>
</html>