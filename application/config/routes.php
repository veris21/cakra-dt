<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = 'welcome';
$route['translate_uri_dashes'] = FALSE;

$route['auth']                      = 'auth';
$route['validate/register']         = 'auth/register';
$route['check_keygen']              = 'auth/check_keygen';
$route['login']                     = 'auth/login';
$route['logout']                    = 'auth/logout';

$route['dt']                        = 'dt';
$route['dt/export']                 = 'dt/export_dt';
$route['dt/record']                 = 'dt/record';
$route['dt/details/(:any)']         = 'dt/details/$1';
$route['dt/edit/(:any)']            = 'dt/edit/$1';
$route['dt/hapus/(:any)']           = 'dt/hapus/$1';
$route['dt/details/pdf/(:any)']     = 'dt/details_pdf/$1';
$route['dt/details/excel/(:any)']   = 'dt/details_excel/$1';
$route['check/lembur']              = 'dt/cek_lembur';

$route['proyek']                     = 'proyek';
$route['proyek/details/(:num)']      = 'proyek/details_proyek/$1';
$route['proyek/input']               = 'proyek/input_proyek';



$route['tarif']                     = 'tarif';
$route['tarif/get']                 = 'tarif/get_tarif';
$route['tarif/input']               = 'tarif/tarif_input';
$route['tarif/update']              = 'tarif/tarif_update';
$route['tarif/delete']              = 'tarif/tarif_delete';

$route['sopir']                     = 'sopir';
$route['sopir/view/(:any)']         = 'sopir/sopir_details/$1';
$route['sopir/input']               = 'sopir/sopir_input';
$route['sopir/update']              = 'sopir/sopir_update';
$route['sopir/delete']              = 'sopir/sopir_delete';

$route['mobil']                     = 'mobil';
$route['mobil/sopir/input']         = 'mobil/insert_sopir';
$route['mobil/view/(:any)']         = 'mobil/mobil_details/$1';
$route['mobil/input']               = 'mobil/mobil_input';
$route['mobil/update']              = 'mobil/mobil_update';
$route['mobil/delete']              = 'mobil/mobil_delete';
$route['mobil/get/(:num)/(:any)']   = 'mobil/mobil_get/$1/$2';
$route['mobil/get_one/(:num)']      = 'mobil/mobil_one/$1';

$route['solar']                     = 'solar';
$route['solar/input']               = 'solar/solar_input';
$route['solar/update']              = 'solar/solar_update';
$route['solar/delete']              = 'solar/solar_delete';

$route['payroll']                     = 'payroll';
$route['payroll/details/(:any)']      = 'payroll/payroll_details/$1';
$route['payroll/input']               = 'payroll/payroll_input';
$route['payroll/update']              = 'payroll/payroll_update';
$route['payroll/delete']              = 'payroll/payroll_delete';
$route['payroll/export/pdf']          = 'payroll/export_pdf';
$route['payroll/export/pdf/(:any)']   = 'payroll/export_pdf_one/$1';
$route['payroll/export/excel']        = 'payroll/export_excel';
$route['payroll/export/excel/(:any)'] = 'payroll/export_excel_one/$1';

$route['gaji/init']                   = 'payroll/init_gaji';

$route['backup']                      = 'backup';

$route['reset']                        = 'dt/remove_data';