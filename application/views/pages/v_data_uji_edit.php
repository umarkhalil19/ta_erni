<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Form Edit <?= $title_sub ?> <small>Data Pasien</small>
        </h1>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="card-title">
                            <div class="title">Form Edit Data Pasien</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?= form_open(base_url('Data_uji/data_uji_update/' . $pasien->pasien_uji_id)) ?>
                        <div class="sub-title">Nama Pasien</div>
                        <div>
                            <input type="text" class="form-control" name="pasien" value="<?= $pasien->pasien_uji_nama ?>">
                        </div>
                        <hr>
                        <h5><b>Silahkan Pilih Gejala Berikut Sesuai Dengan Keluhan Pasien : </b></h5>
                        <div>
                            <?php
                            foreach ($gejala->result() as $g) :
                                $cek = $this->db->query("SELECT gejala_uji_id FROM tbl_gejala_uji WHERE pasien_uji_id='$pasien->pasien_uji_id' AND gejala_id='$g->gejala_id'")->num_rows();
                                // echo '<pre>';
                                // print_r($cek);
                                // echo '</pre>';
                            ?>
                                <div class="sub-title"><?= $g->gejala_nama ?></div>
                                <div class="radio3 radio-check radio-success radio-inline">
                                    <input type="radio" id="radio5<?= $g->gejala_id ?>" name="<?= $g->gejala_id . 'gejala' ?>" value="1" <?php echo $cek == 1 ? 'checked' : ''; ?>>
                                    <label for="radio5<?= $g->gejala_id ?>">
                                        Ya
                                    </label>
                                </div>
                                <div class="radio3 radio-check radio-warning radio-inline">
                                    <input type="radio" id="radio6<?= $g->gejala_id ?>" name="<?= $g->gejala_id . 'gejala' ?>" value="0" <?php echo $cek != 1 ? 'checked' : ''; ?>>
                                    <label for="radio6<?= $g->gejala_id ?>">
                                        Tidak
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div>
                            <button class="btn btn-md btn-success" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>