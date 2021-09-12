<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Tabel <small>Tabel <?= $title_sub ?></small>
        </h1>
        <?php if (isset($_GET['notif'])) : _notif($this->session->flashdata($_GET['notif']));
        endif; ?>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <label>Solusi</label>
                    <ul>
                        <li>Suspek - Melapor dan memeriksakan langsung ke pusat kesehatan masyarakat atau rumah sakit atau fasyankes lainnya agar dapat mendapatkan pemeriksaan lebih lanjut berupa pengambilan pesimen/swab dan melakukan isolasi 10 hari setelah melakukan pemeriksaan. Dan tetap mendapat pemantauan yang dilakukan petugas kesehatan</li><br>
                        <li>Non Suspek - Melakukan pemeriksaan ke pusat kesehatan masyarakat atau rumah sakit untuk mendapatkan pemeriksaan lebih lanjut. Dan tetap mematuhi protokol kesehatan</li><br>
                        <li>Kontak Erat - Melaporkan kepada Petugas COVID-19, melakukan karantina selama 14 hari dan mendapat pemantauan dari petugas COVID-19. Jika setelah 14 hari tidak muncul gejala maka pemantauan dihentikan, namun jika muncul gejala maka harus segera diisolasi dan mendapat pemeriksaan swab (RT-PCR)</li>
                    </ul>
                </div>
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tabel Data Pasien Yang Akan diuji
                        <?php
                        if ($this->session->userdata('level') == 99) {
                        ?>
                            <a href="<?= base_url('Data_uji/data_uji_add') ?>" class="btn btn-md btn-success pull-right"><i class="fa fa-plus"> Tambah Data</i></a>
                        <?php } else { ?>
                            <a href="<?= base_url('Data_uji/data_uji_add') ?>" class="btn btn-md btn-success pull-right"><i class="fa fa-plus"> Screening</i></a>
                        <?php } ?>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th rowspan="2">#</th>
                                        <th width="35%" rowspan="2">Gejala</th>
                                        <th width="5%" colspan="2">Diagnosa</th>
                                        <th rowspan="2">Pengujian Algortima</th>
                                        <?php
                                        if ($this->session->userdata('level') == 99) {
                                        ?>
                                            <th rowspan="2">Action</th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th>Naive Bayes</th>
                                        <th>Dempster Shafer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($uji->result() as $u) :
                                        $nama_p = $this->db->query("SELECT penyakit_nama FROM tbl_penyakit WHERE penyakit_kode='$u->penyakit_kode_nb'")->row();
                                        $nama_p2 = "";
                                        $a_penyakit = explode(",", $u->penyakit_kode_ds);
                                        foreach ($a_penyakit as $ap) {
                                            $c_nama = $this->db->query("SELECT penyakit_nama FROM tbl_penyakit WHERE penyakit_kode='$ap'")->row();
                                            $nama_p2 .= $c_nama->penyakit_nama . '/';
                                        }
                                    ?>
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
                                            <td><?= substr($txt, 0, -1); ?></td>
                                            <td>
                                                <?php
                                                if ($u->penyakit_kode_nb != "" && $u->penyakit_kode_nb != " ") {
                                                    echo $nama_p->penyakit_nama;
                                                } else {
                                                    echo "Belum Terdefinisi";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($u->penyakit_kode_ds != "" && $u->penyakit_kode_ds != " ") {
                                                    echo substr($nama_p2, 0, -1);
                                                } else {
                                                    echo "Belum Terdefinisi";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('Data_uji/naive_bayes/' . $u->pasien_uji_id) ?>" class="btn btn-sm btn-primary">Naive Bayes</a> |
                                                <a href="<?= base_url('Data_uji/dempster_shafer/' . $u->pasien_uji_id) ?>" class="btn btn-sm btn-primary">Dempster Shafer</a>
                                            </td>
                                            <?php
                                            if ($this->session->userdata('level') == 99) {
                                            ?>
                                                <td>
                                                    <a href="<?= base_url('Data_uji/data_uji_edit/' . $u->pasien_uji_id) ?>" class="btn btn-sm btn-primary" title="Edit Data"><small class="fa fa-wrench"></small></a>
                                                    <a href="<?= base_url('Data_uji/data_uji_delete/' . $u->pasien_uji_id) ?>" class="btn btn-sm btn-danger" title="Hapus Data"><small class="fa fa-trash-o"></small></a>
                                                </td>
                                            <?php } ?>
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