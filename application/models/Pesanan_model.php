<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan_model extends CI_Model
{
    public function get_by_pelanggan($pelanggan_id)
    {
        return $this->db->where('pelanggan_id', (int) $pelanggan_id)
            ->order_by('id_pesanan', 'DESC')
            ->get('pesanan')->result_array();
    }

    // hanya pesanan milik pelanggan yang bersangkutan
    public function get_by_id_pelanggan($id, $pelanggan_id)
    {
        return $this->db->get_where('pesanan', array(
            'id_pesanan' => (int) $id,
            'pelanggan_id' => (int) $pelanggan_id
        ))->row_array();
    }

    public function get_items($pesanan_id)
    {
        $this->db->select('pp.jumlah, pp.harga, p.id_produk, p.nama, '
            . '(SELECT g.nama_gambar FROM produk_gambar g WHERE g.produk_id = p.id_produk ORDER BY g.id_gambar ASC LIMIT 1) AS gambar', FALSE);
        $this->db->from('pesanan_produk pp');
        $this->db->join('produk p', 'p.id_produk = pp.produk_id');
        $this->db->where('pp.pesanan_id', (int) $pesanan_id);
        $this->db->order_by('pp.id_pesanan_produk', 'ASC');
        return $this->db->get()->result_array();
    }
}
