<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Hasil Perhitungan <small>Algoritma Naive Bayes</small>
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
                        Tabel Hasil Perhitungan
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Penyakit</th>
                                        <th>Nilai</th>
                                        <!-- <th rowspan="2">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    for ($i = 0; $i < count($hasil); $i++) :
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= 'P0' . $no; ?></td>
                                            <td><?= number_format((float)$hasil[$i], 6, '.', ''); ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    endfor
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tabel Kesimpulan Hasil Perhitungan
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th rowspan="2">#</th>
                                        <th width="50%" rowspan="2">Gejala</th>
                                        <th width="20" colspan="2">Hasil</th>
                                        <!-- <th rowspan="2">Action</th> -->
                                    </tr>
                                    <tr>
                                        <td>Penyakit (Hasil Perhitungan)</td>
                                        <td>Nilai (Hasil Perhitungan)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <?php
                                        $txt = "";
                                        $u = $this->m_vic->edit_data(['pasien_uji_id' => $id], 'tbl_pasien_uji')->row();
                                        $gejala = $this->db->query("SELECT gejala_id,gejala_uji_nilai FROM tbl_gejala_uji WHERE pasien_uji_id='$id'");
                                        foreach ($gejala->result() as $g) :
                                            $nama = $this->db->query("SELECT gejala_nama FROM tbl_gejala WHERE gejala_id='$g->gejala_id'")->row();
                                            $txt .= $nama->gejala_nama . ',';
                                        ?>
                                        <?php endforeach ?>
                                        <td><?= $txt ?></td>
                                        <?php
                                        echo '<td>' . 'P0' . $key . '</td>';
                                        echo '<td>' . number_format((float)$max, 6, '.', '') . '</td>';
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="<?= base_url('Data_uji') ?>" class="btn btn-success pull-right">Selesai</a>
                        </div>
                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    </div>
    <footer></footer>