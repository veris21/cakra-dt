<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('head');?>
<body class="grey lighten-3">
    
    <?php $this->load->view($main_content); ?>
    <div id="results_export"></div>
    <footer>
     <!--Copyright-->
     <div class="footer-copyright py-3">
            © 2018 Copyright:
            <a href="https://si-desa.id" target="_blank"> si-desa.id </a>
        </div>
        <!--/.Copyright-->

    </footer>
    <!--/.Footer-->    
    <?php $this->load->view('modal');?>
    <?php $this->load->view('script');?>
</body>
</html>