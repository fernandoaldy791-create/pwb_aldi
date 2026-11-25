
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Toko Online</title>

    <!-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" /> -->

    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />

    <script src="<?= base_url() ?>assets/plugins/fontawesome/js/all.js" crossorigin="anonymous"></script>

    <script src="<?= base_url() ?>assets/plugins/jquery/jquery-1.11.0.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/slick/slick.css" />

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/slick/slick-theme.css" />

</head>

<body class="sb-nav-fixed">
<?php
// data navbar: daftar kategori, status login pelanggan, dan jumlah isi keranjang
$ci =& get_instance();
$ci->load->model('produk_kategori_model');
$nav_kategori = $ci->produk_kategori_model->get_all();
$nav_login = (bool) $ci->session->userdata('pelanggan_login');
$nav_jml_keranjang = 0;
if ($nav_login) {
    $ci->load->model('keranjang_model');
    $ci->load->model('keranjang_produk_model');
    $nav_keranjang = $ci->keranjang_model->get_by_pelanggan($ci->session->userdata('id'));
    if ($nav_keranjang) {
        $nav_jml_keranjang = count($ci->keranjang_produk_model->get_by_keranjang($nav_keranjang[0]['id_keranjang']));
    }
}
?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-2" aria-label="Eighth navbar example">
        <div class="container">

            <a class="navbar-brand" href="<?= base_url() ?>">Toko Online</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample07">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url() ?>">Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>

                        <ul class="dropdown-menu">
                            <?php foreach ($nav_kategori as $kt) : ?>
                                <li><a class="dropdown-item" href="<?= base_url('kategori/') . $kt['id_kategori'] ?>"><?= html_escape($kt['nama']) ?></a></li>
                            <?php endforeach ?>
                            <?php if (empty($nav_kategori)) : ?>
                                <li><span class="dropdown-item-text text-muted">Belum ada kategori</span></li>
                            <?php endif ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('semua-produk') ?>">Semua Produk</a></li>
                        </ul>
                    </li>

                </ul>

                <form role="search" class="me-3" action="<?= base_url('semua-produk') ?>" method="get">
                    <input class="form-control" type="search" name="q" placeholder="Cari produk" aria-label="Search" value="<?= isset($keyword) ? html_escape($keyword) : '' ?>">
                </form>

                <div class="text-end">
                    <?php if ($nav_login) : ?>
                        <a href="<?= base_url('keranjang') ?>" class="btn btn-outline-light me-2">Keranjang<?php if ($nav_jml_keranjang > 0) : ?> <span class="badge bg-warning text-dark"><?= $nav_jml_keranjang ?></span><?php endif ?></a>
                        <a href="<?= base_url('pesanan') ?>" class="btn btn-outline-light me-2">Pesanan</a>
                        <a href="<?= base_url('profil') ?>" class="btn btn-outline-light me-2"><?= html_escape($ci->session->userdata('nama')) ?></a>
                        <a href="<?= base_url('logout') ?>" class="btn btn-warning">Logout</a>
                    <?php else : ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-light me-2">Login</a>
                        <a href="<?= base_url('register') ?>" class="btn btn-warning">Register</a>
                    <?php endif ?>
                </div>

            </div>
        </div>
    </nav>
