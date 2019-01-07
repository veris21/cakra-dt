    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/jquery-3.3.1.min.js';?>"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/popper.min.js';?>"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/bootstrap.js';?>"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/mdb.js';?>"></script>
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/moment.min.js';?>"></script>
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/addons/datatables.js';?>"></script>
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/addons/select2.min.js';?>"></script>
    <script type="text/javascript" src="<?php echo site_url().ASSETS.'js/gigjo.min.js';?>"></script>
    <script type="text/javascript" src="<?php //echo site_url().ASSETS.'js/addons/bootstrap-datetimepicker.min.js';?>"></script>
    <!-- Initializations -->
    <script type="text/javascript">
    var isOnline = window.navigator.onLine;
        if (isOnline) {
        $('#status_online').html('<button class="btn btn-outline-success btn-sm btn-flat">ONLINE</button>');
        } else {
            $('#status_online').html('<button class="btn btn-outline-danger btn-sm btn-flat">OFFLINE</button>');
        }
        var isHotmix;
        var rit;
        var km;
        var tarif_id;
        var total_ritasi;
        var tarif;
        var pp = 2;
        var status_kerja;
        var jamAwal;
        var jamAkhir;
        var jamkerja;
        var jamberangkat;
        var bulan = '';
        var gaji_id = '';
        var mobil_id;
        var obj;
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#true').hide();
        $('#false').hide();
        // Animations initialization
        new WOW().init();
//  =============================================
//  ============= [ TABLE FACTORY ] ===============
        $('#proyek_detil').DataTable({
            responsive: true
        });

        $('#payroll_list').DataTable({
            responsive: true
        });

        $('#tarif').DataTable({
            responsive: true
        });

        $('#gaji_pokok').DataTable({
            responsive: true
        });

        $('#sopir').DataTable({
            responsive: true
        });

        $('#proyek').DataTable({
            responsive: true
        });

        $('#dt_list').DataTable({
            responsive: true
        });

        $('#mobil').DataTable({
            responsive: true
        });

        $('#solar_list').DataTable({
            responsive: true
        });

        $('#kfsolar_list').DataTable({
            responsive: true
        });

//  =============================================
$('#select2').select2();        
$('#select3').select2();
//  ============= [ ADD FACTORY ] ===============
        function add_tarif(){
            $('#add_tarif').modal('show');
        }

        function add_sopir(){
            $('#add_sopir').modal('show');
        }

        function add_mobil(){
            $('#add_mobil').modal('show');
        }

        function get_gaji_ref(){

        }

        function posting_tarif(){
            $('#add_tarif').modal('hide');
            $.ajax({
                url: '<?php echo site_url('tarif/input');?>',
                type: 'POST',
                dataType: 'JSON',
                data: $('#form_tarif').serialize(),
                success : function(data){
                    $('#form_tarif')[0].reset();
                    location.reload();
                }
            });
        }

        function posting_sopir(){
            $('#add_sopir').modal('hide');
            $.ajax({
                url: '<?php echo site_url('sopir/input');?>',
                type: 'POST',
                dataType: 'JSON',
                data: $('#form_sopir').serialize(),
                success : function(data){
                    $('#form_sopir')[0].reset();
                    location.reload();
                }
            });
        }

        function posting_mobil(){
            $('#add_mobil').modal('hide');
            $.ajax({
                url: '<?php echo site_url('mobil/input');?>',
                type: 'POST',
                dataType: 'JSON',
                data: $('#form_mobil').serialize(),
                success : function(data){
                    $('#form_mobil')[0].reset();
                    location.reload();
                }
            });
        }

        function sopir_mobil_add(id_m){
            // alert(id_m);
            // die;
            $('#form_mobil_sopir')[0].reset();
            $('#dt_mobil').text('');
            $('#plat_mobil').text('');
            $('#type_mobil').text('');
            $.ajax({
                url: '<?php echo site_url('mobil/get_one/'); ?>'+id_m,
                // type:'POST',
                // dataType: 'JSON',
                success: function(data){
                    // console.log(mb);
                    var mb = JSON.parse(data);
                    $('[name="id_mobil"]').val(mb.id);
                    $('#dt_mobil').text(mb.dt);
                    $('#plat_mobil').text(mb.plat);
                    $('#type_mobil').text(mb.type);
                    $('#update_sopir_mobil').modal('show');
                }
            });
        }

        function posting_sopir_mobil(){
            $.ajax({
                url: '<?php echo site_url('mobil/sopir/input'); ?>',
                type:'POST',
                data : $('#form_mobil_sopir').serialize(),
                success: function(){
                    $('#form_mobil_sopir')[0].reset();
                    location.reload();
                }
            });
        }

        function status_mobil_update(id){
            alert(id);
        }

        function add_dt(){
            $('#dt_record').modal('show');
        }

        function posting_dt(){
            swal({
                title: 'Apa Anda Yakin?',
                text: "Pastikan Data yang dimasukkan Benar, data akan digenerate secara otomatis kedalam sistem !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Simpan!'
            }, function isConfirm() {
            $.ajax({
                url: '<?php echo site_url('dt/record'); ?>',
                type:'POST',
                data : $('#form_dt').serialize(),
                success: function(data){
                    console.log(data);
                    $('#form_dt')[0].reset();
                    location.reload();
                }
            });
            });
        }

        function mobil_value(){
            $('[name="gaji_id"]').val('');
            mobil_id = $('[name="mobil"]').val();
            bulan = $('[name="tanggal"]').val();
            $.ajax({
                url: '<?php echo site_url('mobil/get/'); ?>'+mobil_id+'/'+bulan,
                success: function (data){
                    var mobil = JSON.parse(data);
                    // console.log(mobil);
                    if(mobil.data.dt_type==2){
                        // jamAkhir = moment('15:30', ['h:m a', 'H:m']);
                        // jamAwal = moment('07:30', ['h:m a', 'H:m']);
                        jamAwal = '07:30';
                        jamAkhir = '15:30';
                        jamkerja = null;
                        $('#dt_notif').text('DT-Tangki Air ('+ mobil.data.type+')');
                        $('#plat_notif').text(mobil.data.plat);
                        // $('#plat').show();
                        $('#dt_notif').show();
                    }else{
                        jamAwal = '07:00';
                        jamAkhir = '17:00';
                        jamkerja = null;
                        $('#dt_notif').text('DT-Dump Truck ('+ mobil.data.type+')');
                        $('#plat_notif').text(mobil.data.plat);
                        // $('#plat').show();
                        $('#dt_notif').show();
                    }

                    if(mobil.gaji == null){
                        $.ajax({
                            url: '<?php echo site_url('gaji/init'); ?>',
                            type: 'POST',
                            dataType:'JSON',
                            data : {
                                mobil: mobil.data.id,
                                bulan: bulan
                            },
                            success: function(x){
                                console.log(x);
                                $('[name="gaji_id"]').val(x.id);
                            }
                        });
                    }else{
                        $('[name="gaji_id"]').val(mobil.gaji.id);
                    }
                }
            });
        }


        function export_payroll(){
            $('#export_form_payroll')[0].reset();
            $('#export_payroll').modal('show');
        }

        function export_data_payroll(){
            $('#export_payroll').modal('hide');
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: $('#export_form_payroll').serialize(),       
                url: '<?php echo site_url('payroll/export/excel');?>',
                success: function (results) {
                    console.log(results);
                    window.location.replace('<?php echo base_url(); ?>'+results.link);          
                }
            });
        }

        function export_dt(){
            $('#export').modal('show');
        }

        function export_data_dt(){
            $('#export').modal('hide');
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: $('#export_form').serialize(),       
                url: '<?php echo site_url('dt/export');?>',
                success: function (results) {
                    // console.log(results);
                    // window.location.replace('<?php echo base_url(); ?>'+results.link);      
                    window.open('<?php echo base_url(); ?>'+results.link,'_blank'); 
                }
            });
        }

        function backup(){
            $.ajax({
                url: '<?php echo site_url('backup');?>',
                success : function(data){
                    obj = JSON.parse(data);
                    if(obj.status !=true){
                        $('#true').hide();
                        $('#false').show();
                    }else{
                        $('#true').show();
                        $('#false').hide();
                    }
                    $('#message').text(obj.message);
                    $('#success').modal('show');
                    // console.log(data);
                }
            });
        }


        $('#tanggal').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'yyyy-mm-dd',
            // minDate: today,
            // maxDate: function () {
            //     return $('#endDate').val();
            // }
        });
        
        $('.datepicker').datepicker();

        $('#pay').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm',
        });

        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            // minDate: today,
            maxDate: function () {
                return $('#endDate').val();
            }
        });

        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            minDate: function () {
                return $('#startDate').val();
            }
        });

        $('#startDate1').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            // minDate: today,
            maxDate: function () {
                return $('#endDate').val();
            }
        });
        $('#endDate2').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            minDate: function () {
                return $('#startDate').val();
            }
        });

        $('#startDate2').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            // minDate: today,
            maxDate: function () {
                return $('#endDate').val();
            }
        });

        $('#endDate1').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd',
            minDate: function () {
                return $('#startDate').val();
            }
        });

        $('[name="status_standby_dt"]').change(function() {
        if($(this).is(":checked")) {
            // var returnVal = confirm("Are you sure?");
            // $(this).attr("checked", returnVal);
            $('#dari').hide();        
            $('#berangkat').hide();        
            $('#membawa').hide();        
            $('#pengirim').hide();        
            $('#penerima').hide();        
            $('#rit').hide();        
            $('#isi_solar').hide();        
            $('#pakai_solar').hide();
            $('#sampai').hide();        
            $('#untuk').hide();        
            $('#jarak').hide();  
            $('#tujuan').hide();
            $('#pos_proyek').hide();
            $('#jumlah_kirim').hide();        
            $('#satuan_kirim').hide();   
            $('#type_bawaan').hide();        
            $('#isRusak').show();     
            $('#isStandby').show(); 
        }else{
            $('#isStandby').hide();
            $('#isRusak').hide();
            $('#pos_proyek').show();
            $('#tujuan').show();
            $('#dari').show();        
            $('#berangkat').show();        
            $('#membawa').show();        
            $('#pengirim').show();        
            $('#penerima').show();        
            $('#rit').show();        
            $('#isi_solar').show();        
            $('#pakai_solar').show();
            $('#sampai').show();        
            $('#untuk').show();        
            $('#jarak').show();        
            $('#jumlah_kirim').show();        
            $('#satuan_kirim').show();        
            $('#type_bawaan').show();        
        }
        });

        function type_tarif(){
            isHotmix = $('[name="type_bawaan"]').val();
            $('[name="km"]').val('');
            $('[name="rit"]').val('');
            $('#tarif_km').html('Rp.0,-');
            $('#total_ritasi').html('Rp.0,-')
            rit = 0;
            km = 0;
            total_ritasi = 0;
        }

        $('[name="pp"]').change(function() {
            if($(this).is(":checked")) {
                return pp = 2;
            }else{
               return pp = 1;
            }
        });

        function km_count(){
            rit = 0;
            tarif = 0;
            total_ritasi = 0;
            $('[name="tarif_id"]').val('');
            $('[name="rit"]').val('');
            $('#tarif_km').html('Rp.0,-');
            $('#total_ritasi').html('Rp.0,-')
            km = $('[name="km"]').val();
            $.ajax({
                url: '<?php echo site_url('tarif/get');?>',
                type: 'POST',
                dataType:'JSON',
                data: {
                    isHotmix : isHotmix,
                    km : km
                },
                success: function(data){
                    // var data = JSON.parse(x);
                    console.log(data);
                    tarif_id = data.id;
                    tarif = data.tarif;
                    $('[name="tarif_id"]').val(tarif_id);
                    $('#tarif_km').html('<b><i>Rp.'+parseInt(tarif).toLocaleString()+' /Km</i></b>');
                }
            });
            // console.log('KM:'+km+ 'Type : '+isHotmix);
        }
        
        function status_lembur(){
                $('[name="tambahan"]').val('');
                $('[name="isLembur"]').val('');
                $('#status_kerja').text('');
                var jamkerja = $('[name="sampai"]').val();
                var jamberangkat = $('[name="berangkat"]').val();

                $.ajax({
                    url: '<?php echo site_url('check/lembur');?>',
                    dataType: 'JSON',
                    type: 'POST',
                    data: {
                        bulan: bulan,
                        isHotmix: isHotmix,
                        mobil_id : mobil_id,
                        jamkerja : jamkerja,
                        jamberangkat: jamberangkat,
                        jamAkhir : jamAkhir,
                        jamAwal: jamAwal
                    },
                    success: function(data){
                        $('[name="tambahan"]').val(data.tambahan);
                        console.log(data);
                        $('#status_kerja').text(data.status_lembur);
                        $('[name="isLembur"]').val(data.status_lembur);
                    }
                });
        }

        function rit_count(){
            rit = $('[name="rit"]').val();
            total_ritasi = parseInt((rit*tarif)).toLocaleString();
            $('#total_ritasi').html('<b><i>Rp.'+total_ritasi+'</i></b> <span class="pull-right">   Total : '+(km*pp)*rit+' KM</span>');
        }

        function print_payroll(id) {
            swal({
                title: 'Apa Anda Yakin?',
                text: "Dengan Mencetak Maka Status AKan Otomatis Menjadi Dibayarkan !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Cetak!'
            }, function isConfirm() {
            //     $.ajax({
            //     url: '<?php echo site_url('payroll/export/pdf/'); ?>'+id,
            //     success: function(data){
            //         console.log(data);
                    
            //     }
            // });
            // location.replace('<?php echo site_url('payroll/export/pdf/'); ?>'+id,'__blank');
            window.open('<?php echo site_url('payroll/export/pdf/'); ?>'+id,'_blank');
            });
            
        }

        function print_dt(id) {
            swal({
                title: 'Apa Anda Yakin?',
                text: "Mencetak Data DT Per Tanggal !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Cetak!'
            }, function isConfirm() {
                // window.open('<?php echo site_url('payroll/export/pdf/'); ?>'+id,'_blank');
            });
        }

        function rm_data(){
            $.ajax({
                url: '<?php echo site_url('reset'); ?>',
                success: function(data){
                    location.reload();
                }
            });
        }

        function add_proyek(){
            $('#form_proyek')[0].reset();
            $('#add_proyek').modal('show');
        }

        function posting_proyek(){
            $.ajax({
                url: '<?php echo site_url('proyek/input');?>',
                type: 'POST',
                dataType: 'JSON',
                data: $('#form_proyek').serialize(),
                success: function(){
                    location.reload();
                }
            });
        }
        function lakukan_pembayaran(id){
            location.reload();
            window.open('<?php echo site_url('payroll/export/pdf/'); ?>'+id,'_blank');
        }


        function form_import_dt(){
            $('#form_import_dt')[0].reset();
            $('#import_dt_excel').modal('show');

        }

        function form_import_data_solar(){
            $('#form_import_solar')[0].reset();
            $('#import_table_solar').modal('show');
        }

        function import_excel(){
            $('#form_import_dt')[0].reset();
        }
    </script>