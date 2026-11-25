# Petunjuk Menjalankan - Toko Online (CodeIgniter 3)

1. Taruh folder proyek di `htdocs` (XAMPP) atau `www` (Laragon), mis. `htdocs/pwb_aldi`.
2. Import database: phpMyAdmin -> tab **Import** -> pilih `dbpwb.sql` -> Go
   (atau terminal: `mysql -u root < dbpwb.sql`). Database `dbpwb` dibuat otomatis.
3. Buka:
   - Toko (front-end) : `http://localhost/pwb_aldi/`
   - Admin            : `http://localhost/pwb_aldi/admin/login`

`base_url` terdeteksi otomatis, jadi nama folder bebas. Pastikan `mod_rewrite` Apache aktif.

## Akun bawaan
| Peran     | Login                                      | Password      |
|-----------|--------------------------------------------|---------------|
| Admin     | username `admin`                           | `admin123`    |
| Pelanggan | email `pelanggan@example.com`              | `password123` |

## Halaman front-end (Pertemuan 10)
| URL                    | Fungsi                                                    |
|------------------------|-----------------------------------------------------------|
| `/`                    | Home: carousel + daftar produk (maks. 8) dari database    |
| `/semua-produk`        | Semua produk (pencarian: `?q=kata`)                       |
| `/kategori/{id}`       | Produk per kategori                                       |
| `/produk/{id}`         | Detail produk + slider gambar (Slick) + tambah keranjang  |
| `/keranjang`           | Keranjang (wajib login): tombol -/+ jumlah, hapus, total, checkout |
| `/pesanan`, `/pesanan/{id}` | Daftar & detail pesanan hasil checkout               |
| `/login` `/register` `/profil` `/logout` | Akun pelanggan                          |

## Keranjang (Pertemuan 11)
Route: `keranjang`, `keranjang/tambah`, `keranjang/ubah`, `keranjang/hapus` (semuanya POST kecuali tampil).

- Tabel `keranjang` (id_keranjang, pelanggan_id, total) dan `keranjang_produk` (id_keranjang_produk, keranjang_id, produk_id, jumlah).
- Produk yang sama ditambahkan dua kali -> jumlahnya digabung. Total di keranjang tidak boleh melebihi stok.
- Item keranjang hanya bisa diubah/dihapus oleh pemiliknya. Menghapus item terakhir ikut menghapus keranjang.
- Tombol **Checkout** membuat pesanan (`Pesanan_controller`): stok dikurangi, keranjang dikosongkan,
  semua dalam satu transaksi database. Label "terjual" menghitung pesanan berstatus dibayar/dikirim/selesai.

File: `controllers/{Keranjang,Pesanan}_controller.php`, `models/{Keranjang,Keranjang_produk,Pesanan}_model.php`,
`views/ecom/{keranjang,pesanan_list,pesanan_detail}.php`, `config/routes.php`, `dbpwb.sql`.

Catatan: jika database lama sudah ada, import ulang `dbpwb.sql` (tabel `keranjang` berubah: kolom `total` ditambahkan).
