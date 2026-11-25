<style>
    .diskon {
        position: absolute;
        top: 8px;
        right: 16px;
    }
</style>
<?php if ($this->session->flashdata('message')) : ?>
    <div class="container"><?= $this->session->flashdata('message') ?></div>
<?php endif; ?>
<div class="container mb-3">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">

        <?php foreach ($list_produk as $key => $value) : ?>
            <?php $this->load->view('ecom/_produk_card', array('value' => $value, 'gambar_model' => $gambar_model)); ?>
        <?php endforeach ?>

        <?php if (empty($list_produk)) : ?>
            <div class="col-12 text-center text-muted py-5">Belum ada produk.</div>
        <?php endif ?>

    </div>
</div>

<div class="container mt-4 text-center">
    <a href="<?= base_url('semua-produk') ?>" class="btn btn-outline-primary">Lihat Semua Produk</a>
</div>
