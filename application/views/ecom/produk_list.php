<style>
    .diskon {
        position: absolute;
        top: 8px;
        right: 16px;
    }
</style>
<div class="container mb-3 mt-4">
    <div class="p-4 mb-4 bg-light rounded-3">
        <div class="container-fluid py-1 text-center">
            <h4><?= html_escape($judul) ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-small mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Produk</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <?php foreach ($list_produk as $value) : ?>
            <?php $this->load->view('ecom/_produk_card', array('value' => $value, 'gambar_model' => $gambar_model)); ?>
        <?php endforeach ?>
    </div>

    <?php if (empty($list_produk)) : ?>
        <div class="text-center text-muted py-5">Produk tidak ditemukan.</div>
    <?php endif ?>
</div>
