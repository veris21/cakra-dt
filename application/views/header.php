<header>
<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
            <div class="container-fluid">
                <div class="waves-effect">
                    <center>
                    <strong class="blue-text">Selamat Datang di Sistem Manajemen Data Arus Trayek</strong>
                    </center>
                </div>
                <!-- Collapse -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>

                    <!-- Right -->
                    <ul class="navbar-nav nav-flex-icons">
                        
                        <li class="nav-item">
                            <button class="btn btn-outline-warning waves-effect btn-sm"
                                onclick="backup()">
                                <i class="fa fa-reload mr-2"></i>Backup DB
                            </button>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('logout'); ?>" class="nav-link border border-light rounded waves-effect"
                               >
                                <i class="fa fa-sign-out mr-2"></i>Keluar
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
</nav>
<div class="sidebar-fixed position-fixed" style="font-size:12px;font-weight:bold;">

<a class="logo-wrapper waves-effect">
    <img src="<?php echo site_url().'application/assets/img/logo.png';?>" class="img-fluid" alt="">
    
</a>

<div class="list-group list-group-flush">
    <!--  -->
    <a href="<?php echo site_url();?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='' ? 'active' : '');?>">
        <i class="fa fa-pie-chart mr-3"></i>Dashboard
    </a>
    <!--  -->
    <a href="<?php echo site_url('proyek');?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='proyek' ? 'active' : '');?>">
    <i class="fa fa-gears mr-3"></i>Data Proyek</a>
    <!--  -->
    <a href="<?php echo site_url('dt');?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='dt' ? 'active' : '');?>">
    <i class="fa fa-database mr-3"></i>DT Record</a>
    <!--  -->
    <a href="<?php echo site_url('payroll');?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='payroll' ? 'active' : '');?>">
    <i class="fa fa-money mr-3"></i>Pembayaran</a>
    <!--  -->
    <a href="<?php echo site_url('tarif');?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='tarif' ? 'active' : '');?>">
    <i class="fa fa-credit-card mr-3"></i>Tarif Trayek</a>
    <!--  -->
    <a href="<?php echo site_url('sopir');?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='sopir' ? 'active' : '');?>">
    <i class="fa fa-user mr-3"></i>Master Data Sopir</a>
    <!--  -->
    <a href="<?php echo site_url('mobil');?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='mobil' ? 'active' : '');?>">
    <i class="fa fa-truck mr-3"></i>Master Data Mobil</a>
    <!--  -->
    <a href="<?php echo site_url('solar');?>" class="list-group-item list-group-item-action waves-effect <?php echo ($this->uri->segment(1)=='solar' ? 'active' : '');?>">
    <i class="fa fa-bars mr-3"></i>Data Solar</a>
    <!--  -->
    <hr>
    <center id="status_online"></center>
    
</div>

</div>
<!-- Sidebar -->
</header>