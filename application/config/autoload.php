<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = array();
$autoload['libraries'] = array(
'session',
'database',
'email',
'parser',
'form_validation',
'encryption',
'upload',
'pdfgenerator',
'pHPExcel');
$autoload['drivers'] = array();
$autoload['helper'] = array('url', 'file','date', 'form','directory','download','path','login_helper', 'bulan_helper');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array(
    'tarif_model',
    'auth_model',
    'sopir_model',
    'dt_model',
    'payroll_model',
    'solar_model',
    'mobil_model',
    'proyek_model'
);
