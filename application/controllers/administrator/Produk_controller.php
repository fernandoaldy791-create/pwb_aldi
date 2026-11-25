<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_admin_logged_in();
        // Load model
        $this->load->model('produk_model');
        $this->load->model('produk_kategori_model');
        $this->load->model('produk_gambar_model');
    }


    public function index()
    {
        $data['title'] = 'Daftar Produk';
        $data['list_produk'] = $this->produk_model->get_all();
        $this->load->view('administrator/templates/header', $data);
        $this->load->view('administrator/templates/sidebar');
        $this->load->view('administrator/produk/index');
        $this->load->view('administrator/templates/footer');
    }

  
    public function tambah_produk()
    {
        $data['title'] = 'Tambah Produk';
        $this->form_validation->set_rules('nama_produk', 'Nama produk', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required|callback__cek_kategori');
        $this->form_validation->set_rules('harga_produk', 'Harga', 'required|is_natural');
        $this->form_validation->set_rules('stok_produk', 'Stok', 'trim|is_natural');
        if ($this->form_validation->run() !== FALSE) {
            $this->__simpan_produk();
        } else {
            $data['list_kategori'] = $this->produk_kategori_model->get_all();
            $this->load->view('administrator/templates/header', $data);
            $this->load->view('administrator/templates/sidebar');
            $this->load->view('administrator/produk/tambah_produk', $data);
            $this->load->view('administrator/templates/footer');
        }
    }

   
    public function _cek_kategori($id)
    {
        if ($this->produk_kategori_model->get_by_id($id)) {
            return TRUE;
        }
        $this->form_validation->set_message('_cek_kategori', 'Kategori yang dipilih tidak valid.');
        return FALSE;
    }

    private function __simpan_produk()
    {
        $data = [
            'nama' => ucwords($this->input->post('nama_produk')),
            'categori_id' => $this->input->post('kategori_produk'),
            'harga' => (int) $this->input->post('harga_produk'),
            'stok' => (int) $this->input->post('stok_produk'),
            'deskripsi' => ucfirst($this->input->post('deskripsi_produk'))
        ];

    
        $id_produk = $this->produk_model->tambah($data);
   

        if ($id_produk) {
            $gagal = $this->__produk_gambar_upload($id_produk);
            if (empty($gagal)) {
                $this->__alert('success', 'Berhasil menambahkan produk!!');
            } else {
                $this->__alert('warning', 'Produk berhasil ditambahkan, tetapi ada gambar yang gagal diupload: ' . implode('; ', $gagal));
            }
        } else {
            $this->__alert('danger', 'Gagal menambahkan produk!!');
        }

        redirect('admin/produk');
    }


    private function __produk_gambar_upload($id_produk)
    {
        $gagal = [];
        if (!isset($_FILES['gambar_produk']) || !is_array($_FILES['gambar_produk']['name'])) {
            return $gagal;
        }

        $folder = FCPATH . 'uploads/produk/';
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $this->load->library('upload');
        $count = count($_FILES['gambar_produk']['name']);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($_FILES['gambar_produk']['name'][$i])) {
                $_FILES['file']['name'] = $_FILES['gambar_produk']['name'][$i];
                $_FILES['file']['type'] = $_FILES['gambar_produk']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['gambar_produk']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['gambar_produk']['error'][$i];
                $_FILES['file']['size'] = $_FILES['gambar_produk']['size'][$i];

                $config['upload_path'] = $folder;
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                $config['max_size'] = '5000';
                $config['file_name'] = "produk-" . $id_produk . '-' . date('YmdHis') . '-' . $i;

   
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $data = [
                        'nama_gambar' => $filename,
                        'produk_id' => $id_produk
                    ];
                    $this->produk_gambar_model->tambah($data);
                } else {
                    $gagal[] = $_FILES['file']['name'] . ' (' . trim(strip_tags($this->upload->display_errors('', ''))) . ')';
                }
            }
        }
        return $gagal;
    }


    public function ubah_produk($id)
    {

        $produk = $this->produk_model->get_by_id($id);
        if ($produk) {
            $this->form_validation->set_rules('nama_produk', 'Nama produk', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('kategori_produk', 'Kategori', 'required|callback__cek_kategori');
            $this->form_validation->set_rules('harga_produk', 'Harga', 'required|is_natural');
            $this->form_validation->set_rules('stok_produk', 'Stok', 'trim|is_natural');
            if ($this->form_validation->run() !== FALSE) {
                $this->__ubah_produk($id);
            } else {
                $data['title'] = 'Ubah produk';
                $data['produk'] = $produk;
                $data['list_kategori'] = $this->produk_kategori_model->get_all();
                $data['gambar_model'] = $this->produk_gambar_model;
                $this->load->view('administrator/templates/header', $data);
                $this->load->view('administrator/templates/sidebar');
                $this->load->view('administrator/produk/ubah_produk', $data);
                $this->load->view('administrator/templates/footer');
            }
        } else {
            $this->__alert('danger', 'produk tidak ditemukan!!');
            redirect('admin/produk');
        }
    }

    private function __ubah_produk($id)
    {
        $data = [
            'nama' => ucwords($this->input->post('nama_produk')),
            'categori_id' => $this->input->post('kategori_produk'),
            'harga' => (int) $this->input->post('harga_produk'),
            'stok' => (int) $this->input->post('stok_produk'),
            'deskripsi' => ucfirst($this->input->post('deskripsi_produk'))
        ];

        $ubah = $this->produk_model->ubah($data, $id);
        if ($ubah) {
         
            $gambar_lama = $this->produk_gambar_model->get_by_produk_id($id);
            $jumlah_sebelum = count($gambar_lama);
            $gagal = $this->__produk_gambar_upload($id);
            $jumlah_sesudah = count($this->produk_gambar_model->get_by_produk_id($id));
            $ada_baru = ($jumlah_sesudah - $jumlah_sebelum) > 0;

            if ($ada_baru && $this->input->post('ganti_semua_gambar')) {
                foreach ($gambar_lama as $gambar) {
                    $this->__hapus_file_gambar($gambar['id_gambar'], $gambar['nama_gambar']);
                }
            }

            if (empty($gagal)) {
                $this->__alert('success', 'Berhasil mengubah produk!!');
            } else {
                $this->__alert('warning', 'Produk berhasil diubah, tetapi ada gambar yang gagal diupload: ' . implode('; ', $gagal));
            }
        } else {
            $this->__alert('danger', 'Gagal mengubah produk!!');
        }
        redirect('admin/produk');
    }


    public function hapus_gambar($id_gambar)
    {
        $gambar = $this->produk_gambar_model->get_by_id($id_gambar);
        if ($gambar) {
            $this->__hapus_file_gambar($gambar['id_gambar'], $gambar['nama_gambar']);
            $this->__alert('success', 'Berhasil menghapus gambar!!');
            redirect('admin/produk/ubah/' . $gambar['produk_id']);
        } else {
            $this->__alert('danger', 'gambar tidak ditemukan!!');
            redirect('admin/produk');
        }
    }

 
    public function hapus_produk($id)
    {
      
        $produk = $this->produk_model->get_by_id($id);
        if ($produk) {
   
            if ($this->produk_model->count_pesanan($id) > 0) {
                $this->__alert('danger', 'Produk tidak dapat dihapus karena sudah pernah dipesan pelanggan.');
                redirect('admin/produk');
                return;
            }
         
            $list_gambar = $this->produk_gambar_model->get_by_produk_id($id);
            foreach ($list_gambar as $gambar) {
           
                $this->__hapus_file_gambar($gambar['id_gambar'], $gambar['nama_gambar']);
            }
         
            $this->produk_model->hapus($id);
            $this->__alert('success', 'Berhasil menghapus produk!!');
            redirect('admin/produk');
        } else {
            $this->__alert('danger', 'produk tidak ditemukan!!');
            redirect('admin/produk');
        }
    }


    private function __hapus_file_gambar($id_gambar, $nama_gambar)
    {
        $this->produk_gambar_model->hapus($id_gambar);
        $path = FCPATH . 'uploads/produk/' . $nama_gambar;
        if ($nama_gambar !== '' && is_file($path)) {
            unlink($path);
        }
    }


    private function __alert($tipe, $pesan)
    {
        $icon = ($tipe === 'success') ? 'check-circle-fill' : 'exclamation-triangle-fill';
        $label = ($tipe === 'success') ? 'Success:' : 'Danger:';
        $this->session->set_flashdata('message', '
            <div class="alert alert-' . $tipe . ' d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 mr-2" width="24" height="24" role="img" aria-label="' . $label . '">
                    <use xlink:href="#' . $icon . '" />
                </svg>
                <div>
                    ' . html_escape($pesan) . '
                </div>
                <button type="button" class="close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        ');
    }
}
