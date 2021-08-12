<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Tabel <small>Tabel Data Naive Bayes</small>
        </h1>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-6">
                <!--   Kitchen Sink -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Jumlah kasus Berdasarkan Penyakit
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Penyakit</th>
                                        <th>Kode</th>
                                        <th>Jumlah</th>
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
                                                <?php
                                                $j = $this->db->query("SELECT COUNT(pasien_id) as nilai FROM tbl_pasien WHERE penyakit_kode='$p->penyakit_kode'")->row();
                                                echo $j->nilai;
                                                ?>
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
            <div class="col-md-6">
                <!--   Kitchen Sink -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Nilai Prior Probability Berdasarkan Penyakit
                        <a href="<?= base_url('Naive_bayes/prior_probability') ?>" class="btn btn-sm btn-primary pull-right" title="Update Data"><i class="fa fa-refresh"></i></a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Penyakit</th>
                                        <th>Kode</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($pp->result() as $pp) :
                                        $nama = $this->m_vic->edit_data(['penyakit_id' => $pp->penyakit_id], 'tbl_penyakit')->row();
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $nama->penyakit_nama ?></td>
                                            <td><?= $nama->penyakit_kode ?></td>
                                            <td><?= $pp->pp_nilai ?></td>
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
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Nilai Likelihood Berdasarkan Penyakit
                        <a href="<?= base_url('Naive_bayes/likelihood') ?>" class="btn btn-sm btn-primary pull-right" title="Update Data"><i class="fa fa-refresh"></i></a>
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
                                        <th rowspan="2">Penyakit</th>
                                        <th rowspan="2">Kode</th>
                                        <th colspan="<?= $jmlh->jmlh; ?>" style="text-align: center;">Gejala</th>
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
                                    foreach ($penyakit->result() as $p) :
                                        $g_j = $this->db->query("SELECT lh_nilai FROM tbl_likelihood WHERE penyakit_kode='$p->penyakit_kode'");
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p->penyakit_nama ?></td>
                                            <td><?= $p->penyakit_kode ?></td>
                                            <?php
                                            foreach ($g_j->result() as $g2) :
                                            ?>
                                                <td><?= $g2->lh_nilai ?></td>
                                            <?php endforeach ?>
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