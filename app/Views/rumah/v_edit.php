<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>
        </div>
        <div class="card-body">

            <?php
            $validation = \Config\Services::validation();
            ?>

            <!-- Menampilkan pesan error jika ada -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Error!</h5>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?= form_open_multipart('Rumah/UpdateData/' . $rumah['id_rumah']) ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama KK</label>
                    <input name="nama_kk" value="<?= old('nama_kk', $rumah['nama_kk']) ?>" placeholder="Nama KK" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('nama_kk') ? $validation->getError('nama_kk') : '' ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label>No. KTP</label>
                    <input name="nomor_ktp" value="<?= old('nomor_ktp', $rumah['nomor_ktp']) ?>" placeholder="No. KTP" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('nomor_ktp') ? $validation->getError('nomor_ktp') : '' ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Alamat</label>
                    <input name="alamat" value="<?= old('alamat', $rumah['alamat']) ?>" placeholder="Alamat" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('alamat') ? $validation->getError('alamat') : '' ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Koordinat</label>
                    <input name="coordinat" value="<?= old('coordinat', $rumah['coordinat']) ?>" placeholder="Koordinat (latitude,longitude)" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('coordinat') ? $validation->getError('coordinat') : '' ?></p>
                </div>
            </div>

            <!-- Kolom Keterangan -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Keterangan</label>
                    <select name="id_keterangan" class="form-control">
                        <option value="">--Pilih Keterangan--</option>
                        <?php foreach ($keterangan as $keterangan_data): ?>
                            <option value="<?= $keterangan_data['id_keterangan'] ?>" <?= old('id_keterangan', $rumah['id_keterangan']) == $keterangan_data['id_keterangan'] ? 'selected' : '' ?>>
                                <?= $keterangan_data['keterangan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_keterangan') ? $validation->getError('id_keterangan') : '' ?></p>
                </div>
            </div>

            <!-- Kolom Provinsi, Kabupaten, Kecamatan, Wilayah Administrasi -->
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Provinsi</label>
                    <select name="id_provinsi" class="form-control">
                        <option value="">--Pilih Provinsi--</option>
                        <?php foreach ($provinsi as $provinsi_data): ?>
                            <option value="<?= $provinsi_data['id_provinsi'] ?>" <?= old('id_provinsi', $rumah['id_provinsi']) == $provinsi_data['id_provinsi'] ? 'selected' : '' ?>>
                                <?= $provinsi_data['nama_provinsi'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_provinsi') ? $validation->getError('id_provinsi') : '' ?></p>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Kabupaten</label>
                    <select name="id_kabupaten" class="form-control">
                        <option value="">--Pilih Kabupaten--</option>
                        <?php foreach ($kabupaten as $kabupaten_data): ?>
                            <option value="<?= $kabupaten_data['id_kabupaten'] ?>" <?= old('id_kabupaten', $rumah['id_kabupaten']) == $kabupaten_data['id_kabupaten'] ? 'selected' : '' ?>>
                                <?= $kabupaten_data['nama_kabupaten'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_kabupaten') ? $validation->getError('id_kabupaten') : '' ?></p>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Kecamatan</label>
                    <select name="id_kecamatan" class="form-control">
                        <option value="">--Pilih Kecamatan--</option>
                        <?php foreach ($kecamatan as $kecamatan_data): ?>
                            <option value="<?= $kecamatan_data['id_kecamatan'] ?>" <?= old('id_kecamatan', $rumah['id_kecamatan']) == $kecamatan_data['id_kecamatan'] ? 'selected' : '' ?>>
                                <?= $kecamatan_data['nama_kecamatan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_kecamatan') ? $validation->getError('id_kecamatan') : '' ?></p>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Wilayah Administrasi</label>
                    <select name="id_wilayah" class="form-control">
                        <option value="">--Pilih Wilayah--</option>
                        <?php foreach ($wilayah as $wilayah_data): ?>
                            <option value="<?= $wilayah_data['id_wilayah'] ?>" <?= old('id_wilayah', $rumah['id_wilayah']) == $wilayah_data['id_wilayah'] ? 'selected' : '' ?>>
                                <?= $wilayah_data['nama_wilayah'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('id_wilayah') ? $validation->getError('id_wilayah') : '' ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Jenis Atap</label>
                    <select name="jenis_atap" class="form-control">
                        <option value="">--Pilih Jenis Atap--</option>
                        <option value="Genteng" <?= old('jenis_atap', $rumah['jenis_atap']) == 'Genteng' ? 'selected' : '' ?>>Genteng</option>
                        <option value="Seng" <?= old('jenis_atap', $rumah['jenis_atap']) == 'Seng' ? 'selected' : '' ?>>Seng</option>
                        <option value="Asbes" <?= old('jenis_atap', $rumah['jenis_atap']) == 'Asbes' ? 'selected' : '' ?>>Asbes</option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('jenis_atap') ? $validation->getError('jenis_atap') : '' ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Dinding</label>
                    <select name="jenis_dinding" class="form-control">
                        <option value="">--Pilih Jenis Dinding--</option>
                        <option value="Tembok" <?= old('jenis_dinding', $rumah['jenis_dinding']) == 'Tembok' ? 'selected' : '' ?>>Tembok</option>
                        <option value="Kayu" <?= old('jenis_dinding', $rumah['jenis_dinding']) == 'Kayu' ? 'selected' : '' ?>>Kayu</option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('jenis_dinding') ? $validation->getError('jenis_dinding') : '' ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Jenis Lantai</label>
                    <select name="jenis_lantai" class="form-control">
                        <option value="">--Pilih Jenis Lantai--</option>
                        <option value="Keramik" <?= old('jenis_lantai', $rumah['jenis_lantai']) == 'Keramik' ? 'selected' : '' ?>>Keramik</option>
                        <option value="Tanah" <?= old('jenis_lantai', $rumah['jenis_lantai']) == 'Tanah' ? 'selected' : '' ?>>Tanah</option>
                    </select>
                    <p class="text-danger"><?= $validation->hasError('jenis_lantai') ? $validation->getError('jenis_lantai') : '' ?></p>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Bantuan</label>
                    <input name="jenis_bantuan" value="<?= old('jenis_bantuan', $rumah['jenis_bantuan']) ?>" placeholder="Jenis Bantuan" class="form-control">
                    <p class="text-danger"><?= $validation->hasError('jenis_bantuan') ? $validation->getError('jenis_bantuan') : '' ?></p>
                </div>
            </div>

            <!-- Kolom Foto -->
            <div class="mb-3">
                <label>Foto Rumah</label><br>
                <img src="<?= base_url('foto/' . $rumah['foto']) ?>" alt="Foto Rumah" width="100" />
                <input type="file" name="foto" class="form-control" accept="image/*">
                <p class="text-danger"><?= $validation->hasError('foto') ? $validation->getError('foto') : '' ?></p>
            </div>

            <button class="btn btn-primary btn-flat" type="submit">Simpan</button>
            <a href="<?= base_url('Rumah') ?>" class="btn btn-success btn-flat">Kembali</a>

            <?= form_close(); ?>
        </div>
    </div>
</div>
