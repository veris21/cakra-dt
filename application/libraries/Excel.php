<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

require FCPATH.'vendor/autoload.php';
 
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}