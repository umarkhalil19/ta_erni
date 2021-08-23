<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Tabel <small>Tabel Uji</small>
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
                        Tabel Data Pasien Yang Akan diuji
                        <a href="<?= base_url('Data_uji/data_uji_add') ?>" class="btn btn-md btn-success pull-right"><i class="fa fa-plus"> Tambah Data</i></a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th rowspan="2">#</th>
                                        <th width="50%" rowspan="2">Gejala</th>
                                        <th width="5%" colspan="2">Diagnosa</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <th>Naive Bayes</th>
                                        <th>Dempster Shifer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($uji->result() as $u) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <?php
                                            $txt = "";
                                            $gejala = $this->db->query("SELECT gejala_id,gejala_uji_nilai FROM tbl_gejala_uji WHERE pasien_uji_id='$u->pasien_uji_id'");
                                            foreach ($gejala->result() as $g) :
                                                $nama = $this->db->query("SELECT gejala_nama FROM tbl_gejala WHERE gejala_id='$g->gejala_id'")->row();
                                                $txt .= $nama->gejala_nama . ',';
                                            ?>
                                            <?php endforeach ?>
                                            <td><?= $txt ?></td>
                                            <td>
                                                <?php
                                                if ($u->penyakit_kode_nb != "" && $u->penyakit_kode_nb != " ") {
                                                    echo $u->penyakit_kode_nb;
                                                } else {
                                                    echo "Belum Terdefinisi";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($u->penyakit_kode_ds != "" && $u->penyakit_kode_ds != " ") {
                                                    echo $u->penyakit_kode_ds;
                                                } else {
                                                    echo "Belum Terdefinisi";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('Data_uji/naive_bayes/' . $u->pasien_uji_id) ?>" class="btn btn-sm btn-primary">Naive Bayes</a> |
                                                <a href="<?= base_url('Data_uji/dempster_shafer/' . $u->pasien_uji_id) ?>" class="btn btn-sm btn-primary">Dempster Shafer</a>
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