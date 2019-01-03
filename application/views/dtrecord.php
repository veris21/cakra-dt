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
                        <span>DT Record List</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-sm btn-danger btn-sm my-0 p" type="button" onclick="rm_data()">
                                <i class="fa fa-trash"></i> Reset data
                            </button>
                        <button class="btn btn-sm btn-secondary btn-lg my-0 p" type="button" onclick="add_dt()">
                            <i class="fa fa-plus"></i> Record DT
                        </button>
                    </div>
                </div>
            </div>

            <hr>
            <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        
                    </h4>
                    <div class="d-flex justify-content-center">
                        
                        <!-- Default input -->
                        <button class="btn btn-sm btn-primary btn-sm my-0 p" type="button" onclick="export_dt()">
                            <i class="fa fa-print"></i> Export data
                        </button>
                        <button class="btn btn-sm btn-success btn-lg my-0 p" type="button" onclick="form_import_dt()">
                            <i class="fa fa-upload"></i> Import Data
                        </button>
                    </div>
                </div>
            </div>

            
            <hr>
            <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        Ritasi Total Bulan Ini :<span>
                        <?php 
                    echo mdate('%M %Y', time());
                    $m = mdate('%m', time());
                    $y = mdate('%Y', time());
                    $tot = $this->dt_model->total_ritasi_bulan_ini($m,$y);
                        $count_rit = 0;
                        $count_km = 0;
                        foreach($tot->result() as $t) {
                            $count_rit += $t->rit;
                        }
                         ?>
                        </span>  
                        
                         <!-- <span><input class="datepicker" type="text" id="lihat_dt_bulan"></span> -->
                    </h4>
                    <div class="d-flex justify-content-center">
                        
                        <h4><?php echo number_format($count_rit,0); ?> RIT</h4>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?php //echo time();?></h1>
                </div>
                <div class="card-body">
                <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="dt_list" style="font-size:9px;">
                   <thead class="blue-grey lighten-4">
                   <tr align="center" valign="middle" >
                        <th style="vertical-align : middle;text-align:center;"  rowspan="2">Tanggal</th>
                        <th colspan="2">DT Details</th>
                        <th colspan="2">Keterangan</th>
                        <th colspan="2">RIT Details</th>
                        <th >Total Details</th>
                        <th style="vertical-align : middle;text-align:center;" rowspan="2" width="60">Pilihan</th>
                    </tr>
                    <tr align="center" valign="middle" >
                    <th>Sopir</th>
                    <th>Mobil</th>
                    <th>Dari</th>
                    <th>Tujuan</th>
                    <th>RIT</th>
                    <th>KM</th>
                    <th>Total</th>
                    </tr>
                   </thead>
                   <tbody>
                       <?php 
                            foreach ($data->result() as $data) {
                            $mobil = $this->mobil_model->get_mobil($data->mobil)->row_array();
                            $sopir = $this->sopir_model->get_sopir_one($mobil['sopir'])->row_array();
                            $total_km = 0;
                            $tarif = 0;
                            $kfsolar = 0;
                            $kfsolar_keterangan = '';
                            $solar_pakai = 0;
                            $km = 0;
                            $rit = 0;
                            $total = 0;
                            $tambahan = 0;
                            $pokok = 0;
                            if($data->rit!='' && $data->km!='' || $data->rit!=null && $data->km!=null){
                                $rit = $data->rit;
                                $tf = $this->tarif_model->get_tarif_one($data->tarif)->row_array();
                                $solar = $this->solar_model->get_kfsolar($data->kfsolar)->row_array();
                                $kfsolar = $solar['kfsolar'];
                                $kfsolar_keterangan = $solar['keterangan'];
                                $total_km = number_format($data->rit,2) * number_format($data->km,0);
                                $tarif = $tf['tarif'];
                                $solar_pakai = $data->solar_pakai;
                                $km = $data->km;
                            }
                            $total_ritasi = $rit* $tarif;
                            // if($data->status!=1){
                                $tambahan = $data->tambahan;
                                $pokok = $data->pokok;
                                $total = $pokok + $total_ritasi + $tambahan;
                            // }else{
                            //     $pokok = $data->pokok;
                            //     if($total_ritasi <= 75000){
                            //         $total_ritasi = 75000;
                            //     }else{
                            //         $total_ritasi = $total_ritasi;
                            //     }
                            //     $total = $pokok + $total_ritasi;
                            // }
                            

                       ?>
                       <tr valign="top">
                            <td width="90" style="vertical-align : middle;text-align:center;">
                                <?php echo $data->tanggal; ?>
                            </td>
                            <td style="vertical-align : middle;text-align:center;">                                <?php echo $sopir['nama_sopir']; ?>
                            </td>
                            <td> 
                            <?php echo "<b>".$mobil['plat']."</b>
                            <br/>".$mobil['type']; ?>
                            <hr>
                                Solar : <br><b><?php echo $solar_pakai;?></b> Ltr
                                <hr>
                            Kf.Solar : <b><?php echo $kfsolar;?></b><br>
                            (<?php echo $kfsolar_keterangan;?>)

                            </td>
                            <!--  STatus Aktif jalan -->
                            <?php if($data->status==1){
                            ?>
                                <td >
                                <?php echo $data->dari; ?><br>
                                <?php echo $data->jam_kirim; ?> WIB
                                <hr>
                                Pengirim : <b><?php echo $data->pengirim;?></b>
                                <hr>
                                Membawa : <br><b><?php echo $data->membawa;?></b>
                            </td>
                            <td>
                                <?php echo $data->tujuan; ?><br>
                                <?php echo $data->jam_tiba; ?> WIB
                                <hr>
                                Penerima : <b><?php echo $data->penerima;?></b>
                                <hr>
                                Untuk : <b><?php echo $data->untuk;?></b>
                            </td>
                            <td >
                                <?php echo $data->rit; ?> Rit / <?php echo $pp = ($data->status_ritasi==2?'PP':'P'); ;?>
                                <hr>
                                Tarif : <?php echo "Rp.".number_format($tarif,0); ?>
                                
                            </td>
                            <td width="60">
                                Jarak : <br><?php echo $km; ?> Km
                                <hr>
                                Total : <br><b><?php echo $total_km;?></b> Km
                                
                            </td>
                            <!--  STatus Standby -->
                            <?php
                            }elseif ($data->status==2) {
                             ?>
                             <td >     
                             <button class="btn btn-outline-warning btn-sm btn-block">Standby</button>
                            </td>
                            <td>
                            <p class="text-center"><?php echo $data->untuk;?></p>
                            </td>
                            <td></td>
                            <td></td>
                            <!--  -->
                             <?php
                            }else{ ?>
                            <td >     
                             <button class="btn btn-outline-danger btn-sm btn-block">Rusak</button>
                            </td>
                            <td>
                            <p class="text-center"><?php echo $data->untuk;?></p>
                            </td>
                            <td></td>
                            <td></td>
                           
                            <!--  -->
                            <?php } ?>
                            <!--  -->
                            <td align="right">
                                Kirim : <b><?php echo $data->jumlah_kirim .' '.$data->satuan_jumlah; ?></b>
                                <hr>
                                Tot.Ritasi : <b><?php echo "Rp.".number_format($total_ritasi,0).",-"; ?></b>
                                <hr>
                                Pokok : <?php echo "Rp.".number_format($data->pokok, 0).",-"; ?>
                                <hr>
                                Lembur : <?php echo "Rp.".number_format($tambahan, 0).",-"; ?>
                                <hr>
                                Total : <b><?php echo "Rp.".number_format($total, 0).",-"; ?></b>
                            </td>
                           <td width="70">
                            <a class="btn btn-sm btn-info" href="<?php echo site_url('dt/details/'.$data->id); ?>"><i class="fa fa-eye"></i> Details</a><br>
                            <?php if($this->session->userdata('akses')=='MASTER'){ ?>
                            <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>Edit </button><br>
                            <?php }?>
                            <!-- <button class="btn btn-sm btn-success"><i class="fa fa-upload"></i> Posting Ke Master</button> -->
                            </td>
                       </tr>
                      
                       <?php } ?>
                   </tbody>
                </table>
                </div>
            </div>
	    
        </div>
</main>