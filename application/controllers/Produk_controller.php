<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Produk (front-end): daftar semua produk / per kategori dan detail produk.
 * @property Produk_model $produk_model
 * @property Produk_kategori_model $produk_kategori_model
 * @property Produk_gambar_model $produk_gambar_model
 */
class Produk_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('produk_model');
        $this->load->model('produk_kategori_model');
        $this->load->model('produk_gambar_model');
    }

    // daftar semua produk (opsional: filter kategori dan pencarian ?q=)
    public function index($kategori_id = 0)
    {
        $kategori_id = (int) $kategori_id;
        $keyword = trim((string) $this->input->get('q', TRUE));

        $judul = 'Semua Produk';
        if ($kategori_id > 0) {
            $kategori = $this->produk_kategori_model->get_by_id($kategori_id);
            if (!$kategori) {
                redirect('/');
                die;
            }
            $judul = 'Kategori: ' . $kategori['nama'];
        }
        if ($keyword !== '') {
            $judul .= ' - pencarian "' . $keyword . '"';
        }

        $data['judul'] = $judul;
        $data['keyword'] = $keyword;
        $data['gambar_model'] = $this->produk_gambar_model;
        $data['list_produk'] = $this->produk_model->get_all($kategori_id, $keyword);
        $this->load->view('ecom/template/header', $data);
        $this->load->view('ecom/produk_list', $data);
        $this->load->view('ecom/template/footer');
    }

    public function detail($id = 0)
    {
        if ($id == 0) {
            redirect('/');
            die;
        }
        $produk = $this->produk_model->get_by_id($id);
        if (!$produk) {
            redirect('/');
            die;
        }
        $data['produk'] = $produk;
        $data['list_gambar'] = $this->produk_gambar_model->get_by_produk_id($id);
        $data['kategori'] = $this->produk_kategori_model->get_by_id($produk['categori_id']);
        $this->load->view('ecom/template/header');
        $this->load->view('ecom/produk_detail', $data);
        $this->load->view('ecom/template/footer');
    }
}
