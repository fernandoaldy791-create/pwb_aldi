<div class="container mb-3 mt-4">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-1 text-center">
            <h4>Profil Saya</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-small">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">profil</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-6">
            <?php if ($this->session->flashdata('message')) : ?>
                <?= $this->session->flashdata('message') ?>
            <?php endif ?>
            <table class="table">
                <tr><th style="width:35%">Nama</th><td><?= html_escape($pelanggan['nama_pelanggan']) ?></td></tr>
                <tr><th>Email</th><td><?= html_escape($pelanggan['email']) ?></td></tr>
                <tr><th>No Telpon</th><td><?= html_escape($pelanggan['telp_pelanggan']) ?></td></tr>
                <tr><th>Alamat</th><td><?= html_escape($pelanggan['alamat']) ?></td></tr>
                <tr><th>Kota</th><td><?= html_escape($pelanggan['kota']) ?></td></tr>
                <tr><th>Kode Pos</th><td><?= html_escape($pelanggan['kode_pos']) ?></td></tr>
                <tr><th>Provinsi</th><td><?= html_escape($pelanggan['provinsi']) ?></td></tr>
            </table>
            <a href="<?= base_url('keranjang') ?>" class="btn btn-primary">Lihat Keranjang</a>
            <a href="<?= base_url("pesanan") ?>" class="btn btn-outline-primary">Pesanan Saya</a>
            <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</div>
