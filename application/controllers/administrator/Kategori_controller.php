<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kategori_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_admin_logged_in();
        $this->load->model('produk_kategori_model');
    }

    // ===================== TAMPIL (READ) =====================
    public function index() {
        $data['title'] = 'Kategori';
        $data['list_kategori'] = $this->produk_kategori_model->get_all();
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/kategori/index', $data);
        $this->load->view('administrator/templates/footer');
    }

    // ===================== TAMBAH (CREATE) =====================
    public function tambah_kategori()
    {
        $data['title'] = 'Tambah Kategori';

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
        $this->form_validation->set_rules('deskripsi_kategori', 'Deskripsi', 'trim');

        if ($this->form_validation->run() !== FALSE) {
            $this->__simpan_kategori();
        } else {
            $this->load->view('administrator/templates/header', $data);
            $this->load->view('administrator/templates/sidebar');
            $this->load->view('administrator/kategori/tambah_kategori');
            $this->load->view('administrator/templates/footer');
        }
    }

    private function __simpan_kategori()
    {
        $data = [
            'nama' => ucwords($this->input->post('nama_kategori')),
            'deskripsi' => ucfirst($this->input->post('deskripsi_kategori'))
        ];
        $simpan = $this->produk_kategori_model->tambah($data);

        if ($simpan) {
            $this->_alert('success', 'Berhasil menambahkan kategori!!');
        } else {
            $this->_alert('danger', 'Gagal menambahkan kategori!!');
        }
        redirect('admin/kategori');
    }

    // ===================== HAPUS (DELETE) =====================
    public function hapus_kategori($id)
    {
        // check apakah ada kategori
        $kategori = $this->produk_kategori_model->get_by_id($id);
        if ($kategori) {
            $hapus = $this->produk_kategori_model->hapus($id);
            if ($hapus) {
                $this->_alert('success', 'Berhasil menghapus kategori!!');
            } else {
                $this->_alert('danger', 'Gagal menghapus kategori!!');
            }
        } else {
            $this->_alert('danger', 'Kategori tidak ditemukan!!');
        }
        redirect('admin/kategori');
    }

    // ===================== UBAH (UPDATE) =====================
    public function ubah_kategori($id)
    {
        // check dulu apakah id dengan kategori ada?
        $kategori = $this->produk_kategori_model->get_by_id($id);
        if ($kategori) {
            $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');
            $this->form_validation->set_rules('deskripsi_kategori', 'Deskripsi', 'trim');

            if ($this->form_validation->run() !== FALSE) {
                $this->__ubah_kategori($id);
            } else {
                $data['title'] = 'Ubah Kategori';
                $data['kategori'] = $kategori;
                $this->load->view('administrator/templates/header', $data);
                $this->load->view('administrator/templates/sidebar');
                $this->load->view('administrator/kategori/ubah_kategori', $data);
                $this->load->view('administrator/templates/footer');
            }
        } else {
            $this->_alert('danger', 'Kategori tidak ditemukan!!');
            redirect('admin/kategori');
        }
    }

    private function __ubah_kategori($id)
    {
        $data = [
            'nama' => ucwords($this->input->post('nama_kategori')),
            'deskripsi' => ucfirst($this->input->post('deskripsi_kategori'))
        ];
        $ubah = $this->produk_kategori_model->ubah($data, $id);

        if ($ubah) {
            $this->_alert('success', 'Berhasil mengubah kategori!!');
        } else {
            $this->_alert('danger', 'Gagal mengubah kategori!!');
        }
        redirect('admin/kategori');
    }

    // ===================== PESAN (alert Bootstrap 4 / AdminLTE 3) =====================
    private function _alert($type, $pesan)
    {
        $icon = ($type === 'success') ? 'fa-check-circle' : 'fa-exclamation-triangle';
        $this->session->set_flashdata('message', '
            <div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
                <i class="fas ' . $icon . ' mr-2"></i>
                ' . $pesan . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        ');
    }
}
