<style>
    .image-produk {
        width: 100%
    }

    .image-nav {
        width: 100%;
        padding: 8%
    }
</style>
<?php if ($this->session->flashdata('message')) : ?>
    <div class="container mt-3"><?= $this->session->flashdata('message') ?></div>
<?php endif; ?>

<div class="container mb-3 mt-4">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-1 text-center">
            <h4><?= html_escape($produk['nama']) ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-small">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <?php if ($kategori) : ?>
                        <li class="breadcrumb-item"><a href="<?= base_url('kategori/') . $kategori['id_kategori'] ?>"><?= html_escape($kategori['nama']) ?></a></li>
                    <?php endif ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= html_escape($produk['nama']) ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-5">
            <div class="product-slick mb-2">
                <?php foreach ($list_gambar as $gambar) : ?>
                    <div><img src="<?= base_url('uploads/produk') ?>/<?= $gambar['nama_gambar'] ?>" alt="<?= html_escape($produk['nama']) ?>" class="image-produk img-fluid"></div>
                <?php endforeach ?>
                <?php if (empty($list_gambar)) : ?>
                    <div><img src="<?= base_url('assets/img/no-image.svg') ?>" alt="Tidak ada gambar" class="image-produk img-fluid"></div>
                <?php endif ?>
            </div>
            <div class="row">
                <div class="col-12 p-2">
                    <div class="slider-nav">
                        <?php foreach ($list_gambar as $gambar) : ?>
                            <div><img src="<?= base_url('uploads/produk') ?>/<?= $gambar['nama_gambar'] ?>" alt="" class=" image-nav img-fluid"></div>
                        <?php endforeach ?>
                        <?php if (empty($list_gambar)) : ?>
                            <div><img src="<?= base_url('assets/img/no-image.svg') ?>" alt="" class=" image-nav img-fluid"></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="produk-detail">
                <div class="pro-group">
                    <h2><?= html_escape($produk['nama']) ?></h2>
                    <h5>Rp <?= number_format($produk['harga']) ?> </h5>
                    <p>ID Produk: <?= $produk['id_produk'] ?></p>
                    <p>STOK: <?= (int) $produk['stok'] ?></p>
                    <div class="produk-order mb-0">
                        <h6 class="product-title">jumlah beli</h6>
                        <form action="<?= base_url("keranjang/tambah") ?>" method="post">
                            <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
                            <div class="input-group">
                                <input class="form-control" name="jumlah" type="number" value="1" min="1" max="<?= (int) $produk['stok'] ?>" <?= ((int) $produk['stok'] <= 0) ? 'disabled' : '' ?>>
                            </div>
                            <div class="product-buttons mt-4 mb-4">
                                <?php if ((int) $produk['stok'] > 0) : ?>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>
                                        tambah ke keranjang</button>
                                <?php else : ?>
                                    <button type="button" class="btn btn-secondary" disabled>Stok habis</button>
                                <?php endif ?>
                            </div>
                        </form>
                    </div>

                    <div class="deskripsi">
                        <h4>Deskripsi:</h4>
                        <p><?= nl2br(html_escape($produk['deskripsi'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        $('.product-slick').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.product-slick',
            dots: true,
            centerMode: true,
            focusOnSelect: true
        });
    });
</script>
