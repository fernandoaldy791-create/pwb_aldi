<div class="container mb-3 mt-4">
    <h2 class="mb-4">Pesanan #<?= $pesanan['id_pesanan'] ?></h2>
    <?php if ($this->session->flashdata('message')) : ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-6">
            <p class="mb-1"><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($pesanan['tanggal'])) ?></p>
            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-secondary"><?= html_escape(ucfirst($pesanan['status'])) ?></span></p>
        </div>
        <div class="col-md-6">
            <p class="mb-1"><strong>Alamat pengiriman:</strong></p>
            <p><?= nl2br(html_escape($pesanan['alamat_pengiriman'])) ?></p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_item as $item) : ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?= $item['gambar'] ? base_url('uploads/produk/') . $item['gambar'] : base_url('assets/img/no-image.svg') ?>" alt="" class="me-3" style="width:60px;height:auto">
                                <a href="<?= base_url('produk/') . $item['id_produk'] ?>" class="text-decoration-none text-dark"><strong><?= html_escape($item['nama']) ?></strong></a>
                            </div>
                        </td>
                        <td>Rp <?= number_format($item['harga']) ?></td>
                        <td><?= (int) $item['jumlah'] ?></td>
                        <td>Rp <?= number_format($item['harga'] * $item['jumlah']) ?></td>
                    </tr>
                <?php endforeach ?>
                <tr class="table-light">
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong>Rp <?= number_format($pesanan['total']) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="<?= base_url('pesanan') ?>" class="btn btn-outline-primary">Semua pesanan</a>
    <a href="<?= base_url() ?>" class="btn btn-outline-secondary">Kembali belanja</a>
</div>
