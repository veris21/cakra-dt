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
                        <span>DT Mobil</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="add_mobil()">
                            <i class="fa fa-plus"></i> Mobil
                        </button>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="mobil">
                                <!-- Table head -->
                                <thead class="blue-grey lighten-4">
                                    <tr align="center">
                                        <th>#</th>
                                        <th>DT</th>
                                        <th>PLAT</th>
                                        <th>Type</th>
                                        <th>Sopir</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $mobil) {
                                        switch ($mobil->status) {
                                            case 1:
                                                $status_mobil = '<button type="button" class="btn btn-outline-success waves-effect btn-sm" onclick="status_mobil_update('.$mobil->id.')">Active</button>';
                                                break;
                                                case 2:
                                                $status_mobil = '<button type="button" class="btn btn-outline-danger waves-effect btn-sm" onclick="status_mobil_update('.$mobil->id.')">Rusak</button>';
                                                break;
                                                case 3:
                                                $status_mobil = '<button type="button" class="btn btn-outline-warning waves-effect btn-sm" onclick="status_mobil_update('.$mobil->id.')">Stand By</button>';
                                                break;
                                            default:
                                                # code...
                                                break;
                                        }
                                        $supir = $this->sopir_model->get_sopir_one($mobil->sopir)->row_array();
                                        if($supir!=null){
                                            $nama_supir = "<b>".$supir['nama_sopir']."</b>";
                                        }else {
                                            $nama_supir = '<button type="button" class="btn btn-outline-info waves-effect btn-sm" onclick="sopir_mobil_add('.$mobil->id.')">Kosong</button>';
                                        }
                                        ?>
                                        <tr align="center"  valign="middle">
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $mobil->dt; ?></td>
                                            <td><b><?php echo $mobil->plat; ?></b></td>
                                            <td>
                                            <?php 
                                            echo $mobil->type; 
                                            echo '<br>';
                                            echo ($mobil->dt_type==1 ? '<button class="btn btn-outline-warning waves-effect btn-sm">Dump Truck</button>':'<button class="btn btn-outline-info waves-effect btn-sm">Tangki Air</button>');
                                            ?>
                                            </td>
                                            <td><?php echo $nama_supir; ?></td>
                                            <td><?php echo $status_mobil; ?></td>
                                            <td width="70">
                                                <button type="button" class="btn btn-warning btn-sm" onclick="edit_mobil(<?php echo $mobil->id;?>)">Edit <i class="fa fa-edit"></i></button>
                                                <button type="button" class="btn btn-success btn-sm" onclick="view_mobil(<?php echo $mobil->id;?>)">Details <i class="fa fa-eye"></i></button>
                                            </td>
                                        </tr>
                                       <?php
                                       $no++;
                                    }
                                    ?>
                                </tbody>
                </table>
                </div>
            </div>
        </div>
</main>