<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{

    private $_table = "produk";

    public function get_all()
    {
        $this->db->select('produk.id_produk, produk.nama as pd_nama, produk.stok, produk.harga, produk.deskripsi, kategori.nama as kt_nama');
        $this->db->from($this->_table);
        $this->db->join('kategori', 'kategori.id_kategori = produk.categori_id');
        $this->db->order_by('produk.id_produk', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        #untuk check apakah berhasil atau tidak input data
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
        // update() mengembalikan TRUE bila query berhasil, walaupun datanya tidak berubah
        // (affected_rows() == 0 tidak boleh dianggap gagal, mis. saat hanya mengganti gambar)
        return (bool) $this->db->update($this->_table, $data);
    }

    public function hapus($id)
    {
        $this->db->delete($this->_table, array('id_produk' => $id));
    }
}
