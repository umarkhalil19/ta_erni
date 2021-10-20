<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Tabel <small>Tabel Data Dempster Shafer</small>
        </h1>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <!--   Kitchen Sink -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Nilai Bobot Kepercayaan Berdasarkan Gejala
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">Gejala</th>
                                        <th colspan="<?= $penyakit->num_rows() ?>">Penyakit</th>
                                        <th rowspan="2">Nilai Kepercayaan</th>
                                        <th rowspan="2">Nilai Ketidakpastian</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        foreach ($penyakit->result() as $p) :
                                        ?>
                                            <th><?= $p->penyakit_kode ?></th>
                                        <?php
                                        endforeach
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($gejala->result() as $g) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $g->gejala_nama ?></td>
                                            <?php
                                            foreach ($penyakit->result() as $p) :
                                            ?>
                                                <td>
                                                    <?php
                                                    $nilai = $this->db->query("SELECT dempster_nilai FROM tbl_dempster WHERE gejala_id='$g->gejala_id' AND penyakit_id='$p->penyakit_id'")->row();
                                                    echo $nilai->dempster_nilai;
                                                    ?>
                                                </td>
                                            <?php
                                            endforeach
                                            ?>
                                            <td><?= $g->gejala_kepercayaan ?></td>
                                            <td><?= $g->gejala_ketidakpastian ?></td>
                                            <td>
                                                <a href="<?= base_url('Dempster_shafer/dempster_edit/' . $g->gejala_id) ?>" class="btn btn-sm btn-primary" title="Edit Data"><small class="fa fa-wrench"></small></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End  Kitchen Sink -->
            </div>
        </div>
    </div>