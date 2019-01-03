<!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>DT-DB</title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url().'application/assets/css/bootstrap.css'; ?>" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="<?php echo site_url().'application/assets/css/mdb.css'; ?>" rel="stylesheet">

 <style type="text/css">
    html,
    body,
    header,
    .view {
      height: 100%;
    }

    @media (max-width: 740px) {
      html,
      body,
      header,
      .view {
        height: 1000px;
      }
    }

    @media (min-width: 800px) and (max-width: 850px) {
      html,
      body,
      header,
      .view {
        height: 650px;
      }
    }
    @media (min-width: 800px) and (max-width: 850px) {
              .navbar:not(.top-nav-collapse) {
                  background: #1C2331!important;
              }
          }
  </style>
 </head>
 <body>
     
 <!-- Full Page Intro -->
 <div class="view full-page-intro" style="background-image: url('<?php echo site_url("application/assets/img/aspalt.jpg");?>'); background-repeat: no-repeat; background-size: cover;">

<!-- Mask & flexbox options-->
<div class="mask rgba-black-light d-flex justify-content-center align-items-center">
  <!-- Content -->
  <div class="container">
    <!--Grid row-->
    <div class="row wow fadeIn">
      <!--Grid column-->
      <div class="col-md-6 mb-4 white-text text-center text-md-left">
        <h1 class="display-4 font-weight-bold">Simple Truck & Load Management System <br>
        with DT-DB</h1>
        <hr class="hr-light">
        <p>
          <strong>Simple & responsive data and management load design</strong>
        </p>
        <p class="mb-4 d-none d-md-block">
          <strong>DT-DB adalah sistem informasi management arus trayek Dump Truck dengan UI/UX simple dan mudah digunakan. meliputi management jarak, multi stage pembayaran pengemudi, manajemen jarak dan history trayek serta kemampuan export data dalam bentuk pdf dan .xlsx</strong>
        </p>

        <button type="button" onclick="open_register()" class="btn btn-indigo btn-lg">Validasi Akun DT
          <i class="fa fa-upload ml-2"></i>
        </button>

      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-md-6 col-xl-5 mb-4">

        <!--Card-->
        <div class="card">

          <!--Card content-->
          <div class="card-body">

            <!-- Form -->
            <?php echo form_open('', array('id'=>'login_form')); ?>
              <!-- Heading -->
              <center>
              <img src="<?php echo site_url().'application/assets/img/logo.png';?>" class="img-fluid" alt="">
              </center>
              <hr>
              <h3 class="dark-grey-text text-center">
                <strong>Masuk Sistem</strong>
              </h3>
              <hr>

              <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" name="username" id="username" class="form-control">
                <label for="username">User ID</label>
              </div>
              <div class="md-form">
                <i class="fa fa-envelope prefix grey-text"></i>
                <input type="password" name="password" id="pass" class="form-control">
                <label for="pass">Your email</label>
              </div>
              <div class="text-center">
                <button class="btn btn-indigo" type="button" onclick="login()">Log In</button>
                <hr>
              </div>

            </form>
            <!-- Form -->
            <?php echo form_open('', array('id'=>'register_form','style'=>'display:none')); ?>
              <!-- Heading -->
              <center>
              <img src="<?php echo site_url().'application/assets/img/logo.png';?>" class="img-fluid" alt="">
              </center>
              <hr>
              <h3 class="dark-grey-text text-center">
                <strong>Validasi Akun</strong>
              </h3>
              <hr>
              <div class="md-form">
                <i class="fa fa-key prefix grey-text"></i>
                <input type="text" id="keygen" class="form-control">
                <label for="keygen">Keygen</label>
              </div>

              <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="usernameReg" class="form-control">
                <label for="usernameReg">User ID</label>
              </div>
              <div class="md-form">
                <i class="fa fa-envelope prefix grey-text"></i>
                <input type="password" id="passReg" class="form-control">
                <label for="passReg">Your Password</label>
              </div>
              <div class="text-center">
                <button class="btn btn-indigo">Register</button>
                <hr>
              </div>

            </form>


          </div>

        </div>
        <!--/.Card-->

      </div>
      <!--Grid column-->

    </div>
    <!--Grid row-->

  </div>
  <!-- Content -->

</div>
<!-- Mask & flexbox options-->

</div>


<!--Modal Form Login with Avatar Demo-->
<div class="modal fade" id="loading" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
    <!--Content-->
    <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
            <img src="<?php echo site_url().'application/assets/img/loading.gif';?>"
                class="rounded-circle img-responsive" alt="Avatar photo">
        </div>
        <!--Body-->
        <div class="modal-body text-center mb-1">
        <h5 class="mt-1 mb-2">Loading</h5>

        <div class="md-form ml-0 mr-0">
            <!-- <input type="password" type="text" id="form1" class="form-control ml-0">
            <label for="form1" class="ml-0">Enter password</label> -->
        </div>
        </div>

    </div>
    <!--/.Content-->
</div>
</div>

    <!-- JQuery -->
    <script type="text/javascript" src="<?php echo site_url().'application/assets/js/jquery-3.3.1.min.js';?>"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="<?php echo site_url().'application/assets/js/popper.min.js';?>"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="<?php echo site_url().'application/assets/js/bootstrap.js';?>"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="<?php echo site_url().'application/assets/js/mdb.js';?>"></script>
    <script type="text/javascript" src="<?php echo site_url().'application/assets/js/moment.min.js';?>"></script>
    <script>

    function open_register(){
        $('#login').hide();
        $('#register').show();
    }

    function login(){
        $('#loading').modal('show');
        $.ajax({
            url: '<?php echo site_url('login'); ?>',
            type: 'POST',
            data: $('#login_form').serialize(),
            success: function(data){
              // console.log(data);
              // if(data.status == true ){
                  $('#loading').modal('hide');
                  window.location.replace('<?php echo site_url(); ?>');
                // }else{
                //   $('#loading').modal('hide');
                //   $('#login_form')[0].reset();
                //   location.reload();        
                // }
                
            }
        });
    }

    </script>

 </body>
 </html>