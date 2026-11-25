
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ubah Ekspedisi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= site_url('admin/dashboard'); ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= site_url('admin/ekspedisi2422500068'); ?>">Ekspedisi</a>
                        </li>
                        <li class="breadcrumb-item active">Ubah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">

                <div class="card-header">
                    <h3 class="card-title">Form Ubah Ekspedisi</h3>
                </div>

                <?= form_open('admin/ekspedisi2422500068/update/' . $ekspedisi2422500068['id_ekspedisi068']); ?>

                <div class="card-body">

                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nama_ekspedisi068">Nama Ekspedisi</label>
                        <input
                            type="text"
                            name="nama_ekspedisi068"
                            id="nama_ekspedisi068"
                            class="form-control"
                            maxlength="100"
                            value="<?= set_value('nama_ekspedisi068', $ekspedisi2422500068['nama_ekspedisi068']); ?>"
                            placeholder="Masukkan nama ekspedisi"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_layanan068">Jenis Layanan</label>
                        <textarea
                            name="jenis_layanan068"
                            id="jenis_layanan068"
                            class="form-control"
                            rows="3"
                            maxlength="100"
                            placeholder="Contoh: Reguler, Express, Same Day"><?= set_value('jenis_layanan068', $ekspedisi2422500068['jenis_layanan068']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tarif_per_kg068">Tarif Per Kilogram</label>
                        <input
                            type="number"
                            name="tarif_per_kg068"
                            id="tarif_per_kg068"
                            class="form-control"
                            min="0"
                            step="1"
                            value="<?= set_value('tarif_per_kg068', $ekspedisi2422500068['tarif_per_kg068']); ?>"
                            placeholder="Masukkan tarif per kilogram"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="status068">Status</label>
                        <select
                            name="status068"
                            id="status068"
                            class="form-control"
                            required>

                            <option value="">-- Pilih Status --</option>

                            <option value="Aktif"
                                <?= set_select('status068', 'Aktif', $ekspedisi2422500068['status068'] == 'Aktif'); ?>>
                                Aktif
                            </option>

                            <option value="Nonaktif"
                                <?= set_select('status068', 'Nonaktif', $ekspedisi2422500068['status068'] == 'Nonaktif'); ?>>
                                Nonaktif
                            </option>

                        </select>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>

                    <a href="<?= site_url('admin/ekspedisi2422500068'); ?>"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>

                <?= form_close(); ?>

            </div>
        </div>
    </section>
</div>
