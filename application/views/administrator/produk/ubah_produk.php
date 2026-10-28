<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ubah Produk</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <?php if ($this->session->flashdata('message')) : ?>
                <?= $this->session->flashdata('message') ?>
              <?php endif ?>
              <form method="post" action="<?= base_url('admin/produk/ubah/') . $produk['id_produk'] ?>" enctype="multipart/form-data">
                <div class="mb-3 form-group">
                  <label for="nama_produk" class="form-label">Nama produk</label>
                  <input type="text" class="form-control" name="nama_produk" id="nama_produk" aria-describedby="Nama produk" value="<?= set_value('nama_produk', $produk['nama']) ?>">
                  <small class="text-danger"><em><?= form_error('nama_produk') ?></em></small>
                </div>
                <div class="mb-3 form-group">
                  <label for="kategori_produk" class="form-label">Kategori produk</label>
                  <select class="form-control" name="kategori_produk" id="kategori_produk">
                    <option value="">-- pilih kategori --</option>
                    <?php foreach ($list_kategori as $kategori) : ?>
                      <option <?= ((string) set_value('kategori_produk', $produk['categori_id']) === (string) $kategori['id_kategori']) ? "selected" : '' ?> value="<?= $kategori['id_kategori'] ?>"><?= html_escape($kategori['nama']) ?></option>
                    <?php endforeach ?>
                  </select>
                  <small class="text-danger"><em><?= form_error('kategori_produk') ?></em></small>
                </div>
                <div class="mb-3 form-group">
                  <label for="harga_produk" class="form-label">Harga</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">Rp</span></div>
                    <input type="number" min="0" name="harga_produk" id="harga_produk" class="form-control" value="<?= set_value('harga_produk', $produk['harga']) ?>">
                  </div>
                  <small class="text-danger"><em><?= form_error('harga_produk') ?></em></small>
                </div>
                <div class="mb-3 form-group">
                  <label for="stok_produk" class="form-label">Stok produk</label>
                  <input type="number" min="0" class="form-control" name="stok_produk" id="stok_produk" aria-describedby="Stok produk" value="<?= set_value('stok_produk', $produk['stok']) ?>">
                  <small class="text-danger"><em><?= form_error('stok_produk') ?></em></small>
                </div>
                <div class="mb-3 form-group">
                  <label for="gambar_produk" class="form-label">Gambar Produk</label>
                  <input class="form-control" type="file" id="gambar_produk" name="gambar_produk[]" accept=".jpg,.jpeg,.png,.gif,.webp,image/*" multiple>
                  <small class="text-muted">Pilih gambar baru untuk menambah gambar produk. Centang opsi di bawah bila gambar lama ingin diganti seluruhnya.</small>
                  <div class="custom-control custom-checkbox mt-2">
                    <input type="checkbox" class="custom-control-input" id="ganti_semua_gambar" name="ganti_semua_gambar" value="1">
                    <label class="custom-control-label" for="ganti_semua_gambar">Ganti semua gambar lama dengan gambar yang baru dipilih</label>
                  </div>
                </div>
                <?php
                // get gambar dengan id produk
                $list_gambar = $gambar_model->get_by_produk_id($produk['id_produk']);
                ?>
                <div class="row mb-3">
                  <?php foreach ($list_gambar as $gambar) : ?>
                    <div class="col-lg-3">
                      <div class="card" style="width: 18rem; max-width: 100%;">
                        <img src="<?= base_url('uploads/produk/') . rawurlencode($gambar['nama_gambar']) ?>" class="card-img-top" alt="Gambar produk">
                        <div class="card-body">
                          <a href="<?= base_url('admin/produk/hapus_gambar/') . $gambar['id_gambar'] ?>" class="btn btn-danger btn-block" onclick="return confirm('Hapus gambar ini?')">Hapus</a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                  <?php if (empty($list_gambar)) : ?>
                    <div class="col-12"><span class="text-muted">Produk ini belum memiliki gambar.</span></div>
                  <?php endif ?>
                </div>

                <div class="mb-3 form-group">
                  <label for="deskripsi_produk" class="form-label">Deskripsi</label>
                  <textarea name="deskripsi_produk" id="deskripsi_produk" cols="30" rows="10" class="form-control"><?= set_value('deskripsi_produk', $produk['deskripsi']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
                <a href="<?= base_url('admin/produk') ?>" class="btn btn-danger">Kembali</a>
              </form>
            </div>
          </div>
        </div>
        <!-- /.col-md-6 -->

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
