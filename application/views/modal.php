<style>
form{
    font-size: 9px;
 }
 /*
span {
    font-size: 9px;
} */
</style>

<?php if($this->uri->segment(1)=='payroll'){?>
<!-- --> 
<div class="modal text-monospace fade right" id="export_payroll" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-warning" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Export Data</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <?php echo form_open('', array('id'=>'export_form_payroll')); ?>
                    <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Pilih Bulan</span>
                    </div>
                    <input type="text" id="pay" name="bulan" class="form-control" aria-label="Tanggal Export" aria-describedby="inputGroup-sizing-sm"/>
                    </div>
                    <!-- Default checked -->
                    <div class="input-group input-group-sm mb-3">
                    
                    <label class="bs-switch">
                    <input type="checkbox" name="xls" checked>
                    <span class="slider round"></span>
                    </label>
                    <p class="input-group-prepend">
                        <span>Aktifkan Jika Ingin Mengeksport Data Dalam Bentuk Format .xlsx (ms.excel)</span>
                    </p>
                    </div>
                </form>
                </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-sm btn-outline-success" onclick="export_data_payroll()">Export
                        <i class="fa fa-table"></i>
                    </a>
                    <a role="button" class="btn btn-sm btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>            
            </div>
            <!--/.Content-->
        </div>
</div>
<?php } ?>

    <!-- Side Modal Top Right Success-->
    <div class="modal text-monospace fade right" id="add_proyek" tabindex="1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Tambah Data Proyek Berjalan</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-gear fa-4x mb-3 animated rotateIn"></i>
                    </div>
                    <!-- Form -->
                    <?php echo form_open_multipart('', array('id'=>'form_proyek'));?>           
                    <div class="md-form form-sm">
                    <input type="text" name="nama_pos" id="nama_pos" class="form-control form-control-sm" >
                    <label for="nama_pos">Nama Pos</label>
                    </div>
                    <!--  -->
                    <div class="md-form form-sm">
                    <textarea name="keterangan" id="keterangan" class="form-control" cols="4" rows="2"></textarea>
                    <label for="keterangan">Keterangan</label>
                    </div>
                    <!--  --
                    <label for="tanggalMulai">Tanggal Mulai</label>
                    <!--  -->
                    <div class="md-form form-sm" style="padding:0px;">
                    <input type="text" name="tanggalMulai" id="startDate" class="form-control form-control-sm" placeholder="tanggal awal">
                    </div>

                    <!--  --
                    <label for="tanggalBerakhir">Tanggal Akhir</label>
                    <!--  -->
                    <div class="md-form form-sm" style="padding:0px;">
                    <input type="text" name="tanggalBerakhir" id="endDate" class="form-control form-control-sm" placeholder="tanggal akhir">
                    </div>
                    </form>
                    <!--  -->
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-sm btn-outline-success waves-effect" onclick="posting_proyek()">Simpan
                        <i class="fa fa-save"></i>
                    </a>
                    <a role="button" class="btn btn-sm btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- Side Modal Top Right Success-->


<!--  -->
    <!-- Side Modal Top Right Success-->
    <div class="modal text-monospace fade right" id="add_mobil" tabindex="1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Tambah Data Mobil DT</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-truck fa-4x mb-3 animated rotateIn"></i>
                    </div>
                    <!-- Form -->
                    <?php echo form_open_multipart('', array('id'=>'form_mobil'));?>
                    <!--  -->
                    <div class="md-form input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text md-addon">DT</span>
                        </div>
                        <input type="text" aria-label="Kode DT"  name="dt" class="form-control" placeholder="Kode DT">
                    </div>
                    <!--  -->                  
                    <div class="md-form form-sm">
                        <input type="text" name="plat" id="plat" class="form-control form-control-sm" >
                        <label for="plat">PLAT</label>
                    </div>
                    <!--  -->
                    <div class="md-form form-sm">
                        <input type="text" name="type" id="type" class="form-control form-control-sm">
                        <label for="type">Type</label>
                    </div>
                    <div class="md-form form-sm">
                    <select class="browser-default custom-select" name="status_mobil">
                    <option value="1" selected>Dump Truck</option>
                    <option value="2">Tangki Air</option>
                    </select>
                    </div>

                    <div class="md-form form-sm">
                    <select class="browser-default custom-select" name="status_mobil">
                    <option value="3" selected>Standby</option>
                    <option value="1">Aktif</option>
                    <option value="2">Rusak</option>
                    </select>
                    </div>
                    <!--  --
                    <div class="md-form form-sm">
                    <input type="text" name="type" id="type" class="form-control form-control-sm">
                    <label for="type">Sopir</label>
                    </div>
                     <!--  -->
                    <input type="hidden" name="mobil_id"/>
                    </form>
                    <!--  -->
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-outline-success waves-effect" onclick="posting_mobil()">Posting
                        <i class="fa fa-save"></i>
                    </a>
                    <a role="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- Side Modal Top Right Success-->



    <!-- Side Modal Top Right Success-->
    <div class="modal text-monospace fade right" id="add_sopir" tabindex="1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Tambah Data Sopir</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-user fa-4x mb-3 animated rotateIn"></i>
                    </div>
                    <!-- Form -->
                    <?php echo form_open_multipart('', array('id'=>'form_sopir'));?>
                    <!--  --
                    <div class="md-form input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text md-addon">DT</span>
                    </div>
                    <input type="text" aria-label="Kode DT"  name="dt" class="form-control" placeholder="Kode DT">
                    </div>
                    <!--  -->                  
                    <div class="md-form form-sm">
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm" >
                    <label for="nama">Nama Sopir</label>
                    </div>
                    <!--  -->
                    <div class="md-form form-sm">
                    <input type="text" name="hp" id="hp" class="form-control form-control-sm">
                    <label for="hp">No. Hp</label>
                    </div>
                    <!--  --
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" name="foto" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Foto Sopir</label>
                    </div>
                    </div>     
                     <!--  -->

                    <input type="hidden" name="sopir_id"/>
                    </form>
                    <!--  -->
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-success" onclick="posting_sopir()">Posting
                        <i class="fa fa-diamond ml-1"></i>
                    </a>
                    <a role="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- Side Modal Top Right Success-->

    <!-- Side Modal Top Right Success-->
    <div class="modal text-monospace fade right" id="add_tarif" tabindex="1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Tambah Data Tarif</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-money fa-4x mb-3 animated rotateIn"></i>
                    </div>
                    <!-- Form -->
                    <?php echo form_open('', array('id'=>'form_tarif'));?>
                    <div class="md-form input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text md-addon">Jarak (Km)</span>
                    </div>
                    <input type="number" step="any" name="minJarak" aria-label="minimal" class="form-control" placeholder="min">
                    <input type="number" step="any" name="maxJarak" aria-label="max" class="form-control" placeholder="maks">
                    </div>                    
                    <div class="input-group mb-3">
                    <select class="browser-default custom-select" id="inputGroupSelect02" name="hotmix">
                        <option selected>Choose...</option>
                        <option value="1">HOTMIX</option>
                        <option value="0">NON HOTMIX</option>
                    </select>
                    <div class="input-group-append">
                        <label class="input-group-text" for="inputGroupSelect02">Tipe</label>
                    </div>
                    </div>

                    <div class="md-form input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text md-addon">Rp.</span>
                    </div>
                    <input type="number" step="any" class="form-control" name="tarif" aria-label="Amount (to the nearest rupiah)">
                    <div class="input-group-append">
                        <span class="input-group-text md-addon">.00</span>
                    </div>
                    </div>
                    <input type="hidden" name="tarif_id"/>
                    </form>
                    <!--  -->
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-success" onclick="posting_tarif()">Posting
                        <i class="fa fa-diamond ml-1"></i>
                    </a>
                    <a role="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- Side Modal Top Right Success-->

    <!-- Side Modal Top Right Success-->
    <div class="modal text-monospace fade right" id="success" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-warning" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Success</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                    <i id="false" class="fa fa-time fa-4x mb-3 animated rotateIn"></i>
                    <i id="true" class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
                        <p id="message">
                        </p>
                    </div>
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-block btn-outline-success waves-effect" data-dismiss="modal">
                        thanks</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- Side Modal Top Right Success-->
<?php if($this->uri->segment(1)=='mobil'){?>
    <!-- Side Modal Top Right Success-->
    <div class="modal text-monospace fade right" id="update_sopir_mobil" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-warning" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Pilih Sopir</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <?php echo form_open('', array('id'=>'form_mobil_sopir')); ?>
                    <div class="text-left">
                    <p>Input Data Sopir untuk <br> 
                    DT-<b id="dt_mobil"></b> <br> 
                    Plat Nomor : <b id="plat_mobil"></b> <br>
                    Type : <b id="type_mobil"></b></p>
                    </div>
                    <input type="hidden" name="id_mobil">
                    <hr>
                    <select class="browser-default custom-select" name="sopir" id="select2" style="width:100%;">
                    <option >Pilih Sopir Aktif</option>
                    <?php
                    foreach ($sopir as $so) {
                        echo '<option value="'.$so->id.'">'.$so->nama_sopir.'</option>';
                    }
                    ?>
                    </select>
                </form>
                </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-outline-success" onclick="posting_sopir_mobil()">Posting
                        <i class="fa fa-save"></i>
                    </a>
                    <a role="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- Side Modal Top Right Success-->
<?php } ?>


<?php if($this->uri->segment(1)=='dt'){?>

<!--  -->



    <!-- Side Modal Top Right Success-->
    <div class="modal text-monospace fade right" id="import_dt_excel" tabindex="1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-success" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Import File Excel DT Record</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-table fa-4x mb-3 animated rotateIn"></i>
                    </div>
                    <!-- Form -->
                    <?php echo form_open_multipart('', array('id'=>'form_import_dt'));?>           
                    <div class="md-form form-sm">
                    <input type="text" name="nama_file" id="nama_file" class="form-control form-control-sm" >
                    <label for="nama_file">Nama File</label>
                    </div>
                    <!--  -->
                    
                    <div class="md-form form-sm" style="padding:0px;">
                    <p class="label">
                    Import File Format Excel (.xlsx)
                    </p>
                    </div>

                    <div class="md-form form-sm" style="padding:0px;">
                    <input type="file" name="excel_dt" id="excel" class="form-control form-control-sm" placeholder="file .xlsx">
                    </div>
                    </form>
                    <!--  -->
                </div>

                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-sm btn-outline-success waves-effect" onclick="import_excel()">Import Data
                        <i class="fa fa-upload"></i>
                    </a>
                    <a role="button" class="btn btn-sm btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!-- Side Modal Top Right Success-->



<!-- --> 
<div class="modal text-monospace fade right" id="export" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-side modal-top-right modal-notify modal-warning" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <p class="heading lead">Export Data</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <?php echo form_open('', array('id'=>'export_form')); ?>
                    <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Start Date</span>
                    </div>
                    <input type="text" id="startDate1" name="startDate" class="form-control" aria-label="Tanggal Export" aria-describedby="inputGroup-sizing-sm"/>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">End Date</span>
                    </div>
                    <input type="text" id="endDate1" name="endDate" class="form-control" aria-label="Tanggal Export" aria-describedby="inputGroup-sizing-sm"/>
                    </div>

                    <!-- Default checked -->
                    <div class="input-group input-group-sm mb-3">
                    
                    <label class="bs-switch">
                    <input type="checkbox" name="xls" checked>
                    <span class="slider round"></span>
                    </label>
                    <p class="input-group-prepend">
                        <span>Aktifkan Jika Ingin Mengeksport Data Dalam Bentuk Format .xlsx (ms.excel)</span>
                    </p>
                    </div>
                </form>
                </div>
                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                    <a role="button" class="btn btn-sm btn-outline-success" onclick="export_data_dt()">Export
                        <i class="fa fa-table"></i>
                    </a>
                    <a role="button" class="btn btn-sm btn-outline-warning waves-effect" data-dismiss="modal">No,
                        thanks</a>
                </div>            
            </div>
            <!--/.Content-->
        </div>
</div>

<!-- Danger Demo-->
<div class="modal text-monospace fade bottom" id="dt_record" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-full-height modal-top modal-notify modal-primary" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Record DT</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">               
                <?php echo form_open('', array('id'=>'form_dt'));?>
                <div class="container">
                <div class="row">

                    <div class="col-md-3">
                    <!--  -->
                    <div class="md-form input-group mb-3" id="no_tiket">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">No Tiket</span>
                                </div>
                                <input type="text" class="form-control" name="no_tiket" aria-label="no_tiket">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                    <input type="text" id="tanggal" name="tanggal" class="datepicker" required/>
                    <hr>
                    <!--  START md4 -->
                       <div class="form-group">
                            <label for="">Mobil DT</label>
                            <select class="browser-default custom-select" id="select2" style="width:100%" name="mobil" onchange="mobil_value()" required>
                        <option selected>Pilih Mobil</option>
                        <?php foreach ($mobil_sopir as $mobil) {
                            echo "<option value='".$mobil->id."'>".$mobil->plat."/".$mobil->nama_sopir."</option>";
                        }
                        ?>
                        </select>   
                       </div>        
                       <div class="form-group" id="type_bawaan">
                        <label for="">Type Bawaan</label>
                        <select name="type_bawaan" id="select2" class="form-control" onchange="type_tarif()">
                        <option selected>Type Bawaan</option>
                        <option value="0">Non Hotmix</option>
                        <option value="1">Hotmix</option>
                        <option value="2">Transport</option>
                        </select>
                       </div>         
                    <!--  -->
                    <hr>
                        <div class="row">
                            <div class="col-md-4">
                            <label class="bs-switch">
                            <input type="checkbox" name="status_standby_dt">
                            <span class="slider round"></span>
                            </label>
                            </div>
                            <div class="col-md-8">
                            <div class="input-group-prepend">
                                 <span> Aktifkan Jika Status Mobil Standby / Rusak</span>
                            </div>
                            </div>
                        </div>
                                    
                   
                    </div>
                     <!--  END MD4 -->
                    <div class="col-md-6">
                        <!-- <div class="text-center">
                            <i class="fa fa-truck fa-4x mb-3 animated rotateIn"></i>
                        </div> -->
                        <div class="row">
                            <div class="col-md-6">
                            <!--  -->
                            <div class="md-form input-group mb-3" id="dari">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Dari</span>
                                </div>
                                <input type="text" class="form-control" name="dari" aria-label="Dari">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <div class="md-form input-group mb-3" id="berangkat">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Berangkat</span>
                                </div>
                                <input type="text" class="form-control" name="berangkat" aria-label="berangkat">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon">WIB</span>
                                </div>
                                </div>
                                <!--  -->
                                <div class="md-form input-group mb-3" id="membawa">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Membawa</span>
                                </div>
                                <input type="text" class="form-control" name="membawa" aria-label="membawa">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <!--  -->
                                <div class="md-form input-group mb-3" id="pengirim">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Pengirim</span>
                                </div>
                                <input type="text" class="form-control" name="pengirim" aria-label="pengirim">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <!--  -->
                                <div class="md-form input-group mb-3" id="jarak">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Jarak</span>
                                </div>
                                <input type="number" step="any"  class="form-control" name="km" aria-label="km" onchange="km_count()">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon">KM</span>
                                </div>
                                </div>
                                <!--  -->
                                 <!--  -->
                                 <div class="md-form input-group mb-3" id="jumlah_kirim">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Jumlah Kirim</span>
                                </div>
                                <input type="number" step="any"  class="form-control" name="jumlah_kirim" aria-label="jumlah_kirim" >
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <!--  -->
                                <div class="md-form input-group mb-3" id="isi_solar">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Isi Solar</span>
                                </div>
                                <input  type="number" step="any"  class="form-control" name="isi_solar" aria-label="isi_solar">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon">Liter</span>
                                </div>
                                </div>
                                <!--  --> 
                               </div>
                            <!--  -->
                            <div class="col-md-6">
                            <!--  -->
                            <div class="md-form input-group mb-3" id="tujuan">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Tujuan</span>
                                </div>
                                <input type="text" class="form-control" name="tujuan" aria-label="Tujuan">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <div class="md-form input-group mb-3" id="sampai">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Sampai</span>
                                </div>
                                <input type="text" class="form-control" name="sampai" aria-label="sampai" onchange="status_lembur()">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon">WIB</span>
                                </div>
                                </div>
                                <div class="md-form input-group mb-3" id="untuk">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Untuk </span>
                                </div>
                                <input type="text" class="form-control" name="untuk" aria-label="untuk">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <!--  -->
                                <div class="md-form input-group mb-3" id="penerima">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Penerima</span>
                                </div>
                                <input type="text" class="form-control" name="penerima" aria-label="penerima">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <!--  -->
                                <div class="md-form input-group mb-3" id="rit">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Rit</span>
                                    
                                </div>
                                <input type="number" step="any"  class="form-control" name="rit" aria-label="rit" onchange="rit_count()" >
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="pp" class="custom-control-input" id="defaultchecked" checked>
                                        <label class="custom-control-label" for="defaultchecked">PP/P</label>
                                    </div>
                                    </span>
                                </div>
                                </div>
                                <!--  -->
                                 <!--  -->
                                 <div class="md-form input-group mb-3" id="satuan_kirim">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Satuan</span>
                                </div>
                                <input type="text"  class="form-control" name="satuan_kirim" aria-label="satuan_kirim" >
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon"></span>
                                </div>
                                </div>
                                <!--  -->
                                <!--  -->
                                <div class="md-form input-group mb-3" id="pakai_solar">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Pakai Solar</span>
                                </div>
                                <input type="number" step="any"  class="form-control" name="pakai_solar" aria-label="pakai_solar">
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon">Liter</span>
                                </div>
                                </div>
                                <!--  --> 
                            </div>
                        <!--  -->
                        <div class="md-form input-group mb-3" id="isRusak" style="display:none">
                                <div class="input-group-prepend">
                                    <span class="input-group-text md-addon">Keterangan</span>
                                </div>
                                <input type="text" class="form-control" name="isRusak" aria-label="isRusak" />
                                <div class="input-group-append">
                                    <span class="input-group-text md-addon">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="isStandby" class="custom-control-input" id="rusak" />
                                        <label class="custom-control-label" for="rusak">Rusak</label>
                        
                                     </div>
                                    </span>
                                </div>                                
                        </div>
                        <!--  -->
                        <center>
                        <!-- <div class="input-group" id="isStandby" style="display:none">
                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="isStandby" class="custom-control-input" id="rusak" />
                                        <label class="custom-control-label" for="rusak">Checklist jika Rusak</label>
                        
                         </div>
                         </div> -->
                         </center>
                         <!--  -->

                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                    <div class="card-body">
                    <div class="form-group">
                        <label for="">DT Detail</label>

                        <ul class="list-group z-depth-0">
                            <li class="list-group-item justify-content-between" id="dt_notif">
                            </li>
                            <li class="list-group-item justify-content-between" id="plat_notif" >
                            </li>
                        </ul>
                        
                    </div>

                    <div class="form-group">
                        <label for="">Ritasi</label>
                        <ul class="list-group z-depth-0">
                            <li class="list-group-item justify-content-between" id="tarif_km">
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="">Total Ritasi</label>
                        <ul class="list-group z-depth-0">
                            <li class="list-group-item justify-content-between" id="total_ritasi">
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="">Status Kerja</label>
                        <ul class="list-group z-depth-0">
                            <li class="list-group-item justify-content-between" id="status_kerja">
                            </li>
                        </ul>
                    </div>
                    <div class="form-group" id="pos_proyek">
                        <label for="select3">Pos Proyek</label>
                        <select class="browser-default custom-select" id="select3" style="width:100%" name="pos">
                        <option selected>Pilih Proyek</option>
                        <?php foreach ($pos_proyek as $pos) {
                            echo "<option value='".$pos->id."'>".$pos->nama_pos."/".$pos->keterangan."</option>";
                        }
                        ?>
                        </select>  
                    </div>
                       
                    </div>
                    </div>
                    </div>
                </div>
                </div>
                <input type="hidden" name="tarif_id">
                <input type="hidden" name="gaji_id">
                <input type="hidden" name="bor">
                <input type="hidden" name="isLembur">
                <input type="hidden" name="tambahan">
                </form>
            </div>

            <!--Footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-success" onclick="posting_dt()">Posting
                    <i class="fa fa-upload"></i>
                </button>
                <a role="button" class="btn btn-sm btn-outline-danger waves-effect" data-dismiss="modal">No,
                    thanks</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

<?php } ?>