<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Halaman depan toko (front-end).
 * @property Produk_model $produk_model
 * @property Produk_gambar_model $produk_gambar_model
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('produk_model');
        $this->load->model('produk_kategori_model');
        $this->load->model('produk_gambar_model');
    }

    public function index()
    {
        $data['gambar_model'] = $this->produk_gambar_model;
        // halaman depan hanya menampilkan 8 produk; sisanya lewat tombol "Lihat Semua Produk"
        $data['list_produk'] = $this->produk_model->get_all(0, '', 8);
        $this->load->view('ecom/template/header', $data);
        $this->load->view('ecom/template/carousel');
        $this->load->view('ecom/home', $data);
        $this->load->view('ecom/template/footer');
    }
}
