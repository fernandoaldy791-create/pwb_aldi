<?php
// Kartu produk (dipakai home.php dan produk_list.php). Variabel yang dibutuhkan: $value, $gambar_model
$gambar = $gambar_model->get_by_produk_id($value['id_produk']);
$src_gambar = !empty($gambar)
    ? base_url('uploads/produk/') . $gambar[0]['nama_gambar']
    : base_url('assets/img/no-image.svg');
?>
<div class="col">
    <div class="card shadow-sm h-100">
        <a href="<?= base_url('produk/') . $value['id_produk'] ?>">
            <img src="<?= $src_gambar ?>" class="d-block w-100" alt="<?= html_escape($value['pd_nama']) ?>" style="aspect-ratio:1/1;object-fit:cover;">
        </a>
        <?php if ((int) $value['stok'] <= 0) : ?>
            <div class="diskon">
                <span class="badge bg-danger">Stok habis</span>
            </div>
        <?php endif ?>
        <div class="card-body">
            <a href="<?= base_url('produk/') . $value['id_produk'] ?>">
                <h5 class="card-title"><?= html_escape($value['pd_nama']) ?></h5>
            </a>
            <div class="d-flex justify-content-between align-items-center">
                <div class="harga d-flex" style="color:dark">
                    <small>Rp</small>
                    <h4><?= number_format($value['harga']) ?></h4>
                </div>
                <small>
                    <p><?= (int) $value['terjual'] ?> terjual</p>
                </small>
            </div>
        </div>
    </div>
</div>
