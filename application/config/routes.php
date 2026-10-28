<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'administrator/Admin_auth_controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

#auth & dashboard
$route['admin/login']     = 'administrator/Admin_auth_controller/index';
$route['admin/auth']      = 'administrator/Admin_auth_controller/auth';
$route['admin/logout']    = 'administrator/Admin_auth_controller/logout';
$route['admin/dashboard'] = 'administrator/Admin_dashboard_controller/index';

#kategori
$route['admin/kategori']                = 'administrator/Kategori_controller/index';
$route['admin/kategori/tambah']         = 'administrator/Kategori_controller/tambah';
$route['admin/kategori/simpan']         = 'administrator/Kategori_controller/simpan';
$route['admin/kategori/ubah/(:num)']    = 'administrator/Kategori_controller/ubah/$1';
$route['admin/kategori/update/(:num)']  = 'administrator/Kategori_controller/update/$1';
$route['admin/kategori/hapus/(:num)']   = 'administrator/Kategori_controller/hapus/$1';

#produk
$route['admin/produk']                      = 'administrator/Produk_controller/index';
$route['admin/produk/tambah']               = 'administrator/Produk_controller/tambah_produk';
$route['admin/produk/ubah/(:num)']          = 'administrator/Produk_controller/ubah_produk/$1';
$route['admin/produk/hapus/(:num)']         = 'administrator/Produk_controller/hapus_produk/$1';
#hapus satu gambar produk (untuk TUGAS: ganti gambar pada halaman ubah)
$route['admin/produk/hapus_gambar/(:num)']  = 'administrator/Produk_controller/hapus_gambar/$1';