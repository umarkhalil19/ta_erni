<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Form Edit Data <small>Algoritma Dempster Shafer</small>
        </h1>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="card-title">
                            <div class="title">Form Tambah Data Pasien</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?= form_open(base_url('Dempster_shafer/dempster_update')) ?>
                        <div class="sub-title">Nama Gejala</div>
                        <div>
                            <input type="text" class="form-control" name="gejala" value="<?= $nama->gejala_nama ?>" readonly>
                            <input type="hidden" class="form-control" name="id" value="<?= $nama->gejala_id ?>">
                        </div>
                        <!-- <h5><b>Silahkan Pilih Gejala Berikut Sesuai Dengan Keluhan Pasien : </b></h5> -->
                        <div>
                            <?php
                            foreach ($penyakit->result() as $g) :
                                $cek = $this->db->query("SELECT dempster_nilai FROM tbl_dempster WHERE gejala_id='$nama->gejala_id' AND penyakit_id='$g->penyakit_id'")->row();
                                if ($cek) {
                                    $nilai = $cek->dempster_nilai;
                                } else {
                                    $nilai = 0;
                                }
                            ?>
                                <div class="sub-title"><?= $g->penyakit_nama ?> (Nilai Pakar)</div>
                                <div class="">
                                    <input type="text" name="<?= $g->penyakit_id . 'gejala' ?>" value="<?= $nilai ?>" class="form-control">
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="sub-title">Nilai Kepercayaan</div>
                        <div>
                            <input type="text" class="form-control" value="<?= $nama->gejala_kepercayaan ?> (Dihitung oleh sistem)" readonly>
                        </div>
                        <div class="sub-title">Nilai Ketidakpastian</div>
                        <div>
                            <input type="text" class="form-control" value="<?= $nama->gejala_ketidakpastian ?> (Dihitung oleh sistem)" readonly>
                        </div>
                        <br>
                        <div>
                            <button class="btn btn-md btn-success pull-right" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>