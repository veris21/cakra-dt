<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
    
    public function index()
    {
        $time = time();
        $dbOrigin = APPPATH.'database/master.db';
        $backup = FCPATH.'dbbackup/'.mdate("%d%m%Y", $time).'-backup.db';
        if(copy($dbOrigin, $backup)){
            $status =  TRUE;
            $message =  "success to backup $backup";
        }else {
            $status =  FALSE;
            $message =  "failed to backup $dbOrigin";
        }
        echo json_encode(array('status'=>$status,'message'=>$message));

    }

}

/* End of file Backup.php */
