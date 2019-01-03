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
                        <span>DT Sopir</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="add_sopir()">
                            <i class="fa fa-plus"></i> Sopir
                        </button>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="sopir">
                                <!-- Table head -->
                                <thead class="blue-grey lighten-4">
                                    <tr align="center">
                                        <th>#</th>
                                        <!-- <th>Foto</th> -->
                                        <th>Status</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kontak HP</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $sopir) {
                                        ?>
                                        <tr align="center"  valign="middle">
                                            <td><?php echo $no; ?></td>
                                            <!-- <td><?php //echo $sopir->foto; ?></td> -->
                                            <td><?php echo ($sopir->status==1 ? '<button type="button" class="btn btn-outline-success waves-effect btn-sm">Active</button>' : '<button type="button" class="btn btn-outline-warning waves-effect btn-sm">Non Active</button>' ); ?></td>
                                            <td><?php echo $sopir->nama_sopir; ?></td>
                                            <td><?php echo $sopir->hp; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" onclick="edit_sopir(<?php echo $sopir->id;?>)">Edit <i class="fa fa-edit"></i></button>
                                                <!-- <button type="button" class="btn btn-success btn-sm" onclick="view_sopir(<?php //echo $sopir->id;?>)">Details <i class="fa fa-eye"></i></button> -->
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