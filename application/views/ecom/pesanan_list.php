<div class="container mb-3 mt-4">
    <h2 class="mb-4">Pesanan Saya</h2>
    <?php if ($this->session->flashdata('message')) : ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <?php if (empty($list_pesanan)) : ?>
        <div class="text-center text-muted py-5">
            Belum ada pesanan.<br>
            <a href="<?= base_url('semua-produk') ?>" class="btn btn-outline-primary mt-3">Mulai belanja</a>
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_pesanan as $ps) : ?>
                        <tr>
                            <td>#<?= $ps['id_pesanan'] ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($ps['tanggal'])) ?></td>
                            <td>Rp <?= number_format($ps['total']) ?></td>
                            <td><span class="badge bg-secondary"><?= html_escape(ucfirst($ps['status'])) ?></span></td>
                            <td class="text-end"><a href="<?= base_url('pesanan/') . $ps['id_pesanan'] ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>
