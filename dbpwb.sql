-- ==========================================================================
--  DATABASE : dbpwb
--  Matkul   : Pemrograman Web Bisnis - Toko Online (CodeIgniter 3)
--  Pertemuan: 5 & 6 - CRUD Produk dan Produk Gambar
--
--  Cara import (phpMyAdmin / Laragon / XAMPP):
--    1. Buka phpMyAdmin -> tab "Import" -> pilih file ini -> Go
--       (database akan dibuat otomatis), ATAU
--    2. Lewat terminal:  mysql -u root < dbpwb.sql
--
--  Login admin bawaan:  username = admin   |   password = admin123
-- ==========================================================================

CREATE DATABASE IF NOT EXISTS `dbpwb`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dbpwb`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `pembayaran`;
DROP TABLE IF EXISTS `pesanan_produk`;
DROP TABLE IF EXISTS `pesanan`;
DROP TABLE IF EXISTS `keranjang_produk`;
DROP TABLE IF EXISTS `keranjang`;
DROP TABLE IF EXISTS `pelanggan`;
DROP TABLE IF EXISTS `produk_gambar`;
DROP TABLE IF EXISTS `produk`;
DROP TABLE IF EXISTS `kategori`;
DROP TABLE IF EXISTS `administrator`;
SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------------------------
-- Tabel administrator (untuk login admin)
-- --------------------------------------------------------------------------
CREATE TABLE `administrator` (
  `id_admin`  int          NOT NULL AUTO_INCREMENT,
  `username`  varchar(50)  NOT NULL,
  `password`  varchar(32)  NOT NULL COMMENT 'md5',
  `full_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `uq_admin_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 1. Tabel kategori
-- --------------------------------------------------------------------------
CREATE TABLE `kategori` (
  `id_kategori` int          NOT NULL AUTO_INCREMENT,
  `nama`        varchar(100) NOT NULL,
  `deskripsi`   varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 2. Tabel produk   (sesuai PDF: id_produk, nama, deskripsi, categori_id, harga, stok)
-- --------------------------------------------------------------------------
CREATE TABLE `produk` (
  `id_produk`   int          NOT NULL AUTO_INCREMENT,
  `nama`        varchar(100) NOT NULL,
  `deskripsi`   text         DEFAULT NULL,
  `categori_id` int          NOT NULL,
  `harga`       int          NOT NULL,
  `stok`        int          DEFAULT NULL,
  PRIMARY KEY (`id_produk`),
  KEY `idx_produk_categori` (`categori_id`),
  CONSTRAINT `fk_produk_kategori` FOREIGN KEY (`categori_id`)
    REFERENCES `kategori` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 3. Tabel produk_gambar   (sesuai PDF: id_gambar, nama_gambar, produk_id)
-- --------------------------------------------------------------------------
CREATE TABLE `produk_gambar` (
  `id_gambar`   int          NOT NULL AUTO_INCREMENT,
  `nama_gambar` varchar(100) DEFAULT NULL,
  `produk_id`   int          DEFAULT NULL,
  PRIMARY KEY (`id_gambar`),
  KEY `idx_gambar_produk` (`produk_id`),
  CONSTRAINT `fk_gambar_produk` FOREIGN KEY (`produk_id`)
    REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 4. Tabel pelanggan
-- --------------------------------------------------------------------------
CREATE TABLE `pelanggan` (
  `id_pelanggan` int          NOT NULL AUTO_INCREMENT,
  `nama`         varchar(100) NOT NULL,
  `email`        varchar(100) NOT NULL,
  `password`     varchar(255) NOT NULL,
  `no_hp`        varchar(20)  DEFAULT NULL,
  `alamat`       text         DEFAULT NULL,
  `created_at`   timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pelanggan`),
  UNIQUE KEY `uq_pelanggan_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 5. Tabel keranjang
-- --------------------------------------------------------------------------
CREATE TABLE `keranjang` (
  `id_keranjang` int       NOT NULL AUTO_INCREMENT,
  `pelanggan_id` int       NOT NULL,
  `created_at`   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_keranjang`),
  KEY `idx_keranjang_pelanggan` (`pelanggan_id`),
  CONSTRAINT `fk_keranjang_pelanggan` FOREIGN KEY (`pelanggan_id`)
    REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 6. Tabel keranjang_produk
-- --------------------------------------------------------------------------
CREATE TABLE `keranjang_produk` (
  `id_keranjang_produk` int NOT NULL AUTO_INCREMENT,
  `keranjang_id`        int NOT NULL,
  `produk_id`           int NOT NULL,
  `jumlah`              int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_keranjang_produk`),
  KEY `idx_kp_keranjang` (`keranjang_id`),
  KEY `idx_kp_produk` (`produk_id`),
  CONSTRAINT `fk_kp_keranjang` FOREIGN KEY (`keranjang_id`)
    REFERENCES `keranjang` (`id_keranjang`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kp_produk` FOREIGN KEY (`produk_id`)
    REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 7. Tabel pesanan
-- --------------------------------------------------------------------------
CREATE TABLE `pesanan` (
  `id_pesanan`        int          NOT NULL AUTO_INCREMENT,
  `pelanggan_id`      int          NOT NULL,
  `tanggal`           datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total`             int          NOT NULL DEFAULT 0,
  `status`            enum('menunggu','dibayar','dikirim','selesai','batal') NOT NULL DEFAULT 'menunggu',
  `alamat_pengiriman` text         DEFAULT NULL,
  PRIMARY KEY (`id_pesanan`),
  KEY `idx_pesanan_pelanggan` (`pelanggan_id`),
  CONSTRAINT `fk_pesanan_pelanggan` FOREIGN KEY (`pelanggan_id`)
    REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 8. Tabel pesanan_produk
-- --------------------------------------------------------------------------
CREATE TABLE `pesanan_produk` (
  `id_pesanan_produk` int NOT NULL AUTO_INCREMENT,
  `pesanan_id`        int NOT NULL,
  `produk_id`         int NOT NULL,
  `jumlah`            int NOT NULL DEFAULT 1,
  `harga`             int NOT NULL COMMENT 'harga satuan saat dipesan',
  PRIMARY KEY (`id_pesanan_produk`),
  KEY `idx_pp_pesanan` (`pesanan_id`),
  KEY `idx_pp_produk` (`produk_id`),
  CONSTRAINT `fk_pp_pesanan` FOREIGN KEY (`pesanan_id`)
    REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pp_produk` FOREIGN KEY (`produk_id`)
    REFERENCES `produk` (`id_produk`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------------------------
-- 9. Tabel pembayaran
-- --------------------------------------------------------------------------
CREATE TABLE `pembayaran` (
  `id_pembayaran` int          NOT NULL AUTO_INCREMENT,
  `pesanan_id`    int          NOT NULL,
  `metode`        varchar(50)  DEFAULT NULL,
  `jumlah`        int          NOT NULL DEFAULT 0,
  `bukti`         varchar(100) DEFAULT NULL,
  `status`        enum('menunggu','berhasil','gagal') NOT NULL DEFAULT 'menunggu',
  `tanggal`       datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pembayaran`),
  KEY `idx_pembayaran_pesanan` (`pesanan_id`),
  CONSTRAINT `fk_pembayaran_pesanan` FOREIGN KEY (`pesanan_id`)
    REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================================
--  DATA AWAL
-- ==========================================================================
INSERT INTO `administrator` (`id_admin`, `username`, `password`, `full_name`) VALUES
(1, 'admin', MD5('admin123'), 'Administrator');

INSERT INTO `kategori` (`id_kategori`, `nama`, `deskripsi`) VALUES
(1, 'Baju Anak 1-5', 'Baju anak untuk usia 1-5 tahun'),
(2, 'Baju Koko',     'Baju pria dewasa');

INSERT INTO `produk` (`id_produk`, `nama`, `deskripsi`, `categori_id`, `harga`, `stok`) VALUES
(1, 'Baju Koko Dewasa', 'Baju koko panjang dan pendek', 2, 60000, 10);
