<!DOCTYPE html>
<!-- 
Template Name: BRILLIANT Bootstrap Admin Template
Version: 4.5.6
Author: WebThemez
Website: http://www.webthemez.com/ 
-->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="" name="description" />
    <meta content="webthemez" name="author" />
    <title><?= $title ?></title>
    <!-- Bootstrap Styles-->
    <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="<?= base_url() ?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="<?= base_url() ?>assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/checkbox3.min.css" rel="stylesheet">
    <!-- Custom Styles-->
    <link href="<?= base_url() ?>assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href="<?= base_url() ?>assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/js/Lightweight-Chart/cssCharts.css">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= base_url('Admin') ?>"><strong> Aplikasi TGA</strong></a>

                <div id="sideNav" href="">
                    <i class="fa fa-bars icon"></i>
                </div>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= base_url('Admin/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="<?= base_url('Admin') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file"></i> Master Data<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?= base_url('Gejala') ?>">Gejala</a>
                            </li>
                            <li>
                                <a href="<?= base_url('Penyakit') ?>">Penyakit</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file"></i> Algoritma<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?= base_url('Naive_bayes') ?>">Naive Bayes</a>
                            </li>
                            <li>
                                <a href="<?= base_url('Dempster_shafer') ?>">Dempster Shafer</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file"></i>Data Pasien<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?= base_url('Data_latih') ?>">Data Latih</a>
                            </li>
                            <li>
                                <a href="<?= base_url('Data_uji') ?>">Data Uji</a>
                            </li>
                            <li>
                                <a href="<?= base_url('Grafik') ?>">Grafik</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div class="header">
                <h1 class="page-header">
                    Grafik <small>Grafik Hasil Data Uji</small>
                </h1>
            </div>
            <div id="page-inner">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="panel panel-default chartJs">
                            <div class="panel-heading">
                                <div class="card-title">
                                    <div class="title">Grafik Hasil Algoritma Naive Bayes</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <canvas id="bar-chart" class="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="panel panel-default chartJs">
                            <div class="panel-heading">
                                <div class="card-title">
                                    <div class="title">Grafik Hasil Algoritma Dampster Shafer</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <canvas id="bar-chart-2" class="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="<?= base_url() ?>assets/js/jquery-1.10.2.js"></script>
    <!-- Chart Js -->
    <script type="text/javascript" src="<?= base_url() ?>assets/js/Chart.min.js"></script>
    <?php
    $label_nb = $this->db->query("SELECT DISTINCT(penyakit_kode_nb) as label FROM tbl_pasien_uji ORDER BY penyakit_kode_nb ASC");
    $label_ds = $this->db->query("SELECT DISTINCT(penyakit_kode_ds) as label FROM tbl_pasien_uji ORDER BY penyakit_kode_ds ASC");
    ?>
    <script>
        $(function() {
            var ctx, data, myBarChart, option_bars;
            Chart.defaults.global.responsive = true;
            ctx = $('#bar-chart').get(0).getContext('2d');
            option_bars = {
                scaleBeginAtZero: true,
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: false,
                barShowStroke: true,
                barStrokeWidth: 1,
                barValueSpacing: 5,
                barDatasetSpacing: 3,
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
            };
            data = {
                labels: [
                    <?php
                    foreach ($label_nb->result() as $label) {
                        echo "'$label->label'" . ',';
                    }
                    ?>
                ],
                datasets: [{
                    label: "My First dataset",
                    fillColor: "rgba(26, 188, 156,0.6)",
                    strokeColor: "#1ABC9C",
                    pointColor: "#1ABC9C",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#1ABC9C",
                    data: [
                        <?php
                        foreach ($label_nb->result() as $label) {
                            $nilai = $this->db->query("SELECT COUNT(pasien_uji_id) as nilai FROM tbl_pasien_uji WHERE penyakit_kode_nb='$label->label'")->row();
                            echo "$nilai->nilai" . ',';
                        }
                        ?>
                    ]
                }]
            };
            myBarChart = new Chart(ctx).Bar(data, option_bars);
        });
    </script>
    <script>
        $(function() {
            var ctx, data, myBarChart, option_bars;
            Chart.defaults.global.responsive = true;
            ctx = $('#bar-chart-2').get(0).getContext('2d');
            option_bars = {
                scaleBeginAtZero: true,
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: false,
                barShowStroke: true,
                barStrokeWidth: 1,
                barValueSpacing: 5,
                barDatasetSpacing: 3,
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
            };
            data = {
                labels: [
                    <?php
                    foreach ($label_ds->result() as $label) {
                        echo "'$label->label'" . ',';
                    }
                    ?>
                ],
                datasets: [{
                    label: "My First dataset",
                    fillColor: "rgba(26, 188, 156,0.6)",
                    strokeColor: "#1ABC9C",
                    pointColor: "#1ABC9C",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#1ABC9C",
                    data: [
                        <?php
                        foreach ($label_ds->result() as $label) {
                            $nilai = $this->db->query("SELECT COUNT(pasien_uji_id) as nilai FROM tbl_pasien_uji WHERE penyakit_kode_ds='$label->label'")->row();
                            echo "$nilai->nilai" . ',';
                        }
                        ?>
                    ]
                }]
            };
            myBarChart = new Chart(ctx).Bar(data, option_bars);
        });
    </script>

    <!-- Bootstrap Js -->
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

    <!-- Metis Menu Js -->
    <script src="<?= base_url() ?>assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="<?= base_url() ?>assets/js/morris/raphael-2.1.0.min.js"></script>

    <script src="<?= base_url() ?>assets/js/morris/morris.js"></script>

    <script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
    </script>

    <!-- Custom Js -->
    <script src="<?= base_url() ?>assets/js/custom-scripts.js"></script>




</body>

</html>