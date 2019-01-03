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
                        <span>Tarif DT</span>
                    </h4>
                    <div class="d-flex justify-content-center">
                        <!-- Default input -->
                        <button class="btn btn-primary btn-sm my-0 p" type="button" onclick="add_tarif()">
                            <i class="fa fa-plus"></i> Tarif
                        </button>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                    <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="tarif">
                                    <!-- Table head -->
                                    <thead class="blue-grey lighten-4">
                                        <tr align="center">
                                            <th>#</th>
                                            <th>Tipe</th>
                                            <th>Jarak</th>
                                            <th>Tarif</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data as $tarif) {
                                            switch ($tarif->hotmix) {
                                                case 0:
                                                $isHotmix = '<button type="button" class="btn btn-outline-warning waves-effect btn-sm">Non Hotmix</button>';
                                                    break;
                                                    case 1:
                                                    $isHotmix = '<button type="button" class="btn btn-outline-success waves-effect btn-sm">Hotmix</button>';
                                                    break;

                                                    case 2:
                                                    $isHotmix = '<button type="button" class="btn btn-outline-info waves-effect btn-sm">Transport</button>';
                                                    break;
                                                    default:
                                                    # code...
                                                    break;
                                            }
                                            // $isHotmix = ($tarif->hotmix == 1 ? '<button type="button" class="btn btn-outline-success waves-effect btn-sm">Hotmix</button>' : '<button type="button" class="btn btn-outline-warning waves-effect btn-sm">Non Hotmix</button>');
                                            ?>
                                            <tr align="center"  valign="middle">
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $isHotmix; ?></td>
                                                <td><?php echo $tarif->minJarak." - ".$tarif->maxJarak." KM"; ?></td>
                                                <td><?php echo "Rp.".number_format($tarif->tarif, 0); ?></td>
                                                <td><button type="button" class="btn btn-warning btn-sm" onclick="edit_tarif(<?php echo $tarif->id;?>)">Edit <i class="fa fa-edit"></i></button></td>
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
                <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                    <table style="width:100%" class="display table table-bordered table-sm table-striped table-responsive-sm" id="gaji_pokok">
                                    <!-- Table head -->
                                    <thead class="blue-grey lighten-4">
                                        <tr align="center">
                                            <th>Type</th>
                                            <th>Besaran Pokok</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($pokok as $pokok) {
                                            echo "<tr>";
                                            echo "<td>".$pokok->type."</td>";
                                            echo "<td>Rp.".number_format($pokok->pokok, 2)."</td>";
                                            echo "<td><button class='btn btn-sm btn-warning'>Edit <i class='fa fa-edit'></button></td>";
                                            echo "</tr>";
                                        }
                                         ?>
                                    </tbody>
                    </table>
                    </div>
                </div>
                </div>
                </div>
        </div>
</main>