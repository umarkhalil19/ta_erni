<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Form Edit Data Master <small>Data Penyakit</small>
        </h1>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="card-title">
                            <div class="title">Form Edit Data Penyakit</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?= form_open(base_url('Penyakit/penyakit_update')) ?>
                        <div class="sub-title">Nama Penyakit</div>
                        <div>
                            <input type="hidden" name="id" value="<?= $penyakit->penyakit_id ?>">
                            <input type="text" class="form-control" name="penyakit" value="<?= $penyakit->penyakit_nama ?>">
                            <?php echo form_error('penyakit', '<small><span class="text-danger">', '</span></small>'); ?>
                        </div>
                        <div class="sub-title">Kode Penyakit</div>
                        <div>
                            <input type="text" class="form-control" name="kode" value="<?= $penyakit->penyakit_kode ?>">
                            <?php echo form_error('kode', '<small><span class="text-danger">', '</span></small>'); ?>
                        </div>
                        <hr>
                        <div>
                            <button class="btn btn-md btn-success pull-right" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>