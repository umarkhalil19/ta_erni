<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Tabel <small>Tabel Data Latih</small>
        </h1>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tabel Data Pasien
                        <a href="#" class="btn btn-md btn-success pull-right"><i class="fa fa-plus"> Tambah Data</i></a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <?php
                                    $jmlh = $this->db->query("SELECT COUNT(gejala_id) as jmlh FROM tbl_gejala")->row();
                                    $gejala = $this->db->query("SELECT gejala_id,gejala_kode FROM tbl_gejala");
                                    ?>
                                    <tr>
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">Pasien</th>
                                        <th rowspan="2">Diagnosa</th>
                                        <th colspan="<?= $jmlh->jmlh; ?>" style="text-align: center;">Gejala</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        foreach ($gejala->result() as $g) :
                                        ?>
                                            <th><?= $g->gejala_kode ?></th>
                                        <?php endforeach ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($pasien->result() as $p) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p->pasien_nama ?></td>
                                            <td><?= $p->penyakit_kode ?></td>
                                            <?php
                                            $diagnosa = $this->db->query("SELECT gejala_nilai FROM tbl_diagnosa WHERE pasien_id='$p->pasien_id'");
                                            foreach ($diagnosa->result() as $d) :
                                                switch ($d->gejala_nilai) {
                                                    case '1':
                                                        $txt = 'Ya';
                                                        break;
                                                    case '0':
                                                        $txt = 'Tidak';
                                                        break;
                                                    default:
                                                        $txt = "";
                                                        break;
                                                }
                                            ?>
                                                <td><?= $txt ?></td>
                                            <?php
                                            endforeach
                                            ?>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary" title="Edit Data"><i class="fa fa-wrench"></i></a>
                                                <a href="#" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
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