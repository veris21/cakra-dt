<?php $this->load->view('header'); ?>
<main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
            <!-- Heading -->
            <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        <a href="https://mdbootstrap.com/docs/jquery/" target="_blank">Home Page</a>
                        <span>/</span>
                        <span>Dashboard</span>
                    </h4>
                    <!-- <form class="d-flex justify-content-center">
                        
                        <input type="search" placeholder="Type your query" aria-label="Search" class="form-control">
                        <button class="btn btn-primary btn-sm my-0 p" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form> -->
                </div>

        </div>
        <hr>
        <div class="row">
            <!--  -->
            <div class="col-md-6">
            <!--  -->
            <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        Ritasi Bulan Lalu :<span>
                        <?php 
                    echo date('M Y', strtotime('-1 months'));
                    $m = mdate('%m', time()) - 1;
                    $y = mdate('%Y', time());
                    $tot = $this->dt_model->total_ritasi_bulan_ini($m,$y);
                        $count_rit = 0;
                        $count_km = 0;
                        foreach($tot->result() as $t) {
                            $count_rit += $t->rit;
                        }
                         ?>
                        </span>  
                    </h4>
                    <div class="d-flex justify-content-center">
                        
                        <h4><?php echo number_format($count_rit,0); ?> RIT</h4>
                    </div>
                </div>
            </div>
            <!--  -->
            </div>
            <!--  -->
           <!--  -->
           <div class="col-md-6">
            <!--  -->
            <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        Ritasi Bulan Ini :<span>
                        <?php 
                    echo mdate('%M %Y', time());
                    $m = mdate('%m', time());
                    $y = mdate('%Y', time());
                    $tot = $this->dt_model->total_ritasi_bulan_ini($m,$y);
                        $count_rit = 0;
                        $count_km = 0;
                        foreach($tot->result() as $t) {
                            $count_rit += $t->rit;
                        }
                         ?>
                        </span>  
                        
                         <!-- <span><input class="datepicker" type="text" id="lihat_dt_bulan"></span> -->
                    </h4>
                    <div class="d-flex justify-content-center">
                        
                        <h4><?php echo number_format($count_rit,0); ?> RIT</h4>
                    </div>
                </div>
            </div>
            <!--  -->
            </div>
            <!--  -->
        </div>
        <!--  -->
        <div class="card mb-4 wow fadeIn">
                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        Ritasi Bulan s/d Ini :<span>
                        <?php 
                    echo mdate('%M %Y', time());
                    $m = mdate('%m', time());
                    $y = mdate('%Y', time());
                    $total = $this->dt_model->list_dt();
                        $count_rit_total = 0;
                        $count_km = 0;
                        foreach($total->result() as $t) {
                            $count_rit_total += $t->rit;
                        }
                         ?>
                        </span>  
                        
                         <!-- <span><input class="datepicker" type="text" id="lihat_dt_bulan"></span> -->
                    </h4>
                    <div class="d-flex justify-content-center">
                        
                        <h4><?php echo number_format($count_rit_total,0); ?> RIT</h4>
                    </div>
                </div>
            </div>
            <!--  -->
        <!--  -->
	    
        </div>
</main>