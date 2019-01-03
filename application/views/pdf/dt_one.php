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
			<h2><?php echo $data['tanggal'];?></h2>
			
                    <h3 class="text-center"><?php echo $mobil['nama_sopir'];?><span> / <?php echo $mobil['plat'];?></span></h3>
                    <table border="0.1" class="display table table-bordered table-sm table-striped table-responsive-sm" width="100%">
                        <thead class="blue-grey lighten-4">
                            <tr align="center">
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">Tanggal</th>
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
                                foreach ($dt as $dt) {
                                $pos = '';
                                $harga_ritasi = 0;
                                $tot_km = 0;
                                $tot_rit += $dt->rit;
                                $jumlah = 0;
								$rts = 0;
								$rit = 0;
								$km = 0;
                                if($dt->tarif!=NULL || $dt->tarif!=''){
                                    $t = $this->tarif_model->get_tarif_one($dt->tarif)->row_array();
                                    $harga_ritasi = $t['tarif'];
									$rts = $dt->rit * $t['tarif'];
									$rit =  $dt->rit;
									$km = $dt->km;
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
                                <td style="text-align:center; vertical-align : middle;" align="center" colspan="2"><h3><?php echo number_format($tot_rit,0); ?></h3></td>
                                <td style="text-align:right; vertical-align : middle;" colspan="2" align="right">Pembayaran Bulan Ini :</td>
                                <td style="text-align:right; vertical-align : middle;" colspan="2" align="right"><h3><?php echo 'Rp.'.number_format($total_gaji,2); ?></h3></td>
                            </tr>
                        </tfoot>
                    </table>
<!--  -->

<!--  -->
</body>
</html>