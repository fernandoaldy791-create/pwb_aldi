<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{

    private $_table = "produk";

 
    public function get_all($kategori_id = 0, $keyword = '', $limit = 0)
    {
        $terjual = "(SELECT COALESCE(SUM(pp.jumlah), 0) FROM pesanan_produk pp "
            . "JOIN pesanan ps ON ps.id_pesanan = pp.pesanan_id "
            . "WHERE pp.produk_id = produk.id_produk AND ps.status IN ('dibayar','dikirim','selesai')) AS terjual";

        $this->db->select('produk.id_produk, produk.nama as pd_nama, produk.stok, produk.harga, produk.deskripsi, produk.categori_id, kategori.nama as kt_nama, ' . $terjual, FALSE);
        $this->db->from($this->_table);
        $this->db->join('kategori', 'kategori.id_kategori = produk.categori_id');
        if ((int) $kategori_id > 0) {
            $this->db->where('produk.categori_id', (int) $kategori_id);
        }
        if ($keyword !== '') {
            $this->db->like('produk.nama', $keyword);
        }
        $this->db->order_by('produk.id_produk', 'ASC');
        if ((int) $limit > 0) {
            $this->db->limit((int) $limit);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
   
        return $this->db->insert_id();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_produk', $id);
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    public function ubah($data, $id)
    {
        $this->db->where('id_produk', $id);

        return (bool) $this->db->update($this->_table, $data);
    }

    public function hapus($id)
    {
        $this->db->delete($this->_table, array('id_produk' => $id));
    }

   
    public function count_pesanan($id)
    {
        return (int) $this->db->where('produk_id', (int) $id)->count_all_results('pesanan_produk');
    }
}
