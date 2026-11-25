<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Keranjang_model $keranjang_model
 * @property Keranjang_produk_model $keranjang_produk_model
 * @property Pesanan_model $pesanan_model
 * @property Pelanggan_model $pelanggan_model
 * @property Produk_model $produk_model
 */
class Pesanan_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('keranjang_model');
        $this->load->model('keranjang_produk_model');
        $this->load->model('pesanan_model');
        $this->load->model('pelanggan_model');
        $this->load->model('produk_model');
        if (!$this->session->has_userdata('pelanggan_login')) {
            $this->__alert('warning', 'Silakan login terlebih dahulu.');
            redirect('login');
            die;
        }
    }

    // daftar pesanan milik pelanggan
    public function index()
    {
        $data['list_pesanan'] = $this->pesanan_model->get_by_pelanggan($this->session->userdata('id'));
        $this->load->view('ecom/template/header');
        $this->load->view('ecom/pesanan_list', $data);
        $this->load->view('ecom/template/footer');
    }

    public function detail($id = 0)
    {
        $pesanan = $this->pesanan_model->get_by_id_pelanggan($id, $this->session->userdata('id'));
        if (!$pesanan) {
            $this->__alert('danger', 'Pesanan tidak ditemukan!');
            redirect('pesanan');
            return;
        }
        $data['pesanan'] = $pesanan;
        $data['list_item'] = $this->pesanan_model->get_items($id);
        $this->load->view('ecom/template/header');
        $this->load->view('ecom/pesanan_detail', $data);
        $this->load->view('ecom/template/footer');
    }


    public function tambah()
    {
        if ($this->input->method() !== 'post') {
            redirect('keranjang');
            return;
        }

        $pelanggan_id = $this->session->userdata('id');
        $keranjang_id = (int) $this->input->post('keranjang_id');

        // keranjang harus milik pelanggan yang login dan tidak kosong
        $keranjang = $this->keranjang_model->getKeranjangByIdAndPelanggan($keranjang_id, $pelanggan_id);
        $items = $keranjang ? $this->keranjang_produk_model->get_by_keranjang($keranjang_id) : [];
        if (!$keranjang || empty($items)) {
            $this->__alert('danger', 'Keranjang kosong atau tidak ditemukan!');
            redirect('keranjang');
            return;
        }

      
        $total = 0;
        $baris = [];
        foreach ($items as $item) {
            $produk = $this->produk_model->get_by_id($item['produk_id']);
            if (!$produk || $produk['stok'] < $item['jumlah']) {
                $nama = $produk ? $produk['nama'] : 'Produk';
                $this->__alert('danger', 'Stok ' . $nama . ' tidak cukup. Silakan ubah jumlah di keranjang.');
                redirect('keranjang');
                return;
            }
            $total += $produk['harga'] * $item['jumlah'];
            $baris[] = ['produk_id' => $produk['id_produk'], 'jumlah' => (int) $item['jumlah'], 'harga' => (int) $produk['harga']];
        }

        $pelanggan = $this->pelanggan_model->get_by_id($pelanggan_id);
        $alamat = trim($pelanggan['alamat'] . ', ' . $pelanggan['kota'] . ' ' . $pelanggan['kode_pos'] . ', ' . $pelanggan['provinsi'], ' ,');

      
        $berhasil = TRUE;
        $this->db->trans_begin();
        $this->db->insert('pesanan', [
            'pelanggan_id' => $pelanggan_id,
            'total' => $total,
            'status' => 'menunggu',
            'alamat_pengiriman' => $alamat
        ]);
        $pesanan_id = $this->db->insert_id();
        foreach ($baris as $b) {
            $this->db->insert('pesanan_produk', [
                'pesanan_id' => $pesanan_id,
                'produk_id' => $b['produk_id'],
                'jumlah' => $b['jumlah'],
                'harga' => $b['harga']
            ]);
      
            $this->db->query('UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND stok >= ?', [$b['jumlah'], $b['produk_id'], $b['jumlah']]);
            if ($this->db->affected_rows() != 1) {
                $berhasil = FALSE;
                break;
            }
        }
        if ($berhasil) {
            $this->keranjang_model->hapus($keranjang_id); // isi keranjang ikut terhapus (CASCADE)
        }

        if ($berhasil && $this->db->trans_status() !== FALSE) {
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
            $this->__alert('danger', 'Checkout gagal, stok berubah. Silakan coba lagi.');
            redirect('keranjang');
            return;
        }

        $this->__alert('success', 'Checkout berhasil! Pesanan #' . $pesanan_id . ' telah dibuat.');
        redirect('pesanan/' . $pesanan_id);
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
