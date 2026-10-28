<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"><div class="row mb-2">
            <div class="col-sm-6"><h1>Starter Page</h1></div>
            <div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="<?= site_url('admin/dashboard'); ?>">Home</a></li><li class="breadcrumb-item active">Starter Page</li></ol></div>
        </div></div>
    </section>
    <section class="content"><div class="container-fluid">
        <div class="card"><div class="card-body">
            <p>Kategori</p>
            <a href="<?= site_url('admin/kategori/tambah'); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-plus"></i> Kategori</a>
            <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible"><?= html_escape($this->session->flashdata('success')); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible"><?= html_escape($this->session->flashdata('error')); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
            <div class="table-responsive"><table class="table table-bordered">
                <thead><tr><th style="width:70px">No</th><th>Nama</th><th>Deskripsi</th><th style="width:160px">Action</th></tr></thead>
                <tbody>
                <?php if (!empty($kategori)): ?>
                    <?php $no = 1; foreach ($kategori as $item): ?><tr>
                        <td><?= $no++; ?></td><td><?= html_escape($item['nama']); ?></td><td><?= html_escape($item['deskripsi']); ?></td>
                        <td><a class="btn btn-success btn-xs" style="padding:2px 5px;font-size:11px;line-height:1.2" href="<?= site_url('admin/kategori/ubah/' . $item['id_kategori']); ?>">Ubah</a> <a class="btn btn-danger btn-xs" style="padding:2px 5px;font-size:11px;line-height:1.2" href="<?= site_url('admin/kategori/hapus/' . $item['id_kategori']); ?>" onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a></td>
                    </tr><?php endforeach; ?>
                <?php else: ?><tr><td colspan="4" class="text-center">Belum ada data kategori.</td></tr><?php endif; ?>
                </tbody>
            </table></div>
        </div></div>
    </div></section>
</div>
