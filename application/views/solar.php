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
                        <span>Data Pemakaian Solar</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="add_kfsolar()">
                            <i class="fa fa-plus"></i> Koef. Solar
                        </button>
                        <!-- Default input -->
                        <button class="btn btn-success btn-sm my-0 p" type="button" onclick="export_data_solar()">
                            <i class="fa fa-table"></i> Export Tabel Solar
                        </button>
                    </div>
                </div>
        </div>
        <div class="row">
            <!--  -->
            <!--  -->
            <div class="col-md-12">
            <!--  -->
        <!--  -->
        <div class="card">
                <div class="card-body">
                    <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="solar_list">
                        <thead class="blue-grey lighten-4">
                            <tr align="center">
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">Tanggal</th>
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">DT/Sopir</th>
                                <th colspan="2">Kilometer</th>
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">KFS</th>
                                <th colspan="2">Keterangan</th>
                                <th style="vertical-align : middle;text-align:center;" rowspan="2">Action</th>
                            </tr>
                            <tr align="center">
                                <th>KM Awal</th>
                                <th>KM Akhir</th>
                                <th>Isi</th>
                                <th>Pakai</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php 
                            foreach($solar as $solar){ 
                                $koef = $this->solar_model->get_kfsolar($solar->kfsolar)->row_array();
                                $mobil = $this->mobil_model->get_mobil_and_sopir($solar->mobil)->row_array();
                                
                                ?>
                            <tr>
                                <td align="center"><?php echo $solar->tanggal; ?></td>
                                <td><?php 
                                echo "DT-".$mobil['dt']."/".$mobil['type'];
                                echo "<br>";
                                echo $mobil['plat'];
                                echo "<br>";
                                echo "<b><i>( ".$mobil['nama_sopir']." )</i></b>";
                                 ?></td>
                                <td><?php echo number_format($solar->kmAwal,0)." KM"; ?></td>
                                <td><?php echo number_format($solar->kmAkhir,0)." KM"; ?></td>
                                <td align="center"><?php echo "<b>".number_format($koef['kfsolar'],0)."</b>"; ?></td>
                                <td align="center"><?php echo number_format($solar->isi,1)." Ltr"; ?></td>
                                <td align="center"><?php echo number_format($solar->pakai,1)." Ltr";?></td>
                                <td align="center"><button class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i> Details</button></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <!--  -->
            <!--  -->
            </div>
            <!--  -->
            <!--  -->
            <div class="row">
                
            </div>
        </div>
        </div>
</main>