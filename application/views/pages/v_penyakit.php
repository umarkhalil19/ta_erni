<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Tabel <small>Tabel Gejala</small>
        </h1>
        <?php if (isset($_GET['notif'])) : _notif($this->session->flashdata($_GET['notif']));
        endif; ?>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tabel Data Gejala
                        <a href="<?= base_url("Penyakit/penyakit_add") ?>" class="btn btn-md btn-success pull-right"><i class="fa fa-plus"> Tambah Data</i></a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Penyakit</th>
                                        <th>Kode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($penyakit->result() as $p) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p->penyakit_nama ?></td>
                                            <td><?= $p->penyakit_kode ?></td>
                                            <td>
                                                <a href="<?= base_url('Penyakit/penyakit_edit/' . $p->penyakit_id) ?>" class="btn btn-sm btn-primary" title="Edit Data"><i class="fa fa-wrench"></i></a>
                                                <a href="<?= base_url('Penyakit/penyakit_delete/' . $p->penyakit_id) ?>" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    </div>
    <footer></footer>