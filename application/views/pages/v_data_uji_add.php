<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Form Tambah Data Uji <small>Data Pasien</small>
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
                        <?= form_open(base_url('Data_uji/data_uji_add_act')) ?>
                        <div class="sub-title">Nama Pasien</div>
                        <div>
                            <input type="text" class="form-control" name="pasien" placeholder="Nama Pasien">
                        </div>
                        <hr>
                        <h5><b>Silahkan Pilih Gejala Berikut Sesuai Dengan Keluhan Pasien : </b></h5>
                        <div>
                            <?php
                            foreach ($gejala->result() as $g) :
                            ?>
                                <div class="sub-title"><?= $g->gejala_nama ?></div>
                                <div class="radio3 radio-check radio-success radio-inline">
                                    <input type="radio" id="radio5<?= $g->gejala_id ?>" name="<?= $g->gejala_id . 'gejala' ?>" value="1">
                                    <label for="radio5<?= $g->gejala_id ?>">
                                        Ya
                                    </label>
                                </div>
                                <div class="radio3 radio-check radio-warning radio-inline">
                                    <input type="radio" id="radio6<?= $g->gejala_id ?>" name="<?= $g->gejala_id . 'gejala' ?>" value="0">
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