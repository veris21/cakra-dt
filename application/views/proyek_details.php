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
                        <span>Proyek Details</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="print_proyek(<?php echo $data['id']; ?>)">
                            <i class="fa fa-print"></i> Print Proyek
                        </button>
                    </div>
                    
                </div>
                </div>
<!--  -->
                <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?php echo $data['nama_pos'];?></h1>
                    <p class="card-subtitle"><?php echo $data['keterangan'];?></p>
                </div>
                <div class="card-body">
                </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Details Operasional DT</h4>
                            </div>
                            <div class="card-body">
                                <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="proyek_detil">
                                <thead>
                                    <tr align="center">
                                        <th>Tanggal</th>
                                        <th>DT Details</th>
                                        <th>Pengemudi</th>
                                        <th>Ritasi Details</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$total_rit = 0;
$total_biaya = 0;
foreach($dt as $dt){
$mobil = $this->mobil_model->get_mobil_and_sopir($dt->mobil)->row_array();
$biaya = 0;
$tarif = $this->tarif_model->get_tarif_one($dt->tarif)->row_array();

$r = ($dt->rit * $tarif['tarif']);
$biaya = $dt->pokok + $dt->tambahan + $r;

$total_rit += $dt->rit;
$total_biaya += $biaya;

?>
                                    <tr>
                                        <td align="center"><?php echo $dt->tanggal; ?></td>
                                        <td>
                                        <?php echo 'DT-'.$mobil['dt'].'/'.$mobil['plat']; ?>
                                        <?php echo $mobil['type']; ?>
                                        </td>
                                        <td align="center">
                                        <?php echo $mobil['nama_sopir']; ?>
                                        </td>
                                        <td align="right">
                                            <?php echo $dt->rit; ?> Rit
                                            <br>
                                            Biaya : <?php echo 'Rp.'.number_format($biaya,0).',-'; ?>
                                            <br>
                                            <br>
                                        </td>
                                    </tr>
<?php 
}
?>
                                </tbody>
                                
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rekapitulasi</h4>
                            </div>
                            <div class="card-body">
                                <table width="100%">
                                    <tr>
                                        <td>Total Ritasi </td>
                                        <td align="right"><?php echo $total_rit.' Rit'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Biaya </td>
                                        <td align="right"><?php echo 'Rp.'.number_format($total_biaya,0).',-'; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>