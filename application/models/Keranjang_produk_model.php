<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang_produk_model extends CI_Model
{

    private $_table = "keranjang_produk";

    // Ambil semua data keranjang_produk
    public function get_all()
    {
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function get_by_produk_keranjang($keranjang_id, $produk_id)
    {
        return $this->db->get_where($this->_table, [
            'keranjang_id' => $keranjang_id,
            'produk_id' => $produk_id
        ])->row_array();
    }

    // Tambah data keranjang_produk
    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    // Ambil data berdasarkan id_keranjang_produk
    public function get_by_id($id)
    {
        $this->db->where('id_keranjang_produk', $id);
        $query = $this->db->get($this->_table);
        return $query->row_array();
    }

    // Ambil data berdasarkan keranjang_id
    public function get_by_keranjang($keranjang_id)
    {
        $this->db->where('keranjang_id', $keranjang_id);
        $this->db->order_by('id_keranjang_produk', 'ASC');
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    // Update data keranjang_produk
    public function ubah($data, $id_keranjang_produk)
    {
        $this->db->where('id_keranjang_produk', $id_keranjang_produk);
        return (bool) $this->db->update($this->_table, $data);
    }

    // Hapus data keranjang_produk
    public function hapus($id)
    {
        return (bool) $this->db->delete($this->_table, array('id_keranjang_produk' => $id));
    }
}
