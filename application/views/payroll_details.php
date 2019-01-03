<?php $this->load->view('header'); ?>
<main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
            <!-- Heading -->
            <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        <a href="#" target="_blank">Home</a>
                        <span>/</span>
                        <span>Payroll Details</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="print_payroll(<?php echo $data['id']; ?>)">
                            <i class="fa fa-print"></i> Print Payroll
                        </button>
                    </div>
                    
                </div>
                </div>
<!--  -->
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php 
                    $x = explode('-',$data['bulan']);
                    $bulan = bulan($x[1]);
                    $tahun = $x[0];
                    echo ' '.$bulan.' '.$tahun;
                    ?>
                    </h3>
                </div>
                <div class="card-body">
                    <h3 class="text-center"><?php echo $mobil['nama_sopir'];?><span> / <?php echo $mobil['plat'];?></span></h3>
                    <table class="display table table-bordered table-sm table-striped table-responsive-sm" width="100%">
                        <thead class="blue-grey lighten-4">
                            <tr align="center">
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">Tanggal</th>
                                <th colspan="2">Keterangan</th>
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">Pos Proyek</th>
                                <th colspan="4">Rincian</th>
                            </tr>
                            <tr align="center">
                                <th>Ritasi</th>
                                <th>KM</th>
                                <th>Harga Per Ritasi</th>
                                <th>Pokok</th>
                                <th>Lembur</th>
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
                                $ht = NULL;
                                $lembur = 0;
                                if($dt->tarif!=NULL || $dt->tarif!=''){
                                    $t = $this->tarif_model->get_tarif_one($dt->tarif)->row_array();
                                    $harga_ritasi = $t['tarif'];
                                    $rts = $dt->rit * $t['tarif'];
                                    $rit =  $dt->rit;
                                    $km = $dt->km;
                                    switch($t['hotmix']){
                                        case 1:
                                        $ht = 'HOTMIX';
                                        break;
                                        case 2:
                                        $ht = 'TRANSPORT';
                                        break;
                                        case 0:
                                        $ht = 'NON HOTMIX';
                                        break;
                                    }
                                }
                                $lembur = $dt->tambahan;
                                $jumlah = $dt->pokok + $rts + $lembur;
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
                                    <td><?php echo $dt->tanggal; ?></td>
                                    <td><?php echo $rit; ?></td>
                                    <td><?php echo $km; ?></td>
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
                                    ?></td>
                                    <td align="right"><?php echo 'Rp. '.number_format($harga_ritasi,0).',-'; ?></td>
                                    <td align="right"><?php echo 'Rp. '.number_format($dt->pokok,0).',-'; ?></td>
                                    <td align="right"><?php echo 'Rp. '.number_format($lembur,0).',-'; ?></td>
                                    
                                    <td align="right"><?php echo 'Rp. '.number_format($jumlah,0).',-'; ?></td>
                               </tr>
                               <?php
                            } ?>
                        </tbody>
                        <tfoot class="blue-green lighten-4">
                            <tr>
                                <td align="center"><b>Total RIT :</b></td>
                                <td align="center" colspan="2"><h4><?php echo number_format($tot_rit,0); ?></h4></td>
                                <td colspan="2" align="right">Pembayaran Bulan Ini :</td>
                                <td colspan="3" align="right"><h4><?php echo 'Rp.'.number_format($total_gaji,2); ?></h4></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer">
                <!-- <div class="pull-right"> -->
                <?php if($data['status']==0){ ?>
                <button class="btn btn-lg btn-block btn-outline-warning" onclick="lakukan_pembayaran(<?php echo $data['id']; ?>)">Lakukan Pembayaran <i class="fa fa-upload"></i></button>
                <?php }else{ ?>
                <button class="btn btn-lg btn-block btn-outline-success disabled">Telah Dibayarkan <i class="fa fa-check"></i></button>
                <?php } ?>
                <!-- </div> -->
                </div>
</div>