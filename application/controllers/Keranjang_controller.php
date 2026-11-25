<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Keranjang belanja pelanggan (wajib login).
 * @property Keranjang_model $keranjang_model
 * @property Keranjang_produk_model $keranjang_produk_model
 * @property Produk_model $produk_model
 * @property Produk_gambar_model $produk_gambar_model
 * @property CI_Form_validation $form_validation
 */
class Keranjang_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('keranjang_model');
        $this->load->model('keranjang_produk_model');
        $this->load->model('produk_model');
        $this->load->model('produk_gambar_model');
        if (!$this->session->has_userdata('pelanggan_login')) {
            $this->__alert('warning', 'Silakan login terlebih dahulu untuk memakai keranjang.');
            redirect('login');
            die;
        }
    }

    /* =====================================================================
     *  TAMPIL KERANJANG
     * ===================================================================== */
    public function index()
    {
        $pelanggan_id = $this->session->userdata('id');
        $keranjang = $this->keranjang_model->get_by_pelanggan($pelanggan_id);

        $produk = [];
        $total = 0;
        $keranjang_id = 0;

        if ($keranjang) {
            // ambil data produk di keranjang berdasarkan id_keranjang
            $keranjang_id = $keranjang[0]['id_keranjang'];
            $keranjang_produk = $this->keranjang_produk_model->get_by_keranjang($keranjang_id);

            // ambil data produk berdasarkan id_produk
            foreach ($keranjang_produk as $item) {
                $produk_data = $this->produk_model->get_by_id($item['produk_id']);
                if ($produk_data) {
                    $produk_data['id_keranjang_produk'] = $item['id_keranjang_produk'];
                    $produk_data['jumlah'] = $item['jumlah'];
                    $produk_data['gambar'] = $this->produk_gambar_model->get_by_produk_id($item['produk_id']);
                    $produk[] = $produk_data;
                }
            }

            // total harga produk di keranjang
            foreach ($produk as $item) {
                $total += $item['harga'] * $item['jumlah'];
            }
        }

        $data['total'] = $total;
        $data['keranjang_id'] = $keranjang_id;
        $data['produk'] = $produk;
        $this->load->view('ecom/template/header');
        $this->load->view('ecom/keranjang', $data);
        $this->load->view('ecom/template/footer');
    }

    /* =====================================================================
     *  TAMBAH PRODUK KE KERANJANG (form di halaman detail produk)
     * ===================================================================== */
    public function tambah()
    {
        $this->form_validation->set_rules('id_produk', 'ID produk', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|is_natural_no_zero');
        if ($this->form_validation->run() !== FALSE) {
            $this->__tambah_produk_keranjang();
        } else {
            $this->__alert('danger', 'Data tidak valid. Jumlah beli minimal 1.');
            $id = (int) $this->input->post('id_produk');
            redirect($id > 0 ? 'produk/' . $id : base_url());
        }
    }

    private function __tambah_produk_keranjang()
    {
        $id_produk = (int) $this->input->post('id_produk');
        $jumlah = (int) $this->input->post('jumlah');
        $pelanggan_id = $this->session->userdata('id');

        $produk = $this->produk_model->get_by_id($id_produk);
        if (!$produk) {
            $this->__alert('danger', 'Produk tidak ditemukan!');
            redirect(base_url());
            return;
        }

        // cari keranjang pelanggan, buat baru jika belum ada
        $keranjang = $this->keranjang_model->get_by_pelanggan($pelanggan_id);
        if (!$keranjang) {
            $this->db->insert('keranjang', [
                'pelanggan_id' => $pelanggan_id,
                'total' => 0
            ]);
            $keranjang_id = $this->db->insert_id();
        } else {
            $keranjang_id = $keranjang[0]['id_keranjang'];
        }

        $produk_di_keranjang = $this->keranjang_produk_model->get_by_produk_keranjang($keranjang_id, $id_produk);
        $jumlah_baru = $jumlah + ($produk_di_keranjang ? (int) $produk_di_keranjang['jumlah'] : 0);

        // cek stok (jumlah di keranjang + jumlah yang ditambahkan tidak boleh melebihi stok)
        if ($produk['stok'] < $jumlah_baru) {
            $sudah = $produk_di_keranjang ? (int) $produk_di_keranjang['jumlah'] : 0;
            $pesan = 'Stok produk tidak cukup! Stok tersisa ' . (int) $produk['stok'] . '.';
            if ($sudah > 0) {
                $pesan .= ' Di keranjang Anda sudah ada ' . $sudah . '.';
            }
            $this->__alert('danger', $pesan);
            redirect('produk/' . $id_produk);
            return;
        }

        if ($produk_di_keranjang) {
            $this->keranjang_produk_model->ubah(['jumlah' => $jumlah_baru], $produk_di_keranjang['id_keranjang_produk']);
        } else {
            $this->keranjang_produk_model->tambah([
                'keranjang_id' => $keranjang_id,
                'produk_id' => $id_produk,
                'jumlah' => $jumlah
            ]);
        }

        $this->__update_total($keranjang_id);
        $this->__alert('success', 'Produk berhasil ditambahkan ke keranjang!');
        redirect(base_url("keranjang"));
    }

    /* =====================================================================
     *  UBAH JUMLAH (tombol - dan + di halaman keranjang)
     * ===================================================================== */
    public function ubah_keranjang()
    {
        $this->form_validation->set_rules('id_keranjang_produk', 'ID keranjang', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|is_natural_no_zero');
        if ($this->form_validation->run() !== FALSE) {
            $this->__ubah_produk_keranjang();
        } else {
            $this->__alert('danger', 'Jumlah minimal 1. Untuk membuang produk gunakan tombol hapus.');
            redirect(base_url('keranjang'));
        }
    }

    private function __ubah_produk_keranjang()
    {
        $jumlah = (int) $this->input->post('jumlah');
        $id_keranjang_produk = (int) $this->input->post('id_keranjang_produk');

        // cek dulu apakah benar produk ini ada di keranjang MILIK pelanggan yang login
        $keranjang_produk = $this->__item_milik_pelanggan($id_keranjang_produk);
        if (!$keranjang_produk) {
            $this->__alert('danger', 'Produk tidak ada di keranjang!');
            redirect(base_url('keranjang'));
            return;
        }

        // cek stok
        $produk = $this->produk_model->get_by_id($keranjang_produk['produk_id']);
        if (!$produk || $produk['stok'] < $jumlah) {
            $this->__alert('danger', 'Stok produk tidak cukup!');
            redirect(base_url('keranjang'));
            return;
        }

        // ubah jumlah produk di keranjang berdasarkan id keranjang produk
        $this->keranjang_produk_model->ubah(['jumlah' => $jumlah], $id_keranjang_produk);
        $this->__update_total($keranjang_produk['keranjang_id']);
        $this->__alert('success', 'Produk berhasil diubah di keranjang!');
        redirect(base_url('keranjang'));
    }

    /* =====================================================================
     *  HAPUS PRODUK DARI KERANJANG
     * ===================================================================== */
    public function hapus_produk_keranjang()
    {
        $this->form_validation->set_rules('id_keranjang_produk', 'ID keranjang produk', 'required|is_natural_no_zero');
        if ($this->form_validation->run() !== FALSE) {
            $this->__hapus_produk_keranjang();
        } else {
            redirect(base_url('keranjang'));
        }
    }

    private function __hapus_produk_keranjang()
    {
        $id_keranjang_produk = (int) $this->input->post('id_keranjang_produk');

        // cek dulu apakah benar produk ini ada di keranjang milik pelanggan yang login
        $keranjang_produk = $this->__item_milik_pelanggan($id_keranjang_produk);
        if (!$keranjang_produk) {
            $this->__alert('danger', 'Produk tidak ada di keranjang!');
            redirect(base_url('keranjang'));
            return;
        }

        $keranjang_id = $keranjang_produk['keranjang_id'];
        // hapus dari keranjang berdasarkan id keranjang produk
        $this->keranjang_produk_model->hapus($id_keranjang_produk);

        // jika tidak ada produk lagi di keranjang, hapus keranjang
        $sisa = $this->keranjang_produk_model->get_by_keranjang($keranjang_id);
        if (empty($sisa)) {
            $this->keranjang_model->hapus($keranjang_id);
            $this->__alert('success', 'Produk dihapus. Keranjang kosong!');
            redirect(base_url('keranjang'));
            return;
        }

        $this->__update_total($keranjang_id);
        $this->__alert('success', 'Produk berhasil dihapus dari keranjang!');
        redirect(base_url('keranjang'));
    }

    /* =====================================================================
     *  HELPER PRIVATE
     * ===================================================================== */

    // item keranjang_produk, hanya jika keranjangnya milik pelanggan yang sedang login
    private function __item_milik_pelanggan($id_keranjang_produk)
    {
        $item = $this->keranjang_produk_model->get_by_id($id_keranjang_produk);
        if (!$item) {
            return null;
        }
        $keranjang = $this->keranjang_model->getKeranjangByIdAndPelanggan($item['keranjang_id'], $this->session->userdata('id'));
        return $keranjang ? $item : null;
    }

    // hitung ulang total harga keranjang dan simpan di tabel keranjang
    private function __update_total($keranjang_id)
    {
        $total = 0;
        foreach ($this->keranjang_produk_model->get_by_keranjang($keranjang_id) as $item) {
            $produk_data = $this->produk_model->get_by_id($item['produk_id']);
            if ($produk_data) {
                $total += $produk_data['harga'] * $item['jumlah'];
            }
        }
        $this->keranjang_model->ubah(['total' => $total], $keranjang_id);
        return $total;
    }

    private function __alert($tipe, $pesan)
    {
        $this->session->set_flashdata('message', '
            <div class="alert alert-' . $tipe . ' alert-dismissible fade show" role="alert">
                ' . html_escape($pesan) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
    }
}
