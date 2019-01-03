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
                        <span>Payroll</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="export_payroll()">
                            <i class="fa fa-print"></i> Export data
                        </button>
                    </div>
                    
                </div>
                </div>
            <!--  -->
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?php //echo time();?></h1>
                </div>
                <div class="card-body">
                <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="payroll_list" style="font-size:9px;">
                   <thead class="blue-grey lighten-4">
                    <tr align="center">
                        <th style="vertical-align : middle;text-align:center;" rowspan="2">Tanggal/Bulan</th>
                        <th style="vertical-align : middle;text-align:center;" rowspan="2">DT Details</th>
                        <th colspan="2">Keterangan</th>
                        <th style="vertical-align : middle;text-align:center;" rowspan="2">Payroll</th>
                        <th style="vertical-align : middle;text-align:center;" rowspan="2">Status</th>
                        <th style="vertical-align : middle;text-align:center;" rowspan="2">Action</th>
                    </tr>
                    <tr align="center">                        
                        <th>Total Ritasi</th>
                        <th>Total KM</th>
                        
                    </tr>
                   </thead>
                   <tbody>
                    <?php 
                       $bor = 0;
                       $total = 0;
                       $total_dibayarkan = 0;
                       $b = 0;
                       $total_belum_dibayarkan = 0;
                       foreach ($dt as $d) {
                           $b = $d->bor;
                           $p = $d->pokok;
                        $total += ($b + $p);
                        if($d->status!=0){
                            $total_dibayarkan += ($b + $p);
                        }
                        // $total += ($b + $p);
                       $status = ($d->status==1 ? '<button class="btn btn-sm btn-outline-success"> Dibayarkan</button>':'<button class="btn btn-sm btn-outline-warning">Belum Dibayar</button>');
                       $bor = $b;
                       $p = $this->dt_model->ritasi_bulan_on_dt($d->bulan, $d->mobil)->result();
                       $rit = 0;
                       $km = 0;
                       foreach ($p as $p) {
                           $rit += $p->rit;
                           $km += $p->km;
                       }
                       $so = $this->mobil_model->get_mobil_and_sopir($d->mobil)->row_array();
                    ?>
                    <tr align="center">
                        <td><?php echo $d->bulan; ?></td>
                        <td>
                        <b>
                        <?php 
                        echo $so['nama_sopir'].' / '.$so['plat'];
                        ?>
                        </b>
                        <hr>
                        <?php echo 'DT-'.$so['dt'].' / '.$so['type']; ?>
                       
                        </td>
                        <td align="center">
                            <?php  echo $rit.' Rit'; ?>
                        </td>
                        <td align="center">
                            <?php  echo $km.' KM'; ?>
                        </td>
                        <td align="right">
                        Pokok : <?php echo 'Rp.'.number_format($d->pokok,0); ?>
                        <hr>
                        Ritasi : <?php echo 'Rp.'.number_format($bor,0); ?>
                        <hr>
                        Jumlah : <b><?php echo 'Rp.'.number_format(($bor+$d->pokok),0); ?></b>
                        </td>
                        
                        <td align="center">
                            <?php  echo $status; ?>
                        </td>
                        <td>
                        <a class="btn btn-sm btn-outline-success" href="<?php echo site_url('payroll/details/'.$d->id); ?>">Details <i class="fa fa-eye"></i></a>
                        <br>
                        <?php if($this->session->userdata('akses')=='MASTER'){ ?>
                        <button class="btn btn-sm btn-outline-warning">Edit <i class="fa fa-edit"></i></button>
                        <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                   </tbody>
                   </table>
                </div>
        </div>
<!--  -->
<hr>

<div class="row">
    <!--  -->
    <div class="col-md-6">
    <!--  -->
    <!--  -->
    <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        Belum Dibayarkan :<span>
                        <?php 
                    echo mdate('%M %Y', time());
                    $total_belum_dibayarkan = ($total-$total_dibayarkan);
                         ?>
                        </span>  
                        
                         <!-- <span><input class="datepicker" type="text" id="lihat_dt_bulan"></span> -->
                    </h4>
                    <div class="d-flex justify-content-center">
                        
                        <h4><?php echo 'Rp.'.number_format($total_belum_dibayarkan,0).',-'; ?></h4>
                    </div>
                </div>
            </div>
        <!--  -->
    <!--  -->
    </div>
    <!--  -->
    <div class="col-md-6">
    <!--  -->
    <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        Total Bulan Ini : <br><span>
                        <?php 
                    echo mdate('%M %Y', time());
                         ?>
                        </span>  
                        
                         <!-- <span><input class="datepicker" type="text" id="lihat_dt_bulan"></span> -->
                    </h4>
                    <div class="d-flex justify-content-center">
                        
                        <h4><?php echo 'Rp.'.number_format($total,0).',-'; ?></h4>
                    </div>
                </div>
            </div>           
    <!--  -->
    </div>
    <!--  -->
</div>
<!--  -->
<div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        Dibayarkan Bulan Ini :<span>
                        <?php 
                    echo mdate('%M %Y', time());
                         ?>
                        </span>  
                        
                         <!-- <span><input class="datepicker" type="text" id="lihat_dt_bulan"></span> -->
                    </h4>
                    <div class="d-flex justify-content-center">
                        <h4><?php echo 'Rp. '.number_format($total_dibayarkan,0).',-'; ?></h4>
                    </div>
                </div>
            </div>
	    <!--  -->
        </div>
        
</main>