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
                        <span>Data Proyek</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="add_proyek()">
                            <i class="fa fa-plus"></i>Tambah Proyek Berjalan
                        </button>
                    </div>
                </div>
            </div>
        <!--  -->
        <div class="card">
                <div class="card-body">
                <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="proyek">
                <thead align="center">
                    <tr>
                        <th>#</th>
                        <th>Jangka</th>
                        <th>Pos</th>
                        <th>Keterangan</th>
                        <th>ID / Kode</th>
                        <th width="120">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    foreach($data as $data) { ?>
                    <tr>
                        <td align="center"><?php echo $no; ?></td>
                        <td align="center"><?php echo $data->tanggalMulai." s/d ".$data->tanggalBerakhir; ?></td>
                        <td><?php echo $data->nama_pos; ?></td>
                        <td>
                            <?php 
                            echo $data->keterangan;
                            echo "<hr>";
                            echo ($data->status==1? '<button class="btn waves-effect btn-sm btn-block btn-outline-success" >Finish</button>' : '<button class="btn waves-effect btn-sm btn-block btn-outline-warning" >On Progress</button>');
                            ?>
                        </td>
                        <td align="center" class="jm" ><?php 
                            echo $data->id;?></td>
                        <td align="center">
                        <?php if($data->status==0){ ?>
                        <button class="btn waves-effect btn-sm btn-outline-secondary" onclick="finish_proyek(<?php echo $data->id ?>)"><i class="fa fa-check"></i> Finish</button>
                    <?php } ?>
                        <a href="<?php echo site_url('proyek/details/'.$data->id); ?>" class="btn waves-effect btn-sm btn-outline-success" ><i class="fa fa-eye"></i> Details</a>
                        <button class="btn waves-effect btn-sm btn-outline-warning" onclick="edit_proyek(<?php echo $data->id ?>)"><i class="fa fa-edit"></i> Edit</button>
                        </td>
                    </tr>
                    <?php  $no++; } ?>
                </tbody>
                </table>
                </div>
        </div>
        <!--  -->
        </div>
</main>