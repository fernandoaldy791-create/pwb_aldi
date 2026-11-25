<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
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

$route['admin/ekspedisi2422500068']                = 'administrator/ekspedisi2422500068_controller/index';
$route['admin/ekspedisi2422500068/tambah']         = 'administrator/ekspedisi2422500068_controller/tambah';
$route['admin/ekspedisi2422500068/simpan']         = 'administrator/ekspedisi2422500068_controller/simpan';
$route['admin/ekspedisi2422500068/ubah/(:num)']    = 'administrator/ekspedisi2422500068_controller/ubah/$1';
$route['admin/ekspedisi2422500068/update/(:num)']  = 'administrator/ekspedisi2422500068_controller/update/$1';
$route['admin/ekspedisi2422500068/hapus/(:num)']   = 'administrator/ekspedisi2422500068_controller/hapus/$1';

#produk
$route['admin/produk']                      = 'administrator/Produk_controller/index';
$route['admin/produk/tambah']               = 'administrator/Produk_controller/tambah_produk';
$route['admin/produk/ubah/(:num)']          = 'administrator/Produk_controller/ubah_produk/$1';
$route['admin/produk/hapus/(:num)']         = 'administrator/Produk_controller/hapus_produk/$1';
#hapus satu gambar produk (untuk TUGAS: ganti gambar pada halaman ubah)
$route['admin/produk/hapus_gambar/(:num)']  = 'administrator/Produk_controller/hapus_gambar/$1';

#pelanggan
$route['login']    = 'pelanggan_controller/login';
$route['register'] = 'pelanggan_controller/register';
$route['logout']   = 'pelanggan_controller/logout';
$route['profil']   = 'pelanggan_controller/profil'; // Untuk halaman profil

#ecom (front-end toko)
$route['produk']                = 'produk_controller/detail';
$route['produk/(:num)']         = 'produk_controller/detail/$1';
$route['semua-produk']          = 'produk_controller/index';
$route['kategori/(:num)']       = 'produk_controller/index/$1';

#Keranjang
$route['keranjang']        = 'keranjang_controller/index';
$route['keranjang/tambah'] = 'keranjang_controller/tambah';
$route['keranjang/ubah']   = 'keranjang_controller/ubah_keranjang';
$route['keranjang/hapus']  = 'keranjang_controller/hapus_produk_keranjang';

#Pesanan (checkout dari keranjang)
$route['pesanan']          = 'pesanan_controller/index';
$route['pesanan/tambah']   = 'pesanan_controller/tambah';
$route['pesanan/(:num)']   = 'pesanan_controller/detail/$1';
